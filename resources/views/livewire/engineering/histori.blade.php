<div class="min-h-screen p-4 md:p-8 font-sans transition-colors duration-500"
     x-data="{ darkMode: true }"
     :class="darkMode ? 'bg-[#1E1D1B] text-[#E4E4E4]' : 'bg-[#FAFCFF] text-[#5E6175]'">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <div class="p-6 rounded-[2rem] shadow-sm border flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden transition-colors"
             :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/60'">
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#D9B35A] rounded-full blur-3xl opacity-10 -mr-10 -mt-10"></div>
            
            <div class="relative z-10 flex-grow">
                <span class="px-4 py-1.5 text-[10px] font-extrabold text-[#1E1D1B] bg-[#D9B35A] rounded-full uppercase tracking-widest border border-[#D9B35A]/50">
                    {{ $view === 'project-list' ? 'Dashboard Histori' : ($view === 'commit-list' ? 'Daftar Versi' : 'Detail Dokumen') }}
                </span>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight mt-4 transition-colors"
                    :class="darkMode ? 'text-white' : 'text-slate-800'">
                    {{ $view === 'project-list' ? 'Audit Trail & Versioning RAB' : ($selectedProject->nama_pelanggan ?? 'Detail Histori') }}
                </h1>
                <p class="text-xs mt-1 font-medium transition-colors"
                   :class="darkMode ? 'text-slate-400' : 'text-slate-500'">
                    {{ $view === 'project-list' ? 'Lacak rekam jejak, revisi, dan perubahan nilai setiap versi dokumen.' : 'Rekapitulasi perubahan pada dokumen proyek terkait.' }}
                </p>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-4 w-full md:w-auto">
                <div class="flex items-center gap-2 p-1.5 rounded-xl border transition-colors w-full md:w-auto justify-center" 
                     :class="darkMode ? 'bg-[#1E1D1B]/50 border-[#D9B35A]/30' : 'bg-slate-100 border-slate-200'">
                    <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-white shadow text-slate-900 font-bold' : 'text-slate-400'" class="px-3 py-1.5 text-xs rounded-lg uppercase transition-all">💡 Terang</button>
                    <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-[#1E1D1B] text-[#D9B35A] shadow font-bold' : 'text-slate-500'" class="px-3 py-1.5 text-xs rounded-lg uppercase transition-all">🕶️ Gelap</button>
                </div>

                @if($view === 'project-list')
                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-[#D9B35A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input wire:model.live.debounce.300ms="searchProyek" type="text" placeholder="Cari Proyek..." 
                               class="w-full pl-11 pr-4 py-2.5 border focus:ring-1 focus:ring-[#D9B35A] rounded-xl text-sm font-bold outline-none transition-all"
                               :class="darkMode ? 'bg-[#1E1D1B] border-transparent focus:border-[#D9B35A] text-white' : 'bg-white border-slate-200 focus:border-[#D9B35A] text-slate-800'">
                    </div>
                @else
                    <button wire:click="goBack" class="px-5 py-2.5 text-xs font-bold transition-colors cursor-pointer w-full md:w-auto text-center rounded-xl border"
                            :class="darkMode ? 'text-slate-400 hover:text-[#D9B35A] border-transparent hover:border-[#D9B35A]/30' : 'text-slate-500 hover:text-[#D9B35A] border-slate-200 bg-white hover:border-[#D9B35A]'">
                        ← KEMBALI
                    </button>
                @endif
            </div>
        </div>

        @if (session()->has('sukses')) 
            <div class="px-5 py-3 rounded-2xl text-xs font-bold border shadow-sm animate-fade-in"
                 :class="darkMode ? 'bg-[#4A3F2A] text-[#E2C275] border-[#E2C275]/30' : 'bg-amber-50 text-amber-600 border-amber-200'">
                {{ session('sukses') }}
            </div> 
        @endif

        @if($view === 'project-list')
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($projects as $p)
                    @php
                        $rabCurrent = \App\Models\Rab::where('id_r_project', $p->id)->first();
                        $totalCommit = $rabCurrent ? \App\Models\DocumentCommit::where('id_rab', $rabCurrent->id)->count() : 0;
                    @endphp
                    <div wire:click="showCommits({{ $p->id }})" class="p-8 rounded-[2rem] border hover:border-[#D9B35A] transition-all cursor-pointer group flex flex-col justify-between"
                         :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36] hover:shadow-[0_4px_20px_rgb(217,179,90,0.1)]' : 'bg-white border-[#C7D9F1]/60 hover:shadow-lg'">
                        <div>
                            <h3 class="text-lg font-black transition-colors" :class="darkMode ? 'text-white group-hover:text-[#D9B35A]' : 'text-slate-800 group-hover:text-[#D9B35A]'">{{ $p->nama_pelanggan }}</h3>
                            <p class="text-[10px] font-bold uppercase tracking-widest mt-1 font-mono transition-colors" :class="darkMode ? 'text-slate-500' : 'text-slate-400'">REF: {{ $p->request_no }}</p>
                        </div>
                        <div class="mt-8 flex justify-between items-center border-t pt-4 transition-colors" :class="darkMode ? 'border-[#3D3A36]' : 'border-slate-100'">
                            <div class="px-3 py-1 border w-fit text-[10px] font-black rounded-lg uppercase transition-colors"
                                 :class="darkMode ? 'bg-[#1E1D1B] text-[#D9B35A] border-[#D9B35A]/30' : 'bg-slate-50 text-[#D9B35A] border-[#D9B35A]/30'">
                                {{ $totalCommit }} Versi Log
                            </div>
                            <span class="text-[10px] font-extrabold uppercase {{ $rabCurrent && $rabCurrent->status_rab === 'APPROVED' ? 'text-emerald-500' : 'text-amber-500' }}">
                                {{ $rabCurrent ? $rabCurrent->status_rab : 'Draft' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-12 rounded-3xl border text-center transition-colors"
                         :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/60'">
                        <p class="font-bold text-slate-500">Belum ada proyek dengan histori RAB yang cocok.</p>
                    </div>
                @endforelse
            </div>

        @elseif($view === 'commit-list')
            <div class="p-4 rounded-t-[2rem] border-x border-t flex flex-col md:flex-row justify-between items-start md:items-center gap-4 transition-colors"
                 :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/60'">
                <div class="text-xs font-black uppercase text-[#D9B35A] tracking-widest pl-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#D9B35A]"></span> Log Commit: {{ $rabData->no_boq ?? '-' }}
                </div>
                <div class="w-full md:w-80 relative pr-2">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input wire:model.live.debounce.300ms="searchCommit" type="text" placeholder="Cari catatan, pengomit..." 
                           class="w-full pl-9 pr-4 py-2 border focus:ring-1 focus:ring-[#D9B35A] rounded-xl text-xs font-bold outline-none transition-all"
                           :class="darkMode ? 'bg-[#1E1D1B] border-[#3D3A36] focus:border-[#D9B35A] text-white' : 'bg-slate-50 border-slate-200 focus:border-[#D9B35A] text-slate-800'">
                </div>
            </div>
            
            <div class="rounded-b-[2rem] shadow-sm border overflow-x-auto transition-colors"
                 :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/60'">
                <table class="w-full text-left text-sm min-w-[700px]">
                    <thead class="text-[10px] uppercase font-black tracking-widest border-y transition-colors"
                           :class="darkMode ? 'bg-[#1E1D1B] text-slate-400 border-[#3D3A36]' : 'bg-slate-50 text-slate-500 border-slate-200'">
                        <tr>
                            <th class="px-8 py-4">Versi</th>
                            <th class="px-8 py-4">Nama Editor</th>
                            <th class="px-8 py-4">Waktu Commit</th>
                            <th class="px-8 py-4 text-right">Grand Total (Rp)</th>
                            <th class="px-8 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y transition-colors" :class="darkMode ? 'divide-[#3D3A36]' : 'divide-slate-100'">
                        @forelse($historiCommits as $index => $c)
                            @php $v = count($historiCommits) - $index; @endphp
                            <tr class="transition-all" :class="darkMode ? 'hover:bg-[#1E1D1B]/50' : 'hover:bg-slate-50'">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-[#D9B35A] text-base">v{{ $v }}</span>
                                        @if($index === 0 && empty($searchCommit))
                                            <span class="px-2 py-0.5 text-[8px] font-black bg-emerald-500/20 text-emerald-600 rounded uppercase border border-emerald-500/30">LATEST</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-5 font-bold transition-colors" :class="darkMode ? 'text-slate-300' : 'text-slate-700'">{{ $c->user_name ?? 'Sistem' }}</td>
                                <td class="px-8 py-5 font-mono text-xs font-bold transition-colors" :class="darkMode ? 'text-slate-500' : 'text-slate-500'">{{ \Carbon\Carbon::parse($c->created_at)->format('d M Y, H:i') }}</td>
                                <td class="px-8 py-5 font-mono font-bold text-right transition-colors" :class="darkMode ? 'text-white' : 'text-slate-800'">Rp {{ number_format($c->total_nilai, 0, ',', '.') }}</td>
                                <td class="px-8 py-5 text-center">
                                    <button wire:click="showDetail({{ $c->id }})" class="px-5 py-2 font-black text-[10px] tracking-widest rounded-xl transition-all border"
                                            :class="darkMode ? 'bg-[#1E1D1B] hover:bg-[#3D3A36] text-[#D9B35A] border-[#3D3A36]' : 'bg-white hover:bg-slate-50 text-[#D9B35A] border-[#D9B35A]/50 shadow-sm'">
                                        BONGKAR DATA
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center font-bold text-sm" :class="darkMode ? 'text-slate-500' : 'text-slate-400'">
                                    Tidak ada catatan commit yang sesuai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <div class="lg:col-span-2 p-4 rounded-[2rem] shadow-sm border h-[750px] flex flex-col transition-colors"
                     :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/60'">
                    <div class="flex justify-between items-center px-4 py-3 border-b mb-4 transition-colors" :class="darkMode ? 'border-[#3D3A36]' : 'border-slate-100'">
                        <h4 class="text-xs font-black text-[#D9B35A] uppercase tracking-widest">Preview PDF: {{ $rabData->no_boq }}</h4>
                        <span class="px-3 py-1 text-[10px] font-black rounded-lg border transition-colors"
                              :class="darkMode ? 'bg-[#1E1D1B] text-slate-300 border-[#3D3A36]' : 'bg-slate-50 text-slate-600 border-slate-200'">
                            VERSI DOKUMEN: {{ \Carbon\Carbon::parse($selectedCommit->created_at)->format('d M Y') }}
                        </span>
                    </div>
                    <div class="flex-grow rounded-2xl overflow-hidden border flex flex-col items-center justify-center relative transition-colors"
                         :class="darkMode ? 'bg-[#1E1D1B] border-[#3D3A36]' : 'bg-slate-100 border-slate-200'">
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-20">
                            <span class="font-black text-2xl uppercase tracking-widest" :class="darkMode ? 'text-white' : 'text-slate-800'">MEMUAT PREVIEW PDF...</span>
                        </div>
                        
                        <iframe src="{{ route('cetak.rab', $selectedCommit->id) }}#toolbar=0&navpanes=0" class="w-full h-full border-none relative z-10 bg-white"></iframe>
                    </div>
                </div>
                
                <div class="lg:col-span-1 space-y-6">
                    <div class="p-8 rounded-[2rem] shadow-sm border space-y-6 transition-colors"
                         :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/60'">
                        <h2 class="text-[10px] font-black uppercase tracking-widest text-[#D9B35A] border-b pb-2 transition-colors" :class="darkMode ? 'border-[#3D3A36]' : 'border-slate-100'">Informasi Nilai RAB</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[9px] font-bold uppercase transition-colors" :class="darkMode ? 'text-slate-500' : 'text-slate-400'">Perusahaan / Instansi</p>
                                <p class="text-sm font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-slate-800'">{{ $selectedProject->nama_pelanggan }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold uppercase transition-colors" :class="darkMode ? 'text-slate-500' : 'text-slate-400'">No. Dokumen (BOQ)</p>
                                <p class="font-mono text-sm font-bold text-[#D9B35A]">{{ $rabData->no_boq }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold uppercase transition-colors" :class="darkMode ? 'text-slate-500' : 'text-slate-400'">Nilai Terkalkulasi (Versi Ini)</p>
                                <p class="text-lg font-black font-mono transition-colors" :class="darkMode ? 'text-white' : 'text-slate-800'">Rp {{ number_format($selectedCommit->total_nilai, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8 rounded-[2rem] border space-y-4 transition-colors"
                         :class="darkMode ? 'bg-[#1E1D1B] border-[#3D3A36]' : 'bg-slate-50 border-[#C7D9F1]/60'">
                        <h2 class="text-[10px] font-black uppercase tracking-widest text-[#D9B35A] border-b pb-2 transition-colors" :class="darkMode ? 'border-[#3D3A36]' : 'border-slate-200'">Jejak Otentikasi Editor</h2>
                        
                        <div>
                            <p class="text-[9px] font-bold uppercase transition-colors" :class="darkMode ? 'text-slate-500' : 'text-slate-400'">Disubmit Oleh:</p>
                            <div class="flex items-center gap-3 mt-2">
                                <div class="w-8 h-8 rounded-full bg-[#D9B35A] text-[#1E1D1B] flex items-center justify-center text-xs font-black">
                                    {{ strtoupper(substr($selectedCommit->user_name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black transition-colors" :class="darkMode ? 'text-white' : 'text-slate-800'">{{ $selectedCommit->user_name ?? 'Sistem Automation' }}</p>
                                    <p class="text-[9px] font-mono font-bold transition-colors" :class="darkMode ? 'text-slate-500' : 'text-slate-400'">{{ \Carbon\Carbon::parse($selectedCommit->created_at)->format('H:i:s, d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-2">
                            <p class="text-[9px] font-bold uppercase transition-colors" :class="darkMode ? 'text-slate-500' : 'text-slate-400'">Catatan Revisi / Commit:</p>
                            <div class="text-xs font-medium p-4 rounded-xl border mt-2 whitespace-pre-wrap leading-relaxed transition-colors"
                                 :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36] text-slate-300' : 'bg-white border-slate-200 text-slate-600'">"{{ $selectedCommit->komentar_commit ?? 'Tidak ada catatan.' }}"</div>
                        </div>
                    </div>
                    
                    <a href="{{ route('cetak.rab', $selectedCommit->id) }}" target="_blank" class="block w-full text-center py-4 bg-[#D9B35A] hover:bg-[#CFA751] text-[#1E1D1B] font-black text-[11px] uppercase tracking-widest rounded-2xl shadow-lg transition-all cursor-pointer">
                        CETAK DOKUMEN PDF
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>