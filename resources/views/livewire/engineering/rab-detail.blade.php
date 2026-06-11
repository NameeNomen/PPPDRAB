<div class="min-h-screen font-sans transition-colors duration-300" style="font-family: 'Inter', sans-serif;" x-data="{ darkMode: false }" :class="darkMode ? 'bg-[#121212] text-gray-200' : 'bg-[#F8F9FA] text-gray-800'">
    
    @if (session()->has('sukses'))
        <div class="max-w-[95rem] mx-auto pt-6 px-4 md:px-6">
            <div class="p-4 rounded-xl font-bold flex items-center gap-3 shadow-sm border text-xs tracking-widest uppercase" :class="darkMode ? 'bg-emerald-900/20 border-emerald-800 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-600'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('sukses') }}</span>
            </div>
        </div>
    @endif

    <div class="max-w-[95rem] mx-auto p-4 md:p-6">
        <div class="flex justify-between items-center mb-6 border-b pb-4" :class="darkMode ? 'border-[#2A2A2A]' : 'border-gray-200'">
            <button wire:click="kembaliKeList" class="flex items-center gap-2 text-xs font-semibold px-4 py-2 rounded-lg transition-all" :class="darkMode ? 'text-gray-400 hover:bg-[#1E1E1E] hover:text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'">
                &larr; Kembali ke Board
            </button>
            <div class="flex items-center gap-1 p-1 rounded-lg border shadow-sm transition-colors" :class="darkMode ? 'bg-[#1A1A1A] border-[#2A2A2A]' : 'bg-white border-gray-200'">
                <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-yellow-400 text-gray-900 font-bold shadow-sm' : 'text-gray-400'" class="px-3 py-1.5 text-[10px] rounded-md transition-all uppercase tracking-wider">Terang</button>
                <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-yellow-500 text-gray-900 font-bold shadow-sm' : 'text-gray-400'" class="px-3 py-1.5 text-[10px] rounded-md transition-all uppercase tracking-wider">Gelap</button>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">
            
            <div class="xl:col-span-5 bg-gray-200 dark:bg-[#1E1E1E] rounded-2xl overflow-hidden shadow-sm flex flex-col border border-gray-300 dark:border-[#2A2A2A]" style="height: 85vh; position: sticky; top: 24px;">
                <div class="bg-gray-100 dark:bg-[#121212] p-3 border-b border-gray-300 dark:border-[#2A2A2A] flex justify-between items-center z-10">
                    <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Preview Dokumen Inisiasi Marketing
                    </span>
                </div>
                
                <style>
                    .doc-viewer { overflow-y: auto; overflow-x: hidden; flex: 1; padding: 20px 0; background-color: #E5E7EB; }
                    .dark .doc-viewer { background-color: #2B2B2B; }
                    .doc-viewer::-webkit-scrollbar { width: 8px; }
                    .doc-viewer::-webkit-scrollbar-thumb { background: #9CA3AF; border-radius: 4px; }
                    .dark .doc-viewer::-webkit-scrollbar-thumb { background: #555; }
                </style>

                <div class="doc-viewer">
                    @include('components.dokumen-inisiasi', ['proyek' => $selectedProject])
                </div>
            </div>

            <div class="xl:col-span-7 flex flex-col min-h-[400px]">
                @if(!$rabAktif)
                    <div class="border border-dashed rounded-2xl p-12 shadow-sm flex flex-col items-center text-center transition-colors h-full justify-center" :class="darkMode ? 'bg-[#1E1E1E] border-[#333333]' : 'bg-white border-gray-200'">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 bg-yellow-100 text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h2 class="text-xl font-bold mb-2 uppercase" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">Dokumen RAB Belum Tersedia</h2>
                        <p class="text-sm text-gray-500 mb-8 max-w-sm">Baca dokumen referensi dari marketing di panel sebelah kiri, lalu klik tombol di bawah untuk membuat draf RAB.</p>
                        
                        <button wire:click="editRab" class="px-6 py-4 text-xs font-bold uppercase tracking-wider rounded-lg transition-all shadow-sm flex items-center gap-3" :class="darkMode ? 'bg-yellow-500 text-gray-900 hover:bg-yellow-400' : 'bg-yellow-400 text-gray-900 hover:bg-yellow-500'">
                            <span wire:loading.remove wire:target="editRab" class="flex items-center gap-2"><svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Buat Workspace Baru</span>
                            <span wire:loading wire:target="editRab">Menyiapkan...</span>
                        </button>
                    </div>
                @else
                    @php
                        $isRevisi = strtolower($rabAktif->status_rab ?? '') === 'revision';
                        $isApproved = strtolower($rabAktif->status_rab ?? '') === 'approved';
                    @endphp
                    <div class="rounded-2xl p-8 shadow-sm border transition-all" :class="darkMode ? 'bg-[#1E1E1E] border-[#2A2A2A]' : 'bg-white border-gray-100'">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <span class="text-[10px] font-bold uppercase px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 dark:bg-[#2A2A2A] dark:text-gray-400">Dokumen Aktif</span>
                                <p class="text-xs font-mono text-gray-500 mt-5">NO. REFERENSI BOQ</p>
                                <p class="text-lg font-bold mt-1 uppercase" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">{{ $rabAktif->no_boq }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-medium uppercase text-gray-500 block mb-1.5">Status Persetujuan</span>
                                <span class="text-sm font-bold uppercase px-4 py-1.5 rounded-md" 
                                      :class="$isApproved ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' : ($isRevisi ? 'bg-rose-50 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400' : 'bg-yellow-50 text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-500')">
                                    {{ $rabAktif->status_rab ?? 'DRAFT' }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6 rounded-xl border bg-gray-50 dark:bg-[#121212] dark:border-[#2A2A2A] mb-8">
                            <div class="border-b md:border-b-0 md:border-r pb-4 md:pb-0 md:pr-4 border-gray-200 dark:border-[#2A2A2A]">
                                <p class="text-[10px] font-medium uppercase text-gray-500">Overhead Cost</p>
                                <p class="text-base font-semibold font-mono mt-1" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Rp {{ number_format($rabAktif->overhead_cost, 0, ',', '.') }}</p>
                            </div>
                            <div class="md:pl-2">
                                <p class="text-[10px] font-bold uppercase text-gray-500">Grand Total Estimasi</p>
                                <p class="text-2xl font-bold font-mono mt-1" :class="darkMode ? 'text-yellow-500' : 'text-yellow-600'">Rp {{ number_format($rabAktif->grand_total, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4 pt-6 border-t" :class="darkMode ? 'border-[#2A2A2A]' : 'border-gray-100'">
                            <button wire:click="editRab" class="px-6 py-3 text-xs font-bold uppercase tracking-wider rounded-lg transition-all flex-1" :class="darkMode ? 'bg-yellow-500 text-gray-900 hover:bg-yellow-400' : 'bg-yellow-400 text-gray-900 hover:bg-yellow-500'">
                                <span wire:loading.remove wire:target="editRab">{{ $isApproved ? 'Lihat Spreadsheet' : 'Buka Workspace RAB' }}</span>
                                <span wire:loading wire:target="editRab">Memuat...</span>
                            </button>
                            
                            @if(!$isApproved)
                                <button onclick="confirm('Yakin ingin menghapus dokumen ini?') || event.stopImmediatePropagation()" wire:click="hapusDokumenRab" class="px-6 py-3 text-xs font-bold uppercase tracking-wider rounded-lg transition-all border text-rose-500 hover:bg-rose-50 dark:border-[#2A2A2A] dark:hover:bg-rose-900/20">
                                    Hapus
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>