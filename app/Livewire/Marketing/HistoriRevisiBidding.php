<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use App\Models\Bidding;
use App\Models\RProject;

class HistoriRevisiBidding extends Component
{
    public $view = 'project-list'; 
    public $projects = [];
    public $biddings = [];
    public $selectedProject = null;
    public $selectedBidding = null;

    public function mount()
    {
        // Tarik proyek yang punya data bidding
        $this->projects = RProject::whereHas('biddings')->get();
    }

    public function showBiddings($projectId)
    {
        $this->selectedProject = RProject::find($projectId);
        $this->biddings = Bidding::where('id_r_project', $projectId)->orderBy('created_at', 'desc')->get();
        $this->view = 'bidding-list';
    }

    public function showDetail($biddingId)
    {
        $this->selectedBidding = Bidding::with(['project', 'documentCommits.user'])->findOrFail($biddingId);
        $this->view = 'detail-view';
    }

    public function goBack()
    {
        if ($this->view === 'detail-view') {
            $this->view = 'bidding-list';
            $this->selectedBidding = null;
        } else {
            $this->view = 'project-list';
            $this->selectedProject = null;
            $this->biddings = [];
        }
    }

    public function render()
    {
        return view('livewire.marketing.histori-revisi-bidding')->layout('components.layouts.app');
    }
}