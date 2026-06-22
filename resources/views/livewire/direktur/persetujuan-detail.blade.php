<div class="min-h-screen font-sans bg-[#F8FAFC] text-[#0F172A]" style="font-family: 'Inter', sans-serif;">

    <div class="max-w-[95rem] mx-auto p-4 md:p-8 space-y-6 md:space-y-8">

        {{-- ========================================== --}}
        {{-- HEADER CARD                                --}}
        {{-- ========================================== --}}
        <div class="p-6 md:p-8 rounded-2xl shadow-sm border border-[#E2E8F0] flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden bg-white mb-4">
            
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#4F46E5] rounded-full blur-3xl opacity-15 -mr-10 -mt-10 pointer-events-none"></div>
            
            <div class="relative z-10 flex-grow">
                <span class="px-4 py-1.5 text-[10px] font-bold text-[#312E81] bg-[#EEF2FF] rounded-lg uppercase tracking-wider border border-[#C7D2FE]">
                    {{ $view === 'document_list' ? 'Dashboard Otorisasi' : 'Pratinjau Dokumen' }}
                </span>
                
                <h1 class="text-2xl md:text-3xl font-black tracking-tight mt-4 text-[#1E1B4B]">
                    {{ $view === 'document_list' ? 'Persetujuan Dokumen Proyek' : ($selectedProject->nama_pelanggan ?? 'Detail Dokumen') }}
                </h1>
                
                <p class="text-xs mt-1 font-medium text-[#64748B]">
                    {{ $view === 'document_list' ? 'Tinjau dan sahkan dokumen RAB serta Surat Penawaran yang diajukan oleh tim.' : 'Harap periksa rincian nilai dan syarat komersial sebelum melakukan otorisasi final.' }}
                </p>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-4 w-full md:w-auto">
                @if($view === 'document_list')
                    <button wire:click="kembaliKeIndex" class="group flex items-center justify-center gap-2 px-6 py-3.5 text-xs font-bold transition-all cursor-pointer w-full md:w-auto text-center rounded-xl border border-[#CBD5E1] shadow-sm text-[#1E293B] hover:bg-[#F8FAFC] hover:border-[#4F46E5] bg-white">
                        <svg class="w-4 h-4 text-[#4F46E5] transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        KEMBALI KE BOARD
                    </button>
                @else
                    <button wire:click="kembaliKeDocumentList" class="group flex items-center justify-center gap-2 px-6 py-3.5 text-xs font-bold transition-all cursor-pointer w-full md:w-auto text-center rounded-xl border border-[#CBD5E1] shadow-sm text-[#1E293B] hover:bg-[#F8FAFC] hover:border-[#4F46E5] bg-white">
                        <svg class="w-4 h-4 text-[#4F46E5] transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        TUTUP PRATINJAU
                    </button>
                @endif
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session()->has('sukses'))
            <div class="px-6 py-4 rounded-xl text-xs font-bold border flex items-center gap-3 shadow-sm bg-[#EEF2FF] text-[#312E81] border-[#C7D2FE]">
                <svg class="w-5 h-5 text-[#4F46E5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('sukses') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="px-6 py-4 bg-white text-rose-700 rounded-xl text-xs font-bold border border-rose-300 flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- ========================================== --}}
        {{-- VIEW: DOCUMENT LIST (Pilih Dokumen)        --}}
        {{-- ========================================== --}}
        @if($view === 'document_list')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- List RAB --}}
                @forelse($selectedProject->rabs as $rab)
                    <div class="p-6 md:p-8 rounded-xl border border-[#E2E8F0] shadow-sm flex flex-col justify-between bg-white hover:border-[#818CF8] hover:shadow-md transition-shadow">
                        <div class="w-full border-b border-[#F1F5F9] pb-4 mb-4">
                            <span class="px-3 py-1.5 text-[10px] font-bold rounded bg-[#F8FAFC] text-[#475569] border border-[#E2E8F0]">DOKUMEN RAB WBS</span>
                            <h4 class="text-xl font-bold font-mono mt-4 text-[#1E1B4B]">{{ $rab->no_boq }}</h4>
                            <div class="flex justify-between items-center mt-4">
                                <p class="text-xs font-semibold text-[#64748B]">Total Anggaran:</p>
                                <span class="font-mono text-sm font-bold text-[#312E81]">Rp {{ number_format($rab->grand_total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="w-full text-right">
                            <button wire:click="lihatDetailRab({{ $rab->id }})" class="px-6 py-2.5 font-bold text-[11px] tracking-wider rounded-lg transition-colors flex items-center justify-center gap-2 w-full md:w-auto bg-[#1E1B4B] hover:bg-[#312E81] text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                TINJAU DOKUMEN
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="p-8 border-2 border-dashed rounded-xl flex flex-col items-center justify-center text-center border-[#CBD5E1] text-[#94A3B8] bg-[#F8FAFC]">
                        <p class="text-xs font-bold uppercase">TIDAK ADA RAB PENDING</p>
                    </div>
                @endforelse

                {{-- List Bidding --}}
                @forelse($selectedProject->biddings as $bidding)
                    <div class="p-6 md:p-8 rounded-xl border border-[#E2E8F0] shadow-sm flex flex-col justify-between bg-white hover:border-[#818CF8] hover:shadow-md transition-shadow">
                        <div class="w-full border-b border-[#F1F5F9] pb-4 mb-4">
                            <span class="px-3 py-1.5 text-[10px] font-bold rounded bg-[#F8FAFC] text-[#475569] border border-[#E2E8F0]">SURAT PENAWARAN</span>
                            <h4 class="text-xl font-bold font-mono mt-4 text-[#1E1B4B]">{{ $bidding->no_penawaran }}</h4>
                            <div class="flex justify-between items-center mt-4">
                                <p class="text-xs font-semibold text-[#64748B]">Nilai Penawaran:</p>
                                <span class="font-mono text-sm font-bold text-[#312E81]">Rp {{ number_format($bidding->total_penawaran, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="w-full text-right">
                            <button wire:click="lihatDetailBidding({{ $bidding->id }})" class="px-6 py-2.5 font-bold text-[11px] tracking-wider rounded-lg transition-colors flex items-center justify-center gap-2 w-full md:w-auto bg-[#1E1B4B] hover:bg-[#312E81] text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                TINJAU DOKUMEN
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="p-8 border-2 border-dashed rounded-xl flex flex-col items-center justify-center text-center border-[#CBD5E1] text-[#94A3B8] bg-[#F8FAFC]">
                        <p class="text-xs font-bold uppercase">TIDAK ADA SURAT PENAWARAN PENDING</p>
                    </div>
                @endforelse
            </div>

        {{-- ========================================== --}}
        {{-- VIEW: DETAIL RAB (KOP SURAT FIX!)          --}}
        {{-- ========================================== --}}
        @elseif($view === 'detail_rab' && $selectedRab)
            <div class="flex flex-col xl:flex-row gap-6 items-start w-full">

                {{-- KIRI: PREVIEW IFRAME RAB --}}
                <div class="w-full xl:w-[70%] shrink-0 flex flex-col border border-[#CBD5E1] rounded-xl overflow-hidden shadow-sm h-[85vh] sticky top-6 bg-white">
                    <div class="p-4 border-b border-[#1E1B4B] flex justify-between items-center z-10 flex-none bg-[#1E1B4B] text-white">
                        <h4 class="text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            PRATINJAU DOKUMEN RAB
                        </h4>
                    </div>

                    <div class="flex-grow overflow-hidden flex flex-col items-center justify-center relative bg-[#E2E8F0]">
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-0">
                            <span class="font-bold text-lg uppercase tracking-widest text-[#94A3B8]">MEMUAT DOKUMEN...</span>
                        </div>
                        
                        {{-- Logika ini yang bikin Kop Surat TJT & ISO lu muncul! --}}
                        @if($latest_commit_id)
                            <iframe src="{{ route('engineering.cetak.versi', $latest_commit_id) }}#toolbar=0&navpanes=0" class="w-full h-full border-none relative z-10 bg-transparent"></iframe>
                        @else
                            <iframe src="{{ route('cetak.rab', $selectedRab->id) }}#toolbar=0&navpanes=0" class="w-full h-full border-none relative z-10 bg-transparent"></iframe>
                        @endif
                    </div>
                </div>

                {{-- KANAN: PANEL KONTROL RAB --}}
                <div class="w-full xl:w-[30%] space-y-6">
                    <div class="rounded-xl p-6 border border-[#E2E8F0] shadow-sm bg-white">
                        
                        <div class="mb-6 border-b border-[#F1F5F9] pb-5">
                            <span class="inline-block text-[10px] font-bold uppercase px-2.5 py-1 rounded mb-3 bg-[#EEF2FF] text-[#4F46E5] border border-[#C7D2FE]">Rencana Anggaran Biaya</span>
                            <p class="text-[10px] font-bold uppercase tracking-wider mb-1 text-[#64748B]">No. Referensi BOQ</p>
                            <p class="text-lg font-bold font-mono text-[#0F172A]">{{ $selectedRab->no_boq }}</p>
                        </div>

                        <div class="p-5 rounded-lg border border-[#E2E8F0] mb-6 bg-[#F8FAFC]">
                            <p class="text-[10px] font-bold uppercase tracking-wider mb-2 text-[#475569]">Grand Total Estimasi</p>
                            <p class="text-2xl font-bold font-mono text-[#1E1B4B]">Rp {{ number_format($selectedRab->grand_total, 0, ',', '.') }}</p>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-[#E2E8F0] pt-6">
                            <button wire:click="setujuiDokumen({{ $selectedRab->id }}, 'rab')"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3.5 text-xs font-bold uppercase tracking-wider rounded-lg transition-colors bg-[#1E1B4B] hover:bg-[#312E81] text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Otorisasi & Sahkan
                            </button>
                            <button wire:click="bukaModalRevisi({{ $selectedRab->id }}, 'rab')"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 text-xs font-bold uppercase tracking-wider rounded-lg transition-colors border border-[#E2E8F0] text-[#E11D48] hover:bg-[#FFF1F2] hover:border-[#FDA4AF]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Tolak / Revisi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        {{-- ========================================== --}}
        {{-- VIEW: DETAIL BIDDING (INCLUDE TRANSPARAN)  --}}
        {{-- ========================================== --}}
        @elseif($view === 'detail_bidding' && $selectedBidding)
            <div class="flex flex-col xl:flex-row gap-6 items-start w-full">

                {{-- KIRI: PREVIEW KOMPONEN BLADE BIDDING --}}
                <div class="w-full xl:w-[70%] shrink-0 flex flex-col border border-[#CBD5E1] rounded-xl overflow-hidden shadow-sm h-[85vh] sticky top-6 bg-[#E2E8F0]">
                    <div class="p-4 border-b border-[#1E1B4B] flex justify-between items-center z-10 flex-none bg-[#1E1B4B] text-white">
                        <h4 class="text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            PRATINJAU SURAT PENAWARAN
                        </h4>
                    </div>

                    <div class="flex-grow overflow-y-auto bg-transparent p-0 m-0">
                        @include('components.dokumen-bidding', ['bidding' => $selectedBidding, 'proyek' => $selectedProject])
                    </div>
                </div>

                {{-- KANAN: PANEL KONTROL BIDDING --}}
                <div class="w-full xl:w-[30%] space-y-6">
                    <div class="rounded-xl p-6 border border-[#E2E8F0] shadow-sm bg-white">
                        
                        <div class="mb-5 border-b border-[#F1F5F9] pb-5">
                            <span class="inline-block text-[9px] font-bold uppercase px-2.5 py-1 rounded mb-3 bg-[#EEF2FF] text-[#4F46E5] border border-[#C7D2FE]">Surat Penawaran</span>
                            <p class="text-[10px] font-bold uppercase tracking-wider mb-1 text-[#64748B]">No. Penawaran</p>
                            <p class="text-lg font-bold font-mono text-[#0F172A]">{{ $selectedBidding->no_penawaran }}</p>

                            <div class="mt-4 space-y-2">
                                <div>
                                    <p class="text-[10px] font-semibold text-[#64748B] uppercase tracking-wider">Klien:</p>
                                    <p class="text-xs font-medium text-[#1E293B]">{{ $selectedBidding->nama_pelanggan_snapshot }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-semibold text-[#64748B] uppercase tracking-wider">Perihal:</p>
                                    <p class="text-xs font-medium text-[#1E293B] leading-relaxed">{{ $selectedBidding->perihal }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 rounded-lg border border-[#E2E8F0] mb-5 bg-[#F8FAFC] space-y-3">
                            <h3 class="text-[10px] font-bold uppercase tracking-widest text-[#475569] border-b border-[#E2E8F0] pb-2">Rincian Komersial</h3>
                            <!-- Kalkulasi Penawaran (Otomatis Hitung Margin) -->
@php
    $hargaDasar = $selectedBidding->harga_dasar ?? 0;
    $hargaJual = $selectedBidding->total_penawaran ?? 0;
    // Hitung margin persen: ((Jual - Dasar) / Dasar) * 100
    $marginPersen = ($hargaDasar > 0) ? (($hargaJual - $hargaDasar) / $hargaDasar) * 100 : 0;
@endphp

<div class="p-5 rounded-2xl border-2 mb-5 bg-[#E2EFE7]/30 border-[#4A7256]/30 space-y-3">
    <h3 class="text-[10px] font-black uppercase tracking-widest text-[#4A7256] border-b border-[#4A7256]/20 pb-2">Kalkulasi Penawaran</h3>
    
    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-[8px] font-bold uppercase text-[#888888]">Target Margin</p>
            <div class="flex items-center gap-1">
                <span class="text-lg font-black text-[#4A7256]">{{ number_format($marginPersen, 1, ',', '.') }}</span>
                <span class="text-xs font-bold text-[#666666]">%</span>
            </div>
        </div>
    </div>
    
    <div class="pt-2 border-t border-[#4A7256]/20">
        <p class="text-[8px] font-black uppercase tracking-widest text-[#4A7256] mb-1">Harga Penawaran Final</p>
        <p class="text-lg font-black font-mono text-[#1A1A1A]">
            Rp {{ number_format($selectedBidding->total_penawaran, 1, ',', '.') }}
        </p>
    </div>
</div>
                            <div class="flex justify-between items-center">
                                <p class="text-xs font-medium text-[#64748B]">Harga Dasar (HPP)</p>
                                <p class="font-mono text-xs font-semibold text-[#0F172A]">Rp {{ number_format($selectedBidding->harga_dasar, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-xs font-medium text-[#64748B]">PPN (11%)</p>
                                <p class="font-mono text-xs font-semibold text-[#0F172A]">Rp {{ number_format($selectedBidding->total_penawaran - $selectedBidding->harga_dasar, 0, ',', '.') }}</p>
                            </div>
                            <div class="pt-3 border-t border-[#E2E8F0] mt-2">
                                <p class="text-[10px] font-bold uppercase tracking-wider mb-1 text-[#475569]">Grand Total Penawaran</p>
                                <p class="text-xl font-bold font-mono text-[#1E1B4B]">Rp {{ number_format($selectedBidding->total_penawaran, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-lg border border-[#E2E8F0] bg-[#F8FAFC] mb-6 space-y-3">
                            <h3 class="text-[10px] font-bold uppercase tracking-widest text-[#475569] border-b border-[#E2E8F0] pb-2">Terms & Conditions</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[9px] uppercase text-[#64748B] font-semibold mb-0.5">Masa Berlaku</p>
                                    <p class="text-xs font-medium text-[#0F172A]">{{ $selectedBidding->masa_berlaku }} Hari</p>
                                </div>
                                <div>
                                    <p class="text-[9px] uppercase text-[#64748B] font-semibold mb-0.5">Pengerjaan</p>
                                    <p class="text-xs font-medium text-[#0F172A]">{{ $selectedBidding->waktu_pengerjaan ?? '-' }} Hari</p>
                                </div>
                                <div class="col-span-2 border-t border-[#E2E8F0] pt-2">
                                    <p class="text-[9px] uppercase text-[#64748B] font-semibold mb-1">Term of Payment</p>
                                    <p class="text-xs font-medium text-[#0F172A] leading-relaxed whitespace-pre-line">{{ $selectedBidding->term_of_payment }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-[#E2E8F0] pt-6">
                            <button wire:click="setujuiDokumen({{ $selectedBidding->id }}, 'bidding')"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3.5 text-xs font-bold uppercase tracking-wider rounded-lg transition-colors bg-[#1E1B4B] hover:bg-[#312E81] text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Otorisasi & Sahkan
                            </button>
                            <button wire:click="bukaModalRevisi({{ $selectedBidding->id }}, 'bidding')"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 text-xs font-bold uppercase tracking-wider rounded-lg transition-colors border border-[#E2E8F0] text-[#E11D48] hover:bg-[#FFF1F2] hover:border-[#FDA4AF]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Tolak / Revisi
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
            <div class="fixed inset-0 bg-[#0F172A]/50 z-50 flex items-center justify-center p-4">
                <div class="rounded-xl shadow-lg w-full max-w-lg border border-[#E2E8F0] bg-white">
                    <div class="px-6 py-4 border-b border-[#E2E8F0] flex justify-between items-center bg-[#F8FAFC]">
                        <h3 class="text-xs font-bold uppercase tracking-widest flex items-center gap-2 text-[#0F172A]">
                            <svg class="w-4 h-4 text-[#E11D48]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            INSTRUKSI PERBAIKAN
                        </h3>
                        <button wire:click="tutupModalRevisi" class="text-[#94A3B8] hover:text-[#0F172A] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="kirimRevisi" class="p-6">
                        <div class="mb-6">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-[#64748B] mb-2">Catatan Penolakan</label>
                            <textarea wire:model="komentar_commit" rows="4" placeholder="Jelaskan alasan penolakan atau perbaikan yang diperlukan..."
                                      class="w-full text-sm rounded-lg p-3 outline-none transition-colors resize-none border border-[#CBD5E1] bg-white text-[#0F172A] focus:border-[#4F46E5] focus:ring-1 focus:ring-[#4F46E5]"></textarea>
                            @error('komentar_commit') <span class="text-[#E11D48] text-xs font-medium block mt-1.5">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-end gap-3 pt-4 border-t border-[#E2E8F0]">
                            <button type="button" wire:click="tutupModalRevisi" class="px-5 py-2.5 text-xs font-semibold rounded-lg transition-colors text-[#64748B] hover:bg-[#F1F5F9]">Batal</button>
                            <button type="submit" class="px-6 py-2.5 bg-[#E11D48] hover:bg-[#BE123C] text-white text-xs font-bold uppercase tracking-wider rounded-lg transition-colors">
                                Tolak & Kembalikan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </div>
</div>