<div class="min-h-screen font-sans transition-colors duration-500" 
     x-data="{ darkMode: true }" 
     :class="darkMode ? 'bg-[#1A0D05] text-[#FDF1E6]' : 'bg-[#FCF6F0] text-[#4A3B33]'">
    
    <div class="max-w-7xl mx-auto p-8 md:p-16">
        <!-- HEADER -->
        <header class="flex justify-between items-start mb-20">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] opacity-50 mb-2">Engineering Workspace</p>
                <h1 class="text-4xl font-extrabold tracking-tight mb-2">Control Center</h1>
                <p class="text-xs font-mono opacity-60" x-text="new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })"></p>
            </div>
            <button @click="darkMode = !darkMode" 
                    class="px-8 py-3 text-[10px] font-black uppercase tracking-widest rounded-full border transition-all hover:scale-105"
                    :class="darkMode ? 'border-[#892E00] text-[#FFB200] hover:bg-[#3D251A]' : 'border-[#4A3B33]/20 text-[#4A3B33] hover:bg-[#F2E5D9]'">
                <span x-text="darkMode ? 'LIGHT MODE' : 'DARK MODE'"></span>
            </button>
        </header>

        <!-- STATS -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-20">
            @foreach([
                ['Proyek Aktif', $countBidding + $countProduksi, '#FF7A00'],
                ['RAB Draft', $countWaiting, '#E7B12E'],
                ['Menunggu', $countApproved, '#BA5304'],
                ['Selesai', $countProduksi, '#892E00']
            ] as $stat)
            <div class="p-8 rounded-[2rem] border transition-all hover:scale-[1.02]" 
                 :class="darkMode ? 'bg-[#261308] border-[#892E00]/20' : 'bg-white border-[#E7B12E]/10 shadow-sm'">
                <p class="text-[9px] font-black uppercase tracking-[0.2em] opacity-40 mb-3">{{ $stat[0] }}</p>
                <p class="text-5xl font-black" style="color: {{ $stat[2] }}">{{ $stat[1] }}</p>
            </div>
            @endforeach
        </div>

        <!-- ACTIVITY LOG -->
        <section>
            <h2 class="text-[10px] font-black uppercase tracking-[0.2em] mb-12 opacity-50">Log Aktivitas Terbaru</h2>
            <div class="space-y-6">
                @forelse($aktivitasLog as $index => $log)
                @php 
                    $colors = ['#ECE48F', '#E7B12E', '#E19802', '#E17D12', '#BA5304', '#892E00'];
                    $color = $colors[$index % count($colors)];
                @endphp
                <div class="flex gap-6 items-center p-6 rounded-2xl border transition-all hover:translate-x-2" 
                     :class="darkMode ? 'bg-[#261308] border-[#892E00]/20' : 'bg-white border-[#E7B12E]/10 shadow-sm'">
                    <div class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $color }}"></div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold">
                            <span class="font-black">{{ $log->user_name }}</span> memperbarui estimasi untuk 
                            <span class="font-bold opacity-80 underline decoration-2" style="text-decoration-color: {{ $color }}">
                                {{ $log->rab->project->nama_pelanggan ?? 'Proyek' }}
                            </span>
                        </p>
                    </div>
                    <div class="text-[9px] font-mono opacity-40 text-right">
                        {{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}
                    </div>
                </div>
                @empty
                    <p class="text-center text-xs opacity-30 font-black uppercase">Belum ada aktivitas.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>