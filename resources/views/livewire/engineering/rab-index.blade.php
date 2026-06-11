<div class="min-h-screen font-sans transition-colors duration-300" style="font-family: 'Inter', sans-serif;"
     x-data="{ darkMode: false }"
     :class="darkMode ? 'bg-[#121212] text-gray-200' : 'bg-[#F8F9FA] text-gray-800'">

    @if (session()->has('sukses') || session()->has('success'))
        <div class="max-w-7xl mx-auto p-4 mb-4 mt-6 rounded-xl font-bold flex items-center gap-3 shadow-sm border text-xs tracking-widest uppercase"
             :class="darkMode ? 'bg-emerald-900/20 border-emerald-800 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-600'">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('sukses') ?? session('success') }}</span>
        </div>
    @endif

    <div class="max-w-7xl mx-auto p-4 md:p-8">
        <!-- HEADER -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight flex items-center gap-3" :class="darkMode ? 'text-gray-100' : 'text-gray-900'">
                    <span class="w-1.5 h-6 rounded-full inline-block bg-yellow-400"></span>
                    RAB Workspace
                </h1>
                <p class="text-sm font-medium opacity-60 mt-1" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Sistem manajemen estimasi penawaran harga.</p>
            </div>
            
            <!-- TOGGLE DARK/LIGHT -->
            <div class="flex items-center gap-1 p-1.5 rounded-lg border shadow-sm transition-colors" :class="darkMode ? 'bg-[#1A1A1A] border-[#2A2A2A]' : 'bg-white border-gray-200'">
                <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-yellow-400 text-gray-900 font-bold shadow-sm' : 'text-gray-400 hover:text-gray-600'" class="px-4 py-2 text-xs rounded-md transition-all">Light</button>
                <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-yellow-500 text-gray-900 font-bold shadow-sm' : 'text-gray-400 hover:text-gray-600'" class="px-4 py-2 text-xs rounded-md transition-all">Dark</button>
            </div>
        </div>

        <!-- SEARCH & FILTER TOOLBAR -->
        <div class="rounded-xl p-3 mb-8 flex flex-col md:flex-row gap-4 items-center justify-between shadow-sm transition-colors"
             :class="darkMode ? 'bg-[#1E1E1E]' : 'bg-white'">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none opacity-40">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" wire:model.live="searchProyek" placeholder="Cari proyek atau nomor request..."
                       class="w-full text-sm font-medium pl-11 pr-4 py-3 rounded-lg outline-none transition-all"
                       :class="darkMode ? 'bg-[#121212] text-gray-200 placeholder-gray-500 focus:ring-1 focus:ring-yellow-500' : 'bg-gray-50 text-gray-800 placeholder-gray-400 border border-gray-100 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400'">
            </div>
            <div class="flex items-center w-full md:w-auto">
                <select wire:model.live="filterStatus" class="w-full md:w-auto text-sm font-medium border rounded-lg px-4 py-3 outline-none transition-all cursor-pointer"
                        :class="darkMode ? 'bg-[#121212] border-transparent text-gray-300 focus:ring-1 focus:ring-yellow-500' : 'bg-gray-50 border-gray-100 text-gray-600 focus:border-yellow-400'">
                    <option value="all">Semua Status</option>
                    <option value="draft">Tugas Baru / Draf</option>
                    <option value="pending">Menunggu Review</option>
                    <option value="approved">Sudah Disetujui</option>
                </select>
            </div>
        </div>

        @php
            $revisiTasks = $daftarProyek->filter(fn($p) => strtolower($p->rab->status_rab ?? '') === 'revision')->values();
            $draftTasks = $daftarProyek->filter(fn($p) => in_array(strtolower($p->rab->status_rab ?? ''), ['draft', '']))->values();
            $otherTasks = $daftarProyek->filter(fn($p) => !in_array(strtolower($p->rab->status_rab ?? ''), ['revision', 'draft', '']))->values();
        @endphp

        <!-- ZONA MEJA KERJA -->
        @if($filterStatus === 'all')
            <div class="mb-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                    
                    <!-- KOLOM KIRI: REVISI -->
                    <div class="w-full space-y-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500">Proyek Revisi</h3>
                        </div>
                        
                        @if($revisiTasks->count() > 0)
                            @foreach($revisiTasks as $proyek)
                                <div class="rounded-xl p-5 shadow-sm border transition-all hover:shadow-md" :class="darkMode ? 'bg-[#1E1E1E] border-[#2A2A2A]' : 'bg-white border-gray-100'">
                                    <div>
                                        <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded bg-rose-50 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400">Revisi Direktur</span>
                                        <h3 class="font-bold text-lg mt-3 mb-1 truncate" :class="darkMode ? 'text-gray-100' : 'text-gray-900'">{{ $proyek->nama_pelanggan }}</h3>
                                        <p class="text-xs opacity-60 font-mono">REQ: {{ $proyek->request_no ?? '-' }}</p>
                                    </div>
                                    <div class="mt-5">
                                        <button wire:click="lihatDetail({{ $proyek->id }})" class="w-full py-2.5 text-xs font-bold rounded-lg transition-all text-center" 
                                                :class="darkMode ? 'bg-[#2A2A2A] text-gray-300 hover:bg-rose-600 hover:text-white' : 'bg-gray-100 text-gray-700 hover:bg-rose-50 hover:text-rose-600'">
                                            Perbaiki Dokumen
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="rounded-xl border border-dashed p-8 text-center" :class="darkMode ? 'border-[#2A2A2A] bg-[#1A1A1A]' : 'border-gray-200 bg-gray-50'">
                                <p class="text-sm font-medium text-gray-400">Tidak ada dokumen yang perlu direvisi.</p>
                            </div>
                        @endif
                    </div>

                    <!-- KOLOM KANAN: DRAF BARU -->
                    <div class="w-full space-y-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500">Buat RAB Baru</h3>
                        </div>

                        @if($draftTasks->count() > 0)
                            @foreach($draftTasks as $proyek)
                                <div class="rounded-xl p-5 shadow-sm border transition-all hover:shadow-md" :class="darkMode ? 'bg-[#1E1E1E] border-[#2A2A2A]' : 'bg-white border-gray-100'">
                                    <div>
                                        <span class="px-2.5 py-1 text-[10px] font-bold rounded uppercase border" :class="darkMode ? 'bg-[#2A2A2A] text-yellow-400 border-transparent' : 'bg-yellow-50 text-yellow-700 border-yellow-200'">
                                            {{ $proyek->rab ? 'Draft Tersimpan' : 'Belum Dibuat' }}
                                        </span>
                                        <h3 class="font-bold text-lg mt-3 mb-1 truncate" :class="darkMode ? 'text-gray-100' : 'text-gray-900'">{{ $proyek->nama_pelanggan }}</h3>
                                        <p class="text-xs opacity-50 font-mono">REQ: {{ $proyek->request_no ?? '-' }}</p>
                                    </div>
                                    <div class="mt-5">
                                        <button wire:click="lihatDetail({{ $proyek->id }})" class="w-full py-2.5 text-xs font-bold rounded-lg transition-all text-center" 
                                                :class="darkMode ? 'bg-yellow-500 text-gray-900 hover:bg-yellow-400' : 'bg-yellow-400 text-gray-900 hover:bg-yellow-500'">
                                            Kerjakan Proyek
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="rounded-xl border border-dashed p-8 text-center" :class="darkMode ? 'border-[#2A2A2A] bg-[#1A1A1A]' : 'border-gray-200 bg-gray-50'">
                                <p class="text-sm font-medium text-gray-400">Tidak ada request proyek baru dari Marketing.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- ZONA ARSIP / LAINNYA -->
        <div>
            @if($filterStatus === 'all' && ($revisiTasks->count() > 0 || $draftTasks->count() > 0))
                <div class="flex items-center gap-2 mb-4 mt-12 border-t pt-8" :class="darkMode ? 'border-[#2A2A2A]' : 'border-gray-200'">
                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500">Riwayat & Dokumen Selesai</h2>
                </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($filterStatus === 'all' ? $otherTasks : $daftarProyek as $proyek)
                    <div class="rounded-xl p-5 shadow-sm border transition-colors hover:shadow-md" :class="darkMode ? 'bg-[#1E1E1E] border-[#2A2A2A]' : 'bg-white border-gray-100'">
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-[10px] font-mono opacity-50">{{ $proyek->request_no ?? '-' }}</span>
                                <span class="px-2 py-0.5 text-[9px] font-bold rounded uppercase" 
                                      :class="strtolower($proyek->rab->status_rab ?? '') === 'approved' 
                                      ? (darkMode ? 'text-emerald-400 bg-emerald-900/20' : 'text-emerald-700 bg-emerald-50') 
                                      : (darkMode ? 'text-gray-400 bg-[#2A2A2A]' : 'text-gray-600 bg-gray-100')">
                                    {{ $proyek->rab->status_rab ?? 'DRAFT' }}
                                </span>
                            </div>
                            <h3 class="font-bold text-sm mb-1 truncate" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">{{ $proyek->nama_pelanggan }}</h3>
                        </div>
                        <div class="mt-4">
                            <button wire:click="lihatDetail({{ $proyek->id }})" class="text-xs font-medium hover:underline" :class="darkMode ? 'text-yellow-400' : 'text-yellow-600'">
                                Lihat Detail &rarr;
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full border border-dashed rounded-xl p-10 text-center" :class="darkMode ? 'bg-[#1A1A1A] border-[#2A2A2A]' : 'bg-gray-50 border-gray-200'">
                        <p class="text-sm text-gray-400 font-medium">Tidak ada data proyek yang sesuai kriteria pencarian.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>