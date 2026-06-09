<?php

namespace App\Livewire\Engineering;

use Livewire\Component;
use App\Models\Material;
use App\Models\Rab;
use App\Models\RabItem;
use App\Models\DocumentCommit;
use App\Models\RProject;
use Illuminate\Support\Facades\Auth;

class RabWorkspace extends Component
{
    public $projectId;
    public $selectedProject;
    public $rabAktif;

    // Properti Header Dokumen
    public $rabId;
    public $no_boq;
    public $tanggal_dokumen;
    public $overhead_cost = 0;

    // Properti Histori
    public $commit_message;
    public $nama_editor;

    // Properti Form Item Baru
    public $newKategori;
    public $deskripsiInput = [];
    public $volumeInput = [];
    public $hargaInput = [];
    public $satuanInput = [];

    // Pencarian Material
    public $materialSearch = [];
    public $materialResults = [];
    public $selectedMaterial = [];

    public function mount($id)
    {
        $this->projectId = $id;
        $this->selectedProject = RProject::findOrFail($id);
        $this->rabAktif = Rab::where('id_r_project', $id)->firstOrFail();

        // Load data RAB ke form
        $this->rabId = $this->rabAktif->id;
        $this->no_boq = $this->rabAktif->no_boq;
        $this->tanggal_dokumen = $this->rabAktif->tgl_boq;
        $this->overhead_cost = $this->rabAktif->overhead_cost;
    }

    public function kembaliKeList()
    {
        return $this->redirectRoute('engineering.rab.detail', ['id' => $this->projectId], navigate: true);
    }

    public function updatedMaterialSearch($value, $key = null)
    {
        if (is_array($value)) return;
        $id = str_contains($key, '.') ? last(explode('.', $key)) : $key;

        if (empty($value) || strlen($value) < 2) {
            $this->materialResults[$id] = [];
            return;
        }

        $this->materialResults[$id] = Material::where('nama_barang', 'like', '%' . $value . '%')
            ->select('id', 'nama_barang', 'harga', 'satuan')->take(6)->get();
    }

    public function pilihMaterial($parentId, $materialId, $namaMaterial, $harga, $satuan)
    {
        $this->selectedMaterial[$parentId] = [
            'id' => $materialId, 'nama' => $namaMaterial, 'harga' => $harga, 'satuan' => $satuan
        ];
        $this->hargaInput[$parentId] = $harga;
        $this->satuanInput[$parentId] = $satuan;
        $this->materialSearch[$parentId] = '';
        $this->materialResults[$parentId] = [];
    }

    public function batalPilihMaterial($parentId)
    {
        unset($this->selectedMaterial[$parentId], $this->hargaInput[$parentId], $this->satuanInput[$parentId]);
    }

    public function tambahKategori()
    {
        $this->validate(['newKategori' => 'required|min:3']);
        RabItem::create([
            'id_rab' => $this->rabId,
            'parent_id' => null,
            'tipe' => 'kategori',
            'deskripsi_pekerjaan' => $this->newKategori,
            'qty' => 0,
            'harga_awal' => 0,
            'subtotal' => 0
        ]);
        $this->newKategori = '';
    }

    public function simpanItemBaru($parentId)
    {
        $this->validate([
            "deskripsiInput.{$parentId}" => 'required',
            "volumeInput.{$parentId}" => 'required|numeric',
            "hargaInput.{$parentId}" => 'required|numeric',
        ]);

        $qty = $this->volumeInput[$parentId];
        $harga = $this->hargaInput[$parentId];
        $subtotal = $qty * $harga;

        RabItem::create([
            'id_rab' => $this->rabId,
            'parent_id' => $parentId,
            'tipe' => 'item',
            'id_material' => $this->selectedMaterial[$parentId]['id'] ?? null,
            'deskripsi_pekerjaan' => $this->deskripsiInput[$parentId],
            'qty' => $qty,
            'harga_awal' => $harga,
            'subtotal' => $subtotal
        ]);

        unset($this->deskripsiInput[$parentId], $this->volumeInput[$parentId], $this->hargaInput[$parentId], $this->satuanInput[$parentId], $this->selectedMaterial[$parentId]);
    }

    public function hapusItem($itemId)
    {
        $item = RabItem::find($itemId);
        if($item) {
            if($item->tipe === 'kategori') {
                RabItem::where('parent_id', $item->id)->delete();
            }
            $item->delete();
        }
    }

    public function submitKeDirektur()
    {
        $this->validate([
            'nama_editor' => 'required|min:3',
            'commit_message' => 'required|min:5',
        ], [
            'nama_editor.required' => 'Nama Editor wajib diisi sebelum submit!',
            'commit_message.required' => 'Pesan Histori wajib diisi sebelum submit!',
        ]);

        $this->rabAktif->update([
            'status_rab' => 'pending',
            'overhead_cost' => $this->overhead_cost, 
        ]);

        DocumentCommit::create([
            'id_user' => Auth::id() ?? 1,
            'user_name' => $this->nama_editor,
            'id_rab' => $this->rabId,
            'id_r_project' => $this->projectId,
            'jenis_aksi' => 'submitted',
            'komentar_commit' => $this->commit_message,
            'created_at' => now()
        ]);

        $direktur = \App\Models\User::where('role', 'direktur')->first();
        if ($direktur) {
            \App\Models\Notification::create([
                'id_user' => $direktur->id,
                'judul' => 'Persetujuan RAB Dibutuhkan',
                'pesan' => "RAB untuk proyek {$this->selectedProject->nama_pelanggan} butuh direview. Silakan cek.",
                'url_tujuan' => '/direktur/persetujuan/' . $this->projectId,
                'is_read' => false
            ]);
        }

        session()->flash('sukses', 'Dokumen estimasi RAB berhasil diluncurkan ke sistem Direktur. Silakan istirahat sejenak! ✨');
        return $this->redirectRoute('engineering.rab.index', navigate: true);
    }

    public function render()
    {
        $kategoris = RabItem::where('id_rab', $this->rabId)
            ->where('tipe', 'kategori')
            ->whereNull('parent_id')
            ->with('children.material')
            ->get();
            
        $totalPekerjaan = RabItem::where('id_rab', $this->rabId)->where('tipe', 'item')->sum('subtotal');
        $overhead = (int)($this->overhead_cost ?? 0);
        $grandTotal = $totalPekerjaan + $overhead;

        // Update nilai grand_total di database secara real-time
        $this->rabAktif->update(['grand_total' => $grandTotal]);

        return view('livewire.engineering.rab-workspace', [
            'kategoris' => $kategoris,
            'totalPekerjaan' => $totalPekerjaan,
            'overhead' => $overhead,
            'grandTotal' => $grandTotal,
            'isApproved' => strtolower($this->rabAktif->status_rab) === 'approved'
        ])->layout('components.layouts.app');
    }
}