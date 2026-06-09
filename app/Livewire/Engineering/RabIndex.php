<?php
namespace App\Livewire\Engineering;

use Livewire\Component;
use App\Models\RProject;
use App\Models\Rab;

class RabIndex extends Component
{
    public $daftarProyek = [];
    public $searchProyek = '';
    public $filterStatus = 'all';

    public function mount()
    {
        $this->loadDaftarProyek();
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

    public function lihatDetail($id)
    {
        // Fitur klik bakal lempar user ke halaman Detail (Tahap 2)
        // Note: Kalau error 'Route not defined', cek file web.php lu.
        return $this->redirectRoute('engineering.rab.detail', ['id' => $id], navigate: true);
    }

    public function render()
    {
        return view('livewire.engineering.rab-index')->layout('components.layouts.app');
    }
}