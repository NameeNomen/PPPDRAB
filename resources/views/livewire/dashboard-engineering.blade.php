<div class="min-h-screen font-sans transition-colors duration-300" 
     style="font-family: 'Inter', sans-serif;"
     x-data="{ darkMode: false }" 
     :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5]' : 'bg-[#FAFAFA] text-[#1A1A1A]'">
    
    <div class="max-w-7xl mx-auto p-4 md:p-6">
        <!-- HEADER -->
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 pb-6 border-b-2" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-[#888888] mb-2">Engineering Workspace</p>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight mb-1" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">Control Center</h1>
                <p class="text-xs font-mono text-[#888888]" x-text="new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })"></p>
            </div>
            <button @click="darkMode = !darkMode" 
                    class="px-6 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl border-2 shadow-sm transition-all hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-[#F5C518]/30"
                    :class="darkMode ? 'border-[#F5C518]/50 text-[#F5C518] hover:bg-[#F5C518]/10' : 'border-[#E5E5E5] text-[#1A1A1A] hover:border-[#F5C518] hover:bg-[#F5C518]/10'">
                <span x-text="darkMode ? ' LIGHT MODE' : '🕶️ DARK MODE'"></span>
            </button>
        </header>

        <!-- STATS -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach([
                ['Proyek Aktif', $countBidding + $countProduksi],
                ['RAB Draft', $countWaiting],
                ['Menunggu', $countApproved],
                ['Selesai', $countProduksi]
            ] as $stat)
            <div class="p-6 rounded-2xl border-2 transition-all hover:-translate-y-0.5 hover:shadow-xl" 
                 :class="darkMode ? 'bg-[#111111] border-[#2A2A2A] hover:shadow-[0_4px_20px_rgb(245,197,24,0.1)]' : 'bg-white border-[#E5E5E5] hover:shadow-xl'">
                <p class="text-[10px] font-bold uppercase tracking-widest text-[#888888] mb-3">{{ $stat[0] }}</p>
                <p class="text-4xl md:text-5xl font-black" :class="darkMode ? 'text-[#F5C518]' : 'text-[#9A7B0A]'">{{ $stat[1] }}</p>
            </div>
            @endforeach
        </div>

        <!-- ACTIVITY LOG -->
        <section>
            <h2 class="text-[10px] font-bold uppercase tracking-widest text-[#888888] mb-6">Log Aktivitas Terbaru</h2>
            <div class="space-y-4">
                @forelse($aktivitasLog as $index => $log)
                <div class="flex gap-4 items-center p-6 rounded-2xl border-2 transition-all hover:-translate-y-0.5" 
                     :class="darkMode ? 'bg-[#111111] border-[#2A2A2A] hover:shadow-xl' : 'bg-white border-[#E5E5E5] hover:shadow-xl'">
                    <div class="w-3 h-3 rounded-full shrink-0 bg-[#F5C518]"></div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold">
                            <span class="font-black" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">{{ $log->user_name }}</span>
                            <span class="text-[#888888]"> memperbarui estimasi untuk </span>
                            <span class="font-bold border-b-2 border-[#F5C518]" :class="darkMode ? 'text-[#F5C518]' : 'text-[#9A7B0A]'">
                                {{ $log->rab->project->nama_pelanggan ?? 'Proyek' }}
                            </span>
                        </p>
                    </div>
                    <div class="text-[10px] font-mono font-bold text-[#888888] text-right">
                        {{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}
                    </div>
                </div>
                @empty
                    <div class="p-12 rounded-2xl border-2 text-center" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center bg-[#F5C518]/20">
                            <svg class="w-8 h-8 text-[#9A7B0A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="font-bold text-[#888888]">Belum ada aktivitas.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>
