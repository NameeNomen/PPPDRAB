<div class="min-h-screen font-sans relative overflow-hidden z-0 bg-[#FAFAFA] text-[#2A0001]"
     style="font-family: 'Inter', sans-serif;"
     x-data="{ previewZoom: 0.85 }">
   
    {{-- Background Decorative --}}
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#DA7134]/10 rounded-full blur-3xl -z-10 mix-blend-multiply"></div>
    <div class="absolute bottom-0 left-[-10%] w-[600px] h-[600px] bg-[#E89154]/10 rounded-full blur-3xl -z-10 mix-blend-multiply"></div>

    <div class="max-w-[95rem] mx-auto p-4 md:p-8 relative z-10 space-y-6 md:space-y-8">

        {{-- Flash Messages --}}
        @if (session()->has('sukses'))
            <div class="px-6 py-4 rounded-2xl text-xs font-bold border flex items-center gap-3 shadow-sm animate-fade-in-down bg-[#E89154]/20 text-[#2A0001] border-[#DA7134]/30">
                <svg class="w-5 h-5 text-[#852616]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('sukses') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="px-6 py-4 bg-red-100 text-red-800 rounded-2xl text-xs font-bold border border-red-200 flex items-center gap-3 shadow-sm animate-fade-in-down">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Header Navigation --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-5 border-b-2 border-[#DA7134]/30">
            @if($view === 'document_list')
                <button wire:click="kembaliKeIndex" class="group flex items-center gap-2 px-5 py-2.5 rounded-xl transition-all border-2 shadow-sm text-[#852616] border-[#DA7134]/30 hover:bg-[#E89154]/20 bg-white/80 backdrop-blur-md">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span class="text-xs font-bold uppercase tracking-wider">Kembali ke Board</span>
                </button>
            @else
                <button wire:click="kembaliKeDocumentList" class="group flex items-center gap-2 px-5 py-2.5 rounded-xl transition-all border-2 shadow-sm text-[#852616] border-[#DA7134]/30 hover:bg-[#E89154]/20 bg-white/80 backdrop-blur-md">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span class="text-xs font-bold uppercase tracking-wider">Tutup Pratinjau</span>
                </button>
            @endif
        </div>

        {{-- ========================================== --}}
        {{-- VIEW: DOCUMENT LIST (Pilih Dokumen)        --}}
        {{-- ========================================== --}}
        @if($view === 'document_list')
            <div class="flex items-center gap-4">
                <div>
                    <h2 class="text-xs md:text-sm font-black uppercase tracking-widest">MAP DOKUMEN: <span class="text-[#DA7134]">{{ $selectedProject->nama_pelanggan }}</span></h2>
                    <p class="text-[10px] font-bold mt-0.5 text-[#852616]/70">Pilih dokumen di bawah untuk memproses peninjauan cetak PDF.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                {{-- List RAB --}}
                @forelse($selectedProject->rabs as $rab)
                    <div class="group p-8 rounded-[2rem] border-2 shadow-lg flex flex-col justify-between transition-all duration-300 relative overflow-hidden bg-white/70 backdrop-blur-xl border-[#E89154]/20 hover:border-[#DA7134]/60">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-[#DA7134]/10 to-transparent rounded-bl-full -z-10"></div>
                        <div class="w-full z-10">
                            <span class="px-3 py-1 text-[9px] font-black rounded-xl uppercase bg-[#852616]/10 text-[#852616]">Dokumen RAB WBS</span>
                            <h4 class="text-2xl font-black font-mono mt-4">{{ $rab->no_boq }}</h4>
                            <p class="text-xs font-bold mt-2 text-[#852616]">Total Usulan: 
                                <span class="font-black px-2 py-0.5 rounded-lg ml-1 bg-[#E89154]/20 text-[#2A0001]">Rp {{ number_format($rab->grand_total, 0, ',', '.') }}</span>
                            </p>
                        </div>
                        <div class="mt-10 w-full text-right z-10">
                            <button wire:click="lihatDetailRab({{ $rab->id }})" class="px-6 py-3 font-bold text-[10px] tracking-widest rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg w-full md:w-auto bg-[#2A0001] hover:bg-[#852616] text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> 
                                PRATINJAU DOKUMEN
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="p-6 border-2 border-dashed rounded-[2rem] flex flex-col items-center justify-center text-center border-[#DA7134]/30 text-[#852616]/60 bg-white/40">
                        <p class="text-xs font-bold uppercase">Tidak ada RAB yang perlu disetujui</p>
                    </div>
                @endforelse

                {{-- List Bidding --}}
                @forelse($selectedProject->biddings as $bidding)
                    <div class="group p-8 rounded-[2rem] border-2 shadow-lg flex flex-col justify-between transition-all duration-300 relative overflow-hidden bg-white/70 backdrop-blur-xl border-[#E89154]/20 hover:border-[#DA7134]/60">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-[#DA7134]/10 to-transparent rounded-bl-full -z-10"></div>
                        <div class="w-full z-10">
                            <span class="px-3 py-1 text-[9px] font-black rounded-xl uppercase bg-[#DA7134]/15 text-[#852616]">Dokumen Surat Penawaran</span>
                            <h4 class="text-2xl font-black font-mono mt-4">{{ $bidding->no_penawaran }}</h4>
                            <p class="text-xs font-bold mt-2 text-[#852616]">Nilai Tawar: 
                                <span class="font-black px-2 py-0.5 rounded-lg ml-1 bg-[#E89154]/20 text-[#2A0001]">Rp {{ number_format($bidding->total_penawaran, 0, ',', '.') }}</span>
                            </p>
                        </div>
                        <div class="mt-10 w-full text-right z-10">
                            <button wire:click="lihatDetailBidding({{ $bidding->id }})" class="px-6 py-3 font-bold text-[10px] tracking-widest rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg w-full md:w-auto bg-[#2A0001] hover:bg-[#852616] text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> 
                                PRATINJAU DOKUMEN
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="p-6 border-2 border-dashed rounded-[2rem] flex flex-col items-center justify-center text-center border-[#DA7134]/30 text-[#852616]/60 bg-white/40">
                        <p class="text-xs font-bold uppercase">Tidak ada Surat Penawaran Pending</p>
                    </div>
                @endforelse
            </div>

        {{-- ========================================== --}}
        {{-- VIEW: DETAIL RAB (Menggunakan @include)    --}}
        {{-- ========================================== --}}
        @elseif($view === 'detail_rab' && $selectedRab)
            <div class="flex flex-col xl:flex-row gap-6 items-start w-full">
                
                {{-- KIRI: PREVIEW HTML NATIVE SCALABLE --}}
                <div class="w-full xl:w-[70%] shrink-0 flex flex-col border-2 rounded-[2rem] overflow-hidden shadow-2xl h-[85vh] sticky top-6 bg-white border-[#E89154]/20">
                    
                    <div class="p-3 border-b flex justify-between items-center z-10 flex-none bg-[#2A0001] border-[#DA7134]/30 text-[#E89154]">
                        <span class="text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Pratinjau Dokumen RAB
                        </span>
                        
                        <div class="flex items-center gap-1 rounded px-1 shadow-inner border bg-white/20 border-white/10">
                            <button @click="if(previewZoom > 0.4) previewZoom -= 0.1" class="w-5 h-5 flex items-center justify-center hover:bg-white/20 rounded font-black cursor-pointer transition-colors text-[#F5F5F5]">-</button>
                            <span class="text-[9px] font-mono font-black w-8 text-center text-[#F5F5F5]" x-text="Math.round(previewZoom * 100) + '%'"></span>
                            <button @click="if(previewZoom < 1.5) previewZoom += 0.1" class="w-5 h-5 flex items-center justify-center hover:bg-white/20 rounded font-black cursor-pointer transition-colors text-[#F5F5F5]">+</button>
                        </div>
                    </div>

                    {{-- BUNGKUS DOKUMEN HTML --}}
                    <div class="flex-grow overflow-auto flex justify-center py-8 bg-[#525659]">
                        {{-- PELINDUNG CSS BIAR TABEL GAK SESEK KENA RESET TAILWIND --}}
                        <style>
                            .area-kertas-pdf table { width: 100% !important; border-collapse: collapse !important; margin: 15px 0 !important; }
                            .area-kertas-pdf th, .area-kertas-pdf td { border: 1px solid #000 !important; padding: 10px 14px !important; vertical-align: middle !important; font-size: 11px !important; line-height: 1.5 !important; }
                            .area-kertas-pdf th { background-color: #f3f4f6 !important; font-weight: 900 !important; text-align: center !important; }
                            .area-kertas-pdf h1, .area-kertas-pdf h2, .area-kertas-pdf p { line-height: 1.6 !important; }
                        </style>

                        <div class="transition-all duration-200 origin-top bg-white shadow-2xl area-kertas-pdf" :style="'zoom: ' + previewZoom">
                            @include('livewire.engineering.cetak-rab', [
                                'rabAktif' => $selectedRab,
                                'kategoris' => $wbsStruktur,
                                'proyek' => $selectedProject,
                                'nama_pembuat' => auth()->user()->username ?? 'Engineering'
                            ])
                        </div>
                    </div>
                </div>

                {{-- KANAN: PANEL KONTROL RAB --}}
                <div class="w-full xl:w-[30%] space-y-6">
                    <div class="rounded-[2rem] p-6 border-2 shadow-xl bg-white/80 backdrop-blur-xl border-[#E89154]/20">
                        
                        <div class="mb-6">
                            <span class="inline-block text-[9px] font-black uppercase px-3 py-1.5 rounded-xl mb-3 bg-[#852616]/10 text-[#852616]">Dokumen RAB WBS</span>
                            <p class="text-[10px] font-bold uppercase tracking-wider mb-1 text-[#852616]/70">No. Referensi BOQ</p>
                            <p class="text-xl font-black font-mono text-[#1A1A1A]">{{ $selectedRab->no_boq }}</p>
                        </div>

                        <div class="p-5 rounded-2xl border-2 mb-6 bg-[#E89154]/10 border-[#E89154]/30">
                            <p class="text-[10px] font-black uppercase tracking-wider mb-2 text-[#852616]">Grand Total Estimasi</p>
                            <p class="text-2xl font-black font-mono text-[#2A0001]">Rp {{ number_format($selectedRab->grand_total, 0, ',', '.') }}</p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button wire:click="setujuiDokumen({{ $selectedRab->id }}, 'rab')"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-4 text-[11px] font-black uppercase tracking-widest rounded-xl transition-all shadow-md bg-[#2A0001] hover:bg-[#852616] text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Sahkan Dokumen
                            </button>
                            <button wire:click="bukaModalRevisi({{ $selectedRab->id }}, 'rab')"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3.5 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all border-2 shadow-sm text-[#852616] border-[#852616]/30 hover:bg-[#852616]/10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Tolak & Revisi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        {{-- ========================================== --}}
        {{-- VIEW: DETAIL BIDDING (Menggunakan @include)--}}
        {{-- ========================================== --}}
        @elseif($view === 'detail_bidding' && $selectedBidding)
            <div class="flex flex-col xl:flex-row gap-6 items-start w-full">
                
                {{-- KIRI: PREVIEW KOMPONEN BIDDING NATIVE SCALABLE --}}
                <div class="w-full xl:w-[70%] shrink-0 flex flex-col border-2 rounded-[2rem] overflow-hidden shadow-2xl h-[85vh] sticky top-6 bg-white border-[#E89154]/20">
                    
                    <div class="p-3 border-b flex justify-between items-center z-10 flex-none bg-[#2A0001] border-[#DA7134]/30 text-[#E89154]">
                        <span class="text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Pratinjau Dokumen Penawaran
                        </span>
                        
                        <div class="flex items-center gap-1 rounded px-1 shadow-inner border bg-white/20 border-white/10">
                            <button @click="if(previewZoom > 0.4) previewZoom -= 0.1" class="w-5 h-5 flex items-center justify-center hover:bg-white/20 rounded font-black cursor-pointer transition-colors text-[#F5F5F5]">-</button>
                            <span class="text-[9px] font-mono font-black w-8 text-center text-[#F5F5F5]" x-text="Math.round(previewZoom * 100) + '%'"></span>
                            <button @click="if(previewZoom < 1.5) previewZoom += 0.1" class="w-5 h-5 flex items-center justify-center hover:bg-white/20 rounded font-black cursor-pointer transition-colors text-[#F5F5F5]">+</button>
                        </div>
                    </div>

                    {{-- BUNGKUS DOKUMEN HTML BIDDING --}}
                    <div class="flex-grow overflow-auto flex justify-center py-8 bg-[#525659]">
                        <div class="transition-all duration-200 origin-top bg-white shadow-2xl area-kertas-pdf" :style="'zoom: ' + previewZoom">
                            @include('components.dokumen-bidding', [
                                'bidding' => $selectedBidding,
                                'proyek' => $selectedProject
                            ])
                        </div>
                    </div>
                </div>

                {{-- KANAN: PANEL KONTROL BIDDING --}}
                <div class="w-full xl:w-[30%] space-y-6">
                    <div class="rounded-[2rem] p-6 border-2 shadow-xl bg-white/80 backdrop-blur-xl border-[#E89154]/20">
                        
                        <div class="mb-6">
                            <span class="inline-block text-[9px] font-black uppercase px-3 py-1.5 rounded-xl mb-3 bg-[#DA7134]/15 text-[#852616]">Surat Penawaran</span>
                            <p class="text-[10px] font-bold uppercase tracking-wider mb-1 text-[#852616]/70">No. Penawaran</p>
                            <p class="text-xl font-black font-mono text-[#1A1A1A]">{{ $selectedBidding->no_penawaran }}</p>
                        </div>

                        <div class="p-5 rounded-2xl border-2 mb-6 bg-[#E89154]/10 border-[#E89154]/30">
                            <p class="text-[10px] font-black uppercase tracking-wider mb-2 text-[#852616]">Total Nilai Tawar</p>
                            <p class="text-2xl font-black font-mono text-[#2A0001]">Rp {{ number_format($selectedBidding->total_penawaran, 0, ',', '.') }}</p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button wire:click="setujuiDokumen({{ $selectedBidding->id }}, 'bidding')"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-4 text-[11px] font-black uppercase tracking-widest rounded-xl transition-all shadow-md bg-[#2A0001] hover:bg-[#852616] text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Sahkan Surat
                            </button>
                            <button wire:click="bukaModalRevisi({{ $selectedBidding->id }}, 'bidding')"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3.5 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all border-2 shadow-sm text-[#852616] border-[#852616]/30 hover:bg-[#852616]/10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Tolak & Revisi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ========================================== --}}
        {{-- MODAL REVISI                               --}}
        {{-- ========================================== --}}
        @if($isRevisiModalOpen)
            <div class="fixed inset-0 bg-[#2A0001]/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                <div class="rounded-[2rem] shadow-2xl w-full max-w-lg border-2 overflow-hidden animate-fade-in-down bg-white border-[#DA7134]/30">
                    <div class="px-6 py-5 border-b-2 flex justify-between items-center bg-gradient-to-r from-[#E89154]/20 to-white border-[#DA7134]/20 text-[#852616]">
                        <h3 class="text-xs font-black uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Berikan Instruksi Perbaikan
                        </h3>
                        <button wire:click="tutupModalRevisi" class="font-bold text-lg hover:opacity-70">✕</button>
                    </div>
                    <form wire:submit.prevent="kirimRevisi" class="p-6 space-y-5">
                        <div>
                            <textarea wire:model="komentar_commit" rows="4" placeholder="Ketik alasan penolakan dan poin-poin spesifik yang harus segera diperbaiki oleh tim..."
                                      class="w-full text-sm rounded-2xl p-4 outline-none transition-all resize-none border-2 shadow-inner bg-[#E89154]/5 border-[#DA7134]/30 text-[#2A0001] focus:border-[#852616]"></textarea>
                            @error('komentar_commit') <span class="text-red-500 text-[10px] font-bold block mt-1.5">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-end gap-3 pt-5 border-t-2 border-[#DA7134]/10">
                            <button type="button" wire:click="tutupModalRevisi" class="px-5 py-2.5 text-xs font-bold rounded-xl transition-colors text-[#852616] hover:bg-[#E89154]/10">BATAL</button>
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#852616] to-[#2A0001] hover:from-[#2A0001] hover:to-[#2A0001] text-[#E89154] text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg transition-all">
                                Tolak & Kembalikan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </div>
</div>