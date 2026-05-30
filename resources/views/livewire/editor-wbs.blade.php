<div class="min-h-screen p-8 bg-slate-50 font-sans text-slate-800">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border border-slate-200 bg-white p-6 rounded-2xl shadow-sm border-t-4 border-t-teal-600">
        <div>
            <span class="px-2 py-1 bg-teal-50 text-teal-700 text-[10px] font-black rounded uppercase tracking-widest">WBS & BOQ EDITOR</span>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-2">{{ $projectUtama->nama_pelanggan }}</h1>
            <p class="text-xs text-slate-500 mt-1 font-bold">REF PROYEK: {{ $projectUtama->request_no }} | Target: {{ \Carbon\Carbon::parse($projectUtama->target_waktu)->format('d M Y') }}</p>
        </div>
        <div class="mt-4 md:mt-0 text-right w-full md:w-auto bg-slate-50 p-4 rounded-xl border border-slate-100">
            <p class="text-[10px] text-slate-400 uppercase font-black tracking-widest">Estimasi Grand Total Sementara</p>
            <p class="text-3xl font-black text-teal-600 mt-1">Rp {{ number_format($rabUtama->grand_total ?? 0, 0, ',', '.') }}</p>
            <button wire:click="ajukanKeDirektur" class="mt-3 w-full px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-[10px] tracking-widest rounded-lg transition-all shadow-sm">
                SUBMIT KE DIREKTUR
            </button>
            @if (session()->has('error'))
                <span class="block mt-2 text-rose-500 text-[10px] font-bold">{{ session('error') }}</span>
            @endif
        </div>
    </div>

    @if (session()->has('sukses'))
        <div class="max-w-7xl mx-auto mb-6 p-4 bg-teal-50 border border-teal-200 text-teal-700 rounded-xl text-sm font-bold shadow-sm">
            {{ session('sukses') }}
        </div>
    @endif

    <div class="max-w-7xl mx-auto mb-8 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <h3 class="text-xs font-black text-slate-800 uppercase border-b border-slate-100 pb-3 mb-4 tracking-widest text-teal-700">Data Header RAB</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-[10px] font-black text-slate-500 mb-1.5 uppercase tracking-widest">No. BOQ</label>
                <input type="text" wire:model="no_boq" placeholder="BOQ-..." class="w-full text-sm font-mono font-bold bg-slate-50 border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500">
                @error('no_boq') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-500 mb-1.5 uppercase tracking-widest">Tanggal RAB</label>
                <input type="date" wire:model="tgl_boq" class="w-full text-sm font-bold bg-slate-50 border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500">
                @error('tgl_boq') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-500 mb-1.5 uppercase tracking-widest">Biaya Overhead (Rp)</label>
                <div class="flex gap-2">
                    <input type="number" wire:model="overhead_cost" class="w-full text-sm font-mono font-bold bg-slate-50 border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500">
                    <button wire:click="updateHeaderRab" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-[10px] rounded-xl transition-colors">UPDATE</button>
                </div>
                @error('overhead_cost') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-[10px] font-black text-teal-700 uppercase border-b border-slate-100 pb-3 mb-4 tracking-widest">1. Tambah Kelompok Pekerjaan</h3>
                <form wire:submit.prevent="tambahKelompok" class="space-y-4">
                    <div>
                        <input type="text" wire:model="nama_kelompok" placeholder="e.g. Pekerjaan Sipil / Mekanikal" class="w-full text-sm font-bold bg-slate-50 border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500">
                        @error('nama_kelompok') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-black tracking-widest rounded-xl transition-colors">
                        BUAT KELOMPOK
                    </button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-[10px] font-black text-teal-700 uppercase border-b border-slate-100 pb-3 mb-4 tracking-widest">2. Suntik Material (Sub-Item)</h3>
                <form wire:submit.prevent="tambahItem" class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 mb-1.5 uppercase tracking-widest">Kelompok Induk</label>
                        <select wire:model="parent_id" class="w-full text-sm font-bold bg-slate-50 border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500">
                            <option value="">-- Pilih Kelompok --</option>
                            @foreach($wbsStruktur as $p)
                                <option value="{{ $p->id }}">{{ $p->deskripsi_pekerjaan }}</option>
                            @endforeach
                        </select>
                        @error('parent_id') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 mb-1.5 uppercase tracking-widest">Cari Katalog Material</label>
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.300ms="searchMaterial" placeholder="Ketik minimal 2 huruf..." class="w-full text-sm font-medium bg-white border-slate-200 rounded-lg focus:ring-teal-500 focus:border-teal-500 pl-8">
                                <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>
                        
                        <div>
                            <select wire:model="id_material" size="3" class="w-full text-sm bg-white border-slate-200 rounded-lg focus:ring-teal-500 focus:border-teal-500 p-2 overflow-y-auto" style="min-height: 80px;">
                                @if(strlen($searchMaterial) < 2)
                                    <option disabled class="text-slate-400 text-xs text-center py-4">Ketik pencarian di atas...</option>
                                @elseif($katalogMaterial->isEmpty())
                                    <option disabled class="text-rose-400 text-xs text-center py-4">Material tidak ditemukan.</option>
                                @else
                                    @foreach($katalogMaterial as $m)
                                        <option value="{{ $m->id }}" class="p-2 hover:bg-teal-50 cursor-pointer border-b border-slate-50 font-medium">
                                            {{ $m->nama_barang }} (Rp {{ number_format($m->harga,0,',','.') }}/{{ $m->satuan }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('id_material') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 mb-1.5 uppercase tracking-widest">Volume (Qty)</label>
                        <input type="number" step="0.1" wire:model="qty" placeholder="Jumlah" class="w-full text-sm font-mono font-bold bg-slate-50 border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500">
                        @error('qty') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-[10px] font-black tracking-widest rounded-xl shadow-sm transition-colors">
                        TAMBAHKAN MATERIAL
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-200 h-fit">
            <h3 class="text-xs font-black text-slate-800 uppercase border-b border-slate-100 pb-3 mb-6 tracking-widest">Struktur Hierarki WBS</h3>
            
            <div class="space-y-4">
                @forelse($wbsStruktur as $parent)
                    <div class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="px-5 py-3 bg-slate-100 flex justify-between items-center border-b border-slate-200">
                            <span class="font-black text-slate-800 text-sm">📁 {{ $parent->deskripsi_pekerjaan }}</span>
                            <button wire:click="hapusItem({{ $parent->id }})" class="text-rose-500 hover:text-rose-700 text-[10px] font-bold tracking-widest transition-colors">HAPUS KELOMPOK</button>
                        </div>

                        <div class="p-2 divide-y divide-slate-100 bg-white">
                            @forelse($parent->children as $child)
                                <div class="px-5 py-3 flex justify-between items-center text-sm hover:bg-slate-50 transition-colors group">
                                    <div class="pl-4 border-l-2 border-teal-200">
                                        <p class="font-bold text-slate-800">🛠️ {{ $child->deskripsi_pekerjaan }}</p>
                                        <p class="text-slate-500 mt-1 font-mono text-[10px]">Vol: {{ $child->qty }} × @ Rp {{ number_format($child->harga_awal, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex items-center gap-6">
                                        <span class="font-mono font-black text-slate-800">Rp {{ number_format($child->subtotal, 0, ',', '.') }}</span>
                                        <button wire:click="hapusItem({{ $child->id }})" class="text-slate-300 hover:text-rose-500 font-black opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 font-medium italic p-5 text-center">Kelompok belum diisi material.</p>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl">
                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <p class="text-slate-400 font-bold text-sm">WBS Kosong.</p>
                        <p class="text-slate-400 font-medium text-xs mt-1">Buat Kelompok Pekerjaan di panel kiri, Cangkang RAB akan otomatis terbuat.</p>
                    </div>
                @endforelse
            </div>

            @if($rabUtama)
            <div class="mt-8 pt-5 border-t-2 border-slate-100 flex justify-between items-center px-4 bg-slate-50 p-4 rounded-xl">
                <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Biaya Overhead (Overhead Cost)</span>
                <span class="font-mono font-black text-slate-800 text-lg">Rp {{ number_format($rabUtama->overhead_cost, 0, ',', '.') }}</span>
            </div>
            @endif
        </div>
    </div>
</div>