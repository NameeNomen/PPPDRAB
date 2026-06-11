<div class="min-h-screen font-sans transition-colors duration-300" style="font-family: 'Inter', sans-serif;" x-data="{ darkMode: false }" :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5]' : 'bg-[#FAFAFA] text-[#1A1A1A]'">
    
    @if (session()->has('sukses'))
        <div class="max-w-[95rem] mx-auto pt-6 px-4 md:px-6">
            <div class="p-4 rounded-xl font-semibold flex items-center gap-3 shadow-xl border-2 text-xs tracking-wide uppercase" :class="darkMode ? 'bg-[#F5C518]/10 border-[#F5C518]/40 text-[#F5C518]' : 'bg-[#F5C518]/15 border-[#F5C518]/50 text-[#1A1A1A]'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('sukses') }}</span>
            </div>
        </div>
    @endif

    <div class="max-w-[95rem] mx-auto p-4 md:p-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-5 border-b-2" :class="darkMode ? 'border-[#F5C518]/20' : 'border-[#E5E5E5]'">
            <button wire:click="kembaliKeList" class="group flex items-center gap-2 text-sm font-semibold px-5 py-2.5 rounded-lg transition-all border-2" :class="darkMode ? 'text-[#F5C518] border-[#F5C518]/30 hover:bg-[#F5C518]/10 hover:border-[#F5C518]' : 'text-[#1A1A1A] border-[#E5E5E5] hover:border-[#F5C518] hover:bg-[#F5C518]/10 shadow-sm'">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Board
            </button>
            
            <div class="flex items-center gap-1 p-1 rounded-lg border-2 shadow-sm" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333]' : 'bg-white border-[#E5E5E5]'">
                <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-[#F5C518] text-[#1A1A1A] font-bold shadow-md' : 'text-[#888888] hover:text-[#F5C518]'" class="px-5 py-2 text-xs font-semibold rounded-md transition-all uppercase tracking-wider">Terang</button>
                <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-[#F5C518] text-[#1A1A1A] font-bold shadow-md' : 'text-[#888888] hover:text-[#F5C518]'" class="px-5 py-2 text-xs font-semibold rounded-md transition-all uppercase tracking-wider">Gelap</button>
            </div>
        </div>

        <!-- Main Grid: Kiri-Kanan Side by Side -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            
            <!-- KIRI: Preview Panel -->
            <div class="rounded-2xl border-2 overflow-hidden shadow-xl" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                <!-- Header Preview -->
                <div class="p-4 border-b-2 flex justify-between items-center" :class="darkMode ? 'bg-[#F5C518] border-[#F5C518]' : 'bg-[#F5C518] border-[#F5C518]'">
                    <span class="text-xs font-bold text-[#1A1A1A] uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Preview Dokumen Marketing
                    </span>
                    <span class="text-[10px] font-semibold text-[#1A1A1A]/70 uppercase">Inisiasi</span>
                </div>
                
                <!-- Content Preview -->
                <div class="overflow-y-auto" style="max-height: calc(100vh - 220px);">
                    <div class="p-5">
                        @include('components.dokumen-inisiasi', ['proyek' => $selectedProject])
                    </div>
                </div>
            </div>

            <!-- KANAN: Action Panel -->
            <div class="space-y-6">
                @if(!$rabAktif)
                    <!-- Empty State -->
                    <div class="rounded-2xl p-8 md:p-10 border-2 shadow-xl text-center" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                        <div class="w-16 h-16 mx-auto mb-6 rounded-2xl flex items-center justify-center bg-[#F5C518] text-[#1A1A1A] shadow-xl shadow-[#F5C518]/30">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-bold mb-3" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">Dokumen RAB Belum Tersedia</h2>
                        <p class="text-sm mb-8 max-w-md mx-auto leading-relaxed" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">
                            Silakan review dokumen referensi marketing di panel kiri, kemudian buat workspace RAB baru untuk memulai.
                        </p>
                        
                        <button wire:click="editRab" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-sm font-bold uppercase tracking-wide rounded-xl transition-all shadow-lg text-[#1A1A1A] bg-[#F5C518] hover:bg-[#FFD700] hover:shadow-xl hover:shadow-[#F5C518]/40 hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-[#F5C518]/30">
                            <span wire:loading.remove wire:target="editRab" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                Buat Workspace RAB
                            </span>
                            <span wire:loading wire:target="editRab" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Menyiapkan...
                            </span>
                        </button>
                        
                        <p class="mt-6 text-xs" :class="darkMode ? 'text-[#555555]' : 'text-[#AAAAAA]'">
                            Workspace akan dibuat berdasarkan dokumen referensi
                        </p>
                    </div>
                @else
                    @php
                        $isRevisi = strtolower($rabAktif->status_rab ?? '') === 'revision';
                        $isApproved = strtolower($rabAktif->status_rab ?? '') === 'approved';
                    @endphp
                    
                    <!-- RAB Detail Card -->
                    <div class="rounded-2xl p-6 md:p-8 border-2 shadow-xl" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 pb-6 border-b-2" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
                            <div>
                                <span class="inline-block text-[10px] font-bold uppercase px-3 py-1.5 rounded-lg mb-3 bg-[#F5C518] text-[#1A1A1A]">Dokumen Aktif</span>
                                <p class="text-[10px] font-semibold uppercase tracking-wider mb-1" :class="darkMode ? 'text-[#888888]' : 'text-[#888888]'">No. Referensi BOQ</p>
                                <p class="text-xl font-bold" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">{{ $rabAktif->no_boq }}</p>
                            </div>
                            <div class="text-left sm:text-right">
                                <span class="text-[10px] font-semibold uppercase tracking-wider block mb-2" :class="darkMode ? 'text-[#888888]' : 'text-[#888888]'">Status Persetujuan</span>
                                <span class="inline-flex items-center gap-1.5 text-sm font-bold uppercase px-4 py-2 rounded-xl border-2" 
                                      :class="$isApproved ? 'bg-[#F5C518]/15 text-[#1A1A1A] border-[#F5C518]/50' : ($isRevisi ? 'bg-red-500/10 text-red-500 border-red-500/30' : 'bg-[#F5C518]/10 text-[#1A1A1A] border-[#F5C518]/30')">
                                    <span class="w-2 h-2 rounded-full" :class="$isApproved ? 'bg-[#F5C518]' : ($isRevisi ? 'bg-red-500' : 'bg-[#F5C518]')"></span>
                                    {{ $rabAktif->status_rab ?? 'DRAFT' }}
                                </span>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                            <div class="p-5 rounded-xl border-2" :class="darkMode ? 'bg-[#1A1A1A] border-[#2A2A2A]' : 'bg-[#FAFAFA] border-[#E5E5E5]'">
                                <p class="text-[10px] font-semibold uppercase tracking-wider mb-2" :class="darkMode ? 'text-[#888888]' : 'text-[#888888]'">Overhead Cost</p>
                                <p class="text-lg font-bold font-mono" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">Rp {{ number_format($rabAktif->overhead_cost, 0, ',', '.') }}</p>
                            </div>
                            <div class="p-5 rounded-xl border-2 border-[#F5C518]/50 bg-[#F5C518]/5">
                                <p class="text-[10px] font-bold uppercase tracking-wider mb-2 text-[#1A1A1A]">Grand Total Estimasi</p>
                                <p class="text-2xl font-bold font-mono text-[#1A1A1A]">Rp {{ number_format($rabAktif->grand_total, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t-2" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
                            <button wire:click="editRab" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-bold uppercase tracking-wide rounded-xl transition-all flex-1 text-[#1A1A1A] bg-[#F5C518] hover:bg-[#FFD700] shadow-md hover:shadow-xl hover:shadow-[#F5C518]/30 focus:outline-none focus:ring-4 focus:ring-[#F5C518]/30">
                                <span wire:loading.remove wire:target="editRab" class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    {{ $isApproved ? 'Lihat Spreadsheet' : 'Buka Workspace RAB' }}
                                </span>
                                <span wire:loading wire:target="editRab" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Memuat...
                                </span>
                            </button>
                            
                            @if(!$isApproved)
                                <button onclick="return confirm('Yakin ingin menghapus dokumen ini?')" wire:click="hapusDokumenRab" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-bold uppercase tracking-wide rounded-xl transition-all border-2 text-red-600 border-red-500/30 hover:bg-red-500 hover:text-white hover:border-red-500 hover:shadow-lg hover:shadow-red-500/20 focus:outline-none focus:ring-4 focus:ring-red-500/30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Info Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="p-4 rounded-xl border-2 shadow-lg" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-[#F5C518]/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-[#1A1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <span class="text-xs font-semibold" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">Dokumen</span>
                            </div>
                            <p class="text-sm font-bold" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">BOQ Aktif</p>
                        </div>
                        
                        <div class="p-4 rounded-xl border-2 shadow-lg" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-[#F5C518]/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-[#1A1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-xs font-semibold" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">Budget</span>
                            </div>
                            <p class="text-sm font-bold" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">Terestimasi</p>
                        </div>
                        
                        <div class="p-4 rounded-xl border-2 shadow-lg" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-[#F5C518]/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-[#1A1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                </div>
                                <span class="text-xs font-semibold" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">Status</span>
                            </div>
                            <p class="text-sm font-bold" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">{{ $isApproved ? 'Disetujui' : ($isRevisi ? 'Revisi' : 'Proses') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>