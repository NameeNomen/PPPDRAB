<div class="min-h-screen pb-10 font-sans transition-colors duration-500" style="background-color: #FAF8F3;">
    <div class="max-w-7xl mx-auto space-y-8 p-6 md:p-10">
        
        <header class="flex flex-col md:flex-row justify-between items-start md:items-end border-b pb-6 gap-4" style="border-color: #8A7F8D33;">
            <div>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight uppercase" style="color: #8A7F8D;">Executive Control</h1>
                <p class="text-[11px] font-bold tracking-widest uppercase mt-2" style="color: #C9A38D;">PPDRAB Control System — Tri Jaya Teknik</p>
            </div>
            <div class="text-left md:text-right bg-white px-5 py-3 rounded-2xl border border-[#8A7F8D]/10 shadow-sm">
                <p class="text-[9px] font-black uppercase tracking-widest text-[#4B5563] opacity-60">Status Data Realtime</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <p class="text-sm font-bold font-mono" style="color: #8A7F8D;">{{ now()->format('d M Y - H:i') }}</p>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @foreach([
                ['Total Proyek Aktif', $totalProyekAktif], 
                ['Pending Approval', $proyekPending], 
                ['Nilai Proyek Aktif', 'Rp '.number_format($totalNilaiAktif/1000000, 1).'M'], 
                ['Omzet Potensial', 'Rp '.number_format($omzetPotensial/1000000, 1).'M']
            ] as $stat)
            <div class="p-6 rounded-[2rem] border border-black/5 bg-white shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-[#C9A38D] opacity-5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <p class="text-[10px] font-black uppercase tracking-widest mb-3 relative z-10" style="color: #C9A38D;">{{ $stat[0] }}</p>
                <p class="text-2xl md:text-3xl font-black font-mono relative z-10" style="color: #8A7F8D;">{{ $stat[1] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-[2rem] border border-[#8A7F8D]/10 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xs font-black uppercase tracking-widest" style="color: #8A7F8D;">Analisis Tren Proyek & Omzet</h2>
                    <span class="text-[10px] font-bold px-3 py-1 bg-[#FAF8F3] rounded-full text-[#C9A38D]">Bulan Ini</span>
                </div>
                <div class="h-[250px] flex flex-col items-center justify-center rounded-2xl border-2 border-dashed transition-colors hover:bg-slate-50" style="background-color: #FAF8F3; border-color: #C9A38D40;">
                    <svg class="w-8 h-8 mb-3 opacity-50" style="color: #C9A38D;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    <span class="text-[#C9A38D] text-xs font-bold uppercase tracking-widest">[ Ruang Integrasi Chart.js ]</span>
                </div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-[2rem] border border-[#8A7F8D]/10 shadow-sm">
                <h2 class="text-xs font-black uppercase tracking-widest mb-6" style="color: #8A7F8D;">Top 5 Valuasi Tertinggi</h2>
                <div class="space-y-4">
                    @forelse($topProyek as $p)
                    <div class="flex flex-col border-b border-[#FAF8F3] pb-3 last:border-0 hover:bg-[#FAF8F3]/50 p-2 rounded-xl transition-colors">
                        <span class="font-black text-[11px] uppercase tracking-wide text-[#8A7F8D] truncate mb-1">{{ $p->nama_pelanggan }}</span>
                        <span class="font-mono font-bold text-xs" style="color: #C9A38D;">Rp {{ number_format($p->rab->grand_total ?? 0, 0, ',', '.') }}</span>
                    </div>
                    @empty
                    <div class="py-8 text-center text-xs italic opacity-50 text-[#8A7F8D]">Belum ada proyek terdaftar.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
            <div class="bg-white p-6 md:p-8 rounded-[2rem] border border-[#8A7F8D]/10 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xs font-black uppercase tracking-widest" style="color: #8A7F8D;">Pending Otorisasi</h2>
                    @if($antrianApproval->count() > 0)
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                        </span>
                    @endif
                </div>
                <div class="space-y-4">
                    @forelse($antrianApproval as $item)
                    <div class="flex justify-between items-center p-5 rounded-2xl border border-[#8A7F8D]/5 hover:shadow-md transition-all group" style="background-color: #FAF8F3;">
                        <div>
                            <p class="font-black text-xs uppercase tracking-wide" style="color: #8A7F8D;">{{ $item->project->nama_pelanggan ?? 'Sistem' }}</p>
                            <p class="text-[10px] text-[#4B5563] opacity-60 uppercase font-mono font-bold mt-1">REF: {{ $item->no_boq }} • {{ $item->created_at->format('d M') }}</p>
                        </div>
                        <a href="/direktur/persetujuan" class="text-white text-[10px] font-black uppercase tracking-widest px-5 py-2.5 rounded-xl transition-all hover:scale-105 shadow-sm group-hover:shadow-md" style="background-color: #C9A38D;">
                            TINJAU
                        </a>
                    </div>
                    @empty
                    <div class="p-8 text-center border-2 border-dashed border-[#8A7F8D]/20 rounded-2xl">
                        <p class="text-[10px] font-bold text-[#8A7F8D] opacity-60 uppercase tracking-widest">Semua dokumen bersih.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-[2rem] border border-[#8A7F8D]/10 shadow-sm">
                <h2 class="text-xs font-black uppercase tracking-widest mb-8" style="color: #8A7F8D;">Log Audit Sistem</h2>
                <div class="relative border-l-2 ml-3 space-y-8" style="border-color: #C9A38D40;">
                    @forelse($aktivitasTerbaru as $log)
                    <div class="relative pl-6">
                        <span class="absolute -left-[7px] top-1 w-3 h-3 rounded-full border-2 border-white shadow-sm" style="background-color: #C9A38D;"></span>
                        <div class="bg-[#FAF8F3] p-4 rounded-2xl border border-[#8A7F8D]/5">
                            <div class="flex justify-between items-start mb-1">
                                <p class="text-xs font-black uppercase" style="color: #8A7F8D;">{{ $log->user_name }}</p>
                                <span class="text-[9px] font-bold font-mono opacity-50" style="color: #8A7F8D;">
                                    {{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}
                                </span>
                            </div>
                            <p class="text-[10px] font-medium text-[#4B5563] opacity-80 leading-relaxed">
                                Aksi <span class="font-bold uppercase px-1 rounded" style="background-color: #C9A38D20; color: #C9A38D;">{{ $log->jenis_aksi }}</span> pada 
                                <span class="font-bold">{{ $log->rab->project->nama_pelanggan ?? 'Proyek' }}</span>
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="pl-6 text-xs italic text-slate-400">Belum ada rekam jejak aktivitas.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>