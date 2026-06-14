<div class="min-h-screen bg-[#F2F7F5] p-4 md:p-8 font-sans text-[#02462E]">
    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Header Halaman -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-[1.5rem] border border-[#02462E]/10 shadow-sm">
            <div>
                <a href="{{ route('material.index') }}" class="text-[10px] font-bold text-[#02462E]/60 uppercase tracking-widest mb-2 flex items-center gap-1 hover:text-[#02462E] transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    KEMBALI KE KATALOG
                </a>
                <h1 class="text-2xl font-black text-[#02462E] tracking-tight">
                    {{ $material_id ? 'Edit Data Material' : 'Registrasi Material Baru' }}
                </h1>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-[1.5rem] border border-[#02462E]/10 shadow-sm overflow-hidden animate-fade-in-down">
            <form wire:submit.prevent="simpan" class="p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Nama Barang -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-[#02462E] mb-2">Nama Item / Barang <span class="text-[#FEC700]">*</span></label>
                        <input type="text" wire:model="nama_barang" placeholder="Contoh: Semen Portland Tonasa 50Kg" class="w-full text-sm bg-[#F2F7F5] border border-[#02462E]/10 text-[#02462E] rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:bg-white focus:ring-2 focus:ring-[#02462E]/10 transition-all">
                        @error('nama_barang') <span class="text-[#02462E] font-bold text-xs mt-1.5 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Harga -->
                    <div>
                        <label class="block text-xs font-semibold text-[#02462E] mb-2">Harga Dasar (Rp) <span class="text-[#FEC700]">*</span></label>
                        <input type="number" wire:model="harga" placeholder="0" class="w-full text-sm font-mono bg-[#F2F7F5] border border-[#02462E]/10 text-[#02462E] rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:bg-white focus:ring-2 focus:ring-[#02462E]/10 transition-all">
                        @error('harga') <span class="text-[#02462E] font-bold text-xs mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label class="block text-xs font-semibold text-[#02462E] mb-2">Satuan Ukur <span class="text-[#FEC700]">*</span></label>
                        <input type="text" wire:model="satuan" placeholder="Contoh: Sak, Btg, M3, Pcs" class="w-full text-sm bg-[#F2F7F5] border border-[#02462E]/10 text-[#02462E] rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:bg-white focus:ring-2 focus:ring-[#02462E]/10 transition-all">
                        @error('satuan') <span class="text-[#02462E] font-bold text-xs mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Supplier -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-[#02462E] mb-2">Nama Supplier Rekanan</label>
                        <input type="text" wire:model="supplier" placeholder="Ketik nama toko / PT penyedia..." class="w-full text-sm bg-[#F2F7F5] border border-[#02462E]/10 text-[#02462E] rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:bg-white focus:ring-2 focus:ring-[#02462E]/10 transition-all">
                        @error('supplier') <span class="text-[#02462E] font-bold text-xs mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-[#02462E] mb-2">Keterangan / Spesifikasi Teknis</label>
                        <textarea wire:model="deskripsi" rows="3" placeholder="Masukkan detail spesifikasi material jika ada..." class="w-full text-sm bg-[#F2F7F5] border border-[#02462E]/10 text-[#02462E] rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:bg-white focus:ring-2 focus:ring-[#02462E]/10 transition-all resize-none"></textarea>
                        @error('deskripsi') <span class="text-[#02462E] font-bold text-xs mt-1.5 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-3 pt-8 border-t border-[#02462E]/5">
                    <a href="{{ route('material.index') }}" class="px-6 py-2.5 bg-white border border-[#02462E]/20 text-[#02462E] font-bold text-xs rounded-xl hover:bg-[#F2F7F5] transition-all flex items-center justify-center">
                        BATAL
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-[#02462E] text-[#FEC700] font-bold text-xs rounded-xl hover:bg-[#03593B] transition-all shadow-sm">
                        SIMPAN DATA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>