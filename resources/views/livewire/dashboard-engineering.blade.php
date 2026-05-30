<div class="min-h-screen p-4 md:p-8 transition-colors duration-500" 
     x-data="{ darkMode: true }" 
     :class="darkMode ? 'bg-[#1E1D1B] text-[#E4E4E4]' : 'bg-[#FAFCFF] text-[#5E6175]'">
    
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-black tracking-tight transition-colors" :class="darkMode ? 'text-white' : 'text-[#5E6175]'">Engineering Control Center</h1>
                <p class="text-xs font-bold uppercase tracking-widest opacity-50 mt-1">Monitoring Estimasi & Eksekusi Proyek</p>
            </div>
            <button @click="darkMode = !darkMode" class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border transition-all"
                    :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36] text-[#D9B35A]' : 'bg-white border-[#C7D9F1] text-[#5E6175] shadow-sm'">
                <span x-text="darkMode ? '🕶️ DARK MODE' : '💡 LIGHT MODE'"></span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="p-6 rounded-[2rem] border transition-all shadow-sm" :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/50'">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-50">📁 Total Proyek Aktif</p>
                <p class="text-4xl font-black mt-2 transition-colors" :class="darkMode ? 'text-white' : 'text-[#5E6175]'">{{ $countBidding + $countProduksi }}</p>
            </div>
            <div class="p-6 rounded-[2rem] border transition-all shadow-sm" :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/50'">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-50">📋 Total RAB Draft</p>
                <p class="text-4xl font-black mt-2 transition-colors" :class="darkMode ? 'text-white' : 'text-[#5E6175]'">{{ $countWaiting }}</p>
            </div>
            <div class="p-6 rounded-[2rem] border transition-all shadow-sm" :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/50'">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-50">⏳ Menunggu Direktur</p>
                <p class="text-4xl font-black mt-2 transition-colors" :class="darkMode ? 'text-white' : 'text-[#5E6175]'">{{ $countApproved }}</p>
            </div>
            <div class="p-6 rounded-[2rem] border transition-all shadow-sm" :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/50'">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-60 text-emerald-500">✅ RAB Disetujui</p>
                <p class="text-4xl font-black mt-2 text-emerald-500">{{ $countProduksi }}</p>
            </div>
        </div>

        <div class="p-8 rounded-[2rem] border shadow-sm transition-colors" 
             :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/50'">
            <h3 class="font-black mb-6 tracking-tight flex items-center gap-2 transition-colors" :class="darkMode ? 'text-white' : 'text-[#5E6175]'">
                <span class="w-1.5 h-5 rounded-full" :class="darkMode ? 'bg-[#D9B35A]' : 'bg-[#C7D9F1]'"></span> Aktivitas Terbaru
            </h3>
            <div class="space-y-6">
                @forelse($aktivitasLog as $log)
                    <div class="flex gap-4 items-start border-b pb-4 transition-colors" :class="darkMode ? 'border-[#3D3A36]' : 'border-[#C7D9F1]/30'">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-black shrink-0"
                             :class="darkMode ? 'bg-[#D9B35A] text-[#1E1D1B]' : 'bg-[#C7D9F1] text-[#5E6175]'">
                            {{ strtoupper(substr($log->user_name ?? 'S', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs font-black transition-colors" :class="darkMode ? 'text-white' : 'text-[#5E6175]'">
                                {{ $log->user_name }} <span class="font-normal opacity-70">memperbarui RAB untuk</span> 
                                <span :class="darkMode ? 'text-[#D9B35A]' : 'text-[#5E6175]'">{{ $log->rab->project->nama_pelanggan ?? 'Proyek' }}</span>
                            </p>
                            <p class="text-[10px] font-mono mt-1 opacity-50">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs font-bold opacity-50">Belum ada aktivitas terekam.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>