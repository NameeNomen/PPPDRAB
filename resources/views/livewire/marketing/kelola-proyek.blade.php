<div class="p-6 text-[#003057]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        .font-manrope { font-family: 'Manrope', sans-serif; }
    </style>

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-[#003057]">Kelola Proyek & Tender</h1>
            <p class="text-sm text-[#003057]/70 mt-1">Sistem pencatatan inisiasi proyek, bidding, dan costing.</p>
        </div>
        <button wire:click="bukaModal" class="bg-[#003057] hover:bg-[#001D36] text-white px-6 py-3 rounded-xl shadow-lg font-semibold transition-all">
            + Tambah Proyek Baru
        </button>
    </div>

    @if (session()->has('sukses'))
        <div class="bg-[#A3B5E0]/30 border border-[#A3B5E0] text-[#003057] p-4 rounded-xl mb-6 font-semibold shadow-sm flex justify-between items-center">
            <span>{{ session('sukses') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-[#003057] font-bold hover:text-red-500">&times;</button>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#F2F2F2] border-b border-gray-200 text-xs uppercase tracking-wider text-[#003057] font-bold">
                    <th class="p-4">No. Request</th>
                    <th class="p-4">Nama Proyek</th>
                    <th class="p-4">Pelanggan</th>
                    <th class="p-4">Budget (Est)</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-manrope text-sm">
                @forelse($daftarProyek as $proyek)
                <tr class="border-b border-gray-100 hover:bg-[#F2F2F2]/60 transition-colors">
                    <td class="p-4 font-semibold text-[#003057]">{{ $proyek->request_no }}</td>
                    <td class="p-4">
                        <span class="font-semibold text-[#003057] font-sans">{{ $proyek->nama_projek }}</span>
                        <br>
                        <span class="text-xs text-gray-500">{{ $proyek->category->nama_kategori ?? '-' }}</span>
                    </td>
                    <td class="p-4">{{ $proyek->nama_pelanggan }} <br><span class="text-xs text-gray-500">{{ $proyek->pic_pelanggan }}</span></td>
                    <td class="p-4 font-medium">Rp {{ number_format($proyek->estimasi_budget, 0, ',', '.') }}</td>
                    <td class="p-4">
                        <span class="bg-[#E8BF00] text-[#003057] py-1.5 px-3 rounded-full text-xs font-bold uppercase">{{ $proyek->status_proyek }}</span>
                    </td>
                    <td class="p-4 text-center space-x-2">
                        {{-- Pastikan route 'marketing.proyek.detail' ini benar-benar ada di web.php --}}
                        <button onclick="window.open('{{ route('marketing.proyek.detail', $proyek->id) }}', '_blank', 'width=850,height=900,scrollbars=yes')" class="text-[#003057] hover:underline text-xs font-bold">Detail</button>
                        
                        <button wire:click="editProyek({{ $proyek->id }})" class="text-[#E8BF00] hover:underline text-xs font-bold">Edit</button>
                        <button onclick="confirm('Yakin mau hapus data ini?') || event.stopImmediatePropagation()" wire:click="hapusProyek({{ $proyek->id }})" class="text-red-600 hover:underline text-xs font-bold">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500 font-medium">Belum ada data proyek. Santai amat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL FORM MULTIFUNGSI (CREATE & EDIT) --}}
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-[#003057]/60 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto flex flex-col">
            
            <div class="p-6 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white z-20 rounded-t-3xl shadow-sm">
                <h2 class="text-2xl font-bold text-[#003057]">{{ $isEdit ? 'Edit Data Proyek' : 'Inisiasi Proyek Baru' }}</h2>
                <button wire:click="tutupModal" class="text-gray-400 hover:text-red-500 text-3xl font-bold transition-colors">&times;</button>
            </div>

            <div class="p-8 space-y-6">
                {{-- DETAIL DASAR --}}
                <div class="bg-[#F2F2F2]/50 p-6 rounded-2xl border border-gray-200">
                    <h3 class="text-sm font-bold text-[#003057] uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Detail Dasar</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#003057] mb-1.5">Nama Proyek *</label>
                            <input type="text" wire:model="nama_projek" placeholder="Contoh: Pekerjaan Sipil Gudang B" class="w-full bg-white border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-[#E8BF00] outline-none transition-all">
                            @error('nama_projek') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative z-10" x-data="{ open: false }">
                            <label class="block text-sm font-semibold text-[#003057] mb-1.5">Kategori Pekerjaan *</label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    wire:model.live.debounce.300ms="search_kategori" 
                                    @focus="open = true" 
                                    @click.away="open = false"
                                    placeholder="{{ $nama_kategori_terpilih ? $nama_kategori_terpilih : 'Cari kategori...' }}" 
                                    class="w-full bg-white border border-gray-300 rounded-xl py-3 px-4 focus:ring-2 focus:ring-[#E8BF00] outline-none"
                                >
                            </div>
                            @error('category_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror

                            <div x-show="open" style="display: none;" class="absolute left-0 right-0 mt-2 bg-white rounded-xl shadow-lg border border-gray-200 max-h-48 overflow-y-auto z-50">
                                <ul class="divide-y divide-gray-100">
                                    @forelse($listKategori as $kat)
                                        <li wire:click="pilihKategori('{{ $kat->id }}', '{{ addslashes($kat->nama_kategori) }}')" @click="open = false" class="px-4 py-3 hover:bg-[#F2F2F2] cursor-pointer text-sm font-semibold text-[#003057]">
                                            {{ $kat->nama_kategori }}
                                        </li>
                                    @empty
                                        <li class="px-4 py-3 text-sm text-center text-gray-500">Tidak ditemukan...</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#003057] mb-1.5">Prioritas Pekerjaan *</label>
                            <select wire:model="priority" class="w-full bg-white border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-[#E8BF00] outline-none text-sm">
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                            @error('priority') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- INFO KLIEN --}}
                <div class="bg-[#F2F2F2]/50 p-6 rounded-2xl border border-gray-200">
                    <h3 class="text-sm font-bold text-[#003057] uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Info Klien & Anggaran</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#003057] mb-1.5">Nama Perusahaan / Klien *</label>
                            <input type="text" wire:model="nama_pelanggan" class="w-full bg-white border border-gray-300 rounded-xl p-3 outline-none">
                            @error('nama_pelanggan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#003057] mb-1.5">Nama PIC</label>
                            <input type="text" wire:model="pic_pelanggan" class="w-full bg-white border border-gray-300 rounded-xl p-3 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#003057] mb-1.5">Nomor HP</label>
                            <input type="text" wire:model="no_hp" class="w-full bg-white border border-gray-300 rounded-xl p-3 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#003057] mb-1.5">Target Selesai</label>
                            <input type="date" wire:model="target_waktu" class="w-full bg-white border border-gray-300 rounded-xl p-3 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#003057] mb-1.5">Estimasi Budget (Rp)</label>
                            <input type="number" wire:model="estimasi_budget" class="w-full bg-white border border-gray-300 rounded-xl p-3 outline-none">
                            @error('estimasi_budget') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- SPESIFIKASI --}}
                <div class="bg-[#F2F2F2]/50 p-6 rounded-2xl border border-gray-200">
                    <h3 class="text-sm font-bold text-[#003057] uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Detail Spesifikasi</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-[#003057] mb-1.5">Deskripsi Proyek</label>
                            <textarea wire:model="deskripsi_proyek" rows="3" class="w-full bg-white border border-gray-300 rounded-xl p-3 text-sm outline-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#003057] mb-1.5">Alamat Lengkap Lokasi</label>
                            <textarea wire:model="alamat" rows="2" class="w-full bg-white border border-gray-300 rounded-xl p-3 text-sm outline-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#003057] mb-1.5">Upload Lampiran Tambahan (Opsional)</label>
                            <input type="file" wire:model="lampiran" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-[#A3B5E0]/40 file:text-[#003057] cursor-pointer">
                            <div wire:loading wire:target="lampiran" class="text-xs text-[#003057] mt-1 font-semibold animate-pulse">Memproses file...</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-100 bg-[#FAFAFA] flex justify-end gap-4 rounded-b-3xl sticky bottom-0 z-10">
                <button wire:click="tutupModal" wire:loading.attr="disabled" wire:target="simpanProyek, updateProyek" class="px-6 py-3 rounded-xl text-sm font-bold text-[#003057] bg-gray-200 hover:bg-gray-300 disabled:opacity-50 transition-colors">
                    Batal
                </button>
                
                <button wire:click="{{ $isEdit ? 'updateProyek' : 'simpanProyek' }}" wire:loading.attr="disabled" wire:target="simpanProyek, updateProyek" class="px-6 py-3 rounded-xl text-sm font-bold text-[#003057] bg-[#E8BF00] hover:bg-[#D4AF37] flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed transition-all shadow-md">
                    <span wire:loading wire:target="simpanProyek, updateProyek" class="animate-spin inline-block w-4 h-4 border-2 border-[#003057] border-t-transparent rounded-full"></span>
                    <span>{{ $isEdit ? 'Update Proyek' : 'Simpan Proyek' }}</span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>