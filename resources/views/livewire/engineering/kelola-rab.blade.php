<div class="min-h-screen font-sans transition-colors duration-300" 
     x-data="{ darkMode: true }" 
     :class="darkMode ? 'bg-[#1A0D05] text-[#FDECE2]' : 'bg-[#FCF6F0] text-[#5C2C00]'">
    
    <!-- NOTIFIKASI SUKSES (ALERT) -->
    @if (session()->has('sukses') || session()->has('success'))
        <div class="max-w-7xl mx-auto p-4 mb-4 rounded-xl font-bold flex items-center gap-3 shadow-md border animate-fade-in text-xs uppercase tracking-widest"
             :class="darkMode ? 'bg-[#261308] border-[#FF7A00] text-[#FFC107]' : 'bg-white border-[#E65C00] text-[#E65C00]'">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('sukses') ?? session('success') }}</span>
        </div>
    @endif

    <!-- ========================================== -->
    <!-- 1. VIEW 'LIST': HALAMAN UTAMA DAFTAR PROYEK-->
    <!-- ========================================== -->
    @if($view === 'list')
        <div class="max-w-7xl mx-auto p-4 md:p-8">
            <!-- HEADER & TOGGLE -->
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
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Terang
                    </button>
                    <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-[#261308] text-[#FFC107] shadow font-black border border-[#FF7A00]/30' : 'text-[#FDECE2]/50'" class="px-4 py-2 text-[10px] rounded-lg uppercase tracking-widest transition-all flex items-center gap-1.5">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        Gelap
                    </button>
                </div>
            </div>

            <!-- SEARCH & FILTER TOOLBAR -->
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

            <!-- LOGIKA PEMISAHAN TASK (BLADE COLLECTION FILTER DENGAN VALUES() UNTUK ALPINE JS) -->
            @php
                $revisiTasks = $daftarProyek->filter(function($p) {
                    return strtolower($p->rab->status_rab ?? '') === 'revisi';
                })->values();

                $draftTasks = $daftarProyek->filter(function($p) {
                    $status = strtolower($p->rab->status_rab ?? '');
                    return in_array($status, ['draft', '']);
                })->values();

                $otherTasks = $daftarProyek->filter(function($p) {
                    $status = strtolower($p->rab->status_rab ?? '');
                    return !in_array($status, ['revisi', 'draft', '']);
                })->values();
            @endphp

            <div class="space-y-10">
                <!-- ================= ZONA 1: MEJA KERJA UTAMA (REVISI & DRAF) ================= -->
                @if($filterStatus === 'all')
                <div class="mb-12">
                    <h2 class="text-sm font-black uppercase tracking-widest mb-6 flex items-center gap-2" :class="darkMode ? 'text-[#FF7A00]' : 'text-[#E65C00]'">
                        <svg class="w-5 h-5 animate-pulse shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Tindakan Diperlukan (Meja Kerja)
                    </h2>

                    @if($revisiTasks->count() == 0 && $draftTasks->count() == 0)
                        <!-- TAMPILAN JIKA MEJA KERJA KOSONG -->
                        <div class="border-2 border-dashed rounded-[2rem] p-16 text-center transition-colors shadow-inner" :class="darkMode ? 'border-[#331A0A] bg-[#261308]/30' : 'border-[#E65C00]/20 bg-[#FCF6F0]/50'">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center transition-colors" :class="darkMode ? 'bg-[#3B1500] text-[#D96D06]' : 'bg-[#FFF6ED] text-[#ED9D59]'">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <p class="font-black text-base uppercase tracking-widest mb-2" :class="darkMode ? 'text-[#FFC107]' : 'text-[#E65C00]'">Meja Kerja Bersih! 🎉</p>
                            <p class="text-xs opacity-60 font-bold tracking-widest uppercase">Tidak ada proyek yang menunggu draf atau revisi. Silakan ngopi dulu.</p>
                        </div>
                    @else
                        <!-- GRID 2 KOLOM: KIRI REVISI, KANAN DRAFT BARU DENGAN PAGINATION -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                            
                            <!-- BLOK KIRI: REVISI (PAGINATION ALPINE JS) -->
                            <div x-data="{ page: 1, total: {{ $revisiTasks->count() }} }" x-show="total > 0" class="w-full">
                                <h3 class="text-xs font-black uppercase tracking-widest mb-4 flex items-center gap-2 text-rose-500">
                                    <span class="relative flex h-3 w-3">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                                    </span>
                                    TUGAS REVISI
                                </h3>

                                @foreach($revisiTasks as $index => $proyek)
                                    <div x-show="page === {{ $index + 1 }}" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-x-4"
                                         x-transition:enter-end="opacity-100 translate-x-0"
                                         class="border-2 rounded-[2rem] p-8 shadow-xl flex flex-col justify-between relative overflow-hidden min-h-[280px]"
                                         :class="darkMode ? 'bg-[#2E0F05] border-[#FF4500]' : 'bg-[#FFF0ED] border-[#FF4500]'">
                                        
                                        <div class="absolute top-0 right-0 w-40 h-40 bg-[#FF4500]/10 rounded-bl-full -z-10 blur-2xl"></div>

                                        <div>
                                            <div class="flex justify-between items-center mb-6">
                                                <span class="px-3 py-1 text-[9px] font-black uppercase rounded tracking-widest bg-rose-950 text-rose-400 border border-rose-800">
                                                    DIKEMBALIKAN DIREKTUR
                                                </span>
                                            </div>
                                            <h3 class="font-black text-2xl leading-snug mb-2 truncate" :class="darkMode ? 'text-white' : 'text-[#5C2C00]'">{{ $proyek->nama_pelanggan }}</h3>
                                            <p class="text-xs opacity-60 font-mono tracking-widest text-[#FF4500]">REQ: {{ $proyek->request_no ?? '-' }}</p>
                                        </div>
                                        <div class="mt-auto pt-6">
                                            <button wire:click="bukaWorkspace({{ $proyek->id }})" 
                                                    class="w-full py-4 text-xs font-black tracking-widest rounded-xl transition-all flex items-center justify-center gap-2 uppercase shadow-lg border hover:-translate-y-1"
                                                    :class="darkMode ? 'bg-[#FF4500] text-white border-[#FF4500] hover:bg-white hover:text-[#FF4500]' : 'bg-[#E65C00] text-white border-[#E65C00] hover:bg-[#FFC107] hover:text-[#5C2C00]'">
                                                PERBAIKI REVISI 
                                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- KONTROL PAGINATION REVISI -->
                                <div class="flex justify-between items-center mt-4 px-2" x-show="total > 1">
                                    <button @click="page--" :disabled="page === 1" class="p-2 rounded-lg transition-all disabled:opacity-30 border" :class="darkMode ? 'bg-[#261308] border-[#331A0A] text-[#FF7A00] hover:bg-[#3B1500]' : 'bg-white border-[#E65C00]/20 text-[#E65C00] hover:bg-[#FCF6F0]'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    </button>
                                    <span class="text-xs font-black font-mono tracking-widest opacity-60" x-text="page + ' DARI ' + total"></span>
                                    <button @click="page++" :disabled="page === total" class="p-2 rounded-lg transition-all disabled:opacity-30 border" :class="darkMode ? 'bg-[#261308] border-[#331A0A] text-[#FF7A00] hover:bg-[#3B1500]' : 'bg-white border-[#E65C00]/20 text-[#E65C00] hover:bg-[#FCF6F0]'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <!-- BLOK KANAN: DRAFT BARU (PAGINATION ALPINE JS) -->
                            <div x-data="{ page: 1, total: {{ $draftTasks->count() }} }" x-show="total > 0" class="w-full">
                                <h3 class="text-xs font-black uppercase tracking-widest mb-4 flex items-center gap-2" :class="darkMode ? 'text-[#FFC107]' : 'text-[#E65C00]'">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    BUAT DRAF BARU
                                </h3>

                                @foreach($draftTasks as $index => $proyek)
                                    <div x-show="page === {{ $index + 1 }}" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-x-4"
                                         x-transition:enter-end="opacity-100 translate-x-0"
                                         class="border rounded-[2rem] p-8 shadow-lg flex flex-col justify-between relative overflow-hidden min-h-[280px]"
                                         :class="darkMode ? 'bg-[#261308] border-[#FF7A00]/40' : 'bg-white border-[#E65C00]/40'">
                                        
                                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#FFC107]/5 rounded-bl-full -z-10 blur-2xl"></div>

                                        <div>
                                            <div class="flex justify-between items-center mb-6">
                                                <span class="px-3 py-1 text-[9px] font-black rounded uppercase tracking-widest border" 
                                                      :class="darkMode ? 'bg-[#3B1500] text-[#FFC107] border-[#FF7A00]/30' : 'bg-[#FFF6ED] text-[#D96D06] border-[#D96D06]/30'">
                                                    {{ $proyek->rab ? 'DRAFT TERSIMPAN' : 'RAB BELUM DIBUAT' }}
                                                </span>
                                            </div>
                                            <h3 class="font-black text-2xl leading-snug mb-2 truncate" :class="darkMode ? 'text-[#FDECE2]' : 'text-[#5C2C00]'">{{ $proyek->nama_pelanggan }}</h3>
                                            <p class="text-xs opacity-50 font-mono tracking-widest" :class="darkMode ? 'text-[#FFC107]' : 'text-[#E65C00]'">REQ: {{ $proyek->request_no ?? '-' }}</p>
                                        </div>
                                        <div class="mt-auto pt-6">
                                            <button wire:click="bukaWorkspace({{ $proyek->id }})" 
                                                    class="w-full py-4 text-xs font-black tracking-widest rounded-xl transition-all flex items-center justify-center gap-2 uppercase shadow-sm border hover:-translate-y-1"
                                                    :class="darkMode ? 'bg-[#0D0602] text-[#FF7A00] border-[#FF7A00] hover:bg-[#FFC107] hover:text-[#0D0602]' : 'bg-[#FCF6F0] text-[#E65C00] border-[#E65C00]/50 hover:bg-[#E65C00] hover:text-white'">
                                                KERJAKAN RAB 
                                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- KONTROL PAGINATION DRAF -->
                                <div class="flex justify-between items-center mt-4 px-2" x-show="total > 1">
                                    <button @click="page--" :disabled="page === 1" class="p-2 rounded-lg transition-all disabled:opacity-30 border" :class="darkMode ? 'bg-[#261308] border-[#331A0A] text-[#FF7A00] hover:bg-[#3B1500]' : 'bg-white border-[#E65C00]/20 text-[#E65C00] hover:bg-[#FCF6F0]'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    </button>
                                    <span class="text-xs font-black font-mono tracking-widest opacity-60" x-text="page + ' DARI ' + total"></span>
                                    <button @click="page++" :disabled="page === total" class="p-2 rounded-lg transition-all disabled:opacity-30 border" :class="darkMode ? 'bg-[#261308] border-[#331A0A] text-[#FF7A00] hover:bg-[#3B1500]' : 'bg-white border-[#E65C00]/20 text-[#E65C00] hover:bg-[#FCF6F0]'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @endif

                <!-- ================= ZONA 2: LACI ARSIP / LAINNYA ================= -->
                <div>
                    @if($filterStatus === 'all' && ($revisiTasks->count() > 0 || $draftTasks->count() > 0))
                    <h2 class="text-sm font-black uppercase tracking-widest mb-4 flex items-center gap-2 mt-8 border-t pt-8" :class="darkMode ? 'text-[#FDECE2]/50 border-[#331A0A]' : 'text-[#5C2C00]/50 border-[#F5A623]/20'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        Daftar Dokumen Lainnya (Pending & Selesai)
                    </h2>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($filterStatus === 'all' ? $otherTasks : $daftarProyek as $proyek)
                            <div class="border rounded-[1.5rem] p-6 shadow-sm flex flex-col justify-between group transition-all hover:-translate-y-1"
                                 :class="darkMode ? 'bg-[#261308] border-[#331A0A] hover:border-[#FF7A00]/50' : 'bg-white border-[#F5A623]/20 hover:border-[#E65C00]/50'">
                                <div>
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="px-2 py-0.5 text-[9px] font-black uppercase rounded tracking-widest" :class="darkMode ? 'bg-[#0D0602] text-[#FFC107]' : 'bg-[#FCF6F0] text-[#F5A623]'">
                                            PROJECT
                                        </span>
                                        <span class="px-3 py-1 text-[9px] font-black rounded uppercase tracking-widest border" 
                                              :class="darkMode ? 'bg-[#1A0D05] text-[#FDECE2]/70 border-[#331A0A]' : 'bg-[#FCF6F0] text-[#5C2C00]/70 border-[#E65C00]/20'">
                                            {{ $proyek->rab->status_rab ?? 'DRAFT' }}
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-base leading-snug mb-1 truncate transition-colors" :class="darkMode ? 'text-[#FDECE2] group-hover:text-[#FFC107]' : 'text-[#5C2C00] group-hover:text-[#E65C00]'">{{ $proyek->nama_pelanggan }}</h3>
                                    <p class="text-[10px] opacity-50 font-mono mb-4">REQ: {{ $proyek->request_no ?? '-' }}</p>
                                </div>
                                <div class="mt-4 pt-4 border-t" :class="darkMode ? 'border-[#331A0A]' : 'border-[#F5A623]/20'">
                                    <button wire:click="bukaWorkspace({{ $proyek->id }})" 
                                            class="w-full py-2.5 text-[10px] font-black tracking-widest rounded-xl transition-all flex items-center justify-center gap-2 uppercase border"
                                            :class="darkMode ? 'bg-[#0D0602] text-[#FF7A00] border-[#331A0A] hover:border-[#FF7A00] hover:bg-[#FF7A00]/10' : 'bg-[#FCF6F0] text-[#E65C00] border-[#E65C00]/20 hover:border-[#E65C00] hover:bg-[#E65C00]/10'">
                                        Lihat Detail 
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full border rounded-[2rem] p-16 text-center" :class="darkMode ? 'bg-[#261308] border-[#331A0A]' : 'bg-white border-[#E65C00]/20'">
                                <p class="opacity-50 text-xs font-black uppercase tracking-widest">Tidak ada data proyek yang sesuai kriteria.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    <!-- ========================================== -->
    <!-- 2. VIEW 'CARD': DETAIL PERSIAPAN WORKSPACE -->
    <!-- ========================================== -->
    @elseif($view === 'card')
        <div class="max-w-5xl mx-auto p-4 md:p-8">
            <button wire:click="kembaliKeList" class="mb-6 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest px-5 py-3 rounded-xl border transition-all shadow-sm"
                    :class="darkMode ? 'bg-[#261308] border-[#331A0A] text-[#FFC107] hover:bg-[#0D0602]' : 'bg-white border-[#E65C00]/20 text-[#E65C00] hover:bg-[#FCF6F0]'">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                KEMBALI KE BOARD
            </button>
            
            @if(!$rabAktif)
                <div class="border rounded-[2rem] p-12 shadow-sm relative overflow-hidden flex flex-col items-center text-center transition-colors" 
                     :class="darkMode ? 'bg-[#261308] border-[#331A0A]' : 'bg-white border-[#E65C00]/20'">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mb-6 border-4" :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FF7A00]' : 'bg-[#FCF6F0] border-[#E65C00]/20 text-[#E65C00]'">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-black uppercase tracking-tight mb-2" :class="darkMode ? 'text-white' : 'text-[#5C2C00]'">{{ $selectedProject->nama_pelanggan }}</h2>
                    <p class="text-xs font-bold font-mono opacity-50 mb-8 tracking-widest uppercase">ID PROYEK: #{{ $selectedProject->id }} | Draf belum tersedia.</p>
                    
                    <button wire:click="editRab" class="px-8 py-4 text-xs font-black tracking-widest rounded-xl transition-all flex items-center gap-3 uppercase shadow-lg hover:-translate-y-1"
                            :class="darkMode ? 'bg-gradient-to-r from-[#FF7A00] to-[#E65C00] text-[#1A0D05] shadow-[#FF7A00]/20' : 'bg-gradient-to-r from-[#E65C00] to-[#F5A623] text-white shadow-[#E65C00]/20'">
                        <span wire:loading.remove wire:target="editRab" class="flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            INISIASI RAB BARU
                        </span>
                        <span wire:loading wire:target="editRab" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            MENYIAPKAN...
                        </span>
                    </button>
                </div>
            @else
                @php
                    $isRevisi = strtolower($rabAktif->status_rab ?? '') === 'revisi';
                    $isApproved = strtolower($rabAktif->status_rab ?? '') === 'approved';
                @endphp
                <div class="border rounded-[2rem] p-8 md:p-10 shadow-lg relative overflow-hidden transition-all duration-300 mb-8" 
                     :class="darkMode ? ($isRevisi ? 'bg-[#2E0F05] border-[#FF4500]/50 shadow-[0_0_20px_rgba(255,69,0,0.15)]' : 'bg-[#261308] border-[#331A0A]') : ($isRevisi ? 'bg-[#FFF0ED] border-[#FF4500]/50' : 'bg-white border-[#E65C00]/20')">
                    
                    <div class="flex flex-col md:flex-row justify-between items-start gap-6 mb-8">
                        <div>
                            <span class="text-[10px] font-black tracking-widest uppercase px-3 py-1.5 rounded-lg border" 
                                  :class="darkMode ? ($isRevisi ? 'bg-[#FF4500]/20 text-[#FF4500] border-[#FF4500]/30' : ($isApproved ? 'bg-emerald-500/20 text-emerald-400 border-emerald-800' : 'bg-[#0D0602] text-[#FFC107] border-[#331A0A]')) : ($isRevisi ? 'bg-[#FF4500]/10 text-[#FF4500] border-[#FF4500]/30' : ($isApproved ? 'bg-emerald-100 text-emerald-700 border-emerald-300' : 'bg-[#FCF6F0] text-[#E65C00] border-[#E65C00]/20'))">
                                DOKUMEN AKTIF
                            </span>
                            <h2 class="text-3xl font-black mt-4 uppercase tracking-tight" :class="darkMode ? 'text-white' : 'text-[#5C2C00]'">{{ $selectedProject->nama_pelanggan }}</h2>
                            <p class="text-xs font-bold font-mono opacity-60 mt-2 uppercase tracking-widest">REF: {{ $rabAktif->no_boq }}</p>
                        </div>
                        <div class="text-left md:text-right p-4 rounded-xl border" :class="darkMode ? 'bg-[#0D0602] border-[#331A0A]' : 'bg-[#FCF8F5] border-[#E65C00]/30'">
                            <span class="text-[9px] opacity-60 block mb-1 font-black uppercase tracking-widest">Status Dokumen</span>
                            <span class="text-sm font-black uppercase tracking-wider flex items-center gap-1.5" 
                                  :class="darkMode ? ($isRevisi ? 'text-[#FF4500]' : ($isApproved ? 'text-emerald-400' : 'text-[#FF7A00]')) : ($isRevisi ? 'text-[#FF4500]' : ($isApproved ? 'text-emerald-600' : 'text-[#E65C00]'))">
                                @if($isRevisi)
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                @endif
                                {{ $rabAktif->status_rab ?? 'DRAFT' }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6 rounded-2xl border transition-colors shadow-inner" 
                         :class="darkMode ? 'bg-[#0D0602] border-[#331A0A]' : 'bg-[#FCF8F5] border-[#E65C00]/40'">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-60">Overhead Cost</p>
                            <p class="text-base font-black font-mono mt-1" :class="darkMode ? 'text-[#FF7A00]' : 'text-[#E65C00]'">Rp {{ number_format($rabAktif->overhead_cost, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest" :class="darkMode ? 'text-[#FFC107]' : 'text-[#F5A623]'">Grand Total Estimasi</p>
                            <p class="text-2xl font-black font-mono mt-1" :class="darkMode ? 'text-white' : 'text-[#5C2C00]'">Rp {{ number_format($rabAktif->grand_total, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-3 pt-6 border-t" :class="darkMode ? 'border-[#331A0A]' : 'border-[#F5A623]/20'">
                        <button wire:click="editRab" class="px-6 py-3 text-[10px] font-black tracking-widest rounded-xl transition-all uppercase flex items-center gap-2 border shadow-md hover:-translate-y-0.5"
                                :class="darkMode ? 'bg-[#FF7A00] border-[#FF7A00] text-[#1A0D05] hover:bg-[#FFC107]' : 'bg-[#E65C00] border-[#E65C00] text-white hover:bg-[#F5A623]'">
                            <span wire:loading.remove wire:target="editRab" class="flex items-center gap-2">
                                @if($isApproved)
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    BACA SPREADSHEET
                                @else
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    EDIT SPREADSHEET
                                @endif
                            </span>
                            <span wire:loading wire:target="editRab" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-current shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                MEMBUKA...
                            </span>
                        </button>
                        
                        @if(!$isApproved)
                        <button onclick="confirm('Yakin ingin menghapus seluruh dokumen RAB ini beserta historinya?') || event.stopImmediatePropagation()" 
                                wire:click="hapusDokumenRab" class="px-6 py-3 text-rose-500 hover:bg-rose-500 hover:text-white text-[10px] font-black tracking-widest rounded-xl transition-all border uppercase flex items-center gap-2"
                                :class="darkMode ? 'bg-transparent border-rose-900' : 'bg-rose-50 border-rose-300'">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            HAPUS
                        </button>
                        @endif

                        <div class="w-px bg-current opacity-20 mx-2"></div> 

                        <button {{ $isRevisi ? 'disabled' : '' }} 
                                class="px-5 py-3 text-[10px] font-black tracking-widest rounded-xl transition-all uppercase flex items-center gap-2 border"
                                :class="$isRevisi 
                                        ? 'opacity-40 cursor-not-allowed ' . (darkMode ? 'bg-transparent border-[#331A0A] text-slate-500' : 'bg-slate-100 border-slate-200 text-slate-400') 
                                        : (darkMode ? 'bg-[#0D0602] hover:bg-emerald-950 text-emerald-500 border-emerald-900' : 'bg-white hover:bg-emerald-50 text-emerald-600 border-emerald-300')">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            EXCEL
                            @if($isRevisi)
                                <svg class="w-3 h-3 shrink-0 ml-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            @endif
                        </button>
                        
                        <button {{ $isRevisi ? 'disabled' : '' }} 
                                class="px-5 py-3 text-[10px] font-black tracking-widest rounded-xl transition-all uppercase flex items-center gap-2 border"
                                :class="$isRevisi 
                                        ? 'opacity-40 cursor-not-allowed ' . (darkMode ? 'bg-transparent border-[#331A0A] text-slate-500' : 'bg-slate-100 border-slate-200 text-slate-400') 
                                        : (darkMode ? 'bg-[#0D0602] hover:bg-rose-950 text-rose-500 border-rose-900' : 'bg-white hover:bg-rose-50 text-rose-600 border-rose-300')">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            PDF
                            @if($isRevisi)
                                <svg class="w-3 h-3 shrink-0 ml-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            @endif
                        </button>
                    </div>
                </div>
            @endif
        </div>

    <!-- ========================================== -->
    <!-- 3. VIEW 'SPREADSHEET': WORKSTATION RAB FULL-->
    <!-- ========================================== -->
    @elseif($view === 'spreadsheet')
        @php
            $isApproved = strtolower($rabAktif->status_rab ?? '') === 'approved';
        @endphp
        
        <div class="w-full mx-auto p-4 md:p-6">
            <!-- HEADER STICKY -->
            <div class="w-full flex flex-col md:flex-row items-start md:items-center justify-between mb-6 p-4 rounded-2xl border transition-colors sticky top-4 z-40 shadow-lg backdrop-blur-xl"
                 :class="darkMode ? 'bg-[#1A0D05]/80 border-[#FF7A00]/30' : 'bg-white/90 border-[#E65C00]/30'">
                
                <div class="flex items-center gap-4 mb-4 md:mb-0 w-full md:w-auto">
                    <button wire:click="kembaliKeList" 
                            class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl border transition-all flex items-center gap-2"
                            :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FFC107] hover:bg-[#261308]' : 'bg-[#FCF6F0] border-[#E65C00]/20 text-[#E65C00] hover:bg-white'">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        KELUAR
                    </button>
                    <div class="flex items-center gap-1 p-1 rounded-xl shadow-inner border transition-colors" :class="darkMode ? 'bg-[#0D0602] border-[#331A0A]' : 'bg-[#F2E5D9] border-[#E65C00]/20'">
                        <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-white shadow text-[#E65C00] font-black' : 'text-[#5C2C00]/50'" class="px-3 py-1.5 text-[9px] rounded-lg transition-all uppercase tracking-widest flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Terang
                        </button>
                        <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-[#261308] text-[#FFC107] shadow border border-[#FF7A00]/30 font-black' : 'text-[#FDECE2]/50'" class="px-3 py-1.5 text-[9px] rounded-lg transition-all uppercase tracking-widest flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                            Gelap
                        </button>
                    </div>
                </div>

                <div class="w-full md:w-auto flex justify-end">
                    @if(!$isApproved)
                        <button wire:click="submitKeDirektur({{ $rabAktif->id }})" wire:loading.attr="disabled" class="w-full md:w-auto px-6 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg transition-all border hover:-translate-y-0.5"
                                :class="darkMode ? 'bg-[#FF7A00] border-[#FF7A00] text-[#1A0D05] hover:bg-[#FFC107] disabled:opacity-50' : 'bg-[#E65C00] border-[#E65C00] text-white hover:bg-[#F5A623] disabled:opacity-50'">
                            <div wire:loading.remove wire:target="submitKeDirektur" class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                SUBMIT KE DIREKTUR
                            </div>
                            <div wire:loading wire:target="submitKeDirektur" class="flex items-center justify-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-current shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                MEMPROSES...
                            </div>
                        </button>
                    @else
                        <span class="w-full md:w-auto px-6 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl bg-emerald-500/20 text-emerald-500 border border-emerald-500/30 text-center flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            DOKUMEN DIKUNCI (APPROVED)
                        </span>
                    @endif
                </div>
            </div>

            @if ($errors->has('nama_editor') || $errors->has('commit_message'))
                <div class="mb-6 p-5 border-l-4 rounded-xl shadow-sm animate-pulse" :class="darkMode ? 'bg-rose-950/40 border-rose-500 text-rose-300' : 'bg-rose-50 border-rose-500 text-rose-700'">
                    <p class="font-black text-xs uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Form Histori Belum Lengkap!
                    </p>
                    <p class="text-xs mt-1.5 font-bold opacity-80 pl-7">Pastikan Anda telah mengisi Nama Editor dan Pesan Histori Commit sebelum menekan tombol Submit ke Direktur.</p>
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-stretch">
                <!-- PANEL KIRI: INFO PROYEK & FORM COMMIT -->
                <div class="xl:col-span-3 border rounded-3xl p-6 flex flex-col justify-between transition-colors shadow-sm h-full"
                     :class="darkMode ? 'bg-[#1F0D05] border-[#5C2000]' : 'bg-white border-[#ED9D59]/40'">
                    <div>
                        <h3 class="text-[10px] font-black uppercase tracking-widest mb-6 border-b-2 pb-3" 
                            :class="darkMode ? 'text-[#FF7A00] border-[#331A0A]' : 'text-[#E65C00] border-[#F5A623]/20'">
                            INFO TARGET PROYEK
                        </h3>
                        <div class="space-y-5">
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-widest opacity-50 block">INSTANSI / KLIEN</span>
                                <p class="text-sm font-black mt-1 uppercase" :class="darkMode ? 'text-white' : 'text-[#5C2C00]'">{{ $selectedProject->nama_pelanggan }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-widest opacity-50 block">TARGET WAKTU</span>
                                <p class="text-sm font-bold font-mono mt-1" :class="darkMode ? 'text-[#FFC107]' : 'text-[#F5A623]'">
                                    {{ $selectedProject->target_waktu ? \Carbon\Carbon::parse($selectedProject->target_waktu)->format('d F Y') : '-' }}
                                </p>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-widest opacity-50 block">ALAMAT LOKASI</span>
                                <p class="text-xs font-bold mt-1.5 leading-relaxed opacity-80">{{ $selectedProject->alamat ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-widest opacity-50 block mb-1.5">SPESIFIKASI TEKNIS</span>
                                <div class="text-[11px] font-bold p-4 rounded-xl border max-h-48 overflow-y-auto whitespace-pre-line shadow-inner"
                                     :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FDECE2]/70' : 'bg-[#FCF8F5] border-[#ED9D59]/40 text-[#A33C04]/80'">
                                    {{ $selectedProject->deskripsi_proyek ?? 'Tidak ada catatan teknis.' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!$isApproved)
                    <div class="mt-8 border-t-2 pt-6" :class="darkMode ? 'border-[#331A0A]' : 'border-[#F5A623]/20'">
                        <span class="text-[10px] font-black uppercase tracking-widest flex items-center gap-2 mb-4" :class="darkMode ? 'text-[#FF7A00]' : 'text-[#E65C00]'">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            PESAN COMMIT HISTORI
                        </span>
                        <div class="space-y-4">
                            <div>
                                <input type="text" wire:model="nama_editor" placeholder="Nama Anda..." 
                                       class="w-full text-xs font-bold px-4 py-3 rounded-xl border outline-none transition-all shadow-inner"
                                       :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-white focus:border-[#FF7A00]' : 'bg-[#FCF6F0] border-[#E65C00]/30 text-[#5C2C00] focus:border-[#E65C00]'">
                                @error('nama_editor') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest mt-1.5 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <textarea wire:model="commit_message" placeholder="Catatan versi ini..." rows="3"
                                          class="w-full text-xs font-bold px-4 py-3 rounded-xl border outline-none transition-all resize-none shadow-inner"
                                          :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-white focus:border-[#FF7A00]' : 'bg-[#FCF6F0] border-[#E65C00]/30 text-[#5C2C00] focus:border-[#E65C00]'">
                                </textarea>
                                @error('commit_message') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest mt-1.5 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- PANEL KANAN: WORKSTATION / SPREADSHEET -->
                <div class="lg:col-span-9 space-y-6">
                    @if(!$isApproved)
                        <div class="border rounded-3xl p-6 transition-colors shadow-sm" :class="darkMode ? 'bg-[#261308] border-[#331A0A]' : 'bg-white border-[#E65C00]/20'">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                <div>
                                    <label class="block text-[9px] font-black uppercase tracking-widest opacity-60 mb-2">NO. BOQ</label>
                                    <input type="text" wire:model="no_boq" class="w-full text-sm font-mono font-black px-4 py-3 rounded-xl border outline-none transition-all shadow-inner"
                                           :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FFC107] focus:border-[#FF7A00]' : 'bg-[#FCF6F0] border-[#E65C00]/30 text-[#E65C00] focus:border-[#E65C00]'">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black uppercase tracking-widest opacity-60 mb-2">TANGGAL DOKUMEN</label>
                                    <input type="date" wire:model="tanggal_dokumen" class="w-full text-sm font-bold px-4 py-3 rounded-xl border outline-none transition-all shadow-inner"
                                           :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FFC107] focus:border-[#FF7A00]' : 'bg-[#FCF6F0] border-[#E65C00]/30 text-[#E65C00] focus:border-[#E65C00]'">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black uppercase tracking-widest opacity-60 mb-2">OVERHEAD COST (RP)</label>
                                    <input type="number" wire:model.live="overhead_cost" class="w-full text-sm font-mono font-black px-4 py-3 rounded-xl border outline-none transition-all shadow-inner"
                                           :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FFC107] focus:border-[#FF7A00]' : 'bg-[#FCF6F0] border-[#E65C00]/30 text-[#E65C00] focus:border-[#E65C00]'">
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="rounded-3xl border transition-colors shadow-sm overflow-hidden" :class="darkMode ? 'bg-[#261308] border-[#331A0A]' : 'bg-white border-[#E65C00]/20'">
                        
                        @if(!$isApproved)
                            <div class="p-4 border-b flex justify-between items-center gap-3" :class="darkMode ? 'bg-[#1A0D05]/50 border-[#331A0A]' : 'bg-[#FCF6F0] border-[#E65C00]/20'">
                                <div class="flex items-center gap-3 w-full max-w-lg">
                                    <input type="text" wire:model="newKategori" placeholder="Ketik nama kategori utama (ex: Pekerjaan Sipil)..." 
                                           class="text-xs font-bold rounded-xl px-4 py-3 w-full border outline-none shadow-inner transition-all"
                                           :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FFC107] focus:border-[#FF7A00]' : 'bg-white border-[#E65C00]/30 text-[#5C2C00] focus:border-[#E65C00]'">
                                    <button type="button" wire:click="tambahKategori" wire:loading.attr="disabled" class="px-5 py-3 text-[10px] font-black rounded-xl transition-all shrink-0 uppercase tracking-widest shadow-md border flex items-center gap-2"
                                            :class="darkMode ? 'bg-[#FF7A00] border-[#FF7A00] text-[#1A0D05] hover:bg-[#FFC107]' : 'bg-[#E65C00] border-[#E65C00] text-white hover:bg-[#F5A623]'">
                                        <span wire:loading.remove wire:target="tambahKategori">KATEGORI</span>
                                        <span wire:loading wire:target="tambahKategori">⏳...</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                        
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-left text-xs border-collapse min-w-[950px]">
                                <thead class="font-black uppercase tracking-widest border-b" :class="darkMode ? 'bg-[#0D0602] text-[#D96D06] border-[#5C2000]' : 'bg-[#FCF8F5] text-[#D96D06] border-[#ED9D59]/40'">
                                    <tr>
                                        <th class="px-4 py-4 text-center w-12 border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">NO</th>
                                        <th class="px-4 py-4 w-[30%] border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">DESKRIPSI PEKERJAAN</th>
                                        <th class="px-4 py-4 w-[25%] border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">MATERIAL (OPSIONAL)</th>
                                        <th class="px-4 py-4 text-center w-16 border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">VOL</th>
                                        <th class="px-4 py-4 text-right w-32 border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">HARGA SATUAN</th>
                                        <th class="px-4 py-4 text-right w-40 {{ !$isApproved ? 'border-r' : '' }}" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">SUBTOTAL (RP)</th>
                                        @if(!$isApproved) <th class="px-4 py-4 text-center w-16">ACT</th> @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y font-bold relative" :class="darkMode ? 'divide-[#5C2000]' : 'divide-[#ED9D59]/30'">
                                    @php $noIndex = 1; @endphp
                                    @foreach($kategoris as $kat)
                                        <tr wire:key="kategori-{{ $kat->id }}" :class="darkMode ? 'bg-[#3B1500]/40 text-[#FAB64A]' : 'bg-[#FFF6ED] text-[#A33C04]'" class="font-black border-y-2" :style="darkMode ? 'border-color: #5C2000' : 'border-color: #ED9D59'">
                                            <td class="px-4 py-3 text-center font-mono border-r" :class="darkMode?'border-[#5C2000]':'border-[#ED9D59]/30'">{{ $noIndex++ }}</td>
                                            <td class="px-4 py-3 border-r uppercase tracking-wide" :class="darkMode?'border-[#5C2000]':'border-[#ED9D59]/30'" colspan="2">{{ $kat->deskripsi_pekerjaan }}</td>
                                            <td class="px-4 py-3 text-center border-r" :class="darkMode?'border-[#5C2000]':'border-[#ED9D59]/30'">-</td>
                                            <td class="px-4 py-3 text-right border-r" :class="darkMode?'border-[#5C2000]':'border-[#ED9D59]/30'">-</td>
                                            <td class="px-4 py-3 text-right font-mono font-black {{ !$isApproved ? 'border-r' : '' }}" :class="darkMode?'border-[#5C2000] text-white':'border-[#ED9D59]/30 text-[#5C2C00]'">
                                                Rp {{ number_format($kat->children->sum('subtotal'), 0, ',', '.') }}
                                            </td>
                                            @if(!$isApproved)
                                            <td class="px-4 py-3 text-center">
                                                <button type="button" wire:click="hapusItem({{ $kat->id }})" class="text-rose-500 hover:text-white bg-rose-500/10 hover:bg-rose-500 p-1.5 rounded transition-colors" title="Hapus Kategori">
                                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </td>
                                            @endif
                                        </tr>

                                        @foreach($kat->children as $item)
                                            <tr wire:key="item-{{ $item->id }}" :class="darkMode ? 'hover:bg-[#1A0D05]/40 text-[#FDECE2]/80' : 'hover:bg-[#FCF6F0] text-[#5C2C00]/90'">
                                                <td class="px-4 py-2 text-center font-mono border-r opacity-40" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'"></td>
                                                <td class="px-4 py-2 border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">{{ $item->deskripsi_pekerjaan }}</td>
                                                <td class="px-4 py-2 border-r font-mono opacity-80" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">
                                                    {{ $item->material->nama_barang ?? 'Custom/Tenaga' }} 
                                                    <span class="text-[10px] opacity-60 ml-1">({{ $item->material->satuan ?? '-' }})</span>
                                                </td>
                                                <td class="px-4 py-2 text-center border-r font-mono" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">{{ $item->qty }}</td>
                                                <td class="px-4 py-2 text-right border-r font-mono" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">Rp {{ number_format($item->harga_awal, 0, ',', '.') }}</td>
                                                <td class="px-4 py-2 text-right border-r font-mono font-black" :class="darkMode ? 'border-[#5C2000] text-[#FFC107]':'border-[#ED9D59]/20 text-[#E65C00]'">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                                @if(!$isApproved)
                                                <td class="px-4 py-2 text-center">
                                                    <button type="button" wire:click="hapusItem({{ $item->id }})" class="text-rose-500/70 hover:text-rose-500 p-1" title="Hapus Item">
                                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach

                                        @if(!$isApproved)
                                            <tr wire:key="form-input-{{ $kat->id }}" :class="darkMode ? 'bg-[#0D0602]/50' : 'bg-[#FCF6F0]/50'" class="border-b relative">
                                                <td class="px-3 py-2 border-r opacity-30 text-center text-lg font-black" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/30'">+</td>
                                                <td class="px-3 py-2 border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/30'">
                                                    <input type="text" wire:model="deskripsiInput.{{ $kat->id }}" placeholder="Ketik rincian pekerjaan..." 
                                                           class="w-full text-xs font-bold rounded-lg px-3 py-2 outline-none border transition-colors shadow-inner"
                                                           :class="darkMode ? 'bg-[#1A0D05] border-[#331A0A] text-white focus:border-[#FF7A00]' : 'bg-white border-[#E65C00]/40 text-[#5C2C00] focus:border-[#E65C00]'">
                                                </td>

                                                <td class="px-3 py-2 border-r relative" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/30'">
                                                    @if(!empty($selectedMaterial[$kat->id]))
                                                        <div class="flex items-center justify-between p-2 rounded-lg font-mono text-[10px] font-black border transition-all"
                                                             :class="darkMode ? 'bg-[#1A0D05] border-[#FF7A00]/50 text-[#FFC107]' : 'bg-[#FFF6ED] border-[#E65C00]/50 text-[#E65C00]'">
                                                            <div class="flex items-center gap-2 truncate pr-2">
                                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                                <span class="truncate">{{ $selectedMaterial[$kat->id]['nama'] }}</span>
                                                                <span class="opacity-80">Ref: Rp {{ number_format($selectedMaterial[$kat->id]['harga'], 0, ',', '.') }}</span>
                                                            </div>
                                                            <button type="button" wire:click="batalPilihMaterial({{ $kat->id }})" class="text-rose-500 hover:text-rose-400 p-1 focus:outline-none" title="Batal Pilih">
                                                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <input type="text" wire:model.live.debounce.300ms="materialSearch.{{ $kat->id }}" placeholder="Ketik material (Opsional)..." 
                                                               class="w-full text-xs font-bold rounded-lg px-3 py-2 outline-none border transition-colors font-mono shadow-inner"
                                                               :class="darkMode ? 'bg-[#1A0D05] border-[#331A0A] text-white focus:border-[#FF7A00]' : 'bg-white border-[#E65C00]/40 text-[#5C2C00] focus:border-[#E65C00]'">

                                                        @if(!empty($materialResults[$kat->id]))
                                                            <div class="absolute left-0 right-0 top-full rounded-xl shadow-2xl z-50 max-h-48 overflow-y-auto mt-2 p-1 border w-72"
                                                                 :class="darkMode ? 'bg-[#1A0D05] border-[#FF7A00]' : 'bg-white border-[#E65C00]'">
                                                                @foreach($materialResults[$kat->id] as $m)
                                                                    <div wire:key="search-result-{{ $m->id }}-{{ $kat->id }}" wire:click="pilihMaterial({{ $kat->id }}, {{ $m->id }}, '{{ addslashes($m->nama_barang) }}', {{ $m->harga }}, '{{ $m->satuan ?? '-' }}')" 
                                                                         class="p-3 cursor-pointer text-[10px] flex flex-col rounded-lg transition-colors border-b last:border-b-0"
                                                                         :class="darkMode ? 'hover:bg-[#261308] border-[#331A0A] text-[#FDECE2]' : 'hover:bg-[#FFF6ED] border-[#E65C00]/20 text-[#5C2C00]'">
                                                                        <span class="truncate font-black">{{ $m->nama_barang }}</span>
                                                                        <span class="font-mono text-[#E65C00] font-bold" :class="darkMode ? 'text-[#FFC107]' : 'text-[#E65C00]'">Rp {{ number_format($m->harga, 0, ',', '.') }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="px-3 py-2 border-r" :class="darkMode ? 'border-[#331A0A]':'border-[#E65C00]/30'">
                                                    <input type="number" step="0.01" wire:model="volumeInput.{{ $kat->id }}" placeholder="0" 
                                                           class="w-full text-xs font-bold rounded-lg px-2 py-2 text-center border font-mono outline-none shadow-inner" 
                                                           :class="darkMode ? 'bg-[#1A0D05] border-[#331A0A] text-white focus:border-[#FF7A00]' : 'bg-white border-[#E65C00]/40 text-[#5C2C00] focus:border-[#E65C00]'">
                                                </td>
                                                <td class="px-3 py-2 border-r text-center" :class="darkMode ? 'border-[#331A0A]':'border-[#E65C00]/30'">
                                                    <input type="number" wire:model="hargaInput.{{ $kat->id }}" placeholder="Harga..." 
                                                           class="w-full text-xs font-bold rounded-lg px-3 py-2 text-right outline-none border font-mono shadow-inner" 
                                                           :class="darkMode ? 'bg-[#1A0D05] border-[#331A0A] text-white focus:border-[#FF7A00]' : 'bg-white border-[#E65C00]/40 text-[#5C2C00] focus:border-[#E65C00]'">
                                                </td>
                                                <td class="px-3 py-2 border-r text-right" :class="darkMode ? 'border-[#331A0A]':'border-[#E65C00]/30'" colspan="2">
                                                    <button type="button" wire:click="simpanItemBaru({{ $kat->id }})" wire:loading.attr="disabled" class="px-3 py-2 text-[10px] font-black rounded-lg transition-all w-full uppercase tracking-widest flex items-center justify-center gap-1.5 shadow-md border"
                                                            :class="darkMode ? 'bg-[#FF7A00] border-[#FF7A00] text-[#1A0D05] hover:bg-[#FFC107]' : 'bg-[#E65C00] border-[#E65C00] text-white hover:bg-[#F5A623]'">
                                                        <span wire:loading.remove wire:target="simpanItemBaru({{ $kat->id }})">SIMPAN ITEM</span>
                                                        <span wire:loading wire:target="simpanItemBaru({{ $kat->id }})">⏳...</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                
                                <tfoot class="border-t-4" :class="darkMode ? 'border-[#FF7A00] bg-[#0D0602]' : 'border-[#E65C00] bg-[#FCF6F0]'">
                                    <tr class="border-b" :class="darkMode ? 'border-[#331A0A]' : 'border-[#E65C00]/40'">
                                        <td colspan="4" class="px-5 py-3 text-right font-black text-[10px] uppercase tracking-widest" :class="darkMode ? 'text-[#FDECE2]/50' : 'text-[#5C2C00]/60'">
                                            Total : 1 sd {{ count($kategoris) }} =
                                        </td>
                                        <td colspan="2" class="px-5 py-3 text-right font-black font-mono text-sm border-l" :class="darkMode ? 'border-[#331A0A] text-white' : 'border-[#E65C00]/40 text-[#5C2C00]'">
                                            Rp {{ number_format($totalPekerjaan, 2, ',', '.') }}
                                        </td>
                                        @if(!$isApproved) <td></td> @endif
                                    </tr>
                                    <tr class="border-b" :class="darkMode ? 'border-[#331A0A]' : 'border-[#E65C00]/40'">
                                        <td colspan="4" class="px-5 py-3 text-right font-black text-[10px] uppercase tracking-widest" :class="darkMode ? 'text-[#FDECE2]/50' : 'text-[#5C2C00]/60'">
                                            Over Head Cost
                                        </td>
                                        <td colspan="2" class="px-5 py-3 text-right font-black font-mono text-sm border-l" :class="darkMode ? 'border-[#331A0A] text-white' : 'border-[#E65C00]/40 text-[#5C2C00]'">
                                            Rp {{ number_format($overhead, 2, ',', '.') }}
                                        </td>
                                        @if(!$isApproved) <td></td> @endif
                                    </tr>
                                    <tr class="border-b" :class="darkMode ? 'border-[#331A0A]' : 'border-[#E65C00]/40'">
                                        <td colspan="4" class="px-5 py-3 text-right font-black text-[10px] uppercase tracking-widest" :class="darkMode ? 'text-[#FDECE2]/50' : 'text-[#5C2C00]/60'">
                                            Total
                                        </td>
                                        <td colspan="2" class="px-5 py-3 text-right font-black font-mono text-sm border-l" :class="darkMode ? 'border-[#331A0A] text-[#FFC107]' : 'border-[#E65C00]/40 text-[#E65C00]'">
                                            Rp {{ number_format($grandTotal, 2, ',', '.') }}
                                        </td>
                                        @if(!$isApproved) <td></td> @endif
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="px-5 py-4 text-right font-black text-sm uppercase tracking-widest" :class="darkMode ? 'text-[#FF7A00]' : 'text-[#E65C00]'">
                                            Grand Total Dibulatkan
                                        </td>
                                        <td colspan="2" class="px-5 py-4 text-right font-black font-mono text-lg border-l" :class="darkMode ? 'border-[#331A0A] text-[#FF7A00]' : 'border-[#E65C00]/40 text-[#E65C00]'">
                                            Rp {{ number_format(floor($grandTotal/1000)*1000, 2, ',', '.') }}
                                        </td>
                                        @if(!$isApproved) <td></td> @endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

//udaah bagus nih bro, cuman pas bagian workplacenya atau pmbuatan rab nya bisa ga dibuat lebih ergonomis?si detail proyek nya itu ngikutin si rab dah sampai mana detail proyek bisa aja panajng kan bisa di scroll tapi penempaaatannya sangat pas dengan pembuatan rab nya supaya si enginer ga usah scrooll atas lagi tapi cukup melirik kesamping aja si detail proyek sai hai aku ada disini lirik aku kalau kau butuh, btw efesien ga sih kalau misal 1 blade ada lebih dari 1000 kode ?