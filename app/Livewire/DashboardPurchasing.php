<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\MaterialRequest;
use Illuminate\Support\Facades\DB;

class DashboardPurchasing extends Component
{
    public function render()
    {
        // 1. DATA KPI CARDS
        $kpiMaterial = Material::count();
        $kpiSupplier = Supplier::count();
        $kpiRequestPending = MaterialRequest::where('status', 'pending')->count();
        $kpiRequestApproved = MaterialRequest::where('status', 'approved')->count();

        // 2. DATA GRAFIK (Request Material per Bulan Tahun Ini)
        $chartData = MaterialRequest::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

        // Format array agar selalu berisi 12 elemen (Januari - Desember)
        $grafikRequest = [];
        for ($i = 1; $i <= 12; $i++) {
            $grafikRequest[] = $chartData[$i] ?? 0;
        }

        // 3. DATA REQUEST PENDING (Prioritas berdasarkan deadline terdekat)
        $requestPending = MaterialRequest::where('status', 'pending')
            ->orderBy('target_waktu_dibutuhkan', 'asc')
            ->take(5)
            ->get();

        // 4. DATA SUPPLIER TERATAS (Berdasarkan jumlah material yang disuplai)
        $supplierTeratas = Supplier::withCount('materials')
            ->orderBy('materials_count', 'desc')
            ->take(5)
            ->get();

        // 5. DATA MATERIAL TERPOPULER (Paling sering direquest)
        $materialTerpopuler = MaterialRequest::select('nama_material', DB::raw('COUNT(id) as total_request'))
            ->groupBy('nama_material')
            ->orderBy('total_request', 'desc')
            ->take(5)
            ->get();

        // 6. AKTIVITAS TERBARU (Riwayat pergerakan request)
        $aktivitasTerbaru = MaterialRequest::orderBy('updated_at', 'desc')
            ->take(6)
            ->get();

        return view('livewire.dashboard-purchasing', compact(
            'kpiMaterial', 'kpiSupplier', 'kpiRequestPending', 'kpiRequestApproved',
            'grafikRequest', 'requestPending', 'supplierTeratas', 'materialTerpopuler', 'aktivitasTerbaru'
        ))->layout('components.layouts.app');
    }
}
