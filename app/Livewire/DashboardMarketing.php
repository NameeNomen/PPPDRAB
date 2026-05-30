<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RProject;
use App\Models\Bidding;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardMarketing extends Component
{
    public function render()
    {
        $userId = Auth::id();

        // 1. Data Kotak Metrik
        $totalProyek = RProject::where('id_user', $userId)->count();
        $menungguEngineering = RProject::where('id_user', $userId)->where('status_proyek', 'waiting_rab')->count();
        $biddingAktif = Bidding::where('id_user', $userId)->whereIn('status_bidding', ['draft', 'sent'])->count();
        $proyekWon = RProject::where('id_user', $userId)->where('status_proyek', 'won')->count();

        // 2. Data Grafik Doughnut (Win Rate)
        $winRate = $totalProyek > 0 ? round(($proyekWon / $totalProyek) * 100) : 0;
        $sisaRate = 100 - $winRate;

        // 3. Data Grafik Garis (Tren 6 Bulan)
        $chartBulan = [];
        $chartDataProyek = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulanIni = Carbon::today()->startOfMonth()->subMonths($i);
            $chartBulan[] = $bulanIni->isoFormat('MMM'); 
            $chartDataProyek[] = RProject::where('id_user', $userId)
                                ->whereYear('created_at', $bulanIni->year)
                                ->whereMonth('created_at', $bulanIni->month)
                                ->count();
        }

        // 4. Data Tabel Histori
        $historiTerbaru = RProject::where('id_user', $userId)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        return view('livewire.dashboard-marketing', compact(
            'totalProyek', 'menungguEngineering', 'biddingAktif', 'proyekWon', 
            'historiTerbaru', 'winRate', 'sisaRate', 'chartBulan', 'chartDataProyek'
        ))->layout('components.layouts.app');
    }
}