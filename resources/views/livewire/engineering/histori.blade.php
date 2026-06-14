<div class="min-h-screen p-4 md:p-8 font-sans transition-colors duration-300"
     x-data="{ darkMode: false }"
     :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5]' : 'bg-[#FAFAFA] text-[#1A1A1A]'">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header Card -->
        <div class="p-6 rounded-2xl shadow-xl border-2 flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden transition-colors"
             :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#F5C518] rounded-full blur-3xl opacity-10 -mr-10 -mt-10"></div>
            
            <div class="relative z-10 flex-grow">
                <span class="px-4 py-1.5 text-[10px] font-bold text-[#1A1A1A] bg-[#F5C518] rounded-lg uppercase tracking-wider border-2 border-[#F5C518]/50">
                    {{ $view === 'project-list' ? 'Dashboard Histori' : ($view === 'commit-list' ? 'Daftar Versi' : 'Detail Dokumen') }}
                </span>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight mt-4"
                    :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">
                    {{ $view === 'project-list' ? 'Audit Trail & Versioning RAB' : ($selectedProject->nama_pelanggan ?? 'Detail Histori') }}
                </h1>
                <p class="text-xs mt-1 font-medium text-[#888888]">
                    {{ $view === 'project-list' ? 'Lacak rekam jejak, revisi, dan perubahan nilai setiap versi dokumen.' : 'Rekapitulasi perubahan pada dokumen proyek terkait.' }}
                </p>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-4 w-full md:w-auto">
                <div class="flex items-center gap-1 p-1 rounded-lg border-2 shadow-sm transition-colors w-full md:w-auto justify-center" 
                     :class="darkMode ? 'bg-[#1A1A1A] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                    <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-[#F5C518] text-[#1A1A1A] font-bold shadow-md' : 'text-[#888888] hover:text-[#F5C518]'" class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all uppercase tracking-wider">💡 Terang</button>
                    <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-[#F5C518] text-[#1A1A1A] font-bold shadow-md' : 'text-[#888888] hover:text-[#F5C518]'" class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all uppercase tracking-wider">🕶️ Gelap</button>
                </div>

                @if($view === 'project-list')
                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-[#F5C518]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input wire:model.live.debounce.300ms="searchProyek" type="text" placeholder="Cari Proyek..." 
                               class="w-full pl-11 pr-4 py-2.5 border-2 focus:ring-2 focus:ring-[#F5C518]/30 focus:border-[#F5C518] rounded-xl text-sm font-bold outline-none transition-all"
                               :class="darkMode ? 'bg-[#1A1A1A] border-[#2A2A2A] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'">
                    </div>
                @else
                    <button wire:click="goBack" class="group flex items-center gap-2 px-5 py-2.5 text-xs font-bold transition-all cursor-pointer w-full md:w-auto text-center rounded-xl border-2 shadow-sm"
                            :class="darkMode ? 'text-[#F5C518] border-[#F5C518]/30 hover:bg-[#F5C518]/10 hover:border-[#F5C518]' : 'text-[#1A1A1A] border-[#E5E5E5] hover:border-[#F5C518] hover:bg-[#F5C518]/10'">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        KEMBALI
                    </button>
                @endif
            </div>
        </div>

        @if (session()->has('sukses')) 
            <div class="p-4 rounded-xl font-semibold flex items-center gap-3 shadow-xl border-2 text-xs tracking-wide uppercase"
                 :class="darkMode ? 'bg-[#F5C518]/10 border-[#F5C518]/40 text-[#F5C518]' : 'bg-[#F5C518]/15 border-[#9A7B0A]/40 text-[#8B6914]'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('sukses') }}</span>
            </div>
        @endif

        @if($view === 'project-list')
            <!-- Project Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($projects as $p)
                    @php
                        $rabCurrent = \App\Models\Rab::where('id_r_project', $p->id)->first();
                        $totalCommit = $rabCurrent ? \App\Models\DocumentCommit::where('id_rab', $rabCurrent->id)->count() : 0;
                    @endphp
                    <div wire:click="showCommits({{ $p->id }})" class="p-8 rounded-2xl border-2 hover:border-[#F5C518] transition-all cursor-pointer group flex flex-col justify-between hover:-translate-y-0.5"
                         :class="darkMode ? 'bg-[#111111] border-[#2A2A2A] hover:shadow-[0_4px_20px_rgb(245,197,24,0.1)]' : 'bg-white border-[#E5E5E5] hover:shadow-xl'">
                        <div>
                            <h3 class="text-lg font-black transition-colors" :class="darkMode ? 'text-[#F5F5F5] group-hover:text-[#F5C518]' : 'text-[#1A1A1A] group-hover:text-[#9A7B0A]'">{{ $p->nama_pelanggan }}</h3>
                            <p class="text-[10px] font-bold uppercase tracking-widest mt-1 font-mono text-[#888888]">REF: {{ $p->request_no }}</p>
                        </div>
                        <div class="mt-8 flex justify-between items-center border-t-2 pt-4 transition-colors" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
                            <div class="px-3 py-1 border-2 w-fit text-[10px] font-bold rounded-lg uppercase transition-colors"
                                 :class="darkMode ? 'bg-[#1A1A1A] text-[#F5C518] border-[#F5C518]/30' : 'bg-[#FAFAFA] text-[#8B6914] border-[#9A7B0A]/30'">
                                {{ $totalCommit }} Versi Log
                            </div>
                            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase px-3 py-1.5 rounded-lg border-2"
                                  :class="$rabCurrent && $rabCurrent->status_rab === 'APPROVED' ? 'bg-emerald-500/10 text-emerald-600 border-emerald-500/30' : 'bg-[#F5C518]/10 text-[#8B6914] border-[#9A7B0A]/30'">
                                <span class="w-2 h-2 rounded-full" :class="$rabCurrent && $rabCurrent->status_rab === 'APPROVED' ? 'bg-emerald-500' : 'bg-[#9A7B0A]'"></span>
                                {{ $rabCurrent ? $rabCurrent->status_rab : 'Draft' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-12 rounded-2xl border-2 text-center transition-colors"
                         :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center bg-[#F5C518]/20">
                            <svg class="w-8 h-8 text-[#9A7B0A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="font-bold text-[#888888]">Belum ada proyek dengan histori RAB yang cocok.</p>
                    </div>
                @endforelse
            </div>

        @elseif($view === 'commit-list')
            <!-- Commit List Header -->
            <div class="p-4 rounded-t-2xl border-x-2 border-t-2 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 transition-colors"
                 :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                <div class="text-xs font-bold uppercase tracking-widest pl-4 flex items-center gap-2" :class="darkMode ? 'text-[#F5C518]' : 'text-[#9A7B0A]'">
                    <span class="w-2 h-2 rounded-full" :class="darkMode ? 'bg-[#F5C518]' : 'bg-[#9A7B0A]'"></span> Log Commit: {{ $rabData->no_boq ?? '-' }}
                </div>
                <div class="w-full md:w-80 relative pr-2">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-3.5 h-3.5 text-[#888888]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input wire:model.live.debounce.300ms="searchCommit" type="text" placeholder="Cari catatan, pengomit..." 
                           class="w-full pl-9 pr-4 py-2 border-2 focus:ring-2 focus:ring-[#F5C518]/30 focus:border-[#F5C518] rounded-xl text-xs font-bold outline-none transition-all"
                           :class="darkMode ? 'bg-[#1A1A1A] border-[#2A2A2A] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'">
                </div>
            </div>
            
            <!-- Commit Table -->
            <div class="rounded-b-2xl shadow-xl border-2 overflow-x-auto transition-colors"
                 :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                <table class="w-full text-left text-sm min-w-[700px]">
                    <thead class="text-[10px] uppercase font-bold tracking-widest border-y-2 transition-colors"
                           :class="darkMode ? 'bg-[#1A1A1A] text-[#888888] border-[#2A2A2A]' : 'bg-[#FAFAFA] text-[#888888] border-[#E5E5E5]'">
                        <tr>
                            <th class="px-8 py-4">Versi</th>
                            <th class="px-8 py-4">Nama Editor</th>
                            <th class="px-8 py-4">Waktu Commit</th>
                            <th class="px-8 py-4 text-right">Grand Total (Rp)</th>
                            <th class="px-8 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 transition-colors" :class="darkMode ? 'divide-[#2A2A2A]' : 'divide-[#E5E5E5]'">
                        @forelse($historiCommits as $index => $c)
                            @php $v = count($historiCommits) - $index; @endphp
                            <tr class="transition-all" :class="darkMode ? 'hover:bg-[#1A1A1A]/50' : 'hover:bg-[#FAFAFA]'">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-base" :class="darkMode ? 'text-[#F5C518]' : 'text-[#9A7B0A]'">v{{ $v }}</span>
                                        @if($index === 0 && empty($searchCommit))
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[8px] font-bold bg-emerald-500/10 text-emerald-600 rounded-lg uppercase border-2 border-emerald-500/30">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                LATEST
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-5 font-bold" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">{{ $c->user_name ?? 'Sistem' }}</td>
                                <td class="px-8 py-5 font-mono text-xs font-bold text-[#888888]">{{ \Carbon\Carbon::parse($c->created_at)->format('d M Y, H:i') }}</td>
                                <td class="px-8 py-5 font-mono font-bold text-right" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">Rp {{ number_format($c->total_nilai, 0, ',', '.') }}</td>
                                <td class="px-8 py-5 text-center">
                                    <button wire:click="showDetail({{ $c->id }})" class="inline-flex items-center gap-2 px-5 py-2 font-bold text-[10px] tracking-widest rounded-xl transition-all border-2 shadow-sm focus:outline-none focus:ring-4 focus:ring-[#F5C518]/30 hover:-translate-y-0.5"
                                            :class="darkMode ? 'bg-[#1A1A1A] hover:bg-[#F5C518] text-[#F5C518] hover:text-[#1A1A1A] border-[#F5C518]/50' : 'bg-white hover:bg-[#F5C518] text-[#9A7B0A] hover:text-[#1A1A1A] border-[#9A7B0A]/50'">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
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
                
                <!-- Preview Panel -->
                <div class="lg:col-span-2 rounded-2xl shadow-xl border-2 h-[750px] flex flex-col transition-colors overflow-hidden"
                     :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                    <div class="flex justify-between items-center px-4 py-3 border-b-2 transition-colors" :class="darkMode ? 'border-[#2A2A2A] bg-[#F5C518]' : 'border-[#E5E5E5] bg-[#F5C518]'">
                        <h4 class="text-xs font-bold text-[#1A1A1A] uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Preview Snapshot: {{ $rabData->no_boq }}
                        </h4>
                        <span class="px-3 py-1 text-[10px] font-bold rounded-lg border-2 bg-white text-[#1A1A1A] border-[#F5C518]">
                            VERSI: {{ \Carbon\Carbon::parse($selectedCommit->created_at)->format('d M Y') }}
                        </span>
                    </div>
                    
                    <div class="flex-grow overflow-hidden border-t-0 flex flex-col items-center justify-center relative transition-colors"
                         :class="darkMode ? 'bg-[#0A0A0A]' : 'bg-[#FAFAFA]'">
                       <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-20 z-0">
                            <span class="font-black text-2xl uppercase tracking-widest" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">MENGURAI DATA SNAPSHOT...</span>
                        </div>
                        
                        <iframe id="iframe-cetak-pdf" src="{{ route('engineering.cetak.versi', $selectedCommit->id) }}#toolbar=0&navpanes=0" class="w-full h-full border-none relative z-10 bg-white shadow-inner"></iframe>
                    </div>
                </div>
                
                <!-- Info Panel -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- RAB Info Card -->
                    <div class="p-6 rounded-2xl shadow-xl border-2 space-y-5 transition-colors"
                         :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                        <h2 class="text-[10px] font-bold uppercase tracking-widest border-b-2 pb-2 transition-colors" :class="darkMode ? 'text-[#F5C518] border-[#2A2A2A]' : 'text-[#9A7B0A] border-[#E5E5E5]'">Informasi Nilai RAB</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#888888]">Perusahaan / Instansi</p>
                                <p class="text-sm font-bold mt-1" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">{{ $selectedProject->nama_pelanggan }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#888888]">No. Dokumen (BOQ)</p>
                                <p class="font-mono text-sm font-bold mt-1" :class="darkMode ? 'text-[#F5C518]' : 'text-[#9A7B0A]'">{{ $rabData->no_boq }}</p>
                            </div>
                            <div class="p-4 rounded-xl border-2 transition-colors"
                                 :class="darkMode ? 'border-[#F5C518]/50 bg-[#F5C518]/5' : 'border-[#9A7B0A]/30 bg-[#F5C518]/10'">
                                <p class="text-[10px] font-bold uppercase tracking-wider" :class="darkMode ? 'text-[#F5C518]' : 'text-[#8B6914]'">Nilai Terkalkulasi (Versi Ini)</p>
                                <p class="text-xl font-black font-mono mt-1" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">Rp {{ number_format($selectedCommit->total_nilai, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Editor Info Card -->
                    <div class="p-6 rounded-2xl border-2 space-y-4 transition-colors"
                         :class="darkMode ? 'bg-[#1A1A1A] border-[#2A2A2A]' : 'bg-[#FAFAFA] border-[#E5E5E5]'">
                        <h2 class="text-[10px] font-bold uppercase tracking-widest border-b-2 pb-2 transition-colors" :class="darkMode ? 'text-[#F5C518] border-[#2A2A2A]' : 'text-[#9A7B0A] border-[#E5E5E5]'">Jejak Otentikasi Editor</h2>
                        
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#888888]">Disubmit Oleh:</p>
                            <div class="flex items-center gap-3 mt-2">
                                <div class="w-8 h-8 rounded-lg bg-[#F5C518] text-[#1A1A1A] flex items-center justify-center text-xs font-black">
                                    {{ strtoupper(substr($selectedCommit->user_name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">{{ $selectedCommit->user_name ?? 'Sistem Automation' }}</p>
                                    <p class="text-[9px] font-mono font-bold text-[#888888]">{{ \Carbon\Carbon::parse($selectedCommit->created_at)->format('H:i:s, d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-2">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#888888]">Catatan Revisi / Commit:</p>
                            <div class="text-xs font-medium p-4 rounded-xl border-2 mt-2 whitespace-pre-wrap leading-relaxed transition-colors"
                                 :class="darkMode ? 'bg-[#111111] border-[#2A2A2A] text-[#F5F5F5]' : 'bg-white border-[#E5E5E5] text-[#1A1A1A]'">"{{ $selectedCommit->komentar_commit ?? 'Tidak ada catatan.' }}"</div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <button onclick="document.getElementById('iframe-cetak-pdf').contentWindow.print()" class="block w-full text-center py-4 bg-[#F5C518] hover:bg-[#FFD700] text-[#1A1A1A] font-bold text-[11px] uppercase tracking-wider rounded-xl shadow-lg hover:shadow-xl hover:shadow-[#F5C518]/30 transition-all cursor-pointer hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-[#F5C518]/30">
                        🖨️ CETAK DOKUMEN PDF (LANGSUNG)
                    </button>
                    
                    <a href="{{ route('engineering.export.excel', $selectedCommit->id) }}" class="block w-full text-center py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-[11px] uppercase tracking-wider rounded-xl shadow-lg hover:shadow-xl hover:shadow-emerald-500/30 transition-all cursor-pointer hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-emerald-500/30">
                        📊 EXPORT KE EXCEL (.XLS)
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>