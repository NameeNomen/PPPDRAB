<?php

namespace App\Livewire\Engineering;

use Livewire\Component;
use App\Models\RProject;

class RabIndex extends Component
{
    public $searchProyek = '';
    public $filterStatus = 'all';

    public function mount() {}

    public function lihatDetail($id)
    {
        return $this->redirectRoute('engineering.rab.detail', ['id' => $id], navigate: true);
    }

 public function render()
{
    $query = RProject::with(['rab', 'category'])->orderBy('updated_at', 'desc');

    if (!empty($this->searchProyek)) {
        $query->where(function($q) {
            $q->where('nama_pelanggan', 'like', '%' . $this->searchProyek . '%')
              ->orWhere('request_no', 'like', '%' . $this->searchProyek . '%');
        });
    }

    $daftarProyek = $query->get();

    // Filter berdasarkan status
    if ($this->filterStatus !== 'all' && $this->filterStatus !== 'needs_action') {
        $daftarProyek = $daftarProyek->filter(function($p) {
            // Handle jika tidak ada RAB
            if (!$p->rab) {
                return $this->filterStatus === 'draft'; // Anggap draft kalau belum ada RAB
            }
            
            $status = strtolower($p->rab->status_rab ?? 'draft');
            return $status === $this->filterStatus;
        })->values();
    }

    return view('livewire.engineering.rab-index', [
        'daftarProyek' => $daftarProyek
    ])->layout('components.layouts.app');
}
}