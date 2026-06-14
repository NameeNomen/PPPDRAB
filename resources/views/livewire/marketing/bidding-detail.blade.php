<div class="min-h-screen bg-[#F4F9F6] text-[#2A402B] font-sans overflow-x-hidden max-w-full pb-12"
     style="font-family: 'Inter', sans-serif;"
     x-data="{
        showErrorBanner: {{ $errors->any() ? 'true' : 'false' }},
        triggerErrorUI() {
            this.showErrorBanner = true;
            setTimeout(() => this.showErrorBanner = false, 10000);
            this.$nextTick(() => {
                const firstErrorInput = document.querySelector('.field-error');
                if (firstErrorInput) {
                    firstErrorInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        firstErrorInput.focus();
                    }, 400);
                }
            });
        }
    }"
     @validation-failed.window="triggerErrorUI()">

    @if ($errors->any()) <div x-init="$dispatch('validation-failed')" class="hidden"></div> @endif

    <style>
        .field-error {
            border-color: #EF4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important;
            animation: pulse-error 2s infinite;
        }
        @keyframes pulse-error {
            0%, 100% { background-color: #FEF2F2; }
            50% { background-color: #FEE2E2; }
        }
        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #B4CDBF; border-radius: 4px; }
    </style>

    <div x-show="showErrorBanner" style="display: none;"
         class="fixed top-6 left-1/2 transform -translate-x-1/2 z-[200] w-full max-w-2xl px-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 -translate-y-4 scale-95">

        <div class="bg-red-600 text-white rounded-2xl shadow-2xl border-2 border-red-400 p-5 flex flex-col gap-3">
            <div class="flex items-center gap-3 border-b border-red-500 pb-3">
                <div class="bg-white/20 p-2 rounded-lg shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-black uppercase tracking-widest">Sistem Menolak Penyimpanan</p>
                    <p class="text-xs font-medium opacity-90 mt-0.5">Ada data yang tidak valid. Perbaiki kesalahan berikut:</p>
                </div>
                <button @click="showErrorBanner = false" class="ml-auto text-white/70 hover:text-white bg-red-700 hover:bg-red-800 p-1.5 rounded-lg transition-colors outline-none focus:ring-2 focus:ring-white/50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            @if($errors->any())
                <ul class="list-disc list-inside text-xs font-bold space-y-1 ml-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <p class="text-[10px] font-medium bg-red-700/50 p-2 rounded-lg mt-2 border border-red-500/50 flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                    Layar sudah digeser otomatis ke kolom yang bermasalah. Silakan ketik perbaikannya.
                </p>
            @endif
        </div>
    </div>

    <div class="w-full px-4 md:px-8 py-6 max-w-full">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 p-4 rounded-2xl bg-white border border-[#B4CDBF]/50 shadow-sm gap-4">
            <div class="flex items-center gap-4">
                <button wire:click="kembaliKeList" class="text-xs font-bold px-5 py-2.5 rounded-xl transition-colors border shadow-sm bg-[#F4F9F6] border-[#B4CDBF]/50 text-[#2A402B] hover:border-[#4A7256] hover:bg-[#E2EFE7]">
                    &larr; KEMBALI
                </button>
                <div class="w-px h-6 bg-[#B4CDBF]/50"></div>
                <div>
                    <h1 class="text-lg font-black uppercase tracking-tight text-[#2A402B]">Penyusunan Bidding</h1>
                    <p class="text-[10px] font-bold text-[#648B73] uppercase tracking-wider">Proyek: {{ $proyek->nama_pelanggan }}</p>
                </div>
            </div>

            <button wire:click="simpanBidding" wire:loading.attr="disabled"
                    class="relative px-8 py-3 text-xs font-black rounded-xl shadow-lg transition-all uppercase tracking-widest flex items-center justify-center gap-2 text-white bg-[#4A7256] hover:bg-[#354F37] outline-none focus:ring-4 focus:ring-[#4A7256]/30 disabled:opacity-70 disabled:cursor-not-allowed min-w-[200px]">
                
                <span wire:loading.remove wire:target="simpanBidding" class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan & Ajukan
                </span>

                <span wire:loading wire:target="simpanBidding" class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Memproses...
                </span>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 items-start w-full">
            <div class="w-full lg:w-[35%] shrink-0 space-y-6 sticky top-6">
                <div class="bg-white rounded-3xl border border-[#B4CDBF]/50 shadow-md p-6">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-[#648B73] border-b border-[#E2EFE7] pb-3 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#4A7256]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Referensi RAB Disetujui
                    </h3>
                    <div class="space-y-4 font-mono text-sm text-[#2A402B]">
                        <div class="flex justify-between items-start">
                            <span class="text-[#648B73] font-sans text-xs font-bold">Klien / Instansi</span>
                            <span class="font-black text-right uppercase text-xs break-words w-1/2">{{ $proyek->nama_pelanggan }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[#648B73] font-sans text-xs font-bold">No. BOQ</span>
                            <span class="font-black bg-[#F4F9F6] px-2 py-1 rounded">{{ $rabAktif->no_boq ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[#648B73] font-sans text-xs font-bold">Biaya Engineering</span>
                            <span class="font-bold">Rp {{ number_format(($rabAktif->grand_total ?? 0) - ($rabAktif->overhead_cost ?? 0), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[#648B73] font-sans text-xs font-bold">Overhead Cost</span>
                            <span class="font-bold">Rp {{ number_format($rabAktif->overhead_cost ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="pt-4 border-t-2 border-dashed border-[#B4CDBF]/50 flex justify-between items-center text-base">
                            <span class="font-sans font-black uppercase tracking-wider text-[#4A7256]">Total Harga Dasar</span>
                            <span class="font-black text-[#4A7256]">Rp {{ number_format($harga_dasar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-[#E2EFE7] rounded-3xl border border-[#4A7256]/30 shadow-lg p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#4A7256]/10 rounded-bl-full -z-10"></div>
                    <h3 class="text-xs font-black uppercase tracking-widest text-[#2A402B] mb-5">Kalkulasi Penawaran</h3>
                    <div class="space-y-5 relative z-10">
                        <div>
                            <label class="block text-[10px] font-bold mb-2 uppercase tracking-wider text-[#4A7256]">Target Margin (%)</label>
                            <div class="relative">
                                <input type="number" step="0.01" wire:model.live.debounce.500ms="margin_persen" class="w-full text-xl py-3 pl-4 pr-12 rounded-xl border border-white outline-none font-black text-[#2A402B] shadow-inner focus:ring-2 focus:ring-[#4A7256]/50 transition-all">
                                <span class="absolute inset-y-0 right-4 flex items-center font-black text-[#648B73] text-lg">%</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold mb-2 uppercase tracking-wider text-[#4A7256]">Harga Penawaran Final</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-4 flex items-center font-black text-white/70 text-lg">Rp</span>
                                <input type="number" wire:model.live.debounce.500ms="total_penawaran" class="w-full text-2xl py-4 pl-12 pr-4 rounded-xl border border-[#4A7256]/50 outline-none font-black text-white bg-[#4A7256] shadow-md focus:ring-4 focus:ring-[#4A7256]/30 transition-all @error('total_penawaran') field-error @enderror">
                            </div>
                            @error('total_penawaran') <span class="text-red-600 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-[65%] space-y-6">
                <div class="rounded-3xl p-6 shadow-sm border border-[#B4CDBF]/50 bg-white">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-[#4A7256] border-b border-[#E2EFE7] pb-3 mb-5">Detail Identitas Dokumen</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div @error('no_penawaran') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider text-[#648B73]">No. Referensi Penawaran</label>
                            <input type="text" wire:model.live.blur="no_penawaran" class="w-full text-xs p-3 rounded-xl border border-[#E2EFE7] bg-[#F4F9F6] outline-none font-mono font-bold focus:border-[#4A7256] transition-all @error('no_penawaran') field-error @enderror">
                            @error('no_penawaran') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div @error('tgl_penawaran') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider text-[#648B73]">Tanggal Diterbitkan</label>
                            <input type="date" wire:model.live.blur="tgl_penawaran" class="w-full text-xs p-3 rounded-xl border border-[#E2EFE7] bg-[#F4F9F6] outline-none font-bold focus:border-[#4A7256] transition-all @error('tgl_penawaran') field-error @enderror">
                            @error('tgl_penawaran') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2" @error('perihal') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider text-[#648B73]">Perihal Dokumen</label>
                            <input type="text" wire:model.live.blur="perihal" class="w-full text-xs p-3 rounded-xl border border-[#E2EFE7] bg-[#F4F9F6] outline-none font-bold focus:border-[#4A7256] transition-all @error('perihal') field-error @enderror">
                            @error('perihal') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl p-6 shadow-sm border border-[#B4CDBF]/50 bg-white">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-[#4A7256] border-b border-[#E2EFE7] pb-3 mb-5">Tujuan (Kepada Yth.)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div @error('kepada') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider text-[#648B73]">Nama Instansi / Perusahaan</label>
                            <input type="text" wire:model.live.blur="kepada" class="w-full text-xs p-3 rounded-xl border border-[#E2EFE7] bg-[#F4F9F6] outline-none font-bold focus:border-[#4A7256] transition-all @error('kepada') field-error @enderror">
                            @error('kepada') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div @error('up') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider text-[#648B73]">U.P (Penerima Spesifik) - Opsional</label>
                            <input type="text" wire:model.live.blur="up" placeholder="Contoh: Bpk. Procurement" class="w-full text-xs p-3 rounded-xl border border-[#E2EFE7] bg-[#F4F9F6] outline-none font-bold focus:border-[#4A7256] transition-all @error('up') field-error @enderror">
                            @error('up') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl p-6 shadow-sm border border-[#B4CDBF]/50 bg-white">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-[#4A7256] border-b border-[#E2EFE7] pb-3 mb-5">Ketentuan Komersial</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                        <div @error('masa_berlaku') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider text-[#648B73]">Masa Berlaku (Hari)</label>
                            <input type="number" wire:model.live.blur="masa_berlaku" class="w-full text-xs p-3 rounded-xl border border-[#E2EFE7] bg-[#F4F9F6] outline-none font-bold focus:border-[#4A7256] transition-all @error('masa_berlaku') field-error @enderror">
                            @error('masa_berlaku') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div @error('waktu_pengerjaan') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider text-[#648B73]">Waktu Pengerjaan (Hari)</label>
                            <input type="number" wire:model.live.blur="waktu_pengerjaan" class="w-full text-xs p-3 rounded-xl border border-[#E2EFE7] bg-[#F4F9F6] outline-none font-bold focus:border-[#4A7256] transition-all @error('waktu_pengerjaan') field-error @enderror">
                            @error('waktu_pengerjaan') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div @error('garansi') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider text-[#648B73]">Garansi (Contoh: 3 Bulan)</label>
                            <input type="text" wire:model.live.blur="garansi" class="w-full text-xs p-3 rounded-xl border border-[#E2EFE7] bg-[#F4F9F6] outline-none font-bold focus:border-[#4A7256] transition-all @error('garansi') field-error @enderror">
                            @error('garansi') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div @error('term_of_payment') data-has-error @enderror>
                        <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider text-[#648B73]">Term Of Payment (Sistem Pembayaran)</label>
                        <textarea wire:model.live.blur="term_of_payment" rows="3" class="w-full text-xs p-3 rounded-xl border border-[#E2EFE7] bg-[#F4F9F6] outline-none font-bold focus:border-[#4A7256] transition-all @error('term_of_payment') field-error @enderror"></textarea>
                        @error('term_of_payment') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="rounded-3xl p-6 shadow-sm border border-[#B4CDBF]/50 bg-white space-y-5">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-[#4A7256] border-b border-[#E2EFE7] pb-3">Narasi Surat</h3>
                    <div @error('surat_pengantar') data-has-error @enderror>
                        <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider text-[#648B73]">Paragraf Pengantar</label>
                        <textarea wire:model.live.blur="surat_pengantar" rows="3" class="w-full text-xs p-3 rounded-xl border border-[#E2EFE7] bg-[#F4F9F6] outline-none font-bold focus:border-[#4A7256] transition-all @error('surat_pengantar') field-error @enderror"></textarea>
                        @error('surat_pengantar') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                    </div>
                    <div @error('catatan') data-has-error @enderror>
                        <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider text-[#648B73]">Catatan Tambahan (Opsional)</label>
                        <textarea wire:model.live.blur="catatan" rows="2" placeholder="Catatan ekstra yang akan dicetak di bagian bawah dokumen..." class="w-full text-xs p-3 rounded-xl border border-[#E2EFE7] bg-[#F4F9F6] outline-none font-bold focus:border-[#4A7256] transition-all @error('catatan') field-error @enderror"></textarea>
                        @error('catatan') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="rounded-3xl p-6 shadow-md border-2 border-[#4A7256]/20 bg-[#F4F9F6]">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-[#4A7256] mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Otorisasi Pengajuan
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div class="sm:col-span-1" @error('nama_penulis') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider text-[#648B73]">Nama Penyusun</label>
                            <input type="text" wire:model.live.blur="nama_penulis" class="w-full text-xs font-bold p-3 rounded-xl border border-white bg-white outline-none shadow-sm focus:border-[#4A7256] transition-all @error('nama_penulis') field-error @enderror">
                            @error('nama_penulis') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div class="sm:col-span-2" @error('komentar_commit') data-has-error @enderror>
                            <label class="block text-[10px] font-bold mb-1.5 uppercase tracking-wider text-[#648B73]">Pesan Pengajuan / Log Versi</label>
                            <input type="text" wire:model.live.blur="komentar_commit" placeholder="Misal: Penyesuaian margin 12% sesuai meeting..." class="w-full text-xs font-bold p-3 rounded-xl border border-white bg-white outline-none shadow-sm focus:border-[#4A7256] transition-all @error('komentar_commit') field-error @enderror">
                            @error('komentar_commit') <span class="text-red-500 text-[10px] font-bold mt-1 block">⚠ {{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                @if(count($historiRevisi) > 0)
                <div class="mt-8">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-[#648B73] mb-4">Histori Perjalanan Dokumen</h4>
                    <div class="space-y-3">
                        @foreach($historiRevisi as $histori)
                        <div class="p-4 rounded-2xl bg-white border border-[#E2EFE7] flex gap-4 text-xs shadow-sm">
                            <div class="w-10 h-10 rounded-full bg-[#E2EFE7] text-[#4A7256] flex items-center justify-center font-black uppercase shrink-0">
                                {{ substr($histori->user_name ?? 'U', 0, 2) }}
                            </div>
                            <div>
                                <p class="font-black text-[#2A402B] mb-0.5">{{ $histori->user_name }} <span class="text-[#648B73] font-normal text-[10px] ml-2 font-mono">{{ \Carbon\Carbon::parse($histori->created_at)->format('d M Y H:i') }}</span></p>                                    <p class="text-[#4A7256] font-medium leading-relaxed">"{{ $histori->komentar_commit }}"</p>
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