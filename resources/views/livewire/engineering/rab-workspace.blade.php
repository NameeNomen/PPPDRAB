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
     :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5]' : 'bg-[#FAFAFA] text-[#1A1A1A]'">

    @if ($errors->any())
        <div x-init="$dispatch('validation-failed')" class="hidden"></div>
    @endif

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-4px); }
            40% { transform: translateX(4px); }
            60% { transform: translateX(-3px); }
            80% { transform: translateX(3px); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-red {
            0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            50% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .field-error {
            border-color: #EF4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15) !important;
            animation: pulse-red 2s infinite, shake 0.4s ease-in-out;
        }
        .field-error:focus {
            border-color: #EF4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25) !important;
        }
        .error-banner-enter {
            animation: slideDown 0.3s ease-out;
        }
        .spinner {
            animation: spin 1s linear infinite;
        }
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.85;
        }
        .btn-loading .btn-text { opacity: 0; }
        .btn-loading .btn-spinner { display: flex; }
        .btn-spinner {
            display: none;
            position: absolute;
            inset: 0;
            align-items: center;
            justify-content: center;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 10px; height: 10px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

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
                <p class="text-xs opacity-90">Silakan periksa field yang ditandai merah dan lengkapi sebelum melanjutkan.</p>
            </div>
            <button @click="showErrorBanner = false" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/20 transition-colors cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <div class="w-full px-4 md:px-6 py-4 max-w-full">

        <div class="w-full flex flex-col md:flex-row justify-between items-center mb-6 p-4 rounded-xl border-2 shadow-xl sticky top-4 z-40 backdrop-blur-md gap-4" :class="darkMode ? 'bg-[#111111]/95 border-[#2A2A2A]' : 'bg-white/95 border-[#E5E5E5]'">
            <div class="flex items-center gap-4 flex-wrap">
                <button wire:click="kembaliKeList" class="text-xs font-bold px-4 py-2.5 rounded-lg transition-colors border-2 shadow-sm" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5C518] hover:border-[#F5C518]' : 'bg-white border-[#E5E5E5] text-[#1A1A1A] hover:border-[#F5C518] hover:bg-[#F5C518]/10'">
                    &larr; KEMBALI
                </button>
                <div class="w-px h-4" :class="darkMode ? 'bg-[#333333]' : 'bg-[#E5E5E5]'" style="display: block;"></div>
                
                <div class="flex gap-1 p-1 rounded-lg border-2 shadow-sm" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333]' : 'bg-white border-[#E5E5E5]'">
                    <button @click="darkMode = false" :class="!darkMode ? 'bg-[#F5C518] text-[#1A1A1A] font-bold shadow-md' : 'text-[#888888] hover:text-[#F5C518]'" class="px-4 py-1.5 text-[10px] font-bold rounded-md transition-all uppercase tracking-wider">Terang</button>
                    <button @click="darkMode = true" :class="darkMode ? 'bg-[#F5C518] text-[#1A1A1A] font-bold shadow-md' : 'text-[#888888] hover:text-[#F5C518]'" class="px-4 py-1.5 text-[10px] font-bold rounded-md transition-all uppercase tracking-wider">Gelap</button>
                </div>

                <div class="flex gap-2 items-center p-1 rounded-lg border-2" :class="darkMode ? 'bg-[#1A1A1A] border-[#F5C518]/30' : 'bg-[#F5C518]/10 border-[#F5C518]/40'">
                    <button @click="showPreview = !showPreview; setTimeout(() => window.dispatchEvent(new Event('resize')), 300)" class="px-3 py-1.5 text-[10px] font-bold uppercase rounded-md transition-colors" :class="showPreview ? 'bg-[#F5C518] text-[#1A1A1A] shadow-sm' : 'text-[#1A1A1A] hover:bg-[#F5C518]/20'">
                        <span x-text="showPreview ? '👁️ Sembunyikan TOR' : '👁️ Tampilkan TOR'"></span>
                    </button>
                    
                    <div x-show="showPreview" class="relative" x-data="{ openRatio: false }">
                        <button @click="openRatio = !openRatio" type="button" 
                                class="flex items-center gap-2 text-[10px] font-bold uppercase rounded-md px-3 py-1.5 cursor-pointer shadow-sm transition-all border-none outline-none"
                                :class="darkMode ? 'bg-[#1A1A1A] text-[#F5C518] hover:bg-[#2A2A2A]' : 'bg-white text-[#1A1A1A] hover:bg-gray-50'">
                            <span x-text="ratio + ' : ' + (100 - ratio)"></span>
                            <svg class="w-3 h-3 transition-transform duration-300" :class="openRatio ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <div x-show="openRatio" @click.away="openRatio = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                             class="absolute left-0 mt-2 w-32 rounded-lg shadow-xl border-2 z-50 overflow-hidden"
                             :class="darkMode ? 'bg-[#1A1A1A] border-[#333333]' : 'bg-white border-[#E5E5E5]'"
                             style="display: none;">
                            <template x-for="val in [20, 30, 40, 50]" :key="val">
                                <div @click="ratio = val; openRatio = false; setTimeout(() => window.dispatchEvent(new Event('resize')), 100)"
                                     class="px-4 py-2.5 text-[10px] font-bold uppercase cursor-pointer transition-colors flex justify-between items-center"
                                     :class="darkMode ? (ratio == val ? 'bg-[#F5C518]/20 text-[#F5C518]' : 'text-[#888888] hover:bg-[#333333] hover:text-[#F5F5F5]') : (ratio == val ? 'bg-[#F5C518]/10 text-[#1A1A1A]' : 'text-[#666666] hover:bg-gray-50 hover:text-[#1A1A1A]')">
                                    <span x-text="val + ' : ' + (100 - val)"></span>
                                    <svg x-show="ratio == val" class="w-3 h-3" :class="darkMode ? 'text-[#F5C518]' : 'text-[#1A1A1A]'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </template>
                        </div>
                    </div>
                    </div>
            </div>

            <div class="flex items-center gap-3">
                @if(!$isApproved)
                    <button wire:click="submitKeDirektur" wire:loading.class="btn-loading" class="relative px-6 py-2.5 text-xs font-bold rounded-lg shadow-lg transition-all uppercase tracking-widest flex items-center gap-2 text-[#1A1A1A] bg-[#F5C518] hover:bg-[#FFD700] hover:shadow-xl hover:shadow-[#F5C518]/30 focus:outline-none focus:ring-4 focus:ring-[#F5C518]/30">
                        <span class="btn-text flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Submit Ke Direktur
                        </span>
                        <span class="btn-spinner">
                            <svg class="w-4 h-4 spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span class="ml-2 text-[10px]">Memproses...</span>
                        </span>
                    </button>
                @else
                    <span class="px-4 py-2.5 text-xs font-bold uppercase tracking-widest rounded-lg bg-[#F5C518]/15 text-[#1A1A1A] border-2 border-[#F5C518]/50 shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        DOKUMEN APPROVED
                    </span>
                @endif
            </div>
        </div>

        <div class="flex flex-col xl:flex-row gap-6 items-start w-full max-w-full relative transition-all duration-300">
            
            <div x-show="showPreview"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-x-10"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 -translate-x-10"
                 :class="{
                     'xl:w-[20%]': ratio == 20,
                     'xl:w-[30%]': ratio == 30,
                     'xl:w-[40%]': ratio == 40,
                     'xl:w-[50%]': ratio == 50
                 }"
                 class="w-full shrink-0 flex flex-col border-2 rounded-xl overflow-hidden shadow-xl h-[85vh] sticky top-24 transition-all duration-300 origin-left"
                 :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                
                <div class="p-3 border-b-2 flex justify-between items-center z-10 flex-none bg-[#F5C518] border-[#F5C518]">
                    <span class="text-[10px] font-bold text-[#1A1A1A] uppercase tracking-widest flex items-center gap-2 truncate">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Acuan Marketing
                    </span>
                    
                    <div class="flex items-center gap-1 bg-black/10 rounded px-1 shadow-inner">
                        <button @click="if(previewZoom > 0.4) previewZoom -= 0.1" class="w-5 h-5 flex items-center justify-center hover:bg-white/40 rounded text-[#1A1A1A] font-black cursor-pointer transition-colors">-</button>
                        <span class="text-[9px] font-mono font-black text-[#1A1A1A] w-8 text-center" x-text="Math.round(previewZoom * 100) + '%'"></span>
                        <button @click="if(previewZoom < 1.5) previewZoom += 0.1" class="w-5 h-5 flex items-center justify-center hover:bg-white/40 rounded text-[#1A1A1A] font-black cursor-pointer transition-colors">+</button>
                    </div>
                </div>
                
                <div class="overflow-auto flex-grow p-4 flex justify-center custom-scrollbar" :class="darkMode ? 'bg-[#0A0A0A]' : 'bg-[#E5E5E5]'">
                    <div class="transition-all duration-200 origin-top" :style="'zoom: ' + previewZoom">
                        <div class="shadow-xl" :class="darkMode ? 'bg-[#111111]' : 'bg-white'">
                            @include('components.dokumen-inisiasi', ['proyek' => $selectedProject])
                        </div>
                    </div>
                </div>
            </div>

            <div :class="{
                     'xl:w-[80%]': showPreview && ratio == 20,
                     'xl:w-[70%]': showPreview && ratio == 30,
                     'xl:w-[60%]': showPreview && ratio == 40,
                     'xl:w-[50%]': showPreview && ratio == 50,
                     'xl:w-full': !showPreview
                 }"
                 class="w-full min-w-0 space-y-4 flex-grow max-w-full transition-all duration-300">
                
                <div class="rounded-xl p-4 shadow-xl border-2 flex flex-col sm:flex-row justify-between gap-4" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                    <div class="flex gap-4 flex-grow">
                        <div class="w-1/2" @error('no_boq') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#888888]'">NO. BOQ REF</label>
                            <input type="text" wire:model.live.blur="no_boq" id="field-no_boq" {{ $isApproved ? 'disabled' : '' }} class="w-full text-xs p-2.5 rounded-lg border-2 outline-none font-mono font-bold shadow-inner focus:ring-2 focus:ring-[#F5C518]/50 focus:border-[#F5C518] transition-all @error('no_boq') field-error @enderror" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'">
                            @error('no_boq') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div class="w-1/2">
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#888888]'">TANGGAL UPDATE</label>
                            <input type="text" readonly value="{{ \Carbon\Carbon::parse($tanggal_dokumen)->format('d F Y') }}" class="w-full text-xs p-2.5 rounded-lg border-2 opacity-60 font-bold" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'">
                        </div>
                    </div>
                    
                    @if(!$isApproved)
                        <div class="flex items-end shrink-0">
                            <button wire:click="$set('showRequestModal', true)" class="w-full sm:w-auto px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-lg shadow-md transition-all flex items-center gap-2 text-white bg-red-500 hover:bg-red-600 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-red-500/30">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                Request Material Baru
                            </button>
                        </div>
                    @endif
                </div>

                <div class="rounded-xl border-2 shadow-xl overflow-hidden max-w-full" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                    <div class="overflow-x-auto w-full max-w-full">
                        <table class="w-full text-left text-[11px] border-collapse table-fixed min-w-[700px]">
                            <thead class="border-b-2" :class="darkMode ? 'bg-[#1A1A1A] border-[#2A2A2A]' : 'bg-[#FAFAFA] border-[#E5E5E5]'">
                                <tr>
                                    <th class="px-2 py-3 text-center w-[6%] border-r" :class="darkMode ? 'text-[#888888] border-[#2A2A2A]' : 'text-[#666666] border-[#E5E5E5]'">NO</th>
                                    <th class="px-3 py-3 w-[46%] border-r" :class="darkMode ? 'text-[#888888] border-[#2A2A2A]' : 'text-[#666666] border-[#E5E5E5]'">URAIAN PEKERJAAN / MATERIAL SPECIFICATION <span class="block text-[9px] font-normal opacity-50 mt-0.5">(Klik 2x teks untuk edit)</span></th>
                                    <th class="px-2 py-3 text-center w-[10%] border-r" :class="darkMode ? 'text-[#888888] border-[#2A2A2A]' : 'text-[#666666] border-[#E5E5E5]'">QTY</th>
                                    <th class="px-2 py-3 text-center w-[10%] border-r" :class="darkMode ? 'text-[#888888] border-[#2A2A2A]' : 'text-[#666666] border-[#E5E5E5]'">SAT</th>
                                    <th class="px-3 py-3 text-right w-[14%] border-r" :class="darkMode ? 'text-[#888888] border-[#2A2A2A]' : 'text-[#666666] border-[#E5E5E5]'">HARGA</th>
                                    <th class="px-3 py-3 text-right w-[16%]" :class="darkMode ? 'text-[#888888] border-[#2A2A2A]' : 'text-[#666666] border-[#E5E5E5]'">JUMLAH (RP)</th>
                                    @if(!$isApproved) <th class="w-[10%] text-center" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">AKSI</th> @endif
                                </tr>
                            </thead>
                            
                            <tbody class="divide-y" :class="darkMode ? 'divide-[#2A2A2A]' : 'divide-[#E5E5E5]'">
                                @php $alphabet = range('A', 'Z'); @endphp
                                
                                @foreach($kategoris as $indexKat => $kat)
                                    <tr class="font-black uppercase tracking-wider" :class="darkMode ? 'bg-[#F5C518]/5 text-[#F5F5F5]' : 'bg-[#F5C518]/10 text-[#1A1A1A]'">
                                        <td class="px-2 py-2.5 text-center border-r" :class="darkMode ? 'border-[#333333]' : 'border-[#E5E5E5]'">{{ $alphabet[$indexKat] ?? ($indexKat+1) }}.</td>
                                        
                                        <td class="px-3 py-2.5 border-r relative" :class="darkMode ? 'border-[#333333]' : 'border-[#E5E5E5]'" colspan="4" x-data="{ editing: false, deskripsi: '{{ addslashes($kat->deskripsi_pekerjaan) }}' }">
                                            <div x-show="!editing" @dblclick="{{ !$isApproved ? 'editing = true' : '' }}" class="cursor-pointer truncate">{{ $kat->deskripsi_pekerjaan }}</div>
                                            @if(!$isApproved)
                                                <input x-show="editing" x-model="deskripsi" x-trap="editing"
                                                       @keydown.enter="editing = false; $wire.updateInline({{ $kat->id }}, 'deskripsi_pekerjaan', deskripsi)"
                                                       @click.away="editing = false; $wire.updateInline({{ $kat->id }}, 'deskripsi_pekerjaan', deskripsi)"
                                                       class="w-full px-2 py-0.5 outline-none rounded border-2 font-black text-[11px]"
                                                       :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5] border-[#F5C518]' : 'bg-white text-[#1A1A1A] border-[#F5C518]'">
                                            @endif
                                            <div wire:loading wire:target="updateInline({{ $kat->id }}, 'deskripsi_pekerjaan', deskripsi)" class="absolute right-2 top-2">
                                                <span class="flex h-2 w-2 relative">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#F5C518] opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#F5C518]"></span>
                                                </span>
                                            </div>
                                        </td>
                                        
                                        @php
                                            $subtotalKat = $kat->children->sum(function($child) {
                                                return $child->children->count() > 0 ? $child->children->sum('subtotal') : $child->subtotal;
                                            });
                                        @endphp
                                        <td class="px-3 py-2.5 text-right font-mono text-[11px] border-r" :class="darkMode ? 'text-[#F5F5F5] border-[#333333]' : 'text-[#1A1A1A] border-[#E5E5E5]'">{{ number_format($subtotalKat, 0, ',', '.') }}</td>
                                        
                                        @if(!$isApproved)
                                            <td class="text-center p-1 flex justify-center gap-1">
                                                <button wire:click="tambahSubBab({{ $kat->id }})" wire:loading.class="btn-loading" class="relative px-2 py-1 rounded text-[10px] font-black border-2 transition-colors" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5C518] hover:bg-[#F5C518] hover:text-[#1A1A1A]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#F5C518] hover:bg-[#F5C518] hover:text-[#1A1A1A]'" title="Tambah Sub Bab Pekerjaan">
                                                    <span class="btn-text" >↳ +</span>
                                                    <span class="btn-spinner"><svg class="w-3 h-3 spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg></span>
                                                </button>
                                                <button wire:click="hapusItem({{ $kat->id }})" wire:loading.class="btn-loading" class="relative px-2 py-1 rounded text-[10px] border-2 transition-colors text-red-500 hover:bg-red-500 hover:text-white" :class="darkMode ? 'border-[#333333]' : 'border-[#E5E5E5]'">
                                                    <span class="btn-text">&times;</span>
                                                    <span class="btn-spinner"><svg class="w-3 h-3 spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg></span>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                    
                                    @php $itemNo = 1; @endphp
@foreach($kat->children as $item)
<tr class="font-semibold relative" :class="darkMode ? 'bg-[#111111] text-[#F5F5F5]' : 'bg-white text-[#1A1A1A]'">
    <td class="px-2 py-2 text-center border-r font-mono" :class="darkMode ? 'text-[#888888] border-[#2A2A2A]' : 'text-[#888888] border-[#E5E5E5]'">{{ $itemNo++ }}</td>

    <td class="px-3 py-2 border-r pl-6 relative" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'" x-data="{ editing: false, deskripsi: '{{ addslashes($item->deskripsi_pekerjaan) }}' }">
        <div class="w-full">
            <div x-show="!editing" @dblclick="{{ !$isApproved ? 'editing = true' : '' }}" class="cursor-pointer break-words">{{ $item->deskripsi_pekerjaan }}</div>
            @if(!$isApproved)
                <input x-show="editing" x-model="deskripsi" x-trap="editing"
                       @keydown.enter="editing = false; $wire.updateInline({{ $item->id }}, 'deskripsi_pekerjaan', deskripsi)"
                       @click.away="editing = false; $wire.updateInline({{ $item->id }}, 'deskripsi_pekerjaan', deskripsi)"
                       class="w-full px-2 py-0.5 outline-none rounded border-2 text-[11px]"
                       :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5] border-[#F5C518]' : 'bg-[#FAFAFA] text-[#1A1A1A] border-[#F5C518]'">
            @endif

            @if(!$isApproved)
                <div class="mt-1 relative" x-data="{ open: false }">
                    @if($item->id_material)
                        <span class="text-[9px] font-normal px-1.5 py-0.5 rounded cursor-pointer border" :class="darkMode ? 'text-[#F5C518] bg-[#F5C518]/20 border-[#F5C518]/40' : 'text-[#1A1A1A] bg-[#F5C518]/20 border-[#F5C518]/40'" @click="open = !open; $wire.aktifkanPencarianMaterial({{ $item->id }})">
                            📦 {{ $item->material->nama_barang }} (Ganti) &rarr;
                        </span>
                    @else
                        <button class="text-[9px] font-bold px-1.5 py-0.5 rounded border transition-colors" :class="darkMode ? 'text-[#F5C518] bg-[#F5C518]/30 border-[#F5C518]/50 hover:bg-[#F5C518] hover:text-[#1A1A1A]' : 'text-[#1A1A1A] bg-[#F5C518]/30 border-[#F5C518]/50 hover:bg-[#F5C518]'" @click="open = !open; $wire.aktifkanPencarianMaterial({{ $item->id }})">
                            + Hubungkan DB Material
                        </button>
                    @endif

                    @if($searchMaterialId == $item->id)
                        <div class="absolute left-0 mt-1 z-50 w-[450px] p-3 border-2 rounded-lg shadow-2xl"
                             :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'"
                             @click.away="$wire.set('searchMaterialId', null)">
                            
                            <div class="relative mb-3">
                                <input type="text"
                                       wire:model.live.debounce.300ms="materialSearchKeyword"
                                       placeholder="Cari nama material, merk, atau spesifikasi..."
                                       class="w-full p-2.5 text-xs border-2 rounded-lg outline-none focus:border-[#F5C518] pr-10"
                                       :class="darkMode ? 'bg-[#0A0A0A] border-[#2A2A2A] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'">
                                <div wire:loading wire:target="materialSearchKeyword" class="absolute right-3 top-2.5">
                                    <svg class="w-4 h-4 spinner text-[#F5C518]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                </div>
                            </div>

                            <div class="max-h-64 overflow-y-auto custom-scrollbar">
                                @if(count($materialResults) > 0)
                                    <table class="w-full text-[10px]">
                                        <thead class="sticky top-0" :class="darkMode ? 'bg-[#1A1A1A]' : 'bg-[#F5C518]/20'">
                                            <tr>
                                                <th class="text-left p-2 font-bold" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">MATERIAL</th>
                                                <th class="text-center p-2 font-bold" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">QTY</th>
                                                <th class="text-right p-2 font-bold" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">HARGA</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y" :class="darkMode ? 'divide-[#2A2A2A]' : 'divide-[#E5E5E5]'">
                                            @foreach($materialResults as $m)
                                                <tr wire:click="pilihMaterial({{ $item->id }}, {{ $m->id }})" class="cursor-pointer transition-colors" :class="darkMode ? 'hover:bg-[#F5C518]/10' : 'hover:bg-[#F5C518]/10'">
                                                    <td class="p-2">
                                                        <p class="font-bold mb-0.5" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">{{ $m->nama_barang }}</p>
                                                        <p class="text-[9px] opacity-70 mb-1" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">{{ $m->deskripsi }}</p>
                                                    </td>
                                                    <td class="p-2 text-center">
                                                        <span class="px-2 py-1 rounded font-mono text-[9px]" :class="darkMode ? 'bg-[#1A1A1A] text-[#F5C518]' : 'bg-[#F5C518]/10 text-[#1A1A1A]'">{{ $m->jumlah }} {{ $m->satuan }}</span>
                                                    </td>
                                                    <td class="p-2 text-right">
                                                        <p class="font-bold font-mono" :class="darkMode ? 'text-[#F5C518]' : 'text-[#F5C518]'">Rp {{ number_format($m->harga, 0, ',', '.') }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @elseif(strlen($materialSearchKeyword) >= 2)
                                    <div class="p-4 text-center text-xs" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">Material tidak ditemukan</div>
                                @else
                                    <div class="p-4 text-center text-xs" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">Ketik min 2 karakter untuk mencari</div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @else
                @if($item->material) <span class="block text-[9px] font-normal mt-1" :class="darkMode ? 'text-[#888888]' : 'text-[#888888]'">Spec: {{ $item->material->nama_barang }}</span> @endif
            @endif
        </div>
    </td>

    @if($item->children->count() > 0)
        <td class="px-2 py-2 border-r text-center opacity-40 text-[9px] italic" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'" colspan="3">(Dirinci di bawah)</td>
        <td class="px-3 py-2 text-right font-mono font-black border-r" :class="darkMode ? 'text-[#F5C518] border-[#2A2A2A]' : 'text-[#F5C518] border-[#E5E5E5]'">{{ number_format($item->children->sum('subtotal'), 0, ',', '.') }}</td>
    @else
        <td class="px-2 py-2 text-center border-r font-mono" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'" 
            wire:key="qty-item-{{ $item->id }}-{{ $item->qty }}" 
            x-data="{ editing: false, qty: '{{ $item->qty }}' }">
            <div x-show="!editing" @dblclick="{{ !$isApproved ? 'editing = true' : '' }}" class="cursor-pointer font-bold rounded transition-colors" :class="darkMode ? 'hover:bg-[#F5C518]/10' : 'hover:bg-[#F5C518]/10'">{{ $item->qty }}</div>
            @if(!$isApproved)
                <input type="number" step="0.01" x-show="editing" x-model="qty" @keydown.enter="editing = false; $wire.updateInline({{ $item->id }}, 'qty', qty)" @click.away="editing = false; $wire.updateInline({{ $item->id }}, 'qty', qty)" class="w-full text-center outline-none border-2 rounded text-xs shadow-sm" :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5] border-[#F5C518]' : 'bg-white text-[#1A1A1A] border-[#F5C518]'">
            @endif
        </td>

        <td class="px-2 py-2 text-center border-r opacity-70 uppercase font-mono" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">{{ $item->material->satuan ?? 'Lot' }}</td>

        <td class="px-3 py-2 text-right border-r font-mono" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'" 
            wire:key="harga-item-{{ $item->id }}-{{ $item->harga_awal }}" 
            x-data="{ editing: false, harga: '{{ $item->harga_awal }}' }">
            <div x-show="!editing" @dblclick="{{ !$isApproved ? 'editing = true' : '' }}" class="cursor-pointer rounded transition-colors" :class="darkMode ? 'hover:bg-[#F5C518]/10' : 'hover:bg-[#F5C518]/10'">{{ number_format($item->harga_awal, 0, ',', '.') }}</div>
            @if(!$isApproved)
                <input type="number" x-show="editing" x-model="harga" @keydown.enter="editing = false; $wire.updateInline({{ $item->id }}, 'harga_awal', harga)" @click.away="editing = false; $wire.updateInline({{ $item->id }}, 'harga_awal', harga)" class="w-full text-right outline-none border-2 rounded text-xs shadow-sm" :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5] border-[#F5C518]' : 'bg-white text-[#1A1A1A] border-[#F5C518]'">
            @endif
        </td>

        <td class="px-3 py-2 text-right font-mono font-black border-r" :class="darkMode ? 'text-[#1A1A1A] border-[#2A2A2A]' : 'text-[#1A1A1A] border-[#E5E5E5]'">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
    @endif

    @if(!$isApproved)
        <td class="text-center p-1 flex justify-center gap-1">
            <button wire:click="tambahSubSubBab({{ $item->id }})" wire:loading.class="btn-loading" class="relative px-2 py-0.5 rounded text-[9px] font-black border-2 transition-colors" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-red-500 hover:bg-red-500 hover:text-white' : 'bg-[#FAFAFA] border-[#E5E5E5] text-red-500 hover:bg-red-500 hover:text-white'" title="Tambah Sub-sub Bab Material">
                <span class="btn-text">&#8627;&#8627; +</span>
                <span class="btn-spinner"><svg class="w-3 h-3 spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg></span>
            </button>
            <button wire:click="hapusItem({{ $item->id }})" wire:loading.class="btn-loading" class="relative font-bold transition-colors" :class="darkMode ? 'text-[#888888] hover:text-red-500' : 'text-[#888888] hover:text-red-500'">
                <span class="btn-text">&times;</span>
                <span class="btn-spinner"><svg class="w-3 h-3 spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg></span>
            </button>
        </td>
    @endif
</tr> 
                                        
                                        @foreach($item->children as $sub)
    <tr class="text-[10px] border-b" :class="darkMode ? 'bg-[#0A0A0A] text-[#888888] border-[#2A2A2A]' : 'bg-[#FAFAFA] text-[#666666] border-[#E5E5E5]'">
        
        <td class="border-r text-right pr-2 text-red-500 font-bold opacity-50" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">&#8627;&#8627;</td>
        
        <td class="px-3 py-1.5 border-r pl-10" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'" x-data="{ editing: false, deskripsi: '{{ addslashes($sub->deskripsi_pekerjaan) }}' }">
            <div class="w-full">
                <span x-show="!editing" @dblclick="{{ !$isApproved ? 'editing = true' : '' }}" class="cursor-pointer break-words block">- {{ $sub->deskripsi_pekerjaan }}</span>
                @if(!$isApproved)
                    <input x-show="editing" x-model="deskripsi" x-trap="editing"
                           @keydown.enter="editing = false; $wire.updateInline({{ $sub->id }}, 'deskripsi_pekerjaan', deskripsi)"
                           @click.away="editing = false; $wire.updateInline({{ $sub->id }}, 'deskripsi_pekerjaan', deskripsi)"
                           class="w-full px-2 py-0.5 outline-none rounded border-2 text-[10px]"
                           :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5] border-[#F5C518]' : 'bg-white text-[#1A1A1A] border-[#F5C518]'">
                @endif
                
                @if(!$isApproved)
                    <div class="mt-0.5 relative" x-data="{ open: false }">
                        @if($sub->id_material)
                            <span class="text-[8px] font-normal cursor-pointer" :class="darkMode ? 'text-[#F5C518]' : 'text-[#1A1A1A]'" @click="open = !open; $wire.aktifkanPencarianMaterial({{ $sub->id }})">
                                [Mat: {{ $sub->material->nama_barang }}]
                            </span>
                        @else
                            <button class="text-[8px] font-bold hover:underline" :class="darkMode ? 'text-[#F5C518]' : 'text-[#1A1A1A]'" @click="open = !open; $wire.aktifkanPencarianMaterial({{ $sub->id }})">
                                + Set Material
                            </button>
                        @endif

                        @if($searchMaterialId == $sub->id)
                            <div class="absolute left-0 mt-1 z-50 w-[250px] p-2 border-2 rounded-lg shadow-xl" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'" @click.away="$wire.set('searchMaterialId', null)">
                                <input type="text" wire:model.live.debounce.200ms="materialSearchKeyword" placeholder="Cari..." class="w-full p-1 text-[9px] border-2 rounded outline-none focus:border-[#F5C518]" :class="darkMode ? 'bg-[#0A0A0A] border-[#2A2A2A] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'">
                                <div class="mt-1 max-h-32 overflow-y-auto divide-y custom-scrollbar" :class="darkMode ? 'divide-[#2A2A2A]' : 'divide-[#E5E5E5]'">
                                    @foreach($materialResults as $m)
                                        <div wire:click="pilihMaterial({{ $sub->id }}, {{ $m->id }})" class="p-1 text-[8px] cursor-pointer" :class="darkMode ? 'hover:bg-[#F5C518]/10' : 'hover:bg-[#F5C518]/10'">
                                            <p class="font-bold m-0" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">{{ $m->nama_barang }}</p>
                                            <p class="m-0" :class="darkMode ? 'text-[#888888]' : 'text-[#888888]'">Rp {{ number_format($m->harga,0,',','.') }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    @if($sub->material) <span class="block text-[8px] opacity-60 mt-0.5" :class="darkMode ? 'text-[#F5C518]' : 'text-[#F5C518]'">[Mat: {{ $sub->material->nama_barang }}]</span> @endif
                @endif
            </div>
        </td>
        
        <td class="px-2 py-1.5 border-r text-center font-mono" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'" 
            wire:key="qty-sub-{{ $sub->id }}-{{ $sub->qty }}" 
            x-data="{ editing: false, qty: '{{ $sub->qty }}' }">
            <div x-show="!editing" @dblclick="{{ !$isApproved ? 'editing = true' : '' }}" class="cursor-pointer rounded transition-colors" :class="darkMode ? 'hover:bg-[#F5C518]/10' : 'hover:bg-[#F5C518]/10'">{{ $sub->qty }}</div>
            @if(!$isApproved)
                <input type="number" step="0.01" x-show="editing" x-model="qty" @keydown.enter="editing = false; $wire.updateInline({{ $sub->id }}, 'qty', qty)" @click.away="editing = false; $wire.updateInline({{ $sub->id }}, 'qty', qty)" class="w-full text-center outline-none border-2 rounded text-[10px]" :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5] border-[#F5C518]' : 'bg-white text-[#1A1A1A] border-[#F5C518]'">
            @endif
        </td>
        
        <td class="px-2 py-1.5 border-r text-center opacity-60 uppercase font-mono" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">{{ $sub->material->satuan ?? 'Pcs' }}</td>
        
        <td class="px-3 py-1.5 border-r text-right font-mono" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'" 
            wire:key="harga-sub-{{ $sub->id }}-{{ $sub->harga_awal }}" 
            x-data="{ editing: false, harga: '{{ $sub->harga_awal }}' }">
            <div x-show="!editing" @dblclick="{{ !$isApproved ? 'editing = true' : '' }}" class="cursor-pointer rounded transition-colors" :class="darkMode ? 'hover:bg-[#F5C518]/10' : 'hover:bg-[#F5C518]/10'">{{ number_format($sub->harga_awal, 0, ',', '.') }}</div>
            @if(!$isApproved)
                <input type="number" x-show="editing" x-model="harga" @keydown.enter="editing = false; $wire.updateInline({{ $sub->id }}, 'harga_awal', harga)" @click.away="editing = false; $wire.updateInline({{ $sub->id }}, 'harga_awal', harga)" class="w-full text-right outline-none border-2 rounded text-[10px]" :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5] border-[#F5C518]' : 'bg-white text-[#1A1A1A] border-[#F5C518]'">
            @endif
        </td>
        
        <td class="px-3 py-1.5 text-right font-mono border-r font-semibold" :class="darkMode ? 'text-[#F5C518] border-[#2A2A2A]' : 'text-[#F5C518] border-[#E5E5E5]'">{{ number_format($sub->subtotal, 0, ',', '.') }}</td>
        
        @if(!$isApproved)
            <td class="text-center">
                <button wire:click="hapusItem({{ $sub->id }})" wire:loading.class="btn-loading" class="relative transition-colors text-red-400 hover:text-red-600">
                    <span class="btn-text">&times;</span>
                    <span class="btn-spinner"><svg class="w-3 h-3 spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg></span>
                </button>
            </td>
        @endif
    </tr>
@endforeach
@endforeach
                                    <tr class="font-bold text-[11px]" :class="darkMode ? 'bg-[#F5C518]/5' : 'bg-[#F5C518]/5'">
                                        <td class="px-2 py-2 text-center border-r opacity-50" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">&#931;</td>
                                        <td class="px-3 py-2 border-r italic" :class="darkMode ? 'text-[#F5F5F5] border-[#2A2A2A]' : 'text-[#1A1A1A] border-[#E5E5E5]'" colspan="4">Sub Total Bab {{ $alphabet[$indexKat] ?? ($indexKat+1) }}</td>
                                        <td class="px-3 py-2 text-right font-mono border-r" :class="darkMode ? 'text-[#F5F5F5] border-[#2A2A2A]' : 'text-[#1A1A1A] border-[#E5E5E5]'">Rp {{ number_format($subtotalKat, 0, ',', '.') }}</td>
                                        @if(!$isApproved) <td></td> @endif
                                    </tr>
                                @endforeach

                                @if(!$isApproved)
                                    <tr class="border-t-2 border-b-4" :class="darkMode ? 'border-[#333333] bg-[#1A1A1A]' : 'border-[#E5E5E5] bg-[#FAFAFA]'">
                                        <td class="text-center font-black text-[#F5C518] text-sm border-r" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">+</td>
                                        <td colspan="6" class="p-2" @error('newKategori') data-has-error @enderror>
                                            <input type="text" wire:model="newKategori" wire:keydown.enter="tambahKategori" id="field-newKategori" placeholder="Ketik Judul Kategori Baru (ex: PEKERJAAN ATAP) lalu tekan Enter..." class="w-full text-xs font-bold rounded-lg px-4 py-2 outline-none border-2 shadow-inner uppercase focus:ring-2 focus:ring-[#F5C518]/50 focus:border-[#F5C518] transition-all @error('newKategori') field-error @enderror" :class="darkMode ? 'bg-[#0A0A0A] border-[#333333] text-[#F5F5F5]' : 'bg-white border-[#E5E5E5] text-[#1A1A1A]'">
                                            @error('newKategori') <span class="text-red-500 text-[10px] font-bold mt-1 block"> {{ $message }}</span> @enderror
                                        </td>
                                    </tr>
                                @endif
                            </tbody>

                            <tfoot class="border-t-4 font-bold" :class="darkMode ? 'border-[#333333] bg-[#1A1A1A]' : 'border-[#E5E5E5] bg-[#F5C518]/5'">
                                <tr class="border-b" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
                                    <td colspan="5" class="px-4 py-3 text-right text-[11px] uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">TOTAL HARGA PEKERJAAN (HPP)</td>
                                    <td class="px-4 py-3 text-right font-mono text-xs" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">Rp {{ number_format($totalPekerjaan, 2, ',', '.') }}</td>
                                    @if(!$isApproved) <td></td> @endif
                                </tr>
                                <tr class="border-b" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
                                    <td colspan="5" class="px-4 py-2 text-right text-[11px] uppercase tracking-wider align-middle" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">OVERHEAD COST / BIAYA OPERASIONAL</td>
                                    <td class="px-2 py-2 text-right" @error('overhead_cost') data-has-error @enderror>
                                        @if(!$isApproved)
                                            <div class="relative w-full">
                                                <span class="absolute inset-y-0 left-0 pl-2 flex items-center text-[10px] font-mono text-[#888888]">Rp</span>
                                                <input type="number" wire:model.live.blur="overhead_cost" id="field-overhead_cost" class="w-full text-right pl-6 pr-2 py-1.5 rounded-lg border-2 outline-none font-mono text-xs shadow-inner focus:ring-2 focus:ring-[#F5C518]/50 focus:border-[#F5C518] transition-all @error('overhead_cost') field-error @enderror" :class="darkMode ? 'bg-[#0A0A0A] border-[#333333] text-[#F5C518]' : 'bg-white border-[#E5E5E5] text-[#1A1A1A]'">
                                                @error('overhead_cost') <span class="text-red-500 text-[10px] font-bold mt-1 block text-right">⚠ {{ $message }}</span> @enderror
                                            </div>
                                        @else
                                            <span class="font-mono text-xs px-2 text-[#F5C518]">Rp {{ number_format($overhead, 2, ',', '.') }}</span>
                                        @endif
                                    </td>
                                    @if(!$isApproved) <td></td> @endif
                                </tr>
                                <tr class="border-b" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
    <td colspan="5" class="px-4 py-2.5 text-right text-[11px] font-bold uppercase tracking-widest" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">GRAND TOTAL REAL</td>
    
    <!-- GANTI BARIS INI -->
    <td class="px-4 py-2.5 text-right font-mono text-xs" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">
        Rp {{ number_format($grandTotal, 0, ',', '.') }}
    </td>
    
    @if(!$isApproved) <td></td> @endif
</tr>
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-right text-xs font-black uppercase tracking-widest text-[#F5C518]">GRAND TOTAL DIBULATKAN (RIBUAN KE BAWAH)</td>
                                    <td class="px-4 py-4 text-right font-mono text-base font-black text-[#F5C518]">Rp {{ number_format(floor($grandTotal/1000)*1000, 2, ',', '.') }}</td>
                                    @if(!$isApproved) <td></td> @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                @if(!$isApproved)
                    <div class="rounded-xl p-5 shadow-xl border-2 mt-4" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-[#F5C518] mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Otorisasi & Catatan Histori Pembuatan Versi
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-start">
                            <div class="sm:col-span-1" @error('nama_editor') data-has-error @enderror>
                                <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#888888]'">Nama Estimator <span class="text-red-500">*</span></label>
                                <input type="text" wire:model.live.blur="nama_editor" id="field-nama_editor" placeholder="Nama Estimator..." class="w-full text-xs font-bold p-3 rounded-lg border-2 outline-none shadow-inner focus:ring-2 focus:ring-[#F5C518]/50 focus:border-[#F5C518] transition-all @error('nama_editor') field-error @enderror" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'">
                                @error('nama_editor') <span class="text-red-500 text-[10px] font-bold mt-1.5 block">⚠ {{ $message }}</span> @enderror
                            </div>
                            <div class="sm:col-span-2" @error('commit_message') data-has-error @enderror>
                                <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider" :class="darkMode ? 'text-[#888888]' : 'text-[#888888]'">Catatan Versi <span class="text-red-500">*</span></label>
                                <input type="text" wire:model.live.blur="commit_message" id="field-commit_message" placeholder="Tulis catatan versi draf ini sebelum diajukan..." class="w-full text-xs font-bold p-3 rounded-lg border-2 outline-none shadow-inner focus:ring-2 focus:ring-[#F5C518]/50 focus:border-[#F5C518] transition-all @error('commit_message') field-error @enderror" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'">
                                @error('commit_message') <span class="text-red-500 text-[10px] font-bold mt-1.5 block">⚠ {{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        @if($showRequestModal)
            <div class="fixed inset-0 z-[100] bg-black/80 backdrop-blur-sm flex items-center justify-center p-4" x-data="{
                 validateAndSubmit() {
                     let hasError = false;
                     const fields = [
                         { id: 'modal-reqNamaMaterial', name: 'Nama Barang' },
                         { id: 'modal-reqKebutuhan', name: 'Kuantitas' },
                         { id: 'modal-reqSatuan', name: 'Satuan' },
                         { id: 'modal-reqTargetWaktu', name: 'Target Waktu' }
                     ];
                     
                     fields.forEach(f => {
                         const el = document.getElementById(f.id);
                         if (el) {
                             el.classList.remove('field-error');
                             void el.offsetWidth;
                         }
                     });
                     
                     fields.forEach(f => {
                         const el = document.getElementById(f.id);
                         if (el && (!el.value || el.value.trim() === '')) {
                             hasError = true;
                             if (el) el.classList.add('field-error');
                         }
                     });
                     
                     if (hasError) {
                         window.dispatchEvent(new CustomEvent('validation-failed'));
                         return false;
                     }
                     return true;
                 }
             }">
                <div class="w-full max-w-lg rounded-xl p-6 border-2 shadow-2xl" :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                    <div class="flex justify-between items-center mb-5 border-b-2 pb-3" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
                        <h2 class="text-base font-bold uppercase tracking-wide" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">Material Request Form</h2>
                        <button wire:click="$set('showRequestModal', false)" class="text-[#888888] hover:text-red-500 text-2xl font-bold transition-colors cursor-pointer">&times;</button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase mb-1.5" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">Nama Barang / Material <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="reqNamaMaterial" id="modal-reqNamaMaterial" placeholder="Cth: Besi Tahan Panas" class="w-full text-xs font-bold p-2.5 rounded-lg border-2 outline-none focus:ring-2 focus:ring-[#F5C518]/50 focus:border-[#F5C518] transition-all" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase mb-1.5" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">Keterangan Spesifikasi / Merk</label>
                            <textarea wire:model="reqDeskripsi" rows="2" placeholder="Cth: SNI, Grade A" class="w-full text-xs p-2.5 rounded-lg border-2 outline-none resize-none focus:ring-2 focus:ring-[#F5C518]/50 focus:border-[#F5C518] transition-all" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'"></textarea>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-1/2">
                                <label class="block text-[10px] font-bold uppercase mb-1.5" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">Kuantitas <span class="text-red-500">*</span></label>
                                <input type="number" step="0.1" wire:model="reqKebutuhan" id="modal-reqKebutuhan" class="w-full text-xs p-2.5 rounded-lg border-2 outline-none font-mono focus:ring-2 focus:ring-[#F5C518]/50 focus:border-[#F5C518] transition-all" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'">
                            </div>
                            <div class="w-1/2">
                                <label class="block text-[10px] font-bold uppercase mb-1.5" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">Satuan <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="reqSatuan" id="modal-reqSatuan" placeholder="Cth: Pcs, Kg, Sak" class="w-full text-xs p-2.5 rounded-lg border-2 outline-none focus:ring-2 focus:ring-[#F5C518]/50 focus:border-[#F5C518] transition-all" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase mb-1.5" :class="darkMode ? 'text-[#888888]' : 'text-[#666666]'">Target Batas Waktu Disediakan <span class="text-red-500">*</span></label>
                            <input type="datetime-local" wire:model="reqTargetWaktu" id="modal-reqTargetWaktu" class="w-full text-xs p-2.5 rounded-lg border-2 outline-none focus:ring-2 focus:ring-[#F5C518]/50 focus:border-[#F5C518] transition-all" :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'">
                        </div>
                        
                        <button @click="if(!validateAndSubmit()) return; $wire.ajukanMaterialBaru()"
                                wire:loading.class="btn-loading"
                                class="relative w-full py-3 mt-4 text-xs font-bold uppercase tracking-widest rounded-lg shadow-lg transition-all flex items-center justify-center gap-2 text-[#1A1A1A] bg-[#F5C518] hover:bg-[#FFD700] hover:shadow-xl hover:shadow-[#F5C518]/30 focus:outline-none focus:ring-4 focus:ring-[#F5C518]/30 disabled:opacity-50">
                            <span class="btn-text flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                KIRIM KE PURCHASING
                            </span>
                            <span class="btn-spinner hidden">
                                <svg class="w-4 h-4 spinner mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-[10px]">MENGIRIM...</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>