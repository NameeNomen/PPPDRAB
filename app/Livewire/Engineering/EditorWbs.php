<?php

namespace App\Livewire\Engineering;

use Livewire\Component;
use App\Models\Rab;
use App\Models\RabItem;
use App\Models\Material;
use App\Models\RProject;
use App\Models\DocumentCommit;
use Illuminate\Support\Facades\Auth;

class EditorWbs extends Component
{
    public $id_r_project, $projectUtama, $rabUtama;
    
    // Form Header RAB
    public $no_boq, $tgl_boq, $overhead_cost = 0;

    // Form WBS
    public $nama_kelompok; 
    public $parent_id, $id_material, $deskripsi_pekerjaan, $qty = 1;
    
    // Fitur Search
    public $searchMaterial = '';

    public function mount($id_r_project)
    {
        $this->id_r_project = $id_r_project;
        $this->projectUtama = RProject::findOrFail($id_r_project);
        
        // Cek kalau RAB udah pernah dibuat sebelumnya
        $this->rabUtama = Rab::where('id_r_project', $id_r_project)->first();
        
        if ($this->rabUtama) {
            $this->no_boq = $this->rabUtama->no_boq;
            $this->tgl_boq = $this->rabUtama->tgl_boq;
            $this->overhead_cost = $this->rabUtama->overhead_cost;
        } else {
            $this->tgl_boq = now()->format('Y-m-d');
        }
    }

    // Fungsi sakti buat generate cangkang RAB otomatis
    private function pastikanRabAda()
    {
        if (!$this->rabUtama) {
            $this->validate([
                'no_boq' => 'required|unique:rabs,no_boq',
                'tgl_boq' => 'required|date',
                'overhead_cost' => 'required|numeric|min:0',
            ], [
                'no_boq.required' => 'No BOQ wajib diisi dulu sebelum bikin WBS!',
                'no_boq.unique' => 'No BOQ ini sudah dipakai proyek lain.'
            ]);

            $this->rabUtama = Rab::create([
                'id_r_project' => $this->id_r_project,
                'no_boq' => $this->no_boq,
                'tgl_boq' => $this->tgl_boq,
                'overhead_cost' => $this->overhead_cost,
                'grand_total' => 0,
                'id_user' => Auth::id(),
                'status_rab' => 'draft'
            ]);
        }
    }

    public function updateHeaderRab()
    {
        $this->pastikanRabAda();
        if ($this->rabUtama) {
            $this->rabUtama->update([
                'no_boq' => $this->no_boq,
                'tgl_boq' => $this->tgl_boq,
                'overhead_cost' => $this->overhead_cost,
            ]);
            $this->updateGrandTotal();
            session()->flash('sukses', 'Data Header RAB berhasil diperbarui.');
        }
    }

    public function tambahKelompok()
    {
        // Pastikan RAB udah jadi dulu sebelum insert anak WBS-nya
        $this->pastikanRabAda();

        $this->validate([
            'nama_kelompok' => 'required|string|max:255'
        ], ['nama_kelompok.required' => 'Nama kelompok pekerjaan jangan dikosongin!']);

        RabItem::create([
            'id_rab' => $this->rabUtama->id, // Pakai ID RAB yang udah dipastikan ada
            'tipe' => 'kelompok',
            'deskripsi_pekerjaan' => $this->nama_kelompok,
            'qty' => 1,
            'harga_awal' => 0,
            'subtotal' => 0
        ]);

        $this->reset('nama_kelompok');
        session()->flash('sukses', 'Kelompok pekerjaan baru berhasil ditambahkan.');
    }

    public function tambahItem()
    {
        $this->validate([
            'parent_id' => 'required',
            'id_material' => 'required',
            'qty' => 'required|numeric|min:0.1',
        ], [
            'parent_id.required' => 'Pilih dulu mau dimasukkan ke kelompok mana.',
            'id_material.required' => 'Pilih materialnya dari hasil pencarian.',
            'qty.required' => 'Jumlah volume wajib diisi.'
        ]);

        $material = Material::find($this->id_material);
        $subtotal = $material->harga * $this->qty;

        RabItem::create([
            'id_rab' => $this->rabUtama->id,
            'parent_id' => $this->parent_id,
            'id_material' => $this->id_material,
            'tipe' => 'rincian',
            'deskripsi_pekerjaan' => $material->nama_barang,
            'qty' => $this->qty,
            'harga_awal' => $material->harga,
            'subtotal' => $subtotal
        ]);

        $this->updateGrandTotal();
        $this->reset(['id_material', 'qty', 'searchMaterial']);
        session()->flash('sukses', 'Rincian material berhasil ditambahkan.');
    }

    public function hapusItem($id_item)
    {
        RabItem::destroy($id_item);
        RabItem::where('parent_id', $id_item)->delete();
        $this->updateGrandTotal();
        session()->flash('sukses', 'Item berhasil dihapus dari struktur.');
    }

    private function updateGrandTotal()
    {
        if ($this->rabUtama) {
            $totalRincian = RabItem::where('id_rab', $this->rabUtama->id)->where('tipe', 'rincian')->sum('subtotal');
            $grandTotal = $totalRincian + $this->rabUtama->overhead_cost;
            $this->rabUtama->update(['grand_total' => $grandTotal]);
        }
    }

   public function ajukanKeDirektur()
{
    if (!$this->rabUtama || $this->rabUtama->grand_total == 0) {
        session()->flash('error', 'WBS masih kosong, tidak bisa diajukan!');
        return;
    }

    $this->rabUtama->update(['status_rab' => 'pending_approval']);
    $this->projectUtama->update(['status_proyek' => 'rab_approved']);

    // Notifikasi ke Direktur
    $directors = \App\Models\User::where('role', 'direktur')->get();
    foreach ($directors as $dir) {
        \App\Models\Notification::create([
            'id_user' => $dir->id,
            'judul' => 'Pengajuan RAB Proyek',
            'pesan' => "Engineering mengajukan RAB untuk proyek: {$this->projectUtama->nama_pelanggan}. Mohon segera direview.",
            'url_tujuan' => '/direktur/persetujuan/' . $this->id_r_project,
            'is_read' => false
        ]);
    }

    \App\Models\DocumentCommit::create([
        'id_user' => Auth::id(),
        'id_rab' => $this->rabUtama->id,
        'jenis_aksi' => 'submitted',
        'komentar_commit' => 'Mengajukan dokumen RAB untuk review Direktur.',
        'created_at' => now()
    ]);

    return redirect()->route('engineering.dashboard');
}

    public function render()
    {
        // Tarik struktur WBS cuma kalau RAB-nya udah ada
        $wbsStruktur = $this->rabUtama 
            ? RabItem::with('children')->where('id_rab', $this->rabUtama->id)->whereNull('parent_id')->get() 
            : collect([]);

        // Search logic buat Material (biar database lu nggak nangis query ribuan data sekaligus)
        $katalogMaterial = strlen($this->searchMaterial) >= 2 
            ? Material::where('nama_barang', 'like', '%' . $this->searchMaterial . '%')->take(20)->get() 
            : collect([]);

        return view('livewire.engineering.editor-wbs', compact('wbsStruktur', 'katalogMaterial'))
            ->layout('components.layouts.app');
    }
}