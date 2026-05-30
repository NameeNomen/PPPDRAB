<div class="min-h-screen bg-zinc-50 p-4 md:p-8 font-sans text-slate-800">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- HEADER MODULE -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest rounded-md">Master Data</span>
                </div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight uppercase">Kelola Katalog Material</h1>
            </div>
            
            @if(!$isFormOpen)
                <button wire:click="buatBaru" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-bold text-[11px] tracking-widest rounded-xl transition-all shadow-md flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    TAMBAH MATERIAL
                </button>
            @endif
        </div>

        <!-- NOTIFIKASI -->
        @if (session()->has('sukses')) 
            <div class="px-5 py-3 bg-emerald-50 text-emerald-700 rounded-2xl text-xs font-bold border border-emerald-200 shadow-sm">{{ session('sukses') }}</div> 
        @endif
        @if (session()->has('error')) 
            <div class="px-5 py-3 bg-rose-50 text-rose-700 rounded-2xl text-xs font-bold border border-rose-200 shadow-sm">{{ session('error') }}</div> 
        @endif

        @if($isFormOpen)
            <!-- ================= FASE FORM: TAMBAH / EDIT MATERIAL ================= -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden animate-fade-in-down">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <h3 class="text-[11px] font-black text-slate-700 uppercase tracking-widest flex items-center gap-2">
                        <span class="p-1.5 bg-white rounded-lg shadow-sm">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </span>
                        {{ $material_id ? 'Edit Data Material' : 'Form Registrasi Material Baru' }}
                    </h3>
                    <button wire:click="tutupForm" class="text-slate-400 hover:text-slate-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form wire:submit.prevent="simpan" class="p-6 md:p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NAMA BARANG -->
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-1.5">Nama Item / Barang <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model="nama_barang" placeholder="Contoh: Semen Portland Tonasa 50Kg" class="w-full text-sm font-bold bg-zinc-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 outline-none focus:border-slate-400 focus:bg-white transition-all">
                            @error('nama_barang') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- HARGA -->
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-1.5">Harga Dasar (Rp) <span class="text-rose-500">*</span></label>
                            <input type="number" wire:model="harga" placeholder="0" class="w-full text-sm font-mono font-bold bg-zinc-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 outline-none focus:border-slate-400 focus:bg-white transition-all">
                            @error('harga') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- SATUAN -->
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-1.5">Satuan Ukur <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model="satuan" placeholder="Contoh: Sak, Btg, M3, Pcs" class="w-full text-sm font-bold bg-zinc-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 outline-none focus:border-slate-400 focus:bg-white transition-all">
                            @error('satuan') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- SUPPLIER (String) -->
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-1.5">Nama Supplier Rekanan</label>
                            <input type="text" wire:model="supplier" placeholder="Ketik nama toko / PT penyedia..." class="w-full text-sm font-bold bg-zinc-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 outline-none focus:border-slate-400 focus:bg-white transition-all">
                            @error('supplier') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- DESKRIPSI -->
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-1.5">Keterangan / Spesifikasi Teknis</label>
                            <textarea wire:model="deskripsi" rows="3" placeholder="Masukkan detail spesifikasi material jika ada..." class="w-full text-xs bg-zinc-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 outline-none focus:border-slate-400 focus:bg-white transition-all resize-none"></textarea>
                            @error('deskripsi') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="tutupForm" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-[11px] tracking-widest rounded-xl transition-all">BATAL</button>
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] tracking-widest rounded-xl transition-all shadow-md">SIMPAN KATALOG</button>
                    </div>
                </form>
            </div>

        @else
            <!-- ================= FASE TABEL: DAFTAR MATERIAL ================= -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <h3 class="text-[11px] font-black text-slate-700 uppercase tracking-widest flex items-center gap-2">
                        <span class="p-1.5 bg-slate-100 rounded-lg"><svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg></span>
                        Daftar Referensi Harga
                    </h3>
                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></div>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau supplier..." class="w-full pl-9 pr-3 py-2 bg-zinc-50 border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-slate-400 transition-all">
                    </div>
                </div>
                
                <div class="overflow-x-auto p-2">
                    <table class="w-full text-left text-xs whitespace-nowrap">
                        <thead class="bg-zinc-50 text-slate-400 uppercase font-black tracking-widest">
                            <tr>
                                <th class="px-4 py-3 rounded-l-lg">Nama Material</th>
                                <th class="px-4 py-3 text-right">Harga Dasar</th>
                                <th class="px-4 py-3 text-center">Satuan</th>
                                <th class="px-4 py-3">Supplier</th>
                                <th class="px-4 py-3 text-center rounded-r-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($materials as $mat)
                            <tr class="hover:bg-zinc-50 transition-colors group">
                                <td class="px-4 py-3.5">
                                    <div class="font-bold text-slate-700">{{ $mat->nama_barang }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono mt-0.5 truncate max-w-xs">{{ $mat->deskripsi ?? 'Tidak ada spesifikasi' }}</div>
                                </td>
                                <td class="px-4 py-3.5 text-right font-mono font-bold text-slate-700">Rp {{ number_format($mat->harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-3.5 text-center font-bold text-slate-500">{{ $mat->satuan }}</td>
                                <td class="px-4 py-3.5 text-slate-600 font-medium">{{ $mat->supplier ?? '-' }}</td>
                                <td class="px-4 py-3.5 text-center">
                                    <div class="flex items-center justify-center gap-2 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button wire:click="edit({{ $mat->id }})" class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-md transition-colors" title="Edit Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button wire:click="hapus({{ $mat->id }})" class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-500 rounded-md transition-colors" title="Hapus Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-4 py-8 text-center text-slate-400 font-bold bg-zinc-50 rounded-xl mt-2 block">Belum ada data material dalam katalog.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                @if($materials->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50">
                        {{ $materials->links() }}
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>