<?php

namespace App\Livewire\Engineering;

use Livewire\Component;
use App\Models\RProject;
use App\Models\Rab;
use App\Models\DocumentCommit;

class Histori extends Component
{
    public $view = 'project-list';
    
    // Properti Search
    public $searchProyek = '';
    public $searchCommit = '';

    // Properti Data
    public $projects = [];
    public $historiCommits = [];

    // Properti State Terpilih
    public $selectedProject = null;
    public $rabData = null;
    public $selectedCommit = null;

    public $expandedKomentar = [];

    public function mount()
    {
        $this->loadProjects();
    }

    // STATE 1: Load semua proyek yang sudah punya RAB
    public function loadProjects()
    {
        $proyekBerRabIds = Rab::pluck('id_r_project')->unique()->toArray();
        
        $query = RProject::whereIn('id', $proyekBerRabIds)->orderBy('updated_at', 'desc');
        
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

    // STATE 2: Masuk ke daftar commit sebuah proyek
    public function showCommits($id_project)
    {
        $this->selectedProject = RProject::findOrFail($id_project);
        $this->rabData = Rab::where('id_r_project', $id_project)->first();
        
        $this->loadCommits();
        
        $this->expandedKomentar = [];
        $this->searchCommit = '';
        $this->view = 'commit-list';
    }

    public function loadCommits()
    {
        if ($this->rabData) {
            $query = DocumentCommit::where('id_rab', $this->rabData->id)
                                   ->orderBy('created_at', 'desc'); // Paling baru di atas

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

    // STATE 3: Masuk ke detail dokumen satu commit spesifik
    public function showDetail($commitId)
    {
        $this->selectedCommit = DocumentCommit::findOrFail($commitId);
        $this->view = 'detail-view';
    }

    // FUNGSI NAVIGASI MUNDUR
    public function goBack()
    {
        if ($this->view === 'detail-view') {
            $this->view = 'commit-list';
            $this->selectedCommit = null;
        } else {
            $this->view = 'project-list';
            $this->selectedProject = null;
            $this->rabData = null;
            $this->historiCommits = [];
            $this->loadProjects(); 
        }
    }

    // UTILITIES
    public function toggleKomentar($commit_id)
    {
        if (isset($this->expandedKomentar[$commit_id])) {
            unset($this->expandedKomentar[$commit_id]);
        } else {
            $this->expandedKomentar[$commit_id] = true;
        }
    }

    public function cetakVersi($commit_id, $versi)
    {
        session()->flash('sukses', "Sistem sedang memproses Cetak PDF untuk Dokumen RAB Versi {$versi}...");
    }

    public function render()
    {
        // Jangan lupa layoutnya biar nggak error 500 lagi!
        return view('livewire.engineering.histori')->layout('components.layouts.app');
    }
}