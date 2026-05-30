<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RProject;
use App\Models\DocumentCommit;

class DashboardEngineering extends Component
{
    public function render()
    {
        // 4 Kartu Statistik
        $countBidding = RProject::where('status_proyek', 'bidding_process')->count();
        $countProduksi = RProject::where('status_proyek', 'won')->count();
        $countWaiting = RProject::where('status_proyek', 'waiting_rab')->count();
        $countApproved = RProject::where('status_proyek', 'rab_approved')->count();

        // Log Aktivitas (Relasi ke Rab dan Project)
        $aktivitasLog = DocumentCommit::with('rab.project') 
                                      ->orderBy('created_at', 'desc')
                                      ->take(6)
                                      ->get();

        return view('livewire.dashboard-engineering', [
            'countWaiting' => $countWaiting,
            'countApproved' => $countApproved,
            'countBidding' => $countBidding,
            'countProduksi' => $countProduksi,
            'aktivitasLog'  => $aktivitasLog,
        ])->layout('components.layouts.app');
    }
}