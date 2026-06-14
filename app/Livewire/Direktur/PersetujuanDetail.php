<?php

namespace App\Livewire\Direktur;

use Livewire\Component;
use App\Models\Rab;
use App\Models\RabItem; // <-- INI WAJIB ADA BUAT WBS STRUKTUR
use App\Models\Bidding;
use App\Models\RProject;
use App\Models\DocumentCommit;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class PersetujuanDetail extends Component
{
    public $projectId;
    public $selectedProject;
    
    public $view = 'document_list'; 
    public $selected_rab_id = null;
    public $selected_bidding_id = null;

    public $isRevisiModalOpen = false;
    public $komentar_commit = '';
    public $jenisDokumen = '';
    public $dokumenIdToRevise = null;

    public function mount($id)
    {
        $this->projectId = $id;
        $this->loadProject();
    }

    public function loadProject()
    {
        $this->selectedProject = RProject::with([
            'rabs' => function($q) {
                $q->where('status_rab', 'pending');
            },
            'biddings' => function($q) {
                $q->where('status_bidding', 'pending');
            }
        ])->findOrFail($this->projectId);
    }

    public function kembaliKeIndex()
    {
        return $this->redirectRoute('direktur.persetujuan', navigate: true);
    }

    public function kembaliKeDocumentList()
    {
        $this->view = 'document_list';
        $this->reset(['selected_rab_id', 'selected_bidding_id']);
        $this->loadProject();
    }

    public function lihatDetailRab($id)
    {
        $this->selected_rab_id = $id;
        $this->view = 'detail_rab';
    }

    public function lihatDetailBidding($id)
    {
        $this->selected_bidding_id = $id;
        $this->view = 'detail_bidding';
    }

    public function setujuiDokumen($id, $jenis)
    {
        if ($jenis === 'rab') {
            $rab = Rab::findOrFail($id);
            $rab->update(['status_rab' => 'approved']);
            
            // DIPERBAIKI: 'rab_approved' diganti 'bidding' (sesuai enum database)
            RProject::where('id', $rab->id_r_project)->update(['status_proyek' => 'pending']);

            DocumentCommit::create([
                'id_user' => Auth::id() ?? 1,
                'user_name' => Auth::user()->username ?? 'Direktur',
                'id_r_project' => $rab->id_r_project,
                'id_rab' => $id,
                'jenis_aksi' => 'approved',
                'komentar_commit' => 'Dokumen RAB telah disetujui dan disahkan oleh Direktur.',
                'created_at' => now()
            ]);

            Notification::create([
                'id_user' => $rab->id_user,
                'judul' => 'RAB Disetujui Direktur!',
                'pesan' => "RAB dengan nomor {$rab->no_boq} resmi disetujui. Proyek siap berlanjut ke tahap Bidding.",
                'url_tujuan' => route('engineering.rab.detail', $rab->id_r_project) // Pastikan id project
            ]);

        } else {
            $bidding = Bidding::findOrFail($id);
            $bidding->update(['status_bidding' => 'approved']);
            
            // DIPERBAIKI: 'won' diganti 'on_progress' (sesuai enum database)
            RProject::where('id', $bidding->id_r_project)->update(['status_proyek' => 'on_progress']);

            DocumentCommit::create([
                'id_user' => Auth::id() ?? 1,
                'user_name' => Auth::user()->username ?? 'Direktur',
                'id_r_project' => $bidding->id_r_project,
                'id_bidding' => $id,
                'jenis_aksi' => 'approved',
                'komentar_commit' => 'Surat Penawaran Bidding disetujui dan disahkan oleh Direktur.',
                'created_at' => now()
            ]);

            Notification::create([
                'id_user' => $bidding->id_user,
                'judul' => 'Bidding Disetujui Direktur!',
                'pesan' => "Surat Penawaran nomor {$bidding->no_penawaran} disetujui. Silakan kirimkan dokumen ke klien.",
                'url_tujuan' => route('marketing.bidding.log', $bidding->id_r_project) // Pastikan id project
            ]);
        }

        session()->flash('sukses', 'Otorisasi berhasil! Dokumen telah sah disetujui.');
        $this->kembaliKeDocumentList();
    }

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
        ], ['komentar_commit.required' => 'Catatan revisi wajib diisi agar tim tahu bagian yang salah.']);

        if ($this->jenisDokumen === 'rab') {
            $rab = Rab::find($this->dokumenIdToRevise);
            $rab->update(['status_rab' => 'revision']);
            
            // DIPERBAIKI: 'waiting_rab' diganti 'draft' (sesuai enum database)
            RProject::where('id', $rab->id_r_project)->update(['status_proyek' => 'draft']);

            DocumentCommit::create([
                'id_user' => Auth::id() ?? 1,
                'user_name' => Auth::user()->username ?? 'Direktur',
                'id_r_project' => $rab->id_r_project,
                'id_rab' => $this->dokumenIdToRevise,
                'jenis_aksi' => 'revised',
                'komentar_commit' => 'REVISI DIREKTUR: ' . $this->komentar_commit,
                'created_at' => now()
            ]);

            Notification::create([
                'id_user' => $rab->id_user,
                'judul' => 'RAB Ditolak / Perlu Revisi',
                'pesan' => "RAB No {$rab->no_boq} dikembalikan untuk direvisi: {$this->komentar_commit}",
                'url_tujuan' => route('engineering.rab.detail', $rab->id_r_project)
            ]);

        } else {
            $bidding = Bidding::find($this->dokumenIdToRevise);
            $bidding->update(['status_bidding' => 'revision']); 
            
            // DIPERBAIKI: 'rab_approved' diganti 'bidding' (karena bidding direvisi, kembalikan ke tahap bidding)
            RProject::where('id', $bidding->id_r_project)->update(['status_proyek' => 'bidding']);

            DocumentCommit::create([
                'id_user' => Auth::id() ?? 1,
                'user_name' => Auth::user()->username ?? 'Direktur',
                'id_r_project' => $bidding->id_r_project,
                'id_bidding' => $this->dokumenIdToRevise,
                'jenis_aksi' => 'revised',
                'komentar_commit' => 'REVISI DIREKTUR: ' . $this->komentar_commit,
                'created_at' => now()
            ]);

            Notification::create([
                'id_user' => $bidding->id_user,
                'judul' => 'Bidding Ditolak / Perlu Revisi',
                'pesan' => "Penawaran No {$bidding->no_penawaran} dikembalikan untuk direvisi: {$this->komentar_commit}",
                'url_tujuan' => route('marketing.bidding.detail', $bidding->id_r_project)
            ]);
        }

        session()->flash('error', 'Dokumen ditolak dan telah dikembalikan ke divisi terkait.');
        $this->tutupModalRevisi();
        $this->kembaliKeDocumentList();
    }

    public function render()
    {
        $selectedRab = null;
        $wbsStruktur = collect([]); // BIAR VIEW GAK ERROR KALAU KOSONG

        if ($this->view === 'detail_rab' && $this->selected_rab_id) {
            $selectedRab = Rab::find($this->selected_rab_id);
            // INI DATA YANG LU ILANGIN, MAKANNYA ERROR 500!
            $wbsStruktur = RabItem::with('children')->where('id_rab', $this->selected_rab_id)->whereNull('parent_id')->get();
        }

        $selectedBidding = null;
        if ($this->view === 'detail_bidding' && $this->selected_bidding_id) {
            $selectedBidding = Bidding::find($this->selected_bidding_id);
        }

        return view('livewire.direktur.persetujuan-detail', compact('selectedRab', 'selectedBidding', 'wbsStruktur'))
            ->layout('components.layouts.app');
    }
}