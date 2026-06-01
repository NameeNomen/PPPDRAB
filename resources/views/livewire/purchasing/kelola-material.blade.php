<div class="min-h-screen bg-[#F2F7F5] p-4 md:p-8 font-sans text-[#02462E]">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 md:p-8 rounded-[1.5rem] border border-[#02462E]/10 shadow-sm">
            <div>
                <span class="text-[10px] font-bold text-[#02462E]/60 uppercase tracking-widest mb-1 block">Master Data</span>
                <h1 class="text-2xl md:text-3xl font-black text-[#02462E] tracking-tight">Kelola Katalog Material</h1>
            </div>
            
            @if(!$isFormOpen)
                <button wire:click="buatBaru" class="px-6 py-3 bg-[#02462E] hover:bg-[#03593B] text-[#FEC700] font-bold text-[11px] tracking-widest rounded-xl transition-all shadow-sm flex items-center gap-2 hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    TAMBAH MATERIAL
                </button>
            @endif
        </div>

        @if (session()->has('sukses')) 
            <div class="px-6 py-4 bg-[#02462E]/10 text-[#02462E] rounded-xl text-xs font-medium border border-[#02462E]/20 flex items-center gap-3">
                <svg class="w-4 h-4 text-[#02462E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('sukses') }}
            </div> 
        @endif
        @if (session()->has('error')) 
            <div class="px-6 py-4 bg-[#FEC700]/20 text-[#02462E] rounded-xl text-xs font-medium border border-[#FEC700]/30 flex items-center gap-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div> 
        @endif

        @if($isFormOpen)
            <div class="bg-white rounded-[1.5rem] border border-[#02462E]/10 shadow-sm overflow-hidden animate-fade-in-down">
                <div class="px-8 py-6 border-b border-[#02462E]/5 flex justify-between items-center">
                    <h3 class="text-xs font-bold text-[#02462E] uppercase tracking-widest">
                        {{ $material_id ? 'Edit Data Material' : 'Form Registrasi Material Baru' }}
                    </h3>
                    <button wire:click="tutupForm" class="text-[#02462E]/40 hover:text-[#02462E] p-2 bg-[#F2F7F5] rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form wire:submit.prevent="simpan" class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-[#02462E] mb-2">Nama Item / Barang <span class="text-[#FEC700]">*</span></label>
                            <input type="text" wire:model="nama_barang" placeholder="Contoh: Semen Portland Tonasa 50Kg" class="w-full text-sm bg-[#F2F7F5] border border-[#02462E]/10 text-[#02462E] rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:bg-white focus:ring-2 focus:ring-[#02462E]/10 transition-all">
                            @error('nama_barang') <span class="text-[#02462E] font-bold text-xs mt-1.5 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#02462E] mb-2">Harga Dasar (Rp) <span class="text-[#FEC700]">*</span></label>
                            <input type="number" wire:model="harga" placeholder="0" class="w-full text-sm font-mono bg-[#F2F7F5] border border-[#02462E]/10 text-[#02462E] rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:bg-white focus:ring-2 focus:ring-[#02462E]/10 transition-all">
                            @error('harga') <span class="text-[#02462E] font-bold text-xs mt-1.5 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#02462E] mb-2">Satuan Ukur <span class="text-[#FEC700]">*</span></label>
                            <input type="text" wire:model="satuan" placeholder="Contoh: Sak, Btg, M3, Pcs" class="w-full text-sm bg-[#F2F7F5] border border-[#02462E]/10 text-[#02462E] rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:bg-white focus:ring-2 focus:ring-[#02462E]/10 transition-all">
                            @error('satuan') <span class="text-[#02462E] font-bold text-xs mt-1.5 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-[#02462E] mb-2">Nama Supplier Rekanan</label>
                            <input type="text" wire:model="supplier" placeholder="Ketik nama toko / PT penyedia..." class="w-full text-sm bg-[#F2F7F5] border border-[#02462E]/10 text-[#02462E] rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:bg-white focus:ring-2 focus:ring-[#02462E]/10 transition-all">
                            @error('supplier') <span class="text-[#02462E] font-bold text-xs mt-1.5 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-[#02462E] mb-2">Keterangan / Spesifikasi Teknis</label>
                            <textarea wire:model="deskripsi" rows="3" placeholder="Masukkan detail spesifikasi material jika ada..." class="w-full text-sm bg-[#F2F7F5] border border-[#02462E]/10 text-[#02462E] rounded-xl px-4 py-3 outline-none focus:border-[#02462E] focus:bg-white focus:ring-2 focus:ring-[#02462E]/10 transition-all resize-none"></textarea>
                            @error('deskripsi') <span class="text-[#02462E] font-bold text-xs mt-1.5 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-8 border-t border-[#02462E]/5">
                        <button type="button" wire:click="tutupForm" class="px-6 py-2.5 bg-white border border-[#02462E]/20 text-[#02462E] font-bold text-xs rounded-xl hover:bg-[#F2F7F5] transition-all">BATAL</button>
                        <button type="submit" class="px-6 py-2.5 bg-[#02462E] text-[#FEC700] font-bold text-xs rounded-xl hover:bg-[#03593B] transition-all shadow-sm">SIMPAN DATA</button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-white rounded-[1.5rem] border border-[#02462E]/10 shadow-sm overflow-hidden flex flex-col">
                <div class="p-6 md:p-8 border-b border-[#02462E]/5 flex flex-col md:flex-row justify-between items-start md:items-center gap-5">
                    <h3 class="text-xs font-bold text-[#02462E] uppercase tracking-widest">Daftar Referensi Harga</h3>
                    <div class="relative w-full md:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-[#02462E]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau supplier..." class="w-full pl-10 pr-4 py-2.5 bg-[#F2F7F5] border border-[#02462E]/10 rounded-xl text-sm text-[#02462E] focus:outline-none focus:border-[#02462E] focus:ring-2 focus:ring-[#02462E]/10 transition-all">
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-[#F2F7F5] text-[#02462E]/70 border-b border-[#02462E]/10">
                            <tr>
                                <th class="px-8 py-4 font-medium text-xs uppercase tracking-widest">Nama Material</th>
                                <th class="px-8 py-4 text-right font-medium text-xs uppercase tracking-widest">Harga Dasar</th>
                                <th class="px-8 py-4 text-center font-medium text-xs uppercase tracking-widest">Satuan</th>
                                <th class="px-8 py-4 font-medium text-xs uppercase tracking-widest">Supplier</th>
                                <th class="px-8 py-4 text-center font-medium text-xs uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#02462E]/5">
                            @forelse($materials as $mat)
                            <tr class="hover:bg-[#F2F7F5]/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="font-semibold text-[#02462E]">{{ $mat->nama_barang }}</div>
                                    <div class="text-[11px] text-[#02462E]/60 mt-1 truncate max-w-xs">{{ $mat->deskripsi ?? 'Tidak ada spesifikasi' }}</div>
                                </td>
                                <td class="px-8 py-5 text-right font-mono font-medium text-[#02462E]">Rp {{ number_format($mat->harga, 0, ',', '.') }}</td>
                                <td class="px-8 py-5 text-center text-[#02462E]/70">{{ $mat->satuan }}</td>
                                <td class="px-8 py-5 text-[#02462E]">{{ $mat->supplier ?? '-' }}</td>
                                <td class="px-8 py-5 text-center">
                                    <div class="flex items-center justify-center gap-2 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button wire:click="edit({{ $mat->id }})" class="p-2 text-[#02462E]/60 hover:bg-[#F2F7F5] hover:text-[#02462E] rounded-lg transition-colors" title="Edit Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button wire:click="hapus({{ $mat->id }})" class="p-2 text-[#FEC700] hover:bg-[#02462E]/5 hover:text-[#02462E] rounded-lg transition-colors" title="Hapus Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-8 py-16 text-center text-[#02462E]/50 font-medium">Belum ada data material dalam katalog.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($materials->hasPages())
                    <div class="p-6 border-t border-[#02462E]/5 bg-white">
                        {{ $materials->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>