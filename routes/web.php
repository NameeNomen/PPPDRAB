<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PdfController;

// 1. Route Root (Redirector Otomatis)
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'marketing') return redirect()->route('marketing.dashboard');
        if ($role === 'purchasing') return redirect()->route('purchasing.dashboard');
        if ($role === 'engineering') return redirect()->route('engineering.dashboard');
        if ($role === 'direktur') return redirect()->route('direktur.dashboard');
    }
    return redirect()->route('login');
});

// 2. Route Guest (Belum Login)
Route::get('/login', App\Livewire\Auth\Login::class)->name('login')->middleware('guest');

// 3. Route Wajib Login (Auth Group)
Route::middleware(['auth'])->group(function () {
    
    // Fitur Keluar (POST)
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    // ==========================================
    // AREA MARKETING
    // ==========================================
    // ==========================================
// AREA MARKETING
// ==========================================
Route::middleware(['role:marketing'])->group(function () {
    Route::get('/marketing/dashboard', App\Livewire\DashboardMarketing::class)->name('marketing.dashboard');
    Route::get('/marketing/proyek', App\Livewire\Marketing\KelolaProyek::class)->name('marketing.proyek');
    
    // PERHATIKAN TITIK KOMA DI UJUNG SINI
    Route::get('/marketing/bidding/histori', App\Livewire\Marketing\HistoriRevisiBidding::class)->name('marketing.bidding.histori');
    
    // SEKARANG BARIS INI JADI BARIS BARU YANG BERSIH
    Route::get('/marketing/bidding/{id?}',  App\Livewire\Marketing\KelolaBidding::class)->name('marketing.bidding');
});

    // ==========================================
    // AREA ENGINEERING
    // ==========================================
    Route::middleware(['role:engineering'])->group(function () {
        Route::get('/engineering/dashboard', App\Livewire\DashboardEngineering::class)->name('engineering.dashboard');
        Route::get('/engineering/rab', App\Livewire\Engineering\KelolaRab::class)->name('engineering.rab');
        Route::get('/engineering/rab/histori', App\Livewire\Engineering\Histori::class)->name('engineering.rab.histori'); 
        Route::get('/engineering/rab/{id}/wbs', App\Livewire\Engineering\EditorWbs::class)->name('engineering.wbs');
    });

    // ==========================================
    // AREA PURCHASING
    // ==========================================
    Route::middleware(['role:purchasing'])->group(function () {
        Route::get('/purchasing/dashboard', App\Livewire\DashboardPurchasing::class)->name('purchasing.dashboard');
        Route::get('/purchasing/material', App\Livewire\Purchasing\KelolaMaterial::class)->name('purchasing.material');
    });

    // ==========================================
    // AREA DIREKTUR
    // ==========================================
    Route::middleware(['role:direktur'])->group(function () {
        Route::get('/direktur/dashboard', App\Livewire\DashboardDirektur::class)->name('direktur.dashboard');
        Route::get('/direktur/persetujuan/{id?}', App\Livewire\Direktur\KelolaPersetujuan::class)->name('direktur.persetujuan');
    });

    // ==========================================
    // ROUTE CETAK DOKUMEN (PDF)
    // ==========================================
    Route::get('/cetak/bidding/{id}', [PdfController::class, 'cetakBidding'])->name('cetak.bidding');
    Route::get('/cetak/rab/{id}', [PdfController::class, 'cetakRab'])->name('cetak.rab');

});