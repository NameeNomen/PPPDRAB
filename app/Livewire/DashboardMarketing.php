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
        // Mengambil ID user yang sedang login untuk keamanan isolasi data
        $userId = Auth::id();

        // ==========================================
        // 1. DATA KOTAK METRIK (ATAS)
        // ==========================================

        // Total RFQ Masuk: Menghitung semua baris di tabel r_project milik user ini
$totalRfq = RProject::count();

        // Siap Dibuat Bidding: Cross-check ke tabel rabs
        // PERINGATAN: Pastikan kolom di database RAB kamu benar bernama 'status_rab'. 
        // Kalau namanya cuma 'status', ganti kata 'status_rab' di bawah menjadi 'status'.
        $siapBidding = RProject::where('id_user', $userId)
            ->whereHas('rab', function ($query) {
                $query->where('status_rab', 'approved'); 
            })
            ->count();

        // Menunggu Approval Direktur: Hitung bidding user ini yang statusnya 'pending'
        $menungguApproval = Bidding::where('id_user', $userId)
            ->where('status_bidding', 'pending')
            ->count();

        // Nilai Potensi Penjualan: Akumulasi nilai uang dari penawaran yang masih "hidup"
        $potensiPenjualan = Bidding::where('id_user', $userId)
            ->whereIn('status_bidding', ['draft', 'pending', 'approved', 'sent', 'won'])
            ->sum('total_penawaran');


        // ==========================================
        // 2. DATA LIST & TABEL (TENGAH & BAWAH)
        // ==========================================

        // RFQ Terbaru: Ambil 5 data terbaru yang diurutkan dari waktu pembuatan (created_at)
        $rfqTerbaru = RProject::with('category')
            ->where('id_user', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Proyek Siap Dibidding: Ambil 5 data riil yang RAB-nya sudah di-approve
        $proyekSiapBidding = RProject::where('id_user', $userId)
            ->whereHas('rab', function ($query) {
                $query->where('status_rab', 'approved');
            })
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();


        // ==========================================
        // 3. ENGINE GRAFIK (WON VS LOST)
        // ==========================================
        
        $chartBulan = [];
        $chartWon = [];
        $chartLost = [];

        // Looping mundur dari 5 bulan lalu sampai bulan ini (Total 6 bulan)
        for ($i = 5; $i >= 0; $i--) {
            // Ambil titik waktu (bulan dan tahun) yang sedang diproses
            $bulanIni = Carbon::today()->startOfMonth()->subMonths($i);
            $chartBulan[] = $bulanIni->isoFormat('MMM');

            // Hitung jumlah Won di bulan spesifik tersebut
            $chartWon[] = Bidding::where('id_user', $userId)
                ->where('status_bidding', 'won')
                ->whereYear('created_at', $bulanIni->year)
                ->whereMonth('created_at', $bulanIni->month)
                ->count();

            // Hitung jumlah Lost di bulan spesifik tersebut
            $chartLost[] = Bidding::where('id_user', $userId)
                ->where('status_bidding', 'lost')
                ->whereYear('created_at', $bulanIni->year)
                ->whereMonth('created_at', $bulanIni->month)
                ->count();
        }

        // Kirim semua variabel ke file view Blade
        return view('livewire.dashboard-marketing', compact(
            'totalRfq',
            'siapBidding',
            'menungguApproval',
            'potensiPenjualan',
            'rfqTerbaru',
            'proyekSiapBidding',
            'chartBulan',
            'chartWon',
            'chartLost'
        ))->layout('components.layouts.app');
    }
}

