<?php

namespace App\Livewire\Engineering;

use Livewire\Component;
use App\Models\Material;
use App\Models\Rab;
use App\Models\RabItem;
use App\Models\DocumentCommit;
use App\Models\RProject;

class KelolaRab extends Component
{
    public $view = 'list';
    public $daftarProyek = [];
    public $selectedProject;
    public $rabAktif;
    public $searchProyek = '';
    public $filterStatus = 'all';

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

    public function mount()
    {
        $this->loadDaftarProyek();
    }

   

    public function bukaWorkspace($projectId)
    {
        $this->selectedProject = RProject::findOrFail($projectId);
        $this->rabAktif = Rab::where('id_r_project', $projectId)->first();
        $this->view = 'card';
    }

    public function kembaliKeList()
    {
        $this->loadDaftarProyek();
        $this->view = 'list';
    }

    public function editRab()
    {
        if ($this->rabAktif) {
            $this->rabId = $this->rabAktif->id;
            $this->no_boq = $this->rabAktif->no_boq;
            $this->tanggal_dokumen = $this->rabAktif->tgl_boq;
            $this->overhead_cost = $this->rabAktif->overhead_cost;
        } else {
            // Inisiasi draft kosong
            $rabBaru = Rab::create([
                'id_r_project' => $this->selectedProject->id,
                'no_boq' => 'BOQ/' . date('Y/m/d') . '/' . $this->selectedProject->id,
                'tgl_boq' => date('Y-m-d'),
                'overhead_cost' => 0,
                'grand_total' => 0,
                'status_rab' => 'DRAFT'
            ]);
            
            $this->rabAktif = $rabBaru;
            $this->rabId = $rabBaru->id;
            $this->no_boq = $rabBaru->no_boq;
            $this->tanggal_dokumen = $rabBaru->tgl_boq;
            $this->overhead_cost = 0;
        }
        $this->view = 'spreadsheet';
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

    // Nambah Kategori (Parent)
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

    // Nambah Item (Child)
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
            // Hapus children jika ini kategori
            if($item->tipe === 'kategori') {
                RabItem::where('parent_id', $item->id)->delete();
            }
            $item->delete();
        }
    }
   public function updatedSearchProyek() { $this->loadDaftarProyek(); }
    public function updatedFilterStatus() { $this->loadDaftarProyek(); }

    public function loadDaftarProyek()
    {
        $query = RProject::with('rab')->orderBy('updated_at', 'desc');

        // Logic Pencarian
        if (!empty($this->searchProyek)) {
            $query->where(function($q) {
                $q->where('nama_pelanggan', 'like', '%' . $this->searchProyek . '%')
                  ->orWhere('request_no', 'like', '%' . $this->searchProyek . '%');
            });
        }

        $proyek = $query->get();

        // Logic Filter Status
        if ($this->filterStatus !== 'all') {
            $proyek = $proyek->filter(function($p) {
                $status = strtolower($p->rab->status_rab ?? '');
                if ($this->filterStatus === 'draft') return $status === 'draft' || $status === '';
                if ($this->filterStatus === 'pending_approval') return str_contains($status, 'pending'); 
                if ($this->filterStatus === 'approved') return $status === 'approved';
                return true;
            });
        }

        // MAGIC SORTING: Tarik status 'revisi' paksa ke urutan paling atas
        $this->daftarProyek = $proyek->sortBy(function($p) {
            return strtolower($p->rab->status_rab ?? '') === 'revisi' ? 0 : 1;
        })->values();
    }

    public function hapusDokumenRab()
    {
        Rab::find($this->rabId)?->delete();
        $this->rabAktif = null;
        $this->view = 'card';
    }
public function submitKeDirektur($id_rab)
    {
        $rab = \App\Models\Rab::with('project')->findOrFail($id_rab);
        
        // 1. Ubah status RAB jadi pending_approval
        $rab->update(['status_rab' => 'pending_approval']);
        
        // 2. Catat ke Document Commits (CCTV-nya)
        \App\Models\DocumentCommit::create([
            'id_user' => \Illuminate\Support\Facades\Auth::id(),
            'user_name' => \Illuminate\Support\Facades\Auth::user()->username, 
            'id_rab' => $rab->id,
            'id_r_project' => $rab->id_r_project,
            'jenis_aksi' => 'submit_approval',
            'komentar_commit' => 'RAB telah selesai dibuat/diperbarui dan siap direview.',
            'created_at' => now()
        ]);

        // 3. KIRIM NOTIFIKASI KE DIREKTUR (Mencet Bel-nya)
        $direktur = \App\Models\User::where('role', 'direktur')->first();
        if ($direktur) {
            \App\Models\Notification::create([
                'id_user' => $direktur->id,
                'judul' => 'Persetujuan RAB Dibutuhkan',
                'pesan' => "RAB untuk proyek {$rab->project->nama_pelanggan} butuh direview. Silakan cek.",
                'url_tujuan' => '/direktur/persetujuan', // Sesuaikan dengan route dashboard direktur kamu
                'is_read' => false
            ]);
        }

        session()->flash('sukses', 'RAB berhasil dikirim ke Direktur dan notifikasi telah menyala!');
    }

    public function render()
    {
        $kategoris = [];
        $totalPekerjaan = 0;
        $overhead = (int)($this->overhead_cost ?? 0);
        $grandTotal = $overhead;

        if ($this->view === 'spreadsheet' && $this->rabId) {
            $kategoris = RabItem::where('id_rab', $this->rabId)
                ->where('tipe', 'kategori')
                ->whereNull('parent_id')
                ->with('children.material') // Panggil relasi children
                ->get();

            $totalPekerjaan = RabItem::where('id_rab', $this->rabId)->where('tipe', 'item')->sum('subtotal');
            $grandTotal = $totalPekerjaan + $overhead;
        }

        return view('livewire.engineering.kelola-rab', [
            'kategoris' => $kategoris,
            'totalPekerjaan' => $totalPekerjaan,
            'overhead' => $overhead,
            'grandTotal' => $grandTotal
        ])->layout('components.layouts.app'); // Jangan dihapus lagi ini layout-nya!
    }
}