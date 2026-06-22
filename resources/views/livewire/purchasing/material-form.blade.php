<div class="min-h-screen bg-[#F2F7F5] pb-12 font-sans text-[#02462E]">
    <div class="max-w-4xl mx-auto px-4 md:px-8 pt-8 space-y-6">

        <div wire:loading.flex wire:target="simpan" class="fixed inset-0 z-50 items-center justify-center bg-[#02462E]/50 backdrop-blur-sm">
            <div class="bg-white rounded-3xl p-8 shadow-2xl flex flex-col items-center gap-4">
                <div class="w-12 h-12 border-4 border-[#02462E]/20 border-t-[#02462E] rounded-full animate-spin"></div>
                <p class="text-sm font-bold text-[#02462E]">Menyimpan Data ke Master...</p>
            </div>
        </div>

        @if (session()->has('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm mb-6 animate-fade-in-down">
                <div class="flex items-center gap-3">
                    <div class="text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-red-800">Sistem Gagal Menyimpan Data</h4>
                        <p class="text-xs text-red-600 mt-0.5">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white p-6 md:p-8 rounded-[1.5rem] border border-[#02462E]/10 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-[#02462E] rounded-2xl flex items-center justify-center shadow-lg shrink-0">
                <svg class="w-6 h-6 text-[#FEC700]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
            </div>
            <div>
                <a href="{{ route('purchasing.material-index') }}" class="text-[10px] font-bold text-[#02462E]/50 uppercase tracking-widest hover:text-[#02462E] transition-colors">← Kembali ke Katalog</a>
                <h1 class="text-2xl md:text-3xl font-black text-[#02462E] tracking-tight mt-1">Registrasi Material & Supplier</h1>
            </div>
        </div>

        <form wire:submit.prevent="simpan" class="space-y-6">
            
            <div class="bg-white p-6 md:p-8 rounded-[1.5rem] border border-[#02462E]/10 shadow-sm">
                <h3 class="text-xs font-bold text-[#02462E]/50 uppercase tracking-widest mb-6 pb-2 border-b border-[#02462E]/5">1. Identitas Material</h3>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <div class="md:col-span-8">
                        <label class="block text-xs font-bold text-[#02462E] mb-2 uppercase tracking-wide">Nama Item <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="nama_barang" required placeholder="Contoh: Semen Portland 50Kg" class="w-full text-sm bg-[#F2F7F5] border border-[#02462E]/10 rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:ring-2 focus:ring-[#02462E]/10 font-bold text-[#02462E]">
                        @error('nama_barang') <span class="text-red-600 font-bold text-xs mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#02462E] mb-2 uppercase tracking-wide">QTY <span class="text-red-500">*</span></label>
                        <input type="number" wire:model="jumlah" required min="1" placeholder="0" class="w-full text-sm font-mono font-bold bg-[#F2F7F5] border border-[#02462E]/10 rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:ring-2 focus:ring-[#02462E]/10 text-[#02462E]">
                        @error('jumlah') <span class="text-red-600 font-bold text-xs mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#02462E] mb-2 uppercase tracking-wide">Satuan <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="satuan" required placeholder="Sak, Kg" class="w-full text-sm bg-[#F2F7F5] border border-[#02462E]/10 rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:ring-2 focus:ring-[#02462E]/10 font-bold text-[#02462E]">
                        @error('satuan') <span class="text-red-600 font-bold text-xs mt-2 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-[1.5rem] border border-[#02462E]/10 shadow-sm">
                <h3 class="text-xs font-bold text-[#02462E]/50 uppercase tracking-widest mb-6 pb-2 border-b border-[#02462E]/5">2. Nilai Pembelian (Pivot)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-[#02462E] mb-2 uppercase tracking-wide">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#02462E]/50 font-bold">Rp</span>
                            <input type="number" wire:model="harga" required min="1" placeholder="0" class="w-full text-sm font-mono font-bold bg-[#F2F7F5] border border-[#02462E]/10 rounded-xl pl-10 pr-4 py-3 outline-none focus:border-[#02462E] focus:ring-2 focus:ring-[#02462E]/10 text-[#02462E]">
                        </div>
                        @error('harga') <span class="text-red-600 font-bold text-xs mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#02462E] mb-2 uppercase tracking-wide">Lead Time (Estimasi Tiba) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" wire:model="lead_time_hari" required min="0" placeholder="0" class="w-full text-sm font-mono font-bold bg-[#F2F7F5] border border-[#02462E]/10 rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:ring-2 focus:ring-[#02462E]/10 text-[#02462E]">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-[#02462E]/50">Hari</span>
                        </div>
                        @error('lead_time_hari') <span class="text-red-600 font-bold text-xs mt-2 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-[1.5rem] border border-[#02462E]/10 shadow-sm overflow-visible">
                <h3 class="text-xs font-bold text-[#02462E]/50 uppercase tracking-widest mb-6 pb-2 border-b border-[#02462E]/5">3. Sumber Material (Supplier)</h3>
                
                <div x-data="{ showDropdown: true }" class="relative mb-4">
                    <label class="block text-xs font-bold text-[#02462E] mb-2 uppercase tracking-wide">Pilih / Buat Supplier <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.live.debounce.300ms="searchSupplier" @focus="showDropdown = true" required autocomplete="off" placeholder="Ketik nama toko atau PT..." class="w-full text-sm bg-white border-2 border-[#02462E]/20 rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:ring-4 focus:ring-[#02462E]/10 font-bold text-[#02462E] shadow-sm transition-all">
                    @error('searchSupplier') <span class="text-red-600 font-bold text-xs mt-2 block">{{ $message }}</span> @enderror
                    
                    @if(count($supplierResults) > 0)
                        <div x-show="showDropdown" @click.away="showDropdown = false" class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow-2xl border border-[#02462E]/10 overflow-hidden">
                            <ul class="max-h-60 overflow-y-auto divide-y divide-[#02462E]/5">
                                @foreach($supplierResults as $supp)
                                    <li wire:click="pilihSupplier({{ $supp['id'] }}, '{{ addslashes($supp['nama_supplier']) }}')" @click="showDropdown = false" class="px-5 py-3 cursor-pointer hover:bg-[#F2F7F5] transition-colors flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-[#02462E]/10 flex items-center justify-center text-[#02462E] font-black text-xs shrink-0">{{ substr($supp['nama_supplier'], 0, 1) }}</div>
                                        <div>
                                            <p class="text-sm font-bold text-[#02462E]">{{ $supp['nama_supplier'] }}</p>
                                            <p class="text-[10px] text-[#02462E]/60">{{ $supp['alamat'] ?? 'Alamat belum diisi' }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                @if(strlen($searchSupplier) >= 2 && $supplier_id === null)
                    <div class="mt-6 p-6 bg-[#F2F7F5] border border-[#02462E]/10 rounded-xl animate-fade-in-down">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-2 py-1 bg-[#FEC700] text-[#02462E] text-[10px] font-black uppercase tracking-widest rounded">Sistem: Supplier Baru</span>
                            <span class="text-xs text-[#02462E]/60 font-medium">Lengkapi data opsional ini untuk database.</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-[#02462E] mb-1 uppercase">Nama PIC / Sales</label>
                                <input type="text" wire:model="pic" placeholder="Cth: Pak Budi" class="w-full text-xs bg-white border border-[#02462E]/10 rounded-lg px-3 py-2 outline-none focus:border-[#02462E]">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-[#02462E] mb-1 uppercase">No. Telepon / WA</label>
                                <input type="text" wire:model="telepon" placeholder="Cth: 0812..." class="w-full text-xs bg-white border border-[#02462E]/10 rounded-lg px-3 py-2 outline-none focus:border-[#02462E] font-mono">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-bold text-[#02462E] mb-1 uppercase">Alamat Lengkap</label>
                                <textarea wire:model="alamat" rows="2" placeholder="Alamat toko..." class="w-full text-xs bg-white border border-[#02462E]/10 rounded-lg px-3 py-2 outline-none focus:border-[#02462E]"></textarea>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if($supplier_id !== null)
                    <div class="mt-4 p-4 border border-emerald-200 bg-emerald-50 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-xs font-bold text-emerald-800">Menggunakan data supplier yang sudah ada di sistem.</p>
                    </div>
                @endif
                
                <div class="mt-6">
                    <label class="block text-xs font-bold text-[#02462E] mb-2 uppercase tracking-wide">
                        Keterangan / Spesifikasi Teknis <span class="text-[#02462E]/40 font-normal normal-case">(Opsional)</span>
                    </label>
                    <textarea wire:model="deskripsi" rows="3" placeholder="Masukkan detail spesifikasi material jika ada..."
                              class="w-full text-sm bg-[#F2F7F5] border border-[#02462E]/10 text-[#02462E] rounded-xl px-5 py-4 outline-none focus:border-[#02462E] focus:ring-2 focus:ring-[#02462E]/10 transition-all resize-none font-semibold placeholder:text-[#02462E]/30"></textarea>
                    @error('deskripsi') <span class="text-red-600 font-bold text-xs mt-2 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="w-full md:w-auto px-10 py-4 bg-[#02462E] hover:bg-[#03593B] text-[#FEC700] font-black text-sm uppercase tracking-widest rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="simpan">Simpan Seluruh Data</span>
                    <span wire:loading wire:target="simpan" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>