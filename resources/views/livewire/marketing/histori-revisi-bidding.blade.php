<div class="min-h-screen p-4 md:p-8 font-sans bg-[#FAFAFA] text-[#1A1A1A]">
    
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #B4CDBF; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #4A7256; }
    </style>

    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header Card -->
        <div class="p-6 rounded-2xl shadow-xl border-2 border-[#E5E5E5] bg-white flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#4A7256] rounded-full blur-3xl opacity-10 -mr-10 -mt-10"></div>
            
            <div class="relative z-10 flex-grow">
                <span class="px-4 py-1.5 text-[10px] font-bold text-white bg-[#4A7256] rounded-lg uppercase tracking-wider border-2 border-[#4A7256]/50">
                    {{ $view === 'project-list' ? 'Dashboard Histori' : ($view === 'commit-list' ? 'Daftar Versi' : 'Detail Dokumen') }}
                </span>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight mt-4 text-[#1A1A1A]">
                    {{ $view === 'project-list' ? 'Audit Trail & Versioning Bidding' : ($selectedProject->nama_pelanggan ?? 'Detail Histori') }}
                </h1>
                <p class="text-xs mt-1 font-medium text-[#888888]">
                    {{ $view === 'project-list' ? 'Lacak rekam jejak, revisi, dan perubahan nilai penawaran setiap versi dokumen.' : 'Rekapitulasi perubahan pada dokumen bidding proyek terkait.' }}
                </p>
            </div>

            <div class="relative z-10 flex flex-col md:flex-row items-center gap-4 w-full md:w-auto">
                @if($view === 'project-list')
                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-[#4A7256]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="searchProyek" type="text" placeholder="Cari Proyek..."
                               class="w-full pl-11 pr-4 py-2.5 border-2 border-[#E5E5E5] bg-[#FAFAFA] focus:ring-2 focus:ring-[#4A7256]/30 focus:border-[#4A7256] rounded-xl text-sm font-bold outline-none transition-all text-[#1A1A1A]">
                    </div>
                @else
                    <button wire:click="goBack" 
                            class="group flex items-center gap-2 px-5 py-2.5 text-xs font-bold transition-all cursor-pointer w-full md:w-auto text-center rounded-xl border-2 border-[#E5E5E5] shadow-sm text-[#1A1A1A] hover:border-[#4A7256] hover:bg-[#4A7256]/10">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        KEMBALI
                    </button>
                @endif
            </div>
        </div>

        @if (session()->has('sukses'))
            <div class="p-4 rounded-xl font-semibold flex items-center gap-3 shadow-xl border-2 border-[#2A402B]/40 bg-[#4A7256]/15 text-[#2A402B] text-xs tracking-wide uppercase">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('sukses') }}</span>
            </div>
        @endif

        @if($view === 'project-list')
            <!-- Project Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($projects as $p)
                    @php
                        $biddingCurrent = \App\Models\Bidding::where('id_r_project', $p->id)->first();
                        $totalCommit = $biddingCurrent ? \App\Models\DocumentCommit::where('id_bidding', $biddingCurrent->id)->count() : 0;
                    @endphp
                    
                    <div wire:click="showCommits({{ $p->id }})" 
                         class="p-8 rounded-2xl border-2 border-[#E5E5E5] bg-white hover:border-[#4A7256] transition-all cursor-pointer group flex flex-col justify-between hover:-translate-y-0.5 hover:shadow-xl">
                        
                        <div>
                            <h3 class="text-lg font-black text-[#1A1A1A] group-hover:text-[#2A402B] transition-colors">
                                {{ $p->nama_pelanggan }}
                            </h3>
                            <p class="text-[10px] font-bold uppercase tracking-widest mt-1 font-mono text-[#888888]">
                                REF: {{ $p->request_no }}
                            </p>
                        </div>

                        <div class="mt-8 flex justify-between items-center border-t-2 border-[#E5E5E5] pt-4">
                            <div class="px-3 py-1 border-2 border-[#2A402B]/30 bg-[#FAFAFA] text-[#2A402B] text-[10px] font-bold rounded-lg uppercase">
                                {{ $totalCommit }} Versi Log
                            </div>
                            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase px-3 py-1.5 rounded-lg border-2
                                  {{ $biddingCurrent && $biddingCurrent->status_bidding === 'approved' ? 'bg-emerald-500/10 text-emerald-600 border-emerald-500/30' : 'bg-[#4A7256]/10 text-[#4A7256] border-[#4A7256]/30' }}">
                                <span class="w-2 h-2 rounded-full {{ $biddingCurrent && $biddingCurrent->status_bidding === 'approved' ? 'bg-emerald-500' : 'bg-[#4A7256]' }}"></span>
                                {{ $biddingCurrent ? ucfirst($biddingCurrent->status_bidding) : 'Draft' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-12 rounded-2xl border-2 border-[#E5E5E5] bg-white text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center bg-[#4A7256]/20">
                            <svg class="w-8 h-8 text-[#4A7256]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <p class="font-bold text-[#888888]">Belum ada proyek dengan histori Bidding yang cocok.</p>
                    </div>
                @endforelse
            </div>

        @elseif($view === 'commit-list')
            <!-- Commit List Header -->
            <div class="p-4 rounded-t-2xl border-x-2 border-t-2 border-[#E5E5E5] bg-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="text-xs font-bold uppercase tracking-widest pl-4 flex items-center gap-2 text-[#2A402B]">
                    <span class="w-2 h-2 rounded-full bg-[#2A402B]"></span> 
                    Log Commit: {{ $biddingData->no_penawaran ?? '-' }}
                </div>
                <div class="w-full md:w-80 relative pr-2">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-3.5 h-3.5 text-[#888888]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="searchCommit" type="text" placeholder="Cari catatan, pengomit..."
                           class="w-full pl-9 pr-4 py-2 border-2 border-[#E5E5E5] bg-[#FAFAFA] focus:ring-2 focus:ring-[#4A7256]/30 focus:border-[#4A7256] rounded-xl text-xs font-bold outline-none transition-all text-[#1A1A1A]">
                </div>
            </div>

            <!-- Commit Table -->
            <div class="rounded-b-2xl shadow-xl border-2 border-[#E5E5E5] bg-white overflow-x-auto">
                <table class="w-full text-left text-sm min-w-[700px]">
                    <thead class="text-[10px] uppercase font-bold tracking-widest border-y-2 border-[#E5E5E5] bg-[#FAFAFA] text-[#888888]">
                        <tr>
                            <th class="px-8 py-4">Versi</th>
                            <th class="px-8 py-4">Nama Editor</th>
                            <th class="px-8 py-4">Waktu Commit</th>
                            <th class="px-8 py-4 text-right">Total Penawaran (Rp)</th>
                            <th class="px-8 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-[#E5E5E5]">
                        @forelse($historiCommits as $index => $c)
                            @php $v = count($historiCommits) - $index; @endphp
                            <tr class="transition-all hover:bg-[#FAFAFA]">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-base text-[#2A402B]">v{{ $v }}</span>
                                        @if($index === 0 && empty($searchCommit))
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[8px] font-bold bg-emerald-500/10 text-emerald-600 rounded-lg uppercase border-2 border-emerald-500/30">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                LATEST
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-5 font-bold text-[#1A1A1A]">
                                    {{ $c->user_name ?? 'Sistem' }}
                                </td>
                                <td class="px-8 py-5 font-mono text-xs font-bold text-[#888888]">
                                    {{ \Carbon\Carbon::parse($c->created_at)->format('d M Y, H:i') }}
                                </td>
                                <td class="px-8 py-5 font-mono font-bold text-right text-[#1A1A1A]">
                                    Rp {{ number_format($c->total_penawaran ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <button wire:click="showDetail({{ $c->id }})" 
                                            class="inline-flex items-center gap-2 px-5 py-2 font-bold text-[10px] tracking-widest rounded-xl transition-all border-2 border-[#2A402B]/50 bg-white text-[#2A402B] shadow-sm hover:bg-[#4A7256] hover:text-white hover:border-[#4A7256] focus:outline-none focus:ring-4 focus:ring-[#4A7256]/30 hover:-translate-y-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        BONGKAR DATA
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center font-bold text-sm text-[#888888]">
                                    Tidak ada catatan commit yang sesuai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        @else
            <!-- Detail View -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <!-- Preview Panel (Scrollable) -->
                <div class="lg:col-span-2 rounded-2xl shadow-xl border-2 border-[#E5E5E5] bg-white h-[750px] flex flex-col overflow-hidden">
                    
                    <div class="flex justify-between items-center px-4 py-3 border-b-2 border-[#E5E5E5] bg-[#4A7256]">
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Preview Snapshot: {{ $biddingData->no_penawaran }}
                        </h4>
                        <span class="px-3 py-1 text-[10px] font-bold rounded-lg border-2 bg-white text-[#1A1A1A] border-[#4A7256]">
                            VERSI: {{ \Carbon\Carbon::parse($selectedCommit->created_at)->format('d M Y') }}
                        </span>
                    </div>

                    <!-- Container Scroll -->
                    <div class="flex-grow overflow-auto custom-scrollbar relative bg-[#FAFAFA]">
                        
                        <div class="p-6 min-h-full">
                            @include('components.dokumen-bidding', [
                                'proyek' => $selectedProject,
                                'bidding' => $biddingData,
                                'rabAktif' => $selectedProject->rabs->first()
                            ])
                        </div>

                    </div>
                </div>

                <!-- Info Panel -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Bidding Info Card -->
                    <div class="p-6 rounded-2xl shadow-xl border-2 border-[#E5E5E5] bg-white space-y-5">
                        
                        <h2 class="text-[10px] font-bold uppercase tracking-widest border-b-2 border-[#E5E5E5] pb-2 text-[#2A402B]">
                            Informasi Nilai Penawaran
                        </h2>
                        
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#888888]">Perusahaan / Instansi</p>
                                <p class="text-sm font-bold mt-1 text-[#1A1A1A]">
                                    {{ $selectedProject->nama_pelanggan }}
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#888888]">No. Penawaran</p>
                                <p class="font-mono text-sm font-bold mt-1 text-[#2A402B]">
                                    {{ $biddingData->no_penawaran }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#888888]">Tanggal Penawaran</p>
                                <p class="font-mono text-sm font-bold mt-1 text-[#1A1A1A]">
                                    {{ \Carbon\Carbon::parse($biddingData->tgl_penawaran)->format('d M Y') }}
                                </p>
                            </div>
                            
                            <div class="p-4 rounded-xl border-2 border-[#2A402B]/30 bg-[#4A7256]/10">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#2A402B]">
                                    Nilai Penawaran (Versi Ini)
                                </p>
                                <p class="text-xl font-black font-mono mt-1 text-[#1A1A1A]">
                                    Rp {{ number_format($selectedCommit->total_penawaran ?? 0, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="p-4 rounded-xl border-2 border-[#B4CDBF]/30 bg-[#B4CDBF]/10">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#648B73]">
                                    Harga Dasar
                                </p>
                                <p class="text-lg font-black font-mono mt-1 text-[#1A1A1A]">
                                    Rp {{ number_format($biddingData->harga_dasar ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Editor Info Card -->
                    <div class="p-6 rounded-2xl border-2 border-[#E5E5E5] bg-[#FAFAFA] space-y-4">
                        
                        <h2 class="text-[10px] font-bold uppercase tracking-widest border-b-2 border-[#E5E5E5] pb-2 text-[#2A402B]">
                            Jejak Otentikasi Editor
                        </h2>
                        
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#888888]">Disubmit Oleh:</p>
                            <div class="flex items-center gap-3 mt-2">
                                <div class="w-8 h-8 rounded-lg bg-[#4A7256] text-white flex items-center justify-center text-xs font-black">
                                    {{ strtoupper(substr($selectedCommit->user_name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-[#1A1A1A]">
                                        {{ $selectedCommit->user_name ?? 'Sistem Automation' }}
                                    </p>
                                    <p class="text-[9px] font-mono font-bold text-[#888888]">
                                        {{ \Carbon\Carbon::parse($selectedCommit->created_at)->format('H:i:s, d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#888888]">Catatan Revisi / Commit:</p>
                            <div class="text-xs font-medium p-4 rounded-xl border-2 border-[#E5E5E5] bg-white mt-2 whitespace-pre-wrap leading-relaxed text-[#1A1A1A]">
                                "{{ $selectedCommit->komentar_commit ?? 'Tidak ada catatan.' }}"
                            </div>
                        </div>
                    </div>

                    <!-- Print Button Only -->
                    <button onclick="window.print()" 
                            class="block w-full text-center py-4 bg-[#4A7256] hover:bg-[#354F37] text-white font-bold text-[11px] uppercase tracking-wider rounded-xl shadow-lg hover:shadow-xl hover:shadow-[#4A7256]/30 transition-all cursor-pointer hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-[#4A7256]/30">
                        🖨️ CETAK DOKUMEN PDF (LANGSUNG)
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>