<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RProject;
use App\Models\Rab;
use App\Models\DocumentCommit;
use Illuminate\Support\Facades\DB;

class DashboardDirektur extends Component
{
    public function render()
    {
        // Deteksi database untuk chart
        $driver = DB::connection()->getDriverName();
        $bulanRaw = $driver === 'sqlite' ? "CAST(strftime('%m', created_at) AS INTEGER)" : 'MONTH(created_at)';

        // 1. Data KPI
        $totalProyekPending = RProject::whereIn('status_proyek', ['pending', 'draft', 'approved'])->count();
        $totalNilaiAktif = Rab::where('status_rab', 'approved')->sum('grand_total');
        $omzetPotensial = Rab::where('status_rab', 'pending_approval')->sum('grand_total');
        
        // 2. Chart Data
        $chartRaw = DocumentCommit::select(
            DB::raw("$bulanRaw as bulan"),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

        $grafikData = [];
        for ($i = 1; $i <= 12; $i++) {
            $grafikData[] = $chartRaw[$i] ?? 0;
        }

        // 3. Data Lainnya
        $antrianApproval = Rab::with('project')->where('status_rab', 'pending_approval')->get();
        $aktivitasTerbaru = DocumentCommit::with('rab.project')->latest()->take(5)->get();
        
        $topProyek = RProject::with('rab')
            ->whereHas('rab')
            ->orderByDesc(Rab::select('grand_total')->whereColumn('id_r_project', 'r_project.id'))
            ->take(5)
            ->get();

        return view('livewire.dashboard-direktur', [
            'totalProyekPending' => $totalProyekPending,
            'totalNilaiAktif' => $totalNilaiAktif,
            'omzetPotensial' => $omzetPotensial,
            'grafikData' => $grafikData,
            'antrianApproval' => $antrianApproval,
            'aktivitasTerbaru' => $aktivitasTerbaru,
            'topProyek' => $topProyek
        ])->layout('components.layouts.app');
    }
}