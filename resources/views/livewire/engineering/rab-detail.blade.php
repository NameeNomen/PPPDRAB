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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

            @if(!$rabAktif)
                <div class="rounded-2xl border-2 overflow-hidden shadow-xl" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                    <div class="p-4 border-b-2 flex justify-between items-center" :class="darkMode ? 'bg-[#F5C518] border-[#F5C518] text-[#1A1A1A]' : 'bg-[#F5C518] border-[#F5C518] text-[#1A1A1A]'">
                        <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Preview Dokumen Marketing
                        </span>
                        <span class="text-[10px] font-bold bg-[#1A1A1A]/10 px-2 py-0.5 rounded uppercase">Inisiasi</span>
                    </div>

                    <div class="overflow-y-auto" style="max-height: calc(100vh - 220px);">
                        <div class="p-5">
                            @include('components.dokumen-inisiasi', ['proyek' => $selectedProject])
                        </div>
                    </div>
                </div>
            @else
                <div class="rounded-2xl border-2 overflow-hidden shadow-xl" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                    @php $stat = strtolower($rabAktif->status_rab ?? ''); @endphp

                    <div class="p-4 border-b-2 flex justify-between items-center transition-colors"
                         :class="'{{ $stat }}' === 'revision' ? 'bg-red-600 border-red-600 text-white' : 'bg-[#F5C518] border-[#F5C518] text-[#1A1A1A]'">
                        <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Lembar Kendali & Detail Revisi Direksi
                        </span>
                        <span class="text-[10px] font-black uppercase bg-black/10 px-2.5 py-0.5 rounded">DIREKTUR</span>
                    </div>

                    <div class="p-6 space-y-6 overflow-y-auto" style="max-height: calc(100vh - 220px);">
                        @if($stat === 'revision')
                            <div class="p-5 rounded-xl bg-red-500/10 border-2 border-red-500/20 text-red-500">
                                <p class="text-xs font-black uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                                    Instruksi Perbaikan Dokumen:
                                </p>
                                <p class="text-xs font-medium leading-relaxed font-mono">
                                    "{{ $latestRevisiComment ?? 'Periksa kembali kalkulasi harga material pendukung dan sesuaikan nilai overhead operasional agar rasio HPP tetap logis.' }}"
                                </p>
                            </div>
                        @elseif($stat === 'approved')
                            <div class="p-5 rounded-xl border-2" :class="darkMode ? 'bg-[#F5C518]/10 border-[#F5C518]/20 text-[#F5C518]' : 'bg-[#F5C518]/10 border-[#F5C518]/30 text-[#B8860B]'">
                                <p class="text-xs font-black uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    Dokumen Disetujui
                                </p>
                                <p class="text-xs font-medium mt-2">Kalkulasi WBS dan estimasi harga final telah divalidasi oleh Direktur. Dokumen siap dicetak secara legal.</p>
                            </div>
                        @else
                            <div class="p-5 rounded-xl border-2" :class="darkMode ? 'bg-[#F5C518]/10 border-[#F5C518]/20 text-[#F5C518]' : 'bg-[#F5C518]/10 border-[#F5C518]/30 text-[#B8860B]'">
                                <p class="text-xs font-black uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Menunggu Peninjauan
                                </p>
                                <p class="text-xs font-medium mt-2">Berkas draf RAB sudah berada di antrean sistem Direktur. Belum ada catatan revisi yang diterbitkan.</p>
                            </div>
                        @endif

                        <div class="text-xs p-4 rounded-xl border border-dashed transition-colors" :class="darkMode ? 'border-gray-800 text-gray-400' : 'border-gray-300 text-gray-500'">
                            <p class="font-bold mb-1 uppercase tracking-wide text-[10px]">Catatan Manajemen Versi:</p>
                            Setiap perubahan teks atau kuantitas material di dalam ruang kerja (*workspace*) akan terekam otomatis sebagai log pembuat terakhir sebelum diajukan kembali ke direksi.
                        </div>
                    </div>
                </div>
            @endif

            <div class="space-y-6">
                @if(!$rabAktif)
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
                    </div>
                @else
                    @php
                        $isRevisi = strtolower($rabAktif->status_rab ?? '') === 'revision';
                        $isApproved = strtolower($rabAktif->status_rab ?? '') === 'approved';
                    @endphp

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
                        </div>

                        @if($latestCommit)
                            <div class="mt-6 pt-6 border-t-2" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
                                <p class="text-[10px] font-bold uppercase tracking-widest mb-3" :class="darkMode ? 'text-[#888888]' : 'text-[#888888]'">Opsi Cetak Final / Ekspor Data</p>

                                <iframe id="iframe-cetak-pdf" src="{{ route('engineering.cetak.versi', $latestCommit->id) }}#toolbar=0&navpanes=0" class="hidden"></iframe>

                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button onclick="document.getElementById('iframe-cetak-pdf').contentWindow.print()" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-bold uppercase tracking-wide rounded-xl transition-all flex-1 border-2 shadow-sm" :class="darkMode ? 'bg-[#1A1A1A] text-[#F5F5F5] border-[#333333] hover:border-[#F5C518] hover:text-[#F5C518]' : 'bg-white text-[#1A1A1A] border-[#E5E5E5] hover:border-[#F5C518]'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        Cetak PDF
                                    </button>

                                    <a href="{{ route('engineering.export.excel', $latestCommit->id) }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-bold uppercase tracking-wide rounded-xl transition-all flex-1 border-2 shadow-sm" :class="darkMode ? 'bg-[#F5C518]/10 text-[#F5C518] border-[#F5C518]/30 hover:bg-[#F5C518]/20' : 'bg-[#F5C518]/10 text-[#B8860B] border-[#F5C518]/30 hover:bg-[#F5C518]/20 hover:shadow-md'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Export Excel
                                    </a>
                                </div>
                            </div>
                        @endif

                    </div>
                @endif
            </div>
        </div>
    </div>
</div>