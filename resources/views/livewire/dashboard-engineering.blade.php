<div class="min-h-screen font-sans transition-colors duration-300 pb-12"
     style="font-family: 'Inter', sans-serif;"
     x-data="{ darkMode: false }"
     :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5]' : 'bg-[#FAFAFA] text-[#1A1A1A]'">

    <div class="max-w-[95rem] mx-auto p-4 md:p-6">
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 pb-6 border-b-2" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-[#888888] mb-2">Engineering Workspace</p>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight mb-1" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">Control Center</h1>
                <p class="text-xs font-mono text-[#888888]" x-text="new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })"></p>
            </div>
            <button @click="darkMode = !darkMode"
                    class="px-6 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl border-2 shadow-sm transition-all hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-[#F5C518]/30"
                    :class="darkMode ? 'border-[#F5C518]/50 text-[#F5C518] hover:bg-[#F5C518]/10' : 'border-[#E5E5E5] text-[#1A1A1A] hover:border-[#F5C518] hover:bg-[#F5C518]/10'">
                <span x-text="darkMode ? '💡 LIGHT MODE' : '🕶️ DARK MODE'"></span>
            </button>
        </header>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
            <div class="p-6 rounded-2xl border-2 transition-all hover:-translate-y-0.5" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5] hover:shadow-xl'">
                <p class="text-[10px] font-bold uppercase tracking-widest text-[#888888] mb-3 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span> RFQ Masuk</p>
                <p class="text-4xl md:text-5xl font-black" :class="darkMode ? 'text-[#F5C518]' : 'text-[#9A7B0A]'">{{ $rfqMasuk }}</p>
                <p class="text-[9px] uppercase font-bold mt-3 opacity-60">Proyek baru butuh estimasi</p>
            </div>
            <div class="p-6 rounded-2xl border-2 transition-all hover:-translate-y-0.5" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5] hover:shadow-xl'">
                <p class="text-[10px] font-bold uppercase tracking-widest text-[#888888] mb-3 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-gray-500"></span> RAB Draft</p>
                <p class="text-4xl md:text-5xl font-black" :class="darkMode ? 'text-[#F5C518]' : 'text-[#9A7B0A]'">{{ $rabDraft }}</p>
                <p class="text-[9px] uppercase font-bold mt-3 opacity-60">Sedang dikerjakan (Workspace)</p>
            </div>
            <div class="p-6 rounded-2xl border-2 transition-all hover:-translate-y-0.5" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5] hover:shadow-xl'">
                <p class="text-[10px] font-bold uppercase tracking-widest text-[#888888] mb-3 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-orange-500"></span> Pending Approval</p>
                <p class="text-4xl md:text-5xl font-black" :class="darkMode ? 'text-[#F5C518]' : 'text-[#9A7B0A]'">{{ $rabPending }}</p>
                <p class="text-[9px] uppercase font-bold mt-3 opacity-60">Di Meja Direktur</p>
            </div>
            <div class="p-6 rounded-2xl border-2 transition-all hover:-translate-y-0.5" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5] hover:shadow-xl'">
                <p class="text-[10px] font-bold uppercase tracking-widest text-[#888888] mb-3 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span> Need Revision</p>
                <p class="text-4xl md:text-5xl font-black text-red-500">{{ $rabRevision }}</p>
                <p class="text-[9px] uppercase font-bold mt-3 opacity-60">Butuh perbaikan segera</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            
            <section class="flex flex-col">
                <h2 class="text-[10px] font-bold uppercase tracking-widest text-[#888888] mb-4">Urutan Proyek Prioritas</h2>
                <div class="p-5 rounded-2xl border-2 flex-grow transition-colors" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                    <div class="space-y-4">
                        @forelse($proyekPrioritas as $p)
                        <div class="flex justify-between items-center p-3 rounded-xl border transition-colors hover:-translate-y-0.5" :class="darkMode ? 'border-[#333333] bg-[#1A1A1A]' : 'border-[#E5E5E5] bg-[#FAFAFA]'">
                            <div>
                                <p class="text-xs font-black uppercase" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">{{ $p->nama_pelanggan }}</p>
                                <p class="text-[10px] font-bold text-[#888888] mt-1">{{ $p->nama_projek }}</p>
                            </div>
                            <a href="{{ route('engineering.rab.detail', $p->id) }}" class="px-4 py-1.5 rounded-lg text-[9px] font-black tracking-widest border transition-colors" :class="darkMode ? 'bg-[#111111] border-[#F5C518] text-[#F5C518] hover:bg-[#F5C518] hover:text-[#111111]' : 'bg-white border-[#9A7B0A] text-[#9A7B0A] hover:bg-[#F5C518] hover:text-[#1A1A1A] hover:border-[#F5C518]'">KERJAKAN</a>
                        </div>
                        @empty
                        <p class="text-xs text-center py-6 text-[#888888] font-bold">Semua RAB proyek telah selesai dikerjakan.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="flex flex-col">
                <h2 class="text-[10px] font-bold uppercase tracking-widest text-[#888888] mb-4 flex items-center justify-between">
                    <span>Status Request Material</span>
                    <span class="text-[9px] font-bold px-2 py-0.5 bg-[#F5C518]/20 text-[#9A7B0A] rounded">Purchasing Queue</span>
                </h2>
                <div class="p-5 rounded-2xl border-2 flex-grow transition-colors" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                    <div class="space-y-4">
                        @forelse($requestMaterial as $req)
                        <div class="p-3 rounded-xl border transition-colors" :class="darkMode ? 'border-[#333333] bg-[#1A1A1A]' : 'border-[#E5E5E5] bg-[#FAFAFA]'">
                            <div class="flex justify-between items-start mb-2">
                                <p class="text-xs font-black" :class="darkMode ? 'text-[#F5C518]' : 'text-[#9A7B0A]'">{{ $req->nama_material }}</p>
                                <span class="text-[9px] font-bold uppercase px-2 py-0.5 rounded-full {{ $req->status == 'pending' ? 'bg-orange-500/20 text-orange-600' : 'bg-emerald-500/20 text-emerald-600' }}">{{ $req->status }}</span>
                            </div>
                            <p class="text-[10px] font-bold text-[#888888]">{{ $req->estimasi_kebutuhan }} {{ $req->satuan }} | Target: {{ \Carbon\Carbon::parse($req->target_waktu_dibutuhkan)->format('d M') }}</p>
                        </div>
                        @empty
                        <p class="text-xs text-center py-6 text-[#888888] font-bold">Belum ada request material ke Purchasing.</p>
                        @endforelse
                    </div>
                </div>
            </section>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <section class="lg:col-span-2">
                <h2 class="text-[10px] font-bold uppercase tracking-widest text-[#888888] mb-4">Log Histori Sistem</h2>
                <div class="space-y-3">
                    @forelse($aktivitasLog as $log)
                    <div class="flex gap-4 items-center p-4 rounded-2xl border-2 transition-all hover:-translate-x-1"
                         :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 font-black text-xs" :class="darkMode ? 'bg-[#1A1A1A] text-[#F5C518]' : 'bg-[#FAFAFA] border border-[#E5E5E5] text-[#9A7B0A]'">
                            {{ substr($log->user_name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-semibold">
                                <span class="font-black uppercase" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">{{ $log->user_name }}</span>
                                <span class="text-[#888888]"> melakukan ({{ strtoupper($log->jenis_aksi) }}) pada </span>
                                <span class="font-bold border-b-2" :class="darkMode ? 'border-[#F5C518] text-[#F5C518]' : 'border-[#9A7B0A] text-[#9A7B0A]'">
                                    {{ $log->rab->project->nama_pelanggan ?? ($log->project->nama_pelanggan ?? 'Sistem') }}
                                </span>
                            </p>
                            @if($log->komentar_commit)
                                <p class="text-[10px] mt-1 italic text-[#888888]">"{{ $log->komentar_commit }}"</p>
                            @endif
                        </div>
                        <div class="text-[9px] font-mono font-bold text-[#888888] text-right shrink-0">
                            {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                        </div>
                    </div>
                    @empty
                    <div class="p-10 rounded-2xl border-2 text-center" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                        <p class="font-bold text-xs text-[#888888]">Log sistem masih kosong.</p>
                    </div>
                    @endforelse
                </div>
            </section>

            <section class="lg:col-span-1">
                <h2 class="text-[10px] font-bold uppercase tracking-widest text-[#888888] mb-4">Catatan Revisi Direktur</h2>
                <div class="p-5 rounded-2xl border-2 flex-grow transition-colors" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                    <div class="space-y-4">
                        @forelse($revisiDirektur as $rev)
                        <div class="p-3 rounded-xl border border-red-500/30 bg-red-500/5 relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-500"></div>
                            <p class="text-[10px] font-black uppercase text-red-500 mb-1">{{ $rev->rab->project->nama_pelanggan ?? 'Proyek' }}</p>
                            <p class="text-xs font-bold" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">"{{ $rev->komentar_commit }}"</p>
                            <p class="text-[9px] font-mono font-bold mt-2 text-[#888888] text-right">{{ \Carbon\Carbon::parse($rev->created_at)->format('d M - H:i') }}</p>
                        </div>
                        @empty
                        <div class="py-8 flex flex-col items-center justify-center opacity-50">
                            <svg class="w-10 h-10 mb-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-xs font-bold text-center" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">Clear! Tidak ada antrean revisi.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>