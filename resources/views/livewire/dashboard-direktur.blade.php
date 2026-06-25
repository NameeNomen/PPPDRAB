<div class="min-h-screen pb-10 font-sans transition-colors duration-500 bg-[#F8FAFC] relative overflow-hidden z-0" style="font-family: 'Inter', sans-serif;">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#4F46E5]/5 rounded-full blur-3xl -z-10 mix-blend-multiply pointer-events-none"></div>
    <div class="absolute bottom-0 left-[-10%] w-[600px] h-[600px] bg-[#818CF8]/5 rounded-full blur-3xl -z-10 mix-blend-multiply pointer-events-none"></div>

    <div class="max-w-7xl mx-auto space-y-8 p-6 md:p-10 relative z-10">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 md:p-8 rounded-2xl border border-[#E2E8F0] shadow-sm relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-2 bg-gradient-to-b from-[#1E1B4B] to-[#4F46E5]"></div>
            <div>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight uppercase text-[#0F172A]">Executive Control</h1>
                <p class="text-[11px] font-bold tracking-widest uppercase mt-2 text-[#64748B]">PPDRAB Control System — Tri Jaya Teknik</p>
            </div>
            <div class="text-left md:text-right bg-[#F8FAFC] px-5 py-3 rounded-xl border border-[#E2E8F0] shadow-sm">
                <p class="text-[9px] font-black uppercase tracking-widest text-[#64748B] opacity-80">Status Data Realtime</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#4F46E5] animate-pulse"></span>
                    <p class="text-sm font-bold font-mono text-[#0F172A]">{{ now()->format('d M Y - H:i') }}</p>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @foreach([
                ['Proyek Dipantau', $totalProyekPending],
                ['Pending Approval', $antrianApproval->count()],
                ['Nilai Proyek Aktif', 'Rp '.number_format($totalNilaiAktif/1000000, 1).'M'],
                ['Omzet Potensial', 'Rp '.number_format($omzetPotensial/1000000, 1).'M']
            ] as $stat)
            <div class="p-6 rounded-2xl border border-[#E2E8F0] bg-white shadow-sm hover:shadow-md hover:border-[#818CF8]/50 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-bl from-[#EEF2FF] to-transparent rounded-bl-full group-hover:scale-150 transition-transform duration-500"></div>
                <p class="text-[10px] font-black uppercase tracking-widest mb-3 relative z-10 text-[#64748B]">{{ $stat[0] }}</p>
                <p class="text-2xl md:text-3xl font-black font-mono relative z-10 text-[#1E1B4B]">{{ $stat[1] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-2xl border border-[#E2E8F0] shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xs font-black uppercase tracking-widest text-[#0F172A]">Analisis Aktivitas Dokumen</h2>
                    <span class="text-[10px] font-bold px-3 py-1 bg-[#EEF2FF] rounded-md text-[#4F46E5] border border-[#C7D2FE]">Tahun Ini</span>
                </div>
                
                @if(array_sum($grafikData) > 0)
                    <div class="h-[250px] flex items-center justify-center rounded-xl border-2 border-dashed border-[#CBD5E1] bg-[#F8FAFC]">
                        <p class="text-[#64748B] text-xs font-bold uppercase tracking-widest"> [ Chart.js Rendering... ] </p>
                    </div>
                @else
                    <div class="h-[250px] flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-[#CBD5E1] bg-[#F8FAFC]">
                        <svg class="w-8 h-8 mb-3 text-[#94A3B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-[#64748B] text-xs font-bold uppercase tracking-widest">Belum Ada Aktivitas Commit Tahun Ini</span>
                    </div>
                @endif
            </div>

            <div class="bg-white p-6 md:p-8 rounded-2xl border border-[#E2E8F0] shadow-sm">
                <h2 class="text-xs font-black uppercase tracking-widest mb-6 text-[#0F172A]">Top 5 Valuasi Tertinggi</h2>
                <div class="space-y-4">
                    @forelse($topProyek as $p)
                        <div class="flex flex-col border-b border-[#F1F5F9] pb-3 last:border-0 hover:bg-[#F8FAFC] p-2 rounded-lg transition-colors">
                            <span class="font-black text-[11px] uppercase tracking-wide text-[#1E293B] truncate mb-1">{{ $p->nama_pelanggan }}</span>
                            <span class="font-mono font-bold text-xs text-[#4F46E5] bg-[#EEF2FF] w-fit px-2 py-0.5 rounded-md border border-[#C7D2FE]">Rp {{ number_format($p->rab->grand_total ?? 0, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <div class="py-8 text-center text-xs font-medium text-[#94A3B8]">Belum ada data proyek.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-[#E2E8F0] shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xs font-black uppercase tracking-widest text-[#0F172A]">Pending Otorisasi</h2>
                    @if($antrianApproval->count() > 0)
                        <span class="flex h-3 w-3 relative"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#818CF8] opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-[#4F46E5]"></span></span>
                    @endif
                </div>
                <div class="space-y-4">
                    @forelse($antrianApproval as $item)
                        <div class="flex justify-between items-center p-5 rounded-xl border border-[#E2E8F0] bg-white hover:border-[#818CF8]/50 hover:bg-[#F8FAFC] shadow-sm transition-all group">
                            <div>
                                <p class="font-black text-xs uppercase tracking-wide text-[#0F172A]">{{ $item->project->nama_pelanggan ?? 'Sistem' }}</p>
                                <p class="text-[10px] text-[#64748B] uppercase font-mono font-bold mt-1">REF: {{ $item->no_boq }} • {{ $item->created_at->format('d M') }}</p>
                            </div>
                            <a href="/direktur/persetujuan" class="bg-[#1E1B4B] hover:bg-[#312E81] text-white text-[10px] font-black uppercase tracking-widest px-5 py-2.5 rounded-lg transition-all shadow-sm">TINJAU</a>
                        </div>
                    @empty
                        <div class="p-8 text-center border-2 border-dashed border-[#CBD5E1] rounded-xl bg-[#F8FAFC]">
                            <p class="text-[10px] font-bold text-[#64748B] uppercase tracking-widest">Semua dokumen bersih.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-2xl border border-[#E2E8F0] shadow-sm">
                <h2 class="text-xs font-black uppercase tracking-widest mb-8 text-[#0F172A]">Log Audit Sistem</h2>
                <div class="relative border-l-2 ml-3 space-y-8 border-[#E2E8F0]">
                    @forelse($aktivitasTerbaru as $log)
                        <div class="relative pl-6">
                            <span class="absolute -left-[7px] top-1 w-3 h-3 rounded-full border-2 border-white bg-[#4F46E5] shadow-sm"></span>
                            <div class="bg-[#F8FAFC] p-4 rounded-xl border border-[#E2E8F0]">
                                <div class="flex justify-between items-start mb-1">
                                    <p class="text-xs font-black uppercase text-[#1E293B]">{{ $log->user_name }}</p>
                                    <span class="text-[9px] font-bold font-mono text-[#64748B]">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}</span>
                                </div>
                                <p class="text-[10px] font-medium text-[#475569] leading-relaxed">
                                    Aksi <span class="font-bold uppercase px-1.5 py-0.5 rounded bg-[#EEF2FF] border border-[#C7D2FE] text-[#4F46E5]">{{ $log->jenis_aksi }}</span> pada
                                    <span class="font-bold text-[#0F172A]">{{ $log->rab->project->nama_pelanggan ?? 'Proyek' }}</span>
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="pl-6 text-xs font-medium text-[#94A3B8]">Belum ada rekam jejak aktivitas.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>