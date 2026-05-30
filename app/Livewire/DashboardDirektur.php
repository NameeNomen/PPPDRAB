<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\RProject;
use App\Models\Rab;
use App\Models\DocumentCommit;

class DashboardDirektur extends Component
{
    public function render()
    {
        return view('livewire.dashboard-direktur', [
            'totalProyekAktif' => RProject::whereIn('status_proyek', ['bidding_process', 'won'])->count(),
            'proyekPending' => Rab::where('status_rab', 'pending_approval')->count(),
            'totalNilaiAktif' => Rab::where('status_rab', 'approved')->sum('grand_total'),
            'omzetPotensial' => Rab::where('status_rab', 'pending_approval')->sum('grand_total'),
            'antrianApproval' => Rab::with('project')->where('status_rab', 'pending_approval')->get(),
            'aktivitasTerbaru' => DocumentCommit::with('rab.project')->latest()->take(5)->get(),
// Ubah 'r_projects_id' menjadi 'id_r_project'
'topProyek' => RProject::with('rab')
    ->whereHas('rab')
    ->orderByDesc(
        Rab::select('grand_total')
            ->whereColumn('id_r_project', 'r_project.id') // Pastikan ini mencocokkan foreign key
    )
    ->take(5)
    ->get(),
            ])->layout('components.layouts.app');
    }
}