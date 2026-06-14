<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use App\Models\Bidding;
use App\Models\RProject;
use App\Models\DocumentCommit;
use Illuminate\Support\Facades\Auth;

class LogBidding extends Component
{
    public $projectId;
    public $selectedProject;
    public $biddingAktif;

    public function mount($id)
    {
        $this->projectId = $id;
        
        // Load proyek dengan RAB approved
        $this->selectedProject = RProject::with(['rabs' => function($q) {
            $q->where('status_rab', 'approved')->latest();
        }])->findOrFail($id);
        
        $this->biddingAktif = Bidding::where('id_r_project', $id)->first();
        
        // Kalau belum ada bidding, redirect ke form input
        if (!$this->biddingAktif) {
            return $this->redirectRoute('marketing.bidding.detail', ['id' => $id], navigate: true);
        }
    }

    public function kembaliKeList()
    {
        return $this->redirectRoute('marketing.bidding.index', navigate: true);
    }

    public function editBidding()
    {
        // Edit bidding yang sudah ada → ke form bidding-detail
        return $this->redirectRoute('marketing.bidding.detail', ['id' => $this->projectId], navigate: true);
    }

    public function hapusDokumenBidding()
    {
        if ($this->biddingAktif) {
            // Hapus semua commit terkait dulu
            DocumentCommit::where('id_bidding', $this->biddingAktif->id)->delete();
            $this->biddingAktif->delete();
            $this->biddingAktif = null;
            session()->flash('sukses', 'Dokumen Bidding berhasil dihapus dari sistem.');
            return $this->redirectRoute('marketing.bidding.index', navigate: true);
        }
    }

    public function render()
    {
        $latestCommit = null;
        if ($this->biddingAktif) {
            $latestCommit = DocumentCommit::where('id_bidding', $this->biddingAktif->id)->latest()->first();
        }

        return view('livewire.marketing.log-bidding', [
            'latestCommit' => $latestCommit
        ])->layout('components.layouts.app');
    }
}