<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Material;
// Asumsi model ini bakal lu bikin nanti
use App\Models\Supplier; 
use App\Models\PurchaseTransaction; 

class DashboardPurchasing extends Component
{
    public $searchMaterial = '';

    public function render()
    {
        // 1. TOP CARDS DATA (MURNI PURCHASING)
        $totalMaterial = Material::count();
        
        $totalSupplier = class_exists(Supplier::class) ? Supplier::count() : 0;
        
        // Total Nilai Pembelian Bulan Ini
        $pembelianBulanIni = class_exists(PurchaseTransaction::class) 
            ? PurchaseTransaction::whereMonth('created_at', now()->month)->sum('total_harga') 
            : 0;

        // Total Frekuensi Transaksi (PO) Bulan Ini
        $trxBulanIni = class_exists(PurchaseTransaction::class)
            ? PurchaseTransaction::whereMonth('created_at', now()->month)->count()
            : 0;

        // 2. TABLE DATA: Material (Live Database, Tanpa Stok)
        $queryMaterial = Material::orderBy('updated_at', 'desc');
        if (!empty($this->searchMaterial)) {
            $queryMaterial->where('nama_barang', 'like', '%' . $this->searchMaterial . '%');
        }
        $daftarMaterial = $queryMaterial->take(5)->get();

        // 3. TABLE DATA: Supplier 
        $daftarSupplier = class_exists(Supplier::class) 
            ? Supplier::withCount('transactions')->orderBy('transactions_count', 'desc')->take(5)->get() 
            : collect([]);

        return view('livewire.dashboard-purchasing', compact(
            'totalMaterial', 'totalSupplier', 'pembelianBulanIni', 'trxBulanIni',
            'daftarMaterial', 'daftarSupplier'
        ))->layout('components.layouts.app');
    }
}