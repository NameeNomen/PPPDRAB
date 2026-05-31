<?php

namespace App\Livewire\Direktur;

use Livewire\Component;
use App\Models\Rab;
use App\Models\RabItem;
use App\Models\Bidding;
use App\Models\RProject;
use App\Models\DocumentCommit;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class KelolaPersetujuan extends Component
{
    public $view = 'list'; 
    
    // Simpan ID saja, bukan Objek Model utuh (Solusi cegah Error 403)
    public $selected_project_id = null;
    public $selected_rab_id = null;
    public $selected_bidding_id = null;
    
    public $isRevisiModalOpen = false;
    public $komentar_commit = '';
    public $jenisDokumen = ''; 
    public $dokumenIdToRevise = null;

    // --- NAVIGASI ---
    public function lihatDokumenProyek($id_project)
    {
        $this->selected_project_id = $id_project;
        $this->view = 'document_list';
    }

    public function lihatDetailRab($id_rab)
    {
        $this->selected_rab_id = $id_rab;
        $this->view = 'detail_rab';
    }

    public function lihatDetailBidding($id_bidding)
    {
        $this->selected_bidding_id = $id_bidding;
        $this->view = 'detail_bidding';
    }

    // --- TANGKAP ID DARI URL NOTIFIKASI ---
    public function mount($id = null)
    {
        if ($id) {
            // Langsung eksekusi fungsi navigasi buat buka dokumen proyek
            $this->lihatDokumenProyek($id);
        }
    }

    public function kembaliKeList()
    {
        $this->view = 'list';
        $this->reset(['selected_project_id', 'selected_rab_id', 'selected_bidding_id']);
    }

    public function kembaliKeDocumentList()
    {
        $this->view = 'document_list';
        $this->reset(['selected_rab_id', 'selected_bidding_id']);
    }

    // --- LOGIKA EKSEKUSI ---
    public function setujuiDokumen($id, $jenis)
    {
        if ($jenis === 'rab') {
            $rab = Rab::findOrFail($id);
            $rab->update(['status_rab' => 'approved']);
            RProject::where('id', $rab->id_r_project)->update(['status_proyek' => 'rab_approved']);
            
            DocumentCommit::create([
                'id_user' => Auth::id() ?? 1,
                'user_name' => Auth::user()->username ?? 'Direktur',
                'id_r_project' => $rab->id_r_project,
                'id_rab' => $id,
                'jenis_aksi' => 'approved',
                'komentar_commit' => 'Dokumen RAB disetujui Direktur. Anggaran sah.',
                'created_at' => now()
            ]);

            // NOTIFIKASI KE ENGINEERING MENGGUNAKAN ROUTE()
            Notification::create([
                'id_user' => $rab->id_user,
                'judul' => 'RAB Disetujui!',
                'pesan' => "RAB No {$rab->no_boq} telah disetujui. Proyek siap lanjut Bidding.",
                'url_tujuan' => '/engineering/rab' // Disesuaikan manual jika route error
            ]);
        } else {
            $bidding = Bidding::findOrFail($id);
            $bidding->update(['status_bidding' => 'approved']);
            RProject::where('id', $bidding->id_r_project)->update(['status_proyek' => 'won']);
            
            DocumentCommit::create([
                'id_user' => Auth::id() ?? 1,
                'user_name' => Auth::user()->username ?? 'Direktur',
                'id_r_project' => $bidding->id_r_project,
                'id_bidding' => $id,
                'jenis_aksi' => 'approved',
                'komentar_commit' => 'Dokumen Penawaran disetujui. Proyek siap dimenangkan.',
                'created_at' => now()
            ]);

            // NOTIFIKASI KE MARKETING MENGGUNAKAN ROUTE()
            Notification::create([
                'id_user' => $bidding->id_user,
                'judul' => 'Bidding Disetujui!',
                'pesan' => "Penawaran No {$bidding->no_penawaran} disetujui. Gass kirim!",
                'url_tujuan' => '/marketing/kelola-bidding'
            ]);
        }

        session()->flash('sukses', 'Dokumen otorisasi sah! Sudah diteruskan ke divisi terkait.');
        $this->kembaliKeDocumentList();
    }

    // --- LOGIKA REVISI ---
    public function bukaModalRevisi($id, $jenis)
    {
        $this->dokumenIdToRevise = $id;
        $this->jenisDokumen = $jenis;
        $this->komentar_commit = '';
        $this->isRevisiModalOpen = true;
    }

    public function tutupModalRevisi()
    {
        $this->isRevisiModalOpen = false;
        $this->reset(['dokumenIdToRevise', 'jenisDokumen', 'komentar_commit']);
    }

    public function kirimRevisi()
    {
        $this->validate([
            'komentar_commit' => 'required|string|min:5'
        ], ['komentar_commit.required' => 'Bos, kasih alasan spesifik!']);

        if ($this->jenisDokumen === 'rab') {
            $rab = Rab::find($this->dokumenIdToRevise);
            $rab->update(['status_rab' => 'revision']); // PERBAIKAN: Ubah ke revision biar sinkron sama Enum DB
            RProject::where('id', $rab->id_r_project)->update(['status_proyek' => 'waiting_rab']);
            
            DocumentCommit::create([
                'id_user' => Auth::id() ?? 1,
                'user_name' => Auth::user()->username ?? 'Direktur',
                'id_r_project' => $rab->id_r_project,
                'id_rab' => $this->dokumenIdToRevise,
                'jenis_aksi' => 'revised',
                'komentar_commit' => 'DITOLAK/REVISI: ' . $this->komentar_commit,
                'created_at' => now()
            ]);

            // NOTIFIKASI KE ENGINEERING 
            Notification::create([
                'id_user' => $rab->id_user,
                'judul' => 'RAB Direvisi Direktur',
                'pesan' => "RAB No {$rab->no_boq} butuh revisi: {$this->komentar_commit}",
                'url_tujuan' => '/engineering/kelola-rab'
            ]);
        } else {
            $bidding = Bidding::find($this->dokumenIdToRevise);
            $bidding->update(['status_bidding' => 'rejected']);
            RProject::where('id', $bidding->id_r_project)->update(['status_proyek' => 'rab_approved']);
            
            DocumentCommit::create([
                'id_user' => Auth::id() ?? 1,
                'user_name' => Auth::user()->username ?? 'Direktur',
                'id_r_project' => $bidding->id_r_project,
                'id_bidding' => $this->dokumenIdToRevise,
                'jenis_aksi' => 'revised',
                'komentar_commit' => 'DITOLAK/REVISI: ' . $this->komentar_commit,
                'created_at' => now()
            ]);

            // NOTIFIKASI KHUSUS KE MARKETING
            Notification::create([
                'id_user' => $bidding->id_user,
                'judul' => 'Bidding Direvisi Direktur',
                'pesan' => "Penawaran {$bidding->no_penawaran} butuh revisi: {$this->komentar_commit}",
                'url_tujuan' => '/marketing/kelola-bidding'
            ]);
        }

        session()->flash('error', 'Dokumen resmi dikembalikan dengan catatan revisi.');
        $this->tutupModalRevisi();
        $this->kembaliKeDocumentList();
    }

    public function render()
    {
        $proyekPending = collect([]);
        
        // PERBAIKAN 1: Filter Dashboard Utama Direktur mencari status "pending"
        if ($this->view === 'list') {
            $proyekPending = RProject::whereHas('rabs', function($q) {
                $q->where('status_rab', 'pending'); // FIXED!
            })->orWhereHas('biddings', function($q) {
                $q->whereIn('status_bidding', ['draft', 'sent']); // Perluasan filter bidding
            })->orderBy('updated_at', 'desc')->get();
        }

        $selectedProject = null;
        
        // PERBAIKAN 2: Filter Card Map Dokumen mencari status "pending"
        if ($this->selected_project_id) {
            $selectedProject = RProject::with([
                'rabs' => function($q) { 
                    $q->where('status_rab', 'pending'); // FIXED! Inilah yang bikin kosong
                },
                'biddings' => function($q) { 
                    $q->whereIn('status_bidding', ['draft', 'sent']); 
                }
            ])->find($this->selected_project_id);
        }

        $selectedRab = null;
        $wbsStruktur = collect([]);
        if ($this->view === 'detail_rab' && $this->selected_rab_id) {
            $selectedRab = Rab::find($this->selected_rab_id);
            $wbsStruktur = RabItem::with('children')->where('id_rab', $this->selected_rab_id)->whereNull('parent_id')->get();
        }

        $selectedBidding = null;
        if ($this->view === 'detail_bidding' && $this->selected_bidding_id) {
            $selectedBidding = Bidding::find($this->selected_bidding_id);
        }

        return view('livewire.direktur.kelola-persetujuan', compact(
            'proyekPending', 'wbsStruktur', 'selectedProject', 'selectedRab', 'selectedBidding'
        ))->layout('components.layouts.app');
    }
}