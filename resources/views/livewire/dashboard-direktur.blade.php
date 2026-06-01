<div class="min-h-screen pb-10 font-sans transition-colors duration-500 bg-[#E89154]/5 relative overflow-hidden z-0">
    <!-- DECORATIVE BACKGROUND BLOBS BIAR GAK KOSONG -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#DA7134]/10 rounded-full blur-3xl -z-10 mix-blend-multiply"></div>
    <div class="absolute bottom-0 left-[-10%] w-[600px] h-[600px] bg-[#E89154]/10 rounded-full blur-3xl -z-10 mix-blend-multiply"></div>

    <div class="max-w-7xl mx-auto space-y-8 p-6 md:p-10 relative z-10">
        
        <!-- HEADER -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/70 backdrop-blur-xl p-6 md:p-8 rounded-[2rem] border border-[#DA7134]/20 shadow-xl shadow-[#DA7134]/5 relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-2 bg-gradient-to-b from-[#852616] to-[#DA7134]"></div>
            <div>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight uppercase text-[#2A0001]">Executive Control</h1>
                <p class="text-[11px] font-bold tracking-widest uppercase mt-2 text-[#852616]">PPDRAB Control System — Tri Jaya Teknik</p>
            </div>
            <div class="text-left md:text-right bg-white/50 backdrop-blur-md px-5 py-3 rounded-2xl border border-[#DA7134]/20 shadow-sm">
                <p class="text-[9px] font-black uppercase tracking-widest text-[#852616] opacity-80">Status Data Realtime</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#DA7134] animate-pulse"></span>
                    <p class="text-sm font-bold font-mono text-[#2A0001]">{{ now()->format('d M Y - H:i') }}</p>
                </div>
            </div>
        </header>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @foreach([
                ['Total Proyek Aktif', $totalProyekAktif], 
                ['Pending Approval', $proyekPending], 
                ['Nilai Proyek Aktif', 'Rp '.number_format($totalNilaiAktif/1000000, 1).'M'], 
                ['Omzet Potensial', 'Rp '.number_format($omzetPotensial/1000000, 1).'M']
            ] as $stat)
            <div class="p-6 rounded-[2rem] border border-[#DA7134]/20 bg-white/70 backdrop-blur-xl shadow-lg shadow-[#DA7134]/5 hover:shadow-xl hover:shadow-[#DA7134]/10 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-bl from-[#DA7134]/15 to-transparent rounded-bl-full group-hover:scale-150 transition-transform duration-500"></div>
                <p class="text-[10px] font-black uppercase tracking-widest mb-3 relative z-10 text-[#852616]">{{ $stat[0] }}</p>
                <p class="text-2xl md:text-3xl font-black font-mono relative z-10 text-[#2A0001]">{{ $stat[1] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            <!-- TREN PROYEK -->
            <div class="lg:col-span-2 bg-white/80 backdrop-blur-xl p-6 md:p-8 rounded-[2rem] border border-[#DA7134]/20 shadow-xl shadow-[#DA7134]/5">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xs font-black uppercase tracking-widest text-[#2A0001]">Analisis Tren Proyek & Omzet</h2>
                    <span class="text-[10px] font-bold px-3 py-1 bg-[#DA7134]/10 rounded-full text-[#852616] border border-[#DA7134]/20">Bulan Ini</span>
                </div>
                <div class="h-[250px] flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-[#DA7134]/30 bg-[#E89154]/5 transition-colors hover:bg-[#E89154]/10">
                    <svg class="w-8 h-8 mb-3 opacity-50 text-[#852616]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    <span class="text-[#852616] text-xs font-bold uppercase tracking-widest">[ Ruang Integrasi Chart.js ]</span>
                </div>
            </div>
            
            <!-- TOP 5 VALUASI -->
            <div class="bg-white/80 backdrop-blur-xl p-6 md:p-8 rounded-[2rem] border border-[#DA7134]/20 shadow-xl shadow-[#DA7134]/5">
                <h2 class="text-xs font-black uppercase tracking-widest mb-6 text-[#2A0001]">Top 5 Valuasi Tertinggi</h2>
                <div class="space-y-4">
                    @forelse($topProyek as $p)
                    <div class="flex flex-col border-b border-[#DA7134]/10 pb-3 last:border-0 hover:bg-[#E89154]/10 p-2 rounded-xl transition-colors">
                        <span class="font-black text-[11px] uppercase tracking-wide text-[#2A0001] truncate mb-1">{{ $p->nama_pelanggan }}</span>
                        <span class="font-mono font-bold text-xs text-[#852616] bg-[#E89154]/10 w-fit px-2 py-0.5 rounded-lg">Rp {{ number_format($p->rab->grand_total ?? 0, 0, ',', '.') }}</span>
                    </div>
                    @empty
                    <div class="py-8 text-center text-xs italic opacity-50 text-[#852616]">Belum ada proyek terdaftar.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
            <!-- PENDING OTORISASI -->
            <div class="bg-white/80 backdrop-blur-xl p-6 md:p-8 rounded-[2rem] border border-[#DA7134]/20 shadow-xl shadow-[#DA7134]/5">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xs font-black uppercase tracking-widest text-[#2A0001]">Pending Otorisasi</h2>
                    @if($antrianApproval->count() > 0)
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#DA7134] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-[#852616]"></span>
                        </span>
                    @endif
                </div>
                <div class="space-y-4">
                    @forelse($antrianApproval as $item)
                    <div class="flex justify-between items-center p-5 rounded-2xl border border-[#DA7134]/20 bg-white/50 backdrop-blur-md hover:bg-[#E89154]/10 shadow-sm hover:shadow-md transition-all group">
                        <div>
                            <p class="font-black text-xs uppercase tracking-wide text-[#2A0001]">{{ $item->project->nama_pelanggan ?? 'Sistem' }}</p>
                            <p class="text-[10px] text-[#852616] uppercase font-mono font-bold mt-1">REF: {{ $item->no_boq }} • {{ $item->created_at->format('d M') }}</p>
                        </div>
                        <a href="/direktur/persetujuan" class="bg-[#2A0001] hover:bg-[#852616] text-[#E89154] hover:text-white text-[10px] font-black uppercase tracking-widest px-5 py-2.5 rounded-xl transition-all hover:-translate-y-0.5 shadow-lg shadow-[#2A0001]/20">
                            TINJAU
                        </a>
                    </div>
                    @empty
                    <div class="p-8 text-center border-2 border-dashed border-[#DA7134]/30 rounded-2xl">
                        <p class="text-[10px] font-bold text-[#852616] opacity-60 uppercase tracking-widest">Semua dokumen bersih.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- LOG AUDIT -->
            <div class="bg-white/80 backdrop-blur-xl p-6 md:p-8 rounded-[2rem] border border-[#DA7134]/20 shadow-xl shadow-[#DA7134]/5">
                <h2 class="text-xs font-black uppercase tracking-widest mb-8 text-[#2A0001]">Log Audit Sistem</h2>
                <div class="relative border-l-2 ml-3 space-y-8 border-[#DA7134]/20">
                    @forelse($aktivitasTerbaru as $log)
                    <div class="relative pl-6">
                        <span class="absolute -left-[7px] top-1 w-3 h-3 rounded-full border-2 border-white bg-[#852616] shadow-sm"></span>
                        <div class="bg-[#E89154]/10 p-4 rounded-2xl border border-[#DA7134]/20">
                            <div class="flex justify-between items-start mb-1">
                                <p class="text-xs font-black uppercase text-[#2A0001]">{{ $log->user_name }}</p>
                                <span class="text-[9px] font-bold font-mono text-[#852616]">
                                    {{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}
                                </span>
                            </div>
                            <p class="text-[10px] font-medium text-[#852616]/80 leading-relaxed">
                                Aksi <span class="font-bold uppercase px-1.5 py-0.5 rounded bg-[#DA7134]/20 text-[#2A0001]">{{ $log->jenis_aksi }}</span> pada 
                                <span class="font-bold text-[#2A0001]">{{ $log->rab->project->nama_pelanggan ?? 'Proyek' }}</span>
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="pl-6 text-xs italic text-[#852616]/50">Belum ada rekam jejak aktivitas.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>