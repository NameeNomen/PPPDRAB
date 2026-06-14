<?php

namespace App\Livewire\Direktur;

use Livewire\Component;
use App\Models\RProject;

class PersetujuanIndex extends Component
{
    public function bukaProyek($id)
    {
        // Pindah ke ruang kerja detail proyek
        return $this->redirectRoute('direktur.persetujuan.detail', ['id' => $id], navigate: true);
    }

    public function render()
    {
        // LOGIKA BENAR: Cari proyek yang RAB-nya 'pending' ATAU Bidding-nya 'pending'
        $proyekPending = RProject::whereHas('rabs', function($q) {
            $q->where('status_rab', 'pending');
        })->orWhereHas('biddings', function($q) {
            $q->where('status_bidding', 'pending');
        })->orderBy('updated_at', 'desc')->get();

        return view('livewire.direktur.persetujuan-index', compact('proyekPending'))
            ->layout('components.layouts.app');
    }
}