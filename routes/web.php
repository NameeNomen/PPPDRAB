<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProjectPreviewController; // <-- Jangan lupa di-import!
use App\Livewire\Engineering\RabIndex;
use App\Livewire\Engineering\RabDetail; 
use App\Livewire\Engineering\RabWorkspace; 
use App\Models\RProject;

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
    Route::middleware(['role:marketing'])->prefix('marketing')->group(function () {
        
        // Modul Dashboard & Proyek

        Route::get('/marketing/bidding/log/{id}', \App\Livewire\Marketing\LogBidding::class)
    ->name('marketing.bidding.log');
        Route::get('/dashboard', App\Livewire\DashboardMarketing::class)->name('marketing.dashboard');
        Route::get('/proyek', App\Livewire\Marketing\KelolaProyek::class)->name('marketing.proyek');
        Route::get('/proyek/preview/{id}', [ProjectPreviewController::class, 'show'])->name('marketing.proyek.preview');
        Route::get('/proyek/detail/{id}', function($id) {
            $proyek = App\Models\RProject::with(['category', 'user', 'attachments'])->findOrFail($id);
            return view('livewire.marketing.detail', compact('proyek')); 
        })->name('marketing.proyek.detail');
        
        // Modul Bidding
        Route::get('/bidding', App\Livewire\Marketing\BiddingIndex::class)->name('marketing.bidding.index');
        Route::get('/bidding/histori', App\Livewire\Marketing\HistoriRevisiBidding::class)->name('marketing.bidding.histori');
        Route::get('/bidding/workspace/{id}', App\Livewire\Marketing\BiddingDetail::class)->name('marketing.bidding.detail');
    });

    // ==========================================
    // AREA ENGINEERING
    // ==========================================
    Route::middleware(['role:engineering'])->prefix('engineering')->group(function () {

        Route::get('/dashboard', App\Livewire\DashboardEngineering::class)->name('engineering.dashboard');
        
        // Kelola RAB
        Route::get('/kelola-rab', App\Livewire\Engineering\RabIndex::class)->name('engineering.rab.index');
        Route::get('/kelola-rab/{id}/detail', App\Livewire\Engineering\RabDetail::class)->name('engineering.rab.detail');
        Route::get('/kelola-rab/{id}/workspace', App\Livewire\Engineering\RabWorkspace::class)->name('engineering.rab.workspace'); 
        
        // Audit Trail & Histori Commit
        Route::get('/rab/histori', App\Livewire\Engineering\Histori::class)->name('engineering.rab.histori'); 
        
        // Editor WBS (Opsional)
        Route::get('/rab/{id}/wbs', App\Livewire\Engineering\EditorWbs::class)->name('engineering.wbs');

        // Cetak PDF dari Snapshot JSON
        Route::get('/cetak-versi/{commit_id}', function($commit_id) {
            $commit = \App\Models\DocumentCommit::findOrFail($commit_id);
            $rabAktif = \App\Models\Rab::findOrFail($commit->id_rab);
            $selectedProject = \App\Models\RProject::with('attachments')->findOrFail($rabAktif->id_r_project);
            
            $nama_pembuat = $commit->user_name ?? 'Sistem Automation';
            $kategoris = json_decode(json_encode($commit->snapshot_data));

            if(empty($kategoris)) {
                $kategoris = \App\Models\RabItem::where('id_rab', $rabAktif->id)
                    ->where('tipe', 'kategori')
                    ->whereNull('parent_id')
                    ->with(['children' => function($q) {
                        $q->with('children.material', 'material');
                    }])->get();
            }

            return view('engineering.cetak-rab', compact('selectedProject', 'rabAktif', 'kategoris', 'nama_pembuat'));
        })->name('engineering.cetak.versi');

        // Export Excel dari Snapshot JSON
        Route::get('/export-excel/{commit_id}', function($commit_id) {
            $commit = \App\Models\DocumentCommit::findOrFail($commit_id);
            $rabAktif = \App\Models\Rab::findOrFail($commit->id_rab);
            $selectedProject = \App\Models\RProject::with('attachments')->findOrFail($rabAktif->id_r_project);
            
            $kategoris = json_decode(json_encode($commit->snapshot_data));

            if(empty($kategoris)) {
                $kategoris = \App\Models\RabItem::where('id_rab', $rabAktif->id)
                    ->where('tipe', 'kategori')
                    ->whereNull('parent_id')
                    ->with(['children' => function($q) {
                        $q->with('children.material', 'material');
                    }])->get();
            }

            $filename = "RAB_VERSION_" . $commit_id . "_" . date('Ymd') . ".xls";

            return response()->view('engineering.excel-rab', compact('selectedProject', 'rabAktif', 'kategoris'))
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Cache-Control', 'max-age=0');
        })->name('engineering.export.excel');

    });

    // ==========================================
    // AREA PURCHASING
    // ==========================================
    Route::middleware(['role:purchasing'])->prefix('purchasing')->group(function () {
        
        Route::get('/dashboard', App\Livewire\DashboardPurchasing::class)->name('purchasing.dashboard');
        
        Route::get('/material', App\Livewire\Purchasing\MaterialIndex::class)->name('material.index');
        Route::get('/material/create', App\Livewire\Purchasing\MaterialForm::class)->name('material.create');
        Route::get('/material/{id}/edit', App\Livewire\Purchasing\MaterialForm::class)->name('material.edit');
        Route::get('/material/{id}/review-request', App\Livewire\Purchasing\ReviewRequest::class)->name('material.review');
    });

    // ==========================================
    // AREA DIREKTUR
    // ==========================================
    Route::middleware(['role:direktur'])->prefix('direktur')->group(function () {
        
        Route::get('/dashboard', App\Livewire\DashboardDirektur::class)->name('direktur.dashboard');
        Route::get('/company-profile', App\Livewire\Direktur\CompanyProfilePage::class)->name('direktur.company-profile');
        Route::get('/persetujuan', App\Livewire\Direktur\PersetujuanIndex::class)->name('direktur.persetujuan');
        Route::get('/persetujuan/proyek/{id}', App\Livewire\Direktur\PersetujuanDetail::class)->name('direktur.persetujuan.detail');    
    });

    // ==========================================
    // ROUTE CETAK DOKUMEN (PDF & GLOBAL)
    // ==========================================
    Route::get('/cetak/bidding/{id}', [PdfController::class, 'cetakBidding'])->name('cetak.bidding');
    Route::get('/cetak/rab/{id}', [PdfController::class, 'cetakRab'])->name('cetak.rab');

});