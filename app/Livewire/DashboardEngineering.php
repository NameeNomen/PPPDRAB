<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RProject;
use App\Models\Rab;
use App\Models\DocumentCommit;
use App\Models\MaterialRequest;

class DashboardEngineering extends Component
{
    public function render()
    {
        $rfqMasuk = RProject::whereDoesntHave('rab')->count(); // Proyek baru yang belum punya RAB sama sekali
        $rabDraft = Rab::where('status_rab', 'draft')->count(); // Lagi lu kerjain
        $rabPending = Rab::where('status_rab', 'pending')->count(); // Udah di meja direktur
        $rabRevision = Rab::where('status_rab', 'revision')->count(); // Direktur minta revisi

        $proyekPrioritas = RProject::whereDoesntHave('rab')
            ->orWhereHas('rab', function($q) {
                $q->whereIn('status_rab', ['draft', 'revision']);
            })->orderBy('created_at', 'asc')->take(5)->get();

        // Request Material Terbaru
        $requestMaterial = MaterialRequest::with('project')->latest()->take(5)->get();

        // Revisi dari Direktur (Ambil history dengan aksi revisi)
        $revisiDirektur = DocumentCommit::with('rab.project')
            ->where('jenis_aksi', 'revised')
            ->latest()->take(5)->get();

        // Log Aktivitas Keseluruhan
        $aktivitasLog = DocumentCommit::with(['rab.project', 'project'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('livewire.dashboard-engineering', [
            'rfqMasuk' => $rfqMasuk,
            'rabDraft' => $rabDraft,
            'rabPending' => $rabPending,
            'rabRevision' => $rabRevision,
            'proyekPrioritas' => $proyekPrioritas,
            'requestMaterial' => $requestMaterial,
            'revisiDirektur' => $revisiDirektur,
            'aktivitasLog'  => $aktivitasLog,
        ])->layout('components.layouts.app');
    }
}