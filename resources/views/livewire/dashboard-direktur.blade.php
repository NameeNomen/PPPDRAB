<div class="min-h-screen p-8" style="background-color: #FAF8F3;">
    <div class="max-w-7xl mx-auto space-y-10">
        
        <!-- Header -->
        <header class="flex justify-between items-end border-b pb-8" style="border-color: #8A7F8D33;">
            <div>
                <h1 class="text-3xl font-black tracking-tight" style="color: #8A7F8D;">Executive Control</h1>
                <p class="text-xs font-bold tracking-widest uppercase mt-1" style="color: #C9A38D;">PPDRAB Control System — Tri Jaya Teknik</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#4B5563] opacity-60">Last Update</p>
                <p class="text-sm font-bold" style="color: #8A7F8D;">{{ now()->format('d M Y - H:i') }}</p>
            </div>
        </header>

        <!-- 1. Statistik Utama -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach([['Total Proyek Aktif', $totalProyekAktif], ['Pending Approval', $proyekPending], ['Nilai Proyek Aktif', 'Rp '.number_format($totalNilaiAktif/1000000, 1).'M'], ['Omzet Potensial', 'Rp '.number_format($omzetPotensial/1000000, 1).'M']] as $stat)
            <div class="p-6 rounded-3xl border border-black/5 bg-white shadow-sm">
                <p class="text-[9px] font-black uppercase tracking-widest mb-2" style="color: #C9A38D;">{{ $stat[0] }}</p>
                <p class="text-2xl font-black" style="color: #8A7F8D;">{{ $stat[1] }}</p>
            </div>
            @endforeach
        </div>

        <!-- 2, 3 & 6. Grafik & Top Proyek -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-[#8A7F8D]/10 shadow-sm">
                <h2 class="text-xs font-black uppercase tracking-widest mb-6" style="color: #8A7F8D;">Analisis Tren Proyek & Omzet</h2>
                <div class="h-64 flex items-center justify-center bg-[#FAF8F3] rounded-2xl border border-dashed border-[#C9A38D]/30 text-[#C9A38D] text-xs font-bold">[Line Chart & Bar Chart Area]</div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-[#8A7F8D]/10 shadow-sm">
                <h2 class="text-xs font-black uppercase tracking-widest mb-6" style="color: #8A7F8D;">Top 5 Proyek Terbesar</h2>
                <div class="space-y-4">
                    @foreach($topProyek as $p)
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-bold text-[#4B5563] truncate mr-4">{{ $p->nama_pelanggan }}</span>
                        <span class="font-mono font-black" style="color: #C9A38D;">Rp {{ number_format($p->rab->grand_total, 0) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 4 & 5. Widget Pending & Aktivitas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-3xl border border-[#8A7F8D]/10 shadow-sm">
                <h2 class="text-xs font-black uppercase tracking-widest mb-6" style="color: #8A7F8D;">Pending Persetujuan</h2>
                <div class="space-y-4">
                    @foreach($antrianApproval as $item)
                    <div class="flex justify-between items-center p-4 rounded-2xl" style="background-color: #FAF8F3;">
                        <div>
                            <p class="font-bold text-sm" style="color: #8A7F8D;">{{ $item->project->nama_pelanggan }}</p>
                            <p class="text-[10px] text-[#4B5563] opacity-60 uppercase">{{ $item->no_boq }} • {{ $item->created_at->format('d M') }}</p>
                        </div>
                        <button class="text-white text-[10px] font-black px-4 py-2 rounded-xl" style="background-color: #C9A38D;">REVIEW</button>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-[#8A7F8D]/10 shadow-sm">
                <h2 class="text-xs font-black uppercase tracking-widest mb-6" style="color: #8A7F8D;">Aktivitas Terkini</h2>
                <div class="space-y-6">
                    @foreach($aktivitasTerbaru as $log)
                    <div class="relative pl-6 border-l-2" style="border-color: #C9A38D50;">
                        <span class="absolute -left-[5px] top-1 w-2 h-2 rounded-full" style="background-color: #C9A38D;"></span>
                        <p class="text-xs font-bold" style="color: #8A7F8D;">{{ $log->user_name }}</p>
                        <p class="text-[10px] font-medium text-[#4B5563] opacity-80 mt-1">
                            {{ $log->jenis_aksi }} pada <span class="font-bold">{{ $log->rab->project->nama_pelanggan ?? 'Proyek' }}</span>
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>