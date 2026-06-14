<div class="min-h-screen font-sans bg-[#F4F9F6] text-[#2A402B] pb-12" style="font-family: 'Inter', sans-serif;" x-data>

    <div class="max-w-[95rem] mx-auto p-4 md:p-6">
        @if (session()->has('sukses'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="mb-6 px-6 py-4 rounded-2xl text-xs font-bold border flex items-center justify-between shadow-sm bg-[#E2EFE7] text-[#2A402B] border-[#4A7256]/30">
                <div class="flex items-center gap-3">
                    <div class="bg-[#4A7256] text-white p-1.5 rounded-lg shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    {{ session('sukses') }}
                </div>
                <button @click="show = false" class="text-[#4A7256] hover:text-[#2A402B] outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 pb-5 border-b-2 border-[#B4CDBF]/50">
            <div>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight flex items-center gap-3 text-[#2A402B]">
                    <span class="w-1.5 h-6 rounded-full inline-block bg-[#4A7256]"></span>
                    Commercial Bidding
                </h1>
                <p class="text-xs font-medium mt-1 text-[#648B73]">Penyusunan & Riwayat Dokumen Penawaran Klien.</p>
            </div>
            </div>

        <div class="rounded-2xl p-4 mb-8 flex flex-col md:flex-row gap-4 items-center justify-between shadow-lg border relative z-40 bg-white/80 backdrop-blur-md border-[#B4CDBF]/50">
            
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-4 h-4 shrink-0 text-[#7A9D8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" wire:model.live="search" placeholder="Cari nama perusahaan atau nomor penawaran..."
                       class="w-full text-sm font-bold pl-11 pr-4 py-3 rounded-xl outline-none border transition-all focus:ring-2 focus:ring-[#4A7256]/30 focus:border-[#4A7256] bg-[#F4F9F6] border-[#B4CDBF]/50 text-[#2A402B] placeholder-[#7A9D8C]">
            </div>
            
            <div class="relative w-full md:w-auto" x-data="{ openFilter: false }">
                <button @click="openFilter = !openFilter" type="button" 
                        class="w-full md:w-64 flex justify-between items-center text-sm font-bold border rounded-xl px-4 py-3 outline-none transition-all cursor-pointer shadow-sm bg-[#F4F9F6] border-[#B4CDBF]/50 text-[#2A402B] hover:bg-[#E2EFE7]">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#4A7256]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <span x-text="
                            $wire.filterStatus === 'all' ? 'Semua Status' : 
                            ($wire.filterStatus === 'draft' ? 'Draft' : 
                            ($wire.filterStatus === 'pending' ? 'Pending Persetujuan' : 
                            ($wire.filterStatus === 'revision' ? 'Revisi' : 'Approved')))
                        "></span>
                    </span>
                    <svg class="w-4 h-4 transition-transform duration-300" :class="openFilter ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="openFilter" @click.away="openFilter = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                     class="absolute right-0 mt-2 w-full md:w-64 rounded-xl shadow-xl border overflow-hidden z-50 bg-white border-[#B4CDBF]/50" style="display: none;">
                    
                    <template x-for="item in [
                        {val: 'all', label: 'Semua Status'}, 
                        {val: 'draft', label: 'Draft'}, 
                        {val: 'pending', label: 'Pending Persetujuan'}, 
                        {val: 'revision', label: 'Perlu Revisi'}, 
                        {val: 'approved', label: 'Approved'}
                    ]" :key="item.val">
                        <div @click="$wire.set('filterStatus', item.val); openFilter = false;"
                             class="px-4 py-3 text-xs font-bold cursor-pointer transition-colors flex justify-between items-center uppercase tracking-wide"
                             :class="$wire.filterStatus === item.val ? 'bg-[#E2EFE7] text-[#2A402B]' : 'text-[#648B73] hover:bg-[#F4F9F6] hover:text-[#2A402B]'">
                            <span x-text="item.label"></span>
                            <svg x-show="$wire.filterStatus === item.val" class="w-4 h-4 text-[#4A7256]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        @if($filterStatus === 'all' && count($siapBidding) > 0)
            <div class="mb-10">
                <div class="flex items-center gap-2 mb-4 border-b pb-2 border-[#B4CDBF]/50">
                    <span class="w-2 h-2 rounded-full bg-[#E55A5A] animate-pulse"></span>
                    <h2 class="text-xs font-black uppercase tracking-widest text-[#2A402B]">Tugas: Buat Penawaran Baru</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($siapBidding as $proyek)
                        <div class="rounded-2xl p-5 border transition-all shadow-md hover:shadow-lg flex flex-col justify-between bg-white border-[#E55A5A]/30">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-bold font-mono text-[#7A9D8C]">{{ $proyek->request_no }}</span>
                                    <span class="px-2 py-1 text-[9px] font-black uppercase rounded bg-[#E55A5A]/10 text-[#E55A5A]">RAB Approved</span>
                                </div>
                                <h3 class="font-black text-sm mb-1 truncate text-[#2A402B]">{{ $proyek->nama_pelanggan }}</h3>
                                <p class="text-xs text-[#648B73] line-clamp-1">{{ $proyek->nama_projek }}</p>
                            </div>
                            <button wire:click="lihatDetail({{ $proyek->id }})" class="mt-4 w-full py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl bg-[#4A7256] hover:bg-[#354F37] text-white transition-colors shadow-md">
                                Buat Bidding
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div>
            <div class="flex items-center gap-2 mb-4 border-b pb-2 border-[#B4CDBF]/50">
                <span class="w-2 h-2 rounded-full bg-[#4A7256]"></span>
                <h2 class="text-xs font-black uppercase tracking-widest text-[#2A402B]">Riwayat Dokumen Penawaran</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($daftarBidding as $bidding)
                    @php
                        $stat = strtolower($bidding->status_bidding ?? 'draft');
                        $config = [
                            'draft' => ['color' => 'bg-[#648B73]', 'bg' => 'bg-[#648B73]/10', 'text' => 'text-[#648B73]'],
                            'pending' => ['color' => 'bg-orange-500', 'bg' => 'bg-orange-500/10', 'text' => 'text-orange-600'],
                            'revision' => ['color' => 'bg-[#E55A5A]', 'bg' => 'bg-[#E55A5A]/10', 'text' => 'text-[#E55A5A]'],
                            'approved' => ['color' => 'bg-[#4A7256]', 'bg' => 'bg-[#4A7256]/10', 'text' => 'text-[#4A7256]'],
                        ][$stat] ?? ['color' => 'bg-gray-500', 'bg' => 'bg-gray-500/10', 'text' => 'text-gray-500'];
                    @endphp

                    <div class="rounded-2xl p-5 border transition-all hover:-translate-y-1 shadow-sm hover:shadow-xl bg-white border-[#B4CDBF]/40">
                        <div class="flex justify-between items-start mb-3">
                            <span class="text-[10px] font-bold font-mono text-[#7A9D8C]">{{ $bidding->no_penawaran ?? '-' }}</span>
                            <span class="inline-flex items-center gap-1.5 px-2 py-1 text-[9px] font-black uppercase rounded {{ $config['bg'] }} {{ $config['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $config['color'] }}"></span>
                                {{ $stat }}
                            </span>
                        </div>
                        <h3 class="font-black text-sm mb-1 truncate text-[#2A402B]">{{ $bidding->nama_perusahaan }}</h3>
                        <p class="text-[10px] font-bold text-[#648B73] mb-4">Total: Rp {{ number_format($bidding->total_penawaran, 0, ',', '.') }}</p>
                        
                        <div class="pt-3 border-t border-[#E2EFE7]">
                            <button wire:click="lihatDetail({{ $bidding->id_r_project }})" 
                                    class="inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-widest transition-colors hover:-translate-x-1 text-[#4A7256] hover:text-[#2A402B]">
                                Buka Workspace
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $daftarBidding->links() }}
            </div>
        </div>

    </div>
</div>