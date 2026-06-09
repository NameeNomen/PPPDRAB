<div class="min-h-screen font-sans transition-colors duration-300" 
     x-data="{ darkMode: true }" 
     :class="darkMode ? 'bg-[#1A0D05] text-[#FDECE2]' : 'bg-[#FCF6F0] text-[#5C2C00]'">

    @if (session()->has('sukses'))
        <div class="max-w-5xl mx-auto pt-8 px-4 md:px-8">
            <div class="p-4 rounded-xl font-bold flex items-center gap-3 shadow-md border animate-fade-in text-xs uppercase tracking-widest"
                 :class="darkMode ? 'bg-[#261308] border-[#FF7A00] text-[#FFC107]' : 'bg-white border-[#E65C00] text-[#E65C00]'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('sukses') }}</span>
            </div>
        </div>
    @endif

    <div class="max-w-5xl mx-auto p-4 md:p-8">
        <div class="flex justify-between items-center mb-6">
            <button wire:click="kembaliKeList" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest px-5 py-3 rounded-xl border transition-all shadow-sm"
                    :class="darkMode ? 'bg-[#261308] border-[#331A0A] text-[#FFC107] hover:bg-[#0D0602]' : 'bg-white border-[#E65C00]/20 text-[#E65C00] hover:bg-[#FCF6F0]'">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                KEMBALI KE BOARD
            </button>

            <div class="flex items-center gap-1 p-1 rounded-xl shadow-inner border transition-colors" :class="darkMode ? 'bg-[#0D0602] border-[#331A0A]' : 'bg-[#F2E5D9] border-[#E65C00]/20'">
                <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-white shadow text-[#E65C00] font-black' : 'text-[#5C2C00]/50'" class="px-3 py-1.5 text-[9px] rounded-lg transition-all uppercase tracking-widest">Terang</button>
                <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-[#261308] text-[#FFC107] shadow border border-[#FF7A00]/30 font-black' : 'text-[#FDECE2]/50'" class="px-3 py-1.5 text-[9px] rounded-lg transition-all uppercase tracking-widest">Gelap</button>
            </div>
        </div>

        @if(!$rabAktif)
            <div class="border rounded-[2rem] p-12 shadow-sm relative overflow-hidden flex flex-col items-center text-center transition-colors mt-8"
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
                        MENYIAPKAN WORKSPACE...
                    </span>
                </button>
            </div>
        @else
            @php
                $isRevisi = strtolower($rabAktif->status_rab ?? '') === 'revisi';
                $isApproved = strtolower($rabAktif->status_rab ?? '') === 'approved';
            @endphp
            <div class="border rounded-[2rem] p-8 md:p-10 shadow-lg relative overflow-hidden transition-all duration-300 mt-8"
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
                    </button>

                    <button {{ $isRevisi ? 'disabled' : '' }}
                            class="px-5 py-3 text-[10px] font-black tracking-widest rounded-xl transition-all uppercase flex items-center gap-2 border"
                            :class="$isRevisi
                            ? 'opacity-40 cursor-not-allowed ' . (darkMode ? 'bg-transparent border-[#331A0A] text-slate-500' : 'bg-slate-100 border-slate-200 text-slate-400')
                            : (darkMode ? 'bg-[#0D0602] hover:bg-rose-950 text-rose-500 border-rose-900' : 'bg-white hover:bg-rose-50 text-rose-600 border-rose-300')">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        PDF
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>