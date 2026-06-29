<?php
namespace App\Livewire\Marketing;

use Livewire\Component;
use App\Models\RProject;
use App\Models\Bidding;
use App\Models\DocumentCommit;

class HistoriRevisiBidding extends Component
{
    public $view = 'project-list';
    
    // Properti Search Binding
    public $searchProyek = '';
    public $searchCommit = '';
    
    // Properti Koleksi Data
    public $projects = [];
    public $historiCommits = [];
    
    // Properti State Pointer Terpilih
    public $selectedProject = null;
    public $biddingData = null;
    public $selectedCommit = null;
    public $expandedKomentar = [];

    public function mount()
    {
        $this->loadProjects();
    }

    // STATE 1: Ambil semua proyek yang sudah terbit Bidding-nya
    public function loadProjects()
    {
        $proyekBerBiddingIds = Bidding::pluck('id_r_project')->unique()->toArray();
        $query = RProject::whereIn('id', $proyekBerBiddingIds)->orderBy('updated_at', 'desc');

        if (!empty($this->searchProyek)) {
            $query->where(function($q) {
                $q->where('nama_pelanggan', 'like', '%' . $this->searchProyek . '%')
                  ->orWhere('request_no', 'like', '%' . $this->searchProyek . '%');
            });
        }

        $this->projects = $query->get();
    }

    public function updatedSearchProyek()
    {
        $this->loadProjects();
    }

    //  Menampilkan daftar riwayat perubahan (Commit) dari satu proyek
    public function showCommits($id_project)
    {
        $this->selectedProject = RProject::with(['rabs' => function($q) {
            $q->where('status_rab', 'approved')->latest();
        }])->findOrFail($id_project);
        
        $this->biddingData = Bidding::where('id_r_project', $id_project)->first();
        $this->loadCommits();
        $this->expandedKomentar = [];
        $this->searchCommit = '';
        $this->view = 'commit-list';
    }

    public function loadCommits()
    {
        if ($this->biddingData) {
            $query = DocumentCommit::where('id_bidding', $this->biddingData->id)
                ->orderBy('created_at', 'desc');

            if (!empty($this->searchCommit)) {
                $query->where(function($q) {
                    $q->where('komentar_commit', 'like', '%' . $this->searchCommit . '%')
                      ->orWhere('jenis_aksi', 'like', '%' . $this->searchCommit . '%')
                      ->orWhere('user_name', 'like', '%' . $this->searchCommit . '%');
                });
            }

            $this->historiCommits = $query->get();
        } else {
            $this->historiCommits = [];
        }
    }

    public function updatedSearchCommit()
    {
        $this->loadCommits();
    }

    // STATE 3: Membuka berkas spesifik pada log commit tertentu
    public function showDetail($commitId)
    {
        $this->selectedCommit = DocumentCommit::findOrFail($commitId);
        $this->view = 'detail-view';
    }

    // SISTEM NAVIGASI MUNDUR (Back)
    public function goBack()
    {
        if ($this->view === 'detail-view') {
            $this->view = 'commit-list';
            $this->selectedCommit = null;
        } else {
            $this->view = 'project-list';
            $this->selectedProject = null;
            $this->biddingData = null;
            $this->historiCommits = [];
            $this->loadProjects();
        }
    }

    public function toggleKomentar($commit_id)
    {
        if (isset($this->expandedKomentar[$commit_id])) {
            unset($this->expandedKomentar[$commit_id]);
        } else {
            $this->expandedKomentar[$commit_id] = true;
        }
    }

    public function render()
    {
        return view('livewire.marketing.histori-revisi-bidding')->layout('components.layouts.app');
    }
}