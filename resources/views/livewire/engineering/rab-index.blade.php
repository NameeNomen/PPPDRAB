<div class="min-h-screen font-sans transition-colors duration-300" 
     x-data="{ darkMode: true }" 
     :class="darkMode ? 'bg-[#1A0D05] text-[#FDECE2]' : 'bg-[#FCF6F0] text-[#5C2C00]'">

    @if (session()->has('sukses') || session()->has('success'))
        <div class="max-w-7xl mx-auto p-4 mb-4 rounded-xl font-bold flex items-center gap-3 shadow-md border animate-fade-in text-xs uppercase tracking-widest"
             :class="darkMode ? 'bg-[#261308] border-[#FF7A00] text-[#FFC107]' : 'bg-white border-[#E65C00] text-[#E65C00]'">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('sukses') ?? session('success') }}</span>
        </div>
    @endif

    <div class="max-w-7xl mx-auto p-4 md:p-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 border-b pb-6" :class="darkMode ? 'border-[#331A0A]' : 'border-[#F5A623]/20'">
            <div>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight flex items-center gap-3 uppercase" :class="darkMode ? 'text-[#FF7A00]' : 'text-[#E65C00]'">
                    <span class="w-2 h-8 rounded-full inline-block" :class="darkMode ? 'bg-[#FFC107]' : 'bg-[#F5A623]'"></span>
                    RAB Engineering Workspace
                </h1>
                <p class="text-xs font-bold opacity-70 mt-2 uppercase tracking-widest">Sistem kalkulator estimasi penawaran harga dan material.</p>
            </div>
            <div class="flex items-center gap-2 p-1.5 rounded-xl border transition-colors shadow-inner" :class="darkMode ? 'bg-[#0D0602] border-[#331A0A]' : 'bg-[#F2E5D9] border-[#E65C00]/20'">
                <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-white shadow text-[#E65C00] font-black' : 'text-[#5C2C00]/50'" class="px-4 py-2 text-[10px] rounded-lg uppercase tracking-widest transition-all flex items-center gap-1.5">
                    Terang
                </button>
                <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-[#261308] text-[#FFC107] shadow font-black border border-[#FF7A00]/30' : 'text-[#FDECE2]/50'" class="px-4 py-2 text-[10px] rounded-lg uppercase tracking-widest transition-all flex items-center gap-1.5">
                    Gelap
                </button>
            </div>
        </div>

        <div class="rounded-2xl p-4 mb-8 border flex flex-col md:flex-row gap-4 items-center justify-between transition-colors shadow-sm"
             :class="darkMode ? 'bg-[#261308] border-[#331A0A]' : 'bg-white border-[#E65C00]/20'">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none opacity-50">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" wire:model.live="searchProyek" placeholder="Cari data proyek atau no request..."
                       class="w-full text-xs font-bold pl-12 pr-4 py-3.5 rounded-xl border outline-none transition-all shadow-inner"
                       :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FDECE2] focus:border-[#FF7A00] focus:ring-2 focus:ring-[#FF7A00]/20' : 'bg-[#FCF6F0] border-[#E65C00]/30 text-[#5C2C00] focus:border-[#E65C00] focus:ring-2 focus:ring-[#E65C00]/20'">
            </div>
            <div class="flex items-center w-full md:w-auto">
                <select wire:model.live="filterStatus" class="w-full md:w-auto text-xs font-bold uppercase tracking-widest border rounded-xl px-5 py-3.5 outline-none shadow-sm transition-all cursor-pointer"
                        :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FFC107] focus:border-[#FF7A00]' : 'bg-[#FCF6F0] border-[#E65C00]/30 text-[#E65C00] focus:border-[#E65C00]'">
                    <option value="all">Tampilkan Semua</option>
                    <option value="draft">Status: Draft / Kosong</option>
                    <option value="pending">Status: Pending</option>
                    <option value="approved">Status: Approved</option>
                </select>
            </div>
        </div>

        @php
            $revisiTasks = $daftarProyek->filter(function($p) { return strtolower($p->rab->status_rab ?? '') === 'revisi'; })->values();
            $draftTasks = $daftarProyek->filter(function($p) { $status = strtolower($p->rab->status_rab ?? ''); return in_array($status, ['draft', '']); })->values();
            $otherTasks = $daftarProyek->filter(function($p) { $status = strtolower($p->rab->status_rab ?? ''); return !in_array($status, ['revisi', 'draft', '']); })->values();
        @endphp

        <div class="space-y-10">
            @if($filterStatus === 'all')
                <div class="mb-12">
                    <h2 class="text-sm font-black uppercase tracking-widest mb-6 flex items-center gap-2" :class="darkMode ? 'text-[#FF7A00]' : 'text-[#E65C00]'">
                        <svg class="w-5 h-5 animate-pulse shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Tindakan Diperlukan (Meja Kerja)
                    </h2>

                    @if($revisiTasks->count() == 0 && $draftTasks->count() == 0)
                        <div class="border-2 border-dashed rounded-[2rem] p-16 text-center transition-colors shadow-inner" :class="darkMode ? 'border-[#331A0A] bg-[#261308]/30' : 'border-[#E65C00]/20 bg-[#FCF6F0]/50'">
                            <p class="font-black text-base uppercase tracking-widest mb-2" :class="darkMode ? 'text-[#FFC107]' : 'text-[#E65C00]'">Meja Kerja Bersih! 🎉</p>
                            <p class="text-xs opacity-60 font-bold tracking-widest uppercase">Tidak ada proyek yang menunggu draf atau revisi. Silakan ngopi dulu.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                            <div x-data="{ page: 1, total: {{ $revisiTasks->count() }} }" x-show="total > 0" class="w-full">
                                <h3 class="text-xs font-black uppercase tracking-widest mb-4 flex items-center gap-2 text-rose-500">TUGAS REVISI</h3>
                                @foreach($revisiTasks as $index => $proyek)
                                    <div x-show="page === {{ $index + 1 }}" class="border-2 rounded-[2rem] p-8 shadow-xl flex flex-col justify-between min-h-[280px]" :class="darkMode ? 'bg-[#2E0F05] border-[#FF4500]' : 'bg-[#FFF0ED] border-[#FF4500]'">
                                        <div>
                                            <span class="px-3 py-1 text-[9px] font-black uppercase rounded bg-rose-950 text-rose-400 border border-rose-800">DIKEMBALIKAN DIREKTUR</span>
                                            <h3 class="font-black text-2xl leading-snug mt-4 mb-2 truncate" :class="darkMode ? 'text-white' : 'text-[#5C2C00]'">{{ $proyek->nama_pelanggan }}</h3>
                                            <p class="text-xs opacity-60 font-mono text-[#FF4500]">REQ: {{ $proyek->request_no ?? '-' }}</p>
                                        </div>
                                        <div class="mt-auto pt-6">
                                            <button wire:click="lihatDetail({{ $proyek->id }})" class="w-full py-4 text-xs font-black tracking-widest rounded-xl transition-all shadow-lg border" :class="darkMode ? 'bg-[#FF4500] text-white border-[#FF4500]' : 'bg-[#E65C00] text-white border-[#E65C00]'">LIHAT DETAIL</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div x-data="{ page: 1, total: {{ $draftTasks->count() }} }" x-show="total > 0" class="w-full">
                                <h3 class="text-xs font-black uppercase tracking-widest mb-4 flex items-center gap-2" :class="darkMode ? 'text-[#FFC107]' : 'text-[#E65C00]'">BUAT DRAF BARU</h3>
                                @foreach($draftTasks as $index => $proyek)
                                    <div x-show="page === {{ $index + 1 }}" class="border rounded-[2rem] p-8 shadow-lg flex flex-col justify-between min-h-[280px]" :class="darkMode ? 'bg-[#261308] border-[#FF7A00]/40' : 'bg-white border-[#E65C00]/40'">
                                        <div>
                                            <span class="px-3 py-1 text-[9px] font-black rounded uppercase border" :class="darkMode ? 'bg-[#3B1500] text-[#FFC107] border-[#FF7A00]/30' : 'bg-[#FFF6ED] text-[#D96D06] border-[#D96D06]/30'">{{ $proyek->rab ? 'DRAFT TERSIMPAN' : 'RAB BELUM DIBUAT' }}</span>
                                            <h3 class="font-black text-2xl leading-snug mt-4 mb-2 truncate" :class="darkMode ? 'text-[#FDECE2]' : 'text-[#5C2C00]'">{{ $proyek->nama_pelanggan }}</h3>
                                            <p class="text-xs opacity-50 font-mono" :class="darkMode ? 'text-[#FFC107]' : 'text-[#E65C00]'">REQ: {{ $proyek->request_no ?? '-' }}</p>
                                        </div>
                                        <div class="mt-auto pt-6">
                                            <button wire:click="lihatDetail({{ $proyek->id }})" class="w-full py-4 text-xs font-black tracking-widest rounded-xl transition-all shadow-sm border" :class="darkMode ? 'bg-[#0D0602] text-[#FF7A00] border-[#FF7A00]' : 'bg-[#FCF6F0] text-[#E65C00] border-[#E65C00]/50'">LIHAT DETAIL</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <div>
                @if($filterStatus === 'all' && ($revisiTasks->count() > 0 || $draftTasks->count() > 0))
                    <h2 class="text-sm font-black uppercase tracking-widest mb-4 mt-8 border-t pt-8" :class="darkMode ? 'text-[#FDECE2]/50 border-[#331A0A]' : 'text-[#5C2C00]/50 border-[#F5A623]/20'">Daftar Dokumen Lainnya (Pending & Selesai)</h2>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($filterStatus === 'all' ? $otherTasks : $daftarProyek as $proyek)
                        <div class="border rounded-[1.5rem] p-6 shadow-sm flex flex-col justify-between" :class="darkMode ? 'bg-[#261308] border-[#331A0A]' : 'bg-white border-[#F5A623]/20'">
                            <div>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="px-2 py-0.5 text-[9px] font-black uppercase rounded" :class="darkMode ? 'bg-[#0D0602] text-[#FFC107]' : 'bg-[#FCF6F0] text-[#F5A623]'">PROJECT</span>
                                    <span class="px-3 py-1 text-[9px] font-black rounded uppercase border" :class="darkMode ? 'bg-[#1A0D05] text-[#FDECE2]/70 border-[#331A0A]' : 'bg-[#FCF6F0] text-[#5C2C00]/70 border-[#E65C00]/20'">{{ $proyek->rab->status_rab ?? 'DRAFT' }}</span>
                                </div>
                                <h3 class="font-bold text-base mb-1 truncate" :class="darkMode ? 'text-[#FDECE2]' : 'text-[#5C2C00]'">{{ $proyek->nama_pelanggan }}</h3>
                                <p class="text-[10px] opacity-50 font-mono mb-4">REQ: {{ $proyek->request_no ?? '-' }}</p>
                            </div>
                            <div class="mt-4 pt-4 border-t" :class="darkMode ? 'border-[#331A0A]' : 'border-[#F5A623]/20'">
                                <button wire:click="lihatDetail({{ $proyek->id }})" class="w-full py-2.5 text-[10px] font-black uppercase rounded-xl border" :class="darkMode ? 'bg-[#0D0602] text-[#FF7A00] border-[#331A0A]' : 'bg-[#FCF6F0] text-[#E65C00] border-[#E65C00]/20'">Lihat Detail</button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full border rounded-[2rem] p-16 text-center" :class="darkMode ? 'bg-[#261308] border-[#331A0A]' : 'bg-white border-[#E65C00]/20'">
                            <p class="opacity-50 text-xs font-black uppercase tracking-widest">Tidak ada data proyek.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>