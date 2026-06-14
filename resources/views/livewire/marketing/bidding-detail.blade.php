<div class="min-h-screen font-sans transition-colors duration-300 overflow-x-hidden max-w-full"
     style="font-family: 'Inter', sans-serif;"
     x-data="{
         darkMode: false,
         showPreview: true,
         ratio: 40,
         previewZoom: 0.85, 
         showErrorBanner: {{ $errors->any() ? 'true' : 'false' }},
         
         triggerErrorUI() {
             this.showErrorBanner = true;
             setTimeout(() => this.showErrorBanner = false, 8000);
             this.$nextTick(() => {
                 const firstError = document.querySelector('.field-error, [data-has-error] input, [data-has-error] textarea');
                 if (firstError) {
                     firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                     setTimeout(() => {
                         if(firstError.tagName === 'INPUT' || firstError.tagName === 'TEXTAREA') {
                             firstError.focus();
                         } else {
                             const input = firstError.querySelector('input, textarea');
                             if(input) input.focus();
                         }
                     }, 400);
                 }
             });
         }
     }"
     @validation-failed.window="triggerErrorUI()"
     :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5]' : 'bg-[#F4F9F6] text-[#2A402B]'">

    @if ($errors->any())
        <div x-init="$dispatch('validation-failed')" class="hidden"></div>
    @endif

    <style>
        @keyframes shake { 0%, 100% { transform: translateX(0); } 20% { transform: translateX(-4px); } 40% { transform: translateX(4px); } 60% { transform: translateX(-3px); } 80% { transform: translateX(3px); } }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulse-red { 0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); } 50% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); } }
        @keyframes spin { to { transform: rotate(360deg); } }
        .field-error { border-color: #EF4444 !important; box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15) !important; animation: pulse-red 2s infinite, shake 0.4s ease-in-out; }
        .error-banner-enter { animation: slideDown 0.3s ease-out; }
        .spinner { animation: spin 1s linear infinite; }
        .btn-loading { position: relative; pointer-events: none; opacity: 0.85; }
        .btn-loading .btn-text { opacity: 0; }
        .btn-loading .btn-spinner { display: flex; position: absolute; inset: 0; align-items: center; justify-content: center; }
        .custom-scrollbar::-webkit-scrollbar { width: 10px; height: 10px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #B4CDBF; border-radius: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #7A9D8C; }
    </style>

    <!-- Error Banner -->
    <div x-show="showErrorBanner" style="display: none;"
         x-transition:enter="error-banner-enter"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="fixed top-0 left-0 right-0 z-[200] p-3 md:p-4">
        <div class="max-w-4xl mx-auto bg-red-500 text-white rounded-xl shadow-2xl border-2 border-red-400 p-4 flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold uppercase tracking-wide mb-1">Ada Kolom yang Belum Diisi / Tidak Valid</p>
                <p class="text-xs opacity-90">Periksa form yang ditandai merah di panel kanan sebelum melanjutkan.</p>
            </div>
            <button @click="showErrorBanner = false" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/20 transition-colors cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <div class="w-full px-4 md:px-6 py-4 max-w-full">
        <!-- TOP BAR -->
        <div class="w-full flex flex-col md:flex-row justify-between items-center mb-6 p-4 rounded-xl border shadow-lg sticky top-4 z-40 backdrop-blur-md gap-4" 
             :class="darkMode ? 'bg-[#111111]/95 border-[#2A2A2A]' : 'bg-white/90 border-[#B4CDBF]/50'">
            
            <div class="flex items-center gap-4 flex-wrap">
                <button wire:click="kembaliKeList" class="text-xs font-bold px-4 py-2.5 rounded-lg transition-colors border shadow-sm" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#4A7256] hover:border-[#4A7256]' : 'bg-[#F4F9F6] border-[#B4CDBF]/50 text-[#2A402B] hover:border-[#4A7256] hover:bg-[#E2EFE7]'">
                    &larr; KEMBALI
                </button>
                <div class="w-px h-4" :class="darkMode ? 'bg-[#333333]' : 'bg-[#B4CDBF]/50'"></div>
                
                <div class="flex gap-1 p-1 rounded-lg border shadow-sm" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333]' : 'bg-white border-[#B4CDBF]/50'">
                    <button @click="darkMode = false" :class="!darkMode ? 'bg-[#4A7256] text-white font-bold shadow-md' : 'text-[#7A9D8C] hover:text-[#4A7256]'" class="px-4 py-1.5 text-[10px] font-bold rounded-md transition-all uppercase tracking-wider">Terang</button>
                    <button @click="darkMode = true" :class="darkMode ? 'bg-[#4A7256] text-white font-bold shadow-md' : 'text-[#7A9D8C] hover:text-[#4A7256]'" class="px-4 py-1.5 text-[10px] font-bold rounded-md transition-all uppercase tracking-wider">Gelap</button>
                </div>

                <div class="flex gap-2 items-center p-1 rounded-lg border" :class="darkMode ? 'bg-[#1A1A1A] border-[#4A7256]/30' : 'bg-[#4A7256]/10 border-[#4A7256]/40'">
                    <button @click="showPreview = !showPreview; setTimeout(() => window.dispatchEvent(new Event('resize')), 300)" class="px-3 py-1.5 text-[10px] font-bold uppercase rounded-md transition-colors" :class="showPreview ? 'bg-[#4A7256] text-white shadow-sm' : 'text-[#2A402B] hover:bg-[#4A7256]/20'">
                        <span x-text="showPreview ? '👁️ Tutup PDF' : '👁️ Buka PDF'"></span>
                    </button>
                    
                    <!-- CUSTOM DROPDOWN ALPINE -->
                    <div x-show="showPreview" class="relative" x-data="{ openRatio: false }">
                        <button @click="openRatio = !openRatio" type="button" 
                                class="flex items-center gap-2 text-[10px] font-bold uppercase rounded-md px-3 py-1.5 cursor-pointer shadow-sm transition-all border-none outline-none"
                                :class="darkMode ? 'bg-[#1A1A1A] text-[#4A7256] hover:bg-[#2A2A2A]' : 'bg-white text-[#2A402B] hover:bg-gray-50'">
                            <span x-text="ratio + ' : ' + (100 - ratio)"></span>
                            <svg class="w-3 h-3 transition-transform duration-300" :class="openRatio ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <div x-show="openRatio" @click.away="openRatio = false" style="display: none;"
                             class="absolute left-0 mt-2 w-32 rounded-lg shadow-xl border z-50 overflow-hidden"
                             :class="darkMode ? 'bg-[#1A1A1A] border-[#333333]' : 'bg-white border-[#B4CDBF]/50'">
                            <template x-for="val in [20, 30, 40, 50]" :key="val">
                                <div @click="ratio = val; openRatio = false; setTimeout(() => window.dispatchEvent(new Event('resize')), 100)"
                                     class="px-4 py-2.5 text-[10px] font-bold uppercase cursor-pointer transition-colors flex justify-between items-center"
                                     :class="darkMode ? (ratio == val ? 'bg-[#4A7256]/20 text-[#4A7256]' : 'text-[#888888] hover:bg-[#333333]') : (ratio == val ? 'bg-[#E2EFE7] text-[#2A402B]' : 'text-[#648B73] hover:bg-gray-50')">
                                    <span x-text="val + ' : ' + (100 - val)"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button wire:click="simpanBidding" wire:loading.class="btn-loading" class="relative px-6 py-2.5 text-xs font-bold rounded-lg shadow-md transition-all uppercase tracking-widest flex items-center gap-2 text-white bg-[#4A7256] hover:bg-[#354F37] focus:outline-none focus:ring-4 focus:ring-[#4A7256]/30">
                    <span class="btn-text flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan & Ajukan
                    </span>
                    <span class="btn-spinner"><svg class="w-4 h-4 spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="ml-2 text-[10px]">Memproses...</span></span>
                </button>
            </div>
        </div>

        <!-- MAIN GRID (Split Screen) -->
        <div class="flex flex-col xl:flex-row gap-6 items-start w-full max-w-full relative transition-all duration-300">
            
            <!-- PANEL KIRI (LIVE PDF PREVIEW) -->
            <div x-show="showPreview"
                 :class="{ 'xl:w-[20%]': ratio == 20, 'xl:w-[30%]': ratio == 30, 'xl:w-[40%]': ratio == 40, 'xl:w-[50%]': ratio == 50 }"
                 class="w-full shrink-0 flex flex-col border rounded-xl overflow-hidden shadow-xl h-[85vh] sticky top-24 transition-all duration-300"
                 :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#B4CDBF]/50'">
                
                <div class="p-3 border-b flex justify-between items-center z-10 flex-none" :class="darkMode ? 'bg-[#1A1A1A] border-[#2A2A2A]' : 'bg-[#F4F9F6] border-[#B4CDBF]/50'">
                    <span class="text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 truncate" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#2A402B]'">
                        <svg class="w-4 h-4 shrink-0 text-[#4A7256]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Live PDF Preview
                    </span>
                    <div class="flex items-center gap-1 rounded px-1 shadow-inner border" :class="darkMode ? 'bg-[#0A0A0A] border-[#333333]' : 'bg-white border-[#B4CDBF]/50'">
                        <button @click="if(previewZoom > 0.4) previewZoom -= 0.1" class="w-5 h-5 flex items-center justify-center hover:bg-black/10 rounded font-black cursor-pointer transition-colors" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#2A402B]'">-</button>
                        <span class="text-[9px] font-mono font-black w-8 text-center" :class="darkMode ? 'text-[#4A7256]' : 'text-[#4A7256]'" x-text="Math.round(previewZoom * 100) + '%'"></span>
                        <button @click="if(previewZoom < 1.5) previewZoom += 0.1" class="w-5 h-5 flex items-center justify-center hover:bg-black/10 rounded font-black cursor-pointer transition-colors" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#2A402B]'">+</button>
                    </div>
                </div>
                
                <div class="overflow-auto flex-grow p-4 flex justify-center custom-scrollbar" :class="darkMode ? 'bg-[#323639]' : 'bg-[#323639]'">
                    <div class="transition-all duration-200 origin-top" :style="'zoom: ' + previewZoom">
                        <!-- MOCK OBJECT BIAR PREVIEW JADI REAL-TIME SAMA INPUTAN KANAN -->
                        @php
                            $mockBidding = (object) [
                                'no_penawaran' => $no_penawaran,
                                'tgl_penawaran' => $tgl_penawaran,
                                'masa_berlaku' => $masa_berlaku,
                                'total_penawaran' => $total_penawaran,
                                'nama_perusahaan' => $nama_perusahaan,
                                'email_perusahaan' => $email_perusahaan,
                                'alamat_perusahaan' => $alamat_perusahaan,
                                'term_of_payment' => $term_of_payment,
                                'surat_pengantar' => $surat_pengantar,
                                'user' => clone auth()->user() ?? (object) ['name' => $nama_penulis]
                            ];
                        @endphp
                        @include('components.dokumen-bidding', ['bidding' => $mockBidding, 'proyek' => $proyek])
                    </div>
                </div>
            </div>

            <!-- PANEL KANAN (FORM INPUT & KOMENTAR) -->
            <div :class="{ 'xl:w-[80%]': showPreview && ratio == 20, 'xl:w-[70%]': showPreview && ratio == 30, 'xl:w-[60%]': showPreview && ratio == 40, 'xl:w-[50%]': showPreview && ratio == 50, 'xl:w-full': !showPreview }"
                 class="w-full min-w-0 space-y-4 flex-grow max-w-full transition-all duration-300">
                
                <!-- IDENTITAS SURAT -->
                <div class="rounded-xl p-5 shadow-lg border flex flex-col gap-4" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#B4CDBF]/50'">
                    <h3 class="text-xs font-black uppercase tracking-widest flex items-center gap-2 border-b pb-2" :class="darkMode ? 'text-[#4A7256] border-[#2A2A2A]' : 'text-[#4A7256] border-[#B4CDBF]/50'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                        Identitas Surat Penawaran
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div @error('no_penawaran') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#648B73]'">No. Dokumen <span class="text-red-500">*</span></label>
                            <input type="text" wire:model.live.blur="no_penawaran" class="w-full text-xs p-2.5 rounded-lg border outline-none font-mono font-bold focus:ring-2 focus:ring-[#4A7256]/30 focus:border-[#4A7256] transition-all @error('no_penawaran') field-error @enderror" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#F4F9F6] border-[#B4CDBF]/50 text-[#2A402B]'">
                            @error('no_penawaran') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div @error('tgl_penawaran') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#648B73]'">Tanggal Terbit <span class="text-red-500">*</span></label>
                            <input type="date" wire:model.live.blur="tgl_penawaran" class="w-full text-xs p-2.5 rounded-lg border outline-none font-bold focus:ring-2 focus:ring-[#4A7256]/30 focus:border-[#4A7256] transition-all @error('tgl_penawaran') field-error @enderror" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#F4F9F6] border-[#B4CDBF]/50 text-[#2A402B]'">
                            @error('tgl_penawaran') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div @error('masa_berlaku') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#648B73]'">Masa Berlaku</label>
                            <input type="text" wire:model.live.blur="masa_berlaku" class="w-full text-xs p-2.5 rounded-lg border outline-none font-bold focus:ring-2 focus:ring-[#4A7256]/30 focus:border-[#4A7256] transition-all @error('masa_berlaku') field-error @enderror" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#F4F9F6] border-[#B4CDBF]/50 text-[#2A402B]'">
                            @error('masa_berlaku') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div @error('total_penawaran') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#648B73]'">Grand Total (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" wire:model.live.blur="total_penawaran" class="w-full text-xs p-2.5 rounded-lg border outline-none font-mono font-black text-[#4A7256] focus:ring-2 focus:ring-[#4A7256]/30 focus:border-[#4A7256] transition-all @error('total_penawaran') field-error @enderror" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333]' : 'bg-[#E2EFE7] border-[#B4CDBF]/50'">
                            @error('total_penawaran') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- INFO KLIEN & KETENTUAN -->
                <div class="rounded-xl p-5 shadow-lg border" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#B4CDBF]/50'">
                    <h3 class="text-xs font-black uppercase tracking-widest flex items-center gap-2 border-b pb-2 mb-4" :class="darkMode ? 'text-[#4A7256] border-[#2A2A2A]' : 'text-[#4A7256] border-[#B4CDBF]/50'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Informasi Klien & Term Of Payment
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div @error('nama_perusahaan') data-has-error @enderror>
                                <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#648B73]'">Nama Klien / Perusahaan <span class="text-red-500">*</span></label>
                                <input type="text" wire:model.live.blur="nama_perusahaan" class="w-full text-xs p-2.5 rounded-lg border outline-none font-bold focus:ring-2 focus:ring-[#4A7256]/30 focus:border-[#4A7256] transition-all @error('nama_perusahaan') field-error @enderror" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#F4F9F6] border-[#B4CDBF]/50 text-[#2A402B]'">
                                @error('nama_perusahaan') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                            </div>
                            <div @error('alamat_perusahaan') data-has-error @enderror>
                                <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#648B73]'">Alamat Klien</label>
                                <textarea wire:model.live.blur="alamat_perusahaan" rows="2" class="w-full text-xs p-2.5 rounded-lg border outline-none focus:ring-2 focus:ring-[#4A7256]/30 focus:border-[#4A7256] transition-all @error('alamat_perusahaan') field-error @enderror" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#F4F9F6] border-[#B4CDBF]/50 text-[#2A402B]'"></textarea>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div @error('term_of_payment') data-has-error @enderror>
                                <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#648B73]'">Sistem Pembayaran (Term of Payment)</label>
                                <textarea wire:model.live.blur="term_of_payment" rows="4" class="w-full text-xs p-2.5 rounded-lg border outline-none focus:ring-2 focus:ring-[#4A7256]/30 focus:border-[#4A7256] transition-all @error('term_of_payment') field-error @enderror" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#F4F9F6] border-[#B4CDBF]/50 text-[#2A402B]'"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SURAT PENGANTAR -->
                <div class="rounded-xl p-5 shadow-lg border" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#B4CDBF]/50'">
                    <h3 class="text-xs font-black uppercase tracking-widest flex items-center gap-2 border-b pb-2 mb-4" :class="darkMode ? 'text-[#4A7256] border-[#2A2A2A]' : 'text-[#4A7256] border-[#B4CDBF]/50'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Paragraf Surat Pengantar
                    </h3>
                    <div @error('surat_pengantar') data-has-error @enderror>
                        <textarea wire:model.live.blur="surat_pengantar" rows="4" class="w-full text-xs p-3 rounded-lg border outline-none focus:ring-2 focus:ring-[#4A7256]/30 focus:border-[#4A7256] transition-all @error('surat_pengantar') field-error @enderror" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#F4F9F6] border-[#B4CDBF]/50 text-[#2A402B]'"></textarea>
                    </div>
                </div>

                <!-- OTORISASI & COMMIT -->
                <div class="rounded-xl p-5 shadow-lg border mt-4" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-[#E2EFE7]/50 border-[#4A7256]/30'">
                    <h3 class="text-xs font-black uppercase tracking-widest text-[#4A7256] mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Otorisasi Pengajuan & Log Revisi
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-start">
                        <div class="sm:col-span-1" @error('nama_penulis') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#648B73]'">Nama Penyusun <span class="text-red-500">*</span></label>
                            <input type="text" wire:model.live.blur="nama_penulis" placeholder="Nama Estimator..." class="w-full text-xs font-bold p-3 rounded-lg border outline-none shadow-inner focus:ring-2 focus:ring-[#4A7256]/30 focus:border-[#4A7256] transition-all @error('nama_penulis') field-error @enderror" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-white border-[#B4CDBF]/50 text-[#2A402B]'">
                            @error('nama_penulis') <span class="text-red-500 text-[10px] font-bold mt-1.5 block">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div class="sm:col-span-2" @error('komentar_commit') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#648B73]'">Catatan Pengajuan / Revisi <span class="text-red-500">*</span></label>
                            <input type="text" wire:model.live.blur="komentar_commit" placeholder="Misal: Revisi nominal pajak, penyesuaian term of payment..." class="w-full text-xs font-bold p-3 rounded-lg border outline-none shadow-inner focus:ring-2 focus:ring-[#4A7256]/30 focus:border-[#4A7256] transition-all @error('komentar_commit') field-error @enderror" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-white border-[#B4CDBF]/50 text-[#2A402B]'">
                            @error('komentar_commit') <span class="text-red-500 text-[10px] font-bold mt-1.5 block">⚠ {{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- HISTORI LOG LIST -->
                @if(count($historiRevisi) > 0)
                <div class="mt-6">
                    <h4 class="text-[10px] font-black uppercase tracking-widest mb-3" :class="darkMode ? 'text-[#888888]' : 'text-[#648B73]'">Histori Perubahan Dokumen</h4>
                    <div class="space-y-3">
                        @foreach($historiRevisi as $histori)
                            <div class="p-3 rounded-xl border flex gap-3 text-xs" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333]' : 'bg-white border-[#B4CDBF]/30'">
                                <div class="w-8 h-8 rounded bg-[#4A7256]/10 text-[#4A7256] flex items-center justify-center font-bold uppercase shrink-0">
                                    {{ substr($histori->user_name ?? 'U', 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-bold mb-0.5" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#2A402B]'">{{ $histori->user_name }} <span class="opacity-50 text-[9px] ml-2 font-mono">{{ $histori->created_at->format('d M Y H:i') }}</span></p>
                                    <p :class="darkMode ? 'text-[#888888]' : 'text-[#648B73]'">"{{ $histori->komentar_commit }}"</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>