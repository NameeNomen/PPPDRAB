<div class="min-h-screen pb-10 font-sans transition-colors duration-500 bg-[#E8D8C4]">
    <div class="max-w-7xl mx-auto space-y-8 p-6 md:p-10">
        
        <header class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-[#C7B7A3] pb-6 gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight uppercase text-[#561C24]">Executive Control</h1>
                <p class="text-[11px] font-bold tracking-widest uppercase mt-2 text-[#6D2932]">PPDRAB Control System — Tri Jaya Teknik</p>
            </div>
            <div class="text-left md:text-right bg-[#F5EFE6] px-5 py-3 rounded-2xl border border-[#C7B7A3] shadow-sm">
                <p class="text-[9px] font-black uppercase tracking-widest text-[#6D2932] opacity-80">Status Data Realtime</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#561C24] animate-pulse"></span>
                    <p class="text-sm font-bold font-mono text-[#561C24]">{{ now()->format('d M Y - H:i') }}</p>
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
            <div class="p-6 rounded-[2rem] border border-[#C7B7A3]/50 bg-[#F5EFE6] shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-[#C7B7A3] opacity-20 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <p class="text-[10px] font-black uppercase tracking-widest mb-3 relative z-10 text-[#6D2932]">{{ $stat[0] }}</p>
                <p class="text-2xl md:text-3xl font-black font-mono relative z-10 text-[#561C24]">{{ $stat[1] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            <div class="lg:col-span-2 bg-[#F5EFE6] p-6 md:p-8 rounded-[2rem] border border-[#C7B7A3] shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xs font-black uppercase tracking-widest text-[#561C24]">Analisis Tren Proyek & Omzet</h2>
                    <span class="text-[10px] font-bold px-3 py-1 bg-[#E8D8C4] rounded-full text-[#561C24]">Bulan Ini</span>
                </div>
                <div class="h-[250px] flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-[#C7B7A3] bg-[#E8D8C4] transition-colors hover:bg-[#C7B7A3]/20">
                    <svg class="w-8 h-8 mb-3 opacity-50 text-[#6D2932]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    <span class="text-[#6D2932] text-xs font-bold uppercase tracking-widest">[ Ruang Integrasi Chart.js ]</span>
                </div>
            </div>
            
            <div class="bg-[#F5EFE6] p-6 md:p-8 rounded-[2rem] border border-[#C7B7A3] shadow-sm">
                <h2 class="text-xs font-black uppercase tracking-widest mb-6 text-[#561C24]">Top 5 Valuasi Tertinggi</h2>
                <div class="space-y-4">
                    @forelse($topProyek as $p)
                    <div class="flex flex-col border-b border-[#C7B7A3]/30 pb-3 last:border-0 hover:bg-[#E8D8C4]/50 p-2 rounded-xl transition-colors">
                        <span class="font-black text-[11px] uppercase tracking-wide text-[#561C24] truncate mb-1">{{ $p->nama_pelanggan }}</span>
                        <span class="font-mono font-bold text-xs text-[#6D2932]">Rp {{ number_format($p->rab->grand_total ?? 0, 0, ',', '.') }}</span>
                    </div>
                    @empty
                    <div class="py-8 text-center text-xs italic opacity-50 text-[#6D2932]">Belum ada proyek terdaftar.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
            <div class="bg-[#F5EFE6] p-6 md:p-8 rounded-[2rem] border border-[#C7B7A3] shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xs font-black uppercase tracking-widest text-[#561C24]">Pending Otorisasi</h2>
                    @if($antrianApproval->count() > 0)
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#6D2932] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-[#561C24]"></span>
                        </span>
                    @endif
                </div>
                <div class="space-y-4">
                    @forelse($antrianApproval as $item)
                    <div class="flex justify-between items-center p-5 rounded-2xl border border-[#C7B7A3] bg-[#E8D8C4] hover:shadow-md transition-all group">
                        <div>
                            <p class="font-black text-xs uppercase tracking-wide text-[#561C24]">{{ $item->project->nama_pelanggan ?? 'Sistem' }}</p>
                            <p class="text-[10px] text-[#6D2932] uppercase font-mono font-bold mt-1">REF: {{ $item->no_boq }} • {{ $item->created_at->format('d M') }}</p>
                        </div>
                        <a href="/direktur/persetujuan" class="text-[#F5EFE6] bg-[#561C24] text-[10px] font-black uppercase tracking-widest px-5 py-2.5 rounded-xl transition-all hover:scale-105 shadow-sm group-hover:shadow-md">
                            TINJAU
                        </a>
                    </div>
                    @empty
                    <div class="p-8 text-center border-2 border-dashed border-[#C7B7A3] rounded-2xl">
                        <p class="text-[10px] font-bold text-[#6D2932] opacity-60 uppercase tracking-widest">Semua dokumen bersih.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <div class="bg-[#F5EFE6] p-6 md:p-8 rounded-[2rem] border border-[#C7B7A3] shadow-sm">
                <h2 class="text-xs font-black uppercase tracking-widest mb-8 text-[#561C24]">Log Audit Sistem</h2>
                <div class="relative border-l-2 ml-3 space-y-8 border-[#C7B7A3]">
                    @forelse($aktivitasTerbaru as $log)
                    <div class="relative pl-6">
                        <span class="absolute -left-[7px] top-1 w-3 h-3 rounded-full border-2 border-[#F5EFE6] bg-[#561C24] shadow-sm"></span>
                        <div class="bg-[#E8D8C4] p-4 rounded-2xl border border-[#C7B7A3]/50">
                            <div class="flex justify-between items-start mb-1">
                                <p class="text-xs font-black uppercase text-[#561C24]">{{ $log->user_name }}</p>
                                <span class="text-[9px] font-bold font-mono text-[#6D2932]">
                                    {{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}
                                </span>
                            </div>
                            <p class="text-[10px] font-medium text-[#6D2932] leading-relaxed">
                                Aksi <span class="font-bold uppercase px-1 rounded bg-[#C7B7A3]/30 text-[#561C24]">{{ $log->jenis_aksi }}</span> pada 
                                <span class="font-bold">{{ $log->rab->project->nama_pelanggan ?? 'Proyek' }}</span>
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="pl-6 text-xs italic text-[#C7B7A3]">Belum ada rekam jejak aktivitas.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>