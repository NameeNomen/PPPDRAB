<?php

namespace App\Livewire\Engineering;

use Livewire\Component;
use App\Models\Material;
use App\Models\Rab;
use App\Models\RabItem;
use App\Models\DocumentCommit;
use App\Models\RProject;
use Illuminate\Support\Facades\Auth;

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
            $rabBaru = Rab::create([
                'id_r_project' => $this->selectedProject->id,
                'no_boq' => 'BOQ/' . date('Y/m/d') . '/' . $this->selectedProject->id,
                'tgl_boq' => date('Y-m-d'),
                'overhead_cost' => 0,
                'grand_total' => 0,
                'status_rab' => 'draft'
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

    public function updatedSearchProyek() { $this->loadDaftarProyek(); }
    public function updatedFilterStatus() { $this->loadDaftarProyek(); }

    public function loadDaftarProyek()
    {
        $query = RProject::with('rab')->orderBy('updated_at', 'desc');

        if (!empty($this->searchProyek)) {
            $query->where(function($q) {
                $q->where('nama_pelanggan', 'like', '%' . $this->searchProyek . '%')
                  ->orWhere('request_no', 'like', '%' . $this->searchProyek . '%');
            });
        }
        
        $proyek = $query->get();

        if ($this->filterStatus !== 'all') {
            $proyek = $proyek->filter(function($p) {
                $status = strtolower($p->rab->status_rab ?? '');
                if ($this->filterStatus === 'draft') return $status === 'draft' || $status === '';
                if ($this->filterStatus === 'pending') return $status === 'pending'; 
                if ($this->filterStatus === 'approved') return $status === 'approved';
                return true;
            });
        }

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
        // Validasi wajib isi form histori sebelum submit
        $this->validate([
            'nama_editor' => 'required|min:3',
            'commit_message' => 'required|min:5',
        ], [
            'nama_editor.required' => 'Nama Editor wajib diisi sebelum submit!',
            'commit_message.required' => 'Pesan Histori wajib diisi sebelum submit!',
        ]);

        $rab = Rab::with('project')->findOrFail($id_rab);
        
        // 1. Ubah status RAB jadi pending
        $rab->update([
            'status_rab' => 'pending',
            'overhead_cost' => $this->overhead_cost, // Simpan overhead terakhir
        ]);
        
        // 2. Catat ke Document Commits pakai inputan lu
        DocumentCommit::create([
            'id_user' => Auth::id() ?? 1,
            'user_name' => $this->nama_editor, 
            'id_rab' => $rab->id,
            'id_r_project' => $rab->id_r_project,
            'jenis_aksi' => 'submitted',
            'komentar_commit' => $this->commit_message,
            'created_at' => now()
        ]);

        // 3. KIRIM NOTIFIKASI KE DIREKTUR 
        $direktur = \App\Models\User::where('role', 'direktur')->first();
        if ($direktur) {
            \App\Models\Notification::create([
                'id_user' => $direktur->id,
                'judul' => 'Persetujuan RAB Dibutuhkan',
                'pesan' => "RAB untuk proyek {$rab->project->nama_pelanggan} butuh direview. Silakan cek.",
                'url_tujuan' => '/direktur/persetujuan/' . $rab->id_r_project,
                'is_read' => false
            ]);
        }
        
        session()->flash('sukses', 'Halo! Dokumen estimasi RAB sudah berhasil meluncur ke sistem Direktur ya. Mohon ditunggu proses review-nya. Terima kasih atas kerja kerasnya, silakan istirahat sejenak! ✨');
        
        // Refresh view
        $this->kembaliKeList();
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
                ->with('children.material')
                ->get();
            $totalPekerjaan = RabItem::where('id_rab', $this->rabId)->where('tipe', 'item')->sum('subtotal');
            $grandTotal = $totalPekerjaan + $overhead;
        }

        return view('livewire.engineering.kelola-rab', [
            'kategoris' => $kategoris,
            'totalPekerjaan' => $totalPekerjaan,
            'overhead' => $overhead,
            'grandTotal' => $grandTotal
        ])->layout('components.layouts.app');
    }
}