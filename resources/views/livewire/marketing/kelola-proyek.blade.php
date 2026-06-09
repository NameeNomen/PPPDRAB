<div class="min-h-screen p-4 md:p-8 bg-slate-50 font-sans text-slate-700 antialiased">
    <!-- Pustaka CSS/JS Peta Terintegrasi Langsung secara Asinkron -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">Kelola Proyek</h1>
                <p class="text-xs md:text-sm text-slate-500 mt-1 font-medium">Panel Inisiasi Penawaran Klien & Kebutuhan Lapangan PT Tri Jaya Teknik.</p>
            </div>
            <button wire:click="bukaModal" class="w-full md:w-auto px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase rounded-xl tracking-wider shadow-md shadow-blue-500/10 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Inisiasi Proyek Baru
            </button>
        </div>
    </div>

    <!-- Banner Notifikasi Sukses -->
    @if (session()->has('sukses'))
        <div class="max-w-7xl mx-auto mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-semibold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>{{ session('sukses') }}</div>
        </div>
    @endif

    @if (session()->has('sukses_material'))
        <div class="max-w-7xl mx-auto mb-6 p-4 bg-sky-50 border border-sky-200 text-sky-800 rounded-xl text-sm font-semibold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-sky-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>{{ session('sukses_material') }}</div>
        </div>
    @endif

    <!-- Data Table Card Grid -->
    <div class="max-w-7xl mx-auto bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto w-full p-2">
            <table class="w-full min-w-[950px] text-left text-sm text-slate-600">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold text-xs uppercase tracking-wider">
                        <th class="px-6 py-4">Nomor Req & Nama Klien</th>
                        <th class="px-6 py-4">Kategori & Batas Waktu</th>
                        <th class="px-6 py-4 text-right">Estimasi Budget</th>
                        <th class="px-6 py-4 text-center">Status Tahapan</th>
                        <th class="px-6 py-4 text-center">Aksi Operasional</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($daftarProyek as $p)
                    <tr class="hover:bg-slate-50/60 transition-colors duration-150 group">
                        <td class="px-6 py-4">
                            <span class="inline-block text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded mb-1">{{ $p->request_no }}</span>
                            <div class="font-bold text-slate-800 text-base">{{ $p->nama_pelanggan }}</div>
                            <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                <svg class="w-3. h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $p->pic_pelanggan }}
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium">
                            <div class="text-sm font-semibold text-slate-700">{{ $p->category ? $p->category->nama_kategori : 'Belum Ditentukan' }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($p->target_waktu)->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-800 text-right text-base">Rp {{ number_format($p->estimasi_budget, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($p->status_proyek == 'waiting_rab')
                                <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200/60 text-[11px] font-bold tracking-wide rounded-full">WAITING RAB</span>
                            @elseif($p->status_proyek == 'rab_approved' || $p->status_proyek == 'won')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-[11px] font-bold tracking-wide rounded-full uppercase">{{ str_replace('_', ' ', $p->status_proyek) }}</span>
                            @else
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 border border-slate-200 text-[11px] font-bold tracking-wide rounded-full uppercase">{{ str_replace('_', ' ', $p->status_proyek) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <button wire:click="lihatDetail({{ $p->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition-colors cursor-pointer" title="Lihat Detail & Status Master RAB">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button wire:click="editProyek({{ $p->id }})" class="p-2 text-slate-500 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer" title="Ubah Data Proyek">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button wire:click="hapusProyek({{ $p->id }})" onclick="confirm('Yakin menghapus dokumen inisiasi ini? Tindakan ini juga akan menghapus data item relasinya!') || event.stopImmediatePropagation()" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-colors cursor-pointer" title="Hapus Dokumen">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center font-semibold text-slate-400">Belum ada dokumen proyek aktif yang terdaftar di sistem.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MAIN MODAL FORM (CREATE / EDIT) -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-[100] overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4 py-8">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-5xl max-h-[90vh] flex flex-col transform transition-all border border-slate-200 overflow-hidden">
            <!-- Header Modal -->
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-white sticky top-0 z-10">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">{{ $isEdit ? 'Ubah Informasi Dokumen Proyek' : 'Form Inisiasi Manajemen Proyek Baru' }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Definisikan keinginan klien menjadi rincian item teknis terukur agar siap dihitung Tim Engineering.</p>
                </div>
                <button wire:click="tutupModal" class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:text-slate-600 flex items-center justify-center cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
           
            <form wire:submit.prevent="{{ $isEdit ? 'updateProyek' : 'simpanProyek' }}" class="p-6 md:p-8 space-y-6 overflow-y-auto flex-1 bg-slate-50/30">
                <!-- Grid Informasi Utama -->
                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">1. Data Pemohon & Manajemen Kontrak</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kategori Proyek (Data Master Real)</label>
                            <select wire:model="category_id" class="w-full text-sm px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 transition-all cursor-pointer">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($listKategori as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Skala Prioritas</label>
                            <select wire:model="priority" class="w-full text-sm px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 transition-all cursor-pointer">
                                <option value="low">Rendah (Low)</option>
                                <option value="medium">Sedang (Medium)</option>
                                <option value="high">Mendesak (High)</option>
                            </select>
                            @error('priority') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Perusahaan / Klien</label>
                            <input list="list-pt" wire:model="nama_pelanggan" class="w-full text-sm px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 transition-all" placeholder="Ketik atau pilih nama PT...">
                            <datalist id="list-pt">
                                @foreach($listPT as $pt) <option value="{{ $pt }}"> @endforeach
                            </datalist>
                            @error('nama_pelanggan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Hubungan PIC</label>
                            <input list="list-pic" wire:model="pic_pelanggan" class="w-full text-sm px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 transition-all" placeholder="Nama penanggung jawab...">
                            <datalist id="list-pic">
                                @foreach($listPIC as $pic) <option value="{{ $pic }}"> @endforeach
                            </datalist>
                            @error('pic_pelanggan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">No Kontak WhatsApp</label>
                            <input type="text" wire:model="no_hp" class="w-full text-sm px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 transition-all" placeholder="0812...">
                            @error('no_hp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Target Batas Waktu Selesai</label>
                            <input type="date" wire:model="target_waktu" class="w-full text-sm px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 transition-all text-slate-600">
                            @error('target_waktu') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                        <div class="md:col-span-1">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Estimasi Budget Awal Klien (Rp)</label>
                            <input type="number" wire:model="estimasi_budget" class="w-full text-sm px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 transition-all" placeholder="10000000">
                            @error('estimasi_budget') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Catatan Singkat / Harapan Makro Klien</label>
                            <input type="text" wire:model="deskripsi_proyek" class="w-full text-sm px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 transition-all" placeholder="Misal: Pemasangan Kanopi Outdoor Stainless tahan badai...">
                            @error('deskripsi_proyek') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- INTEGRASI MAPS / ALAMAT KEDUA KOORDINAT -->
                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">2. Lokasi Geografis Proyek</h4>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Alamat Tertulis Lengkap</label>
                        <input list="list-lokasi" wire:model="alamat" class="w-full text-sm px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 transition-all" placeholder="Jl. Raya Kawasan Industri...">
                        <datalist id="list-lokasi">
                            @foreach($listLokasi as $lok) <option value="{{ $lok }}"> @endforeach
                        </datalist>
                        @error('alamat') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Komponen Peta Interaktif -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <div class="text-[11px] text-slate-400 font-medium mb-1">Geser Penanda Peta (Marker) Tepat Pada Lokasi Lapangan:</div>
                            <div id="mapContainer" class="w-full h-48 rounded-xl border border-slate-200" wire:ignore></div>
                        </div>
                        <div class="space-y-3 flex flex-col justify-center">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase">Garis Lintang (Latitude)</label>
                                <input type="text" wire:model="latitude" id="lat_input" readonly class="w-full text-xs px-3 py-2 bg-slate-100 border border-slate-200 rounded-lg text-slate-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase">Garis Bujur (Longitude)</label>
                                <input type="text" wire:model="longitude" id="lng_input" readonly class="w-full text-xs px-3 py-2 bg-slate-100 border border-slate-200 rounded-lg text-slate-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RINCIAN DETAIL ITEM DAN DROPDOWN PENCARIAN MATERIAL -->
                <div class="bg-blue-50/40 p-5 rounded-xl border border-blue-200/80 space-y-4">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 border-b border-blue-100 pb-3">
                        <div>
                            <h4 class="text-sm font-bold text-blue-900">3. Pemecahan Item Kebutuhan Lapangan (RProjectItem)</h4>
                            <p class="text-xs text-blue-600/80 mt-0.5">Pecah data permintaan klien agar tim estimator/engineer dapat memasangkan material secara akurat.</p>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" wire:click="bukaRequestMaterialModal" class="px-3 py-1.5 text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg transition-all cursor-pointer">
                                💡 Request Material Baru
                            </button>
                            <button type="button" wire:click="addItemRow" class="px-3 py-1.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-all cursor-pointer">
                                + Tambah Baris Pekerjaan
                            </button>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @foreach($items as $index => $item)
                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm relative space-y-3">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                <div class="md:col-span-2">
                                    <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1">Nama Item Pekerjaan / Komponen</label>
                                    <input type="text" wire:model="items.{{ $index }}.nama_item" class="w-full text-sm px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500" placeholder="Contoh: Pembuatan Box Panel Utama">
                                    @error('items.'.$index.'.nama_item') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1">Volume Kebutuhan</label>
                                    <input type="number" wire:model="items.{{ $index }}.qty" class="w-full text-sm px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 text-center" min="1">
                                    @error('items.'.$index.'.qty') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1">Satuan</label>
                                    <input type="text" wire:model="items.{{ $index }}.satuan" class="w-full text-sm px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 text-center" placeholder="Unit / Pcs / Set">
                                    @error('items.'.$index.'.satuan') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1">Spesifikasi Mentah dari Klien</label>
                                    <input type="text" wire:model="items.{{ $index }}.spesifikasi_klien" class="w-full text-sm px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500" placeholder="Misal: Harus anti-karat sus 304...">
                                </div>
                                
                                <div>
                                    <label class="block text-[11px] font-bold text-blue-600 uppercase mb-1 flex justify-between">
                                        <span>Jodohkan dengan Master Material (Opsional)</span>
                                    </label>
                                    <!-- Dropdown Material Real Terintegrasi Menampilkan Informasi Kompleks -->
                                    <select wire:model="items.{{ $index }}.material_id" class="w-full text-sm px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 text-slate-700 cursor-pointer">
                                        <option value="">-- Cari & Pilih dari Database --</option>
                                        @foreach($listMasterMaterial as $mat)
                                            <option value="{{ $mat->id }}">
                                                {{ $mat->nama_barang }} | Spek: {{ Str::limit($mat->deskripsi, 40) }} | [Rp {{ number_format($mat->harga, 0, ',', '.') }}/{{ $mat->satuan }}]
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @if(count($items) > 1)
                            <button type="button" wire:click="removeItemRow({{ $index }})" class="absolute top-2 right-2 text-slate-300 hover:text-red-500 p-1 rounded-lg transition-colors" title="Hapus Baris Pekerjaan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Upload Dokumen Lapangan -->
                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm space-y-3">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $isEdit ? 'Tambahkan Berkas Baru (Opsional)' : '4. Berkas Gambar / Sketsa Lapangan Klien' }}</h4>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full min-h-[90px] border-2 border-dashed border-slate-300 rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100/50 transition-colors">
                            <div class="flex flex-col items-center justify-center text-center p-4">
                                <svg class="w-5 h-5 text-slate-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <p class="text-xs text-slate-500 font-semibold"><span class="text-blue-600">Klik untuk jelajahi file</span> gambar atau PDF teknis lapangan</p>
                                @if(count($lampiran) > 0)
                                    <p class="text-xs text-emerald-600 mt-1 font-bold">{{ count($lampiran) }} berkas telah dimuat di sistem.</p>
                                @endif
                            </div>
                            <input type="file" wire:model="lampiran" multiple class="hidden" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" />
                        </label>
                    </div>
                    <div wire:loading wire:target="lampiran" class="text-xs text-blue-600 font-bold">Mengunggah dan mendokumentasikan file...</div>
                    @error('lampiran.*') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                </div>

                <!-- Tombol Eksekusi Form -->
                <div class="flex justify-end gap-2 pt-4 border-t border-slate-100 bg-white sticky bottom-0 z-10">
                    <button type="button" wire:click="tutupModal" class="px-5 py-2.5 text-xs font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all cursor-pointer">BATAL</button>
                    <button type="submit" class="px-5 py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md flex items-center gap-2 transition-all cursor-pointer">
                        <span wire:loading wire:target="{{ $isEdit ? 'updateProyek' : 'simpanProyek' }}" class="animate-spin h-3 w-3 border-2 border-t-white border-blue-300 rounded-full"></span>
                        {{ $isEdit ? 'PERBARUI DATA PROYEK' : 'SIMPAN DAN AJUKAN PROYEK' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- POP-UP MODAL REQUEST MATERIAL BARU -->
    @if($isRequestMaterialModalOpen)
    <div class="fixed inset-0 z-[110] bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md border border-slate-200 overflow-hidden transform transition-all">
            <div class="px-5 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="text-sm font-bold text-slate-800">Form Pengajuan Material Baru ke Purchasing</h3>
                <button type="button" wire:click="$set('isRequestMaterialModalOpen', false)" class="text-slate-400 hover:text-slate-600 text-lg">×</button>
            </div>
            <form wire:submit.prevent="simpanRequestMaterial" class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Material / Barang</label>
                    <input type="text" wire:model="req_nama_material" class="w-full text-sm px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500" placeholder="Contoh: Plat Besi Tahan Karat Khusus Outdoor">
                    @error('req_nama_material') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Deskripsi Singkat / Alasan Kebutuhan</label>
                    <textarea wire:model="req_deskripsi" rows="3" class="w-full text-sm px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 resize-none" placeholder="Deskripsikan ketebalan, merk, atau alasan kenapa harus barang ini..."></textarea>
                    @error('req_deskripsi') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Satuan Dasar</label>
                    <input type="text" wire:model="req_satuan" class="w-full text-sm px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:border-blue-500" placeholder="Pcs / Lembar / Batang / Kg">
                    @error('req_satuan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                    <button type="button" wire:click="$set('isRequestMaterialModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-500 bg-slate-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 rounded-lg shadow-sm">Kirim ke Purchasing</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- MODAL DETAIL OPERASIONAL (PREVIEW LENGKAP & RAD STATUS) -->
    @if($isDetailModalOpen)
    <div class="fixed inset-0 z-[100] overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 py-8">
        <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] flex flex-col shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center sticky top-0 bg-white z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 shadow-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-800">{{ $detail_request_no }}</h3>
                        <p class="text-xs text-slate-400 font-bold tracking-wider uppercase">{{ $detail_nama_pelanggan }}</p>
                    </div>
                </div>
                <button wire:click="tutupDetailModal" class="w-8 h-8 rounded-full bg-slate-50 hover:bg-red-50 hover:text-red-500 flex justify-center items-center transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
           
            <div class="p-6 md:p-8 space-y-6 overflow-y-auto flex-1 bg-slate-50/50">
                <!-- Data Makro Proyek -->
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Informasi Umum Pemesanan</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kategori</span>
                            <span class="text-xs font-bold text-slate-800 mt-1 block uppercase">{{ $detail_kategori }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Prioritas Dokumen</span>
                            <span class="text-xs font-bold text-slate-800 mt-1 block uppercase">{{ $detail_priority }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Target Batas Akhir</span>
                            <span class="text-xs font-bold text-slate-800 mt-1 block">{{ \Carbon\Carbon::parse($detail_target_waktu)->format('d M Y') }}</span>
                        </div>
                        <div class="bg-blue-50 p-3 rounded-xl border border-blue-100">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider block">Estimasi Pagu Kontrak</span>
                            <span class="text-sm font-black text-blue-700 mt-0.5 block">Rp {{ number_format((int)$detail_estimasi_budget, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-0.5">PIC Lapangan & No Kontak</span>
                            <p class="text-xs font-bold text-slate-800">{{ $detail_pic_pelanggan }} <span class="text-slate-400 font-medium">({{ $detail_no_hp }})</span></p>
                           
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mt-3 mb-0.5">Alamat Tertulis</span>
                            <p class="text-xs font-medium text-slate-600 leading-relaxed">{{ $detail_alamat }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-0.5">Harapan Klien & Keterangan Teknis</span>
                            <p class="text-xs font-medium text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100 whitespace-pre-wrap">{{ $detail_deskripsi_proyek }}</p>
                        </div>
                    </div>

                    <!-- View Maps Koordinat pada Detail -->
                    <div class="pt-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Visualisasi Maps Lapangan</span>
                        <div id="detailMapContainer" class="w-full h-36 rounded-xl border border-slate-200" wire:ignore></div>
                    </div>
                </div>

                <!-- Rincian Pemecahan Item Klien -->
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-3">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Rincian Item Kebutuhan Lapangan Terdaftar (RProjectItem)</h4>
                    <div class="overflow-x-auto border border-slate-200 rounded-lg">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-slate-50 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-2.5">Nama Komponen Pekerjaan</th>
                                    <th class="px-4 py-2.5">Spesifikasi Permintaan Klien</th>
                                    <th class="px-4 py-2.5 text-center">Volume Klien</th>
                                    <th class="px-4 py-2.5">Jodoh Master Material Terkait</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($detail_items as $itm)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-4 py-3 font-semibold text-slate-800">{{ $itm['nama_item'] }}</td>
                                    <td class="px-4 py-3 text-slate-500">{{ $itm['spesifikasi_klien'] ?: '-' }}</td>
                                    <td class="px-4 py-3 text-center font-bold text-blue-600 bg-blue-50/30">{{ $itm['qty'] }} {{ $itm['satuan'] }}</td>
                                    <td class="px-4 py-3"><span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600 font-medium text-[11px]">{{ $itm['material_terpilih'] }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Status Perhitungan RAB Real -->
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-3">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Status Anggaran Pembiayaan Resmi (Engineering Costing)</h4>
                    @php
                        $rabTerkait = \App\Models\Rab::where('id_r_project', $detail_id)->first();
                    @endphp
                    @if($rabTerkait)
                        <div class="flex flex-col sm:flex-row items-center justify-between bg-slate-50 p-4 rounded-xl border border-slate-200 gap-3">
                            <div>
                                <p class="text-xs font-bold text-slate-800">{{ $rabTerkait->no_boq }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <p class="text-xs text-slate-500">Total Akumulasi HPP: <span class="text-slate-800 font-bold">Rp {{ number_format($rabTerkait->grand_total, 0, ',', '.') }}</span></p>
                                    <span class="text-slate-300">|</span>
                                    @if($rabTerkait->status_rab == 'approved')
                                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded">RAB APPROVED</span>
                                    @else
                                        <span class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded">RAB PENDING APPROVAL</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                @if($rabTerkait->status_rab == 'approved')
                                   <a href="{{ route('marketing.bidding', ['create_from_proyek' => $detail_id]) }}" wire:navigate class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm flex items-center gap-1.5 transition-all cursor-pointer">
                                        Lanjut Modul Bidding Penawaran
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                @else
                                    <p class="text-[11px] text-slate-400 italic">Modul Penawaran Bidding terkunci hingga berkas RAB disetujui Direksi.</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-6 bg-slate-50 rounded-xl border border-dashed border-slate-300 text-center">
                            <p class="text-xs font-bold text-slate-400">Tim Engineering Costing belum mendaftarkan rincian pembiayaan material proyek ini.</p>
                        </div>
                    @endif
                </div>
            </div>
           
            <div class="px-6 py-4 bg-white border-t border-slate-100 flex justify-end rounded-b-2xl">
                <button wire:click="tutupDetailModal" class="px-5 py-2 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all cursor-pointer">TUTUP PANEL DETAIL</button>
            </div>
        </div>
    </div>
    @endif

    <!-- LIFECYCLE JAVASCRIPT MAPS INTERAKTIF -->
    <script>
        let map, marker;
        let detailMap, detailMarker;

        window.addEventListener('initMap', event => {
            setTimeout(() => {
                let lat = event.detail.lat;
                let lng = event.detail.lng;
                
                if (!map) {
                    map = L.map('mapContainer').setView([lat, lng], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(map);

                    marker = L.marker([lat, lng], {draggable: true}).addTo(map);
                    
                    marker.on('dragend', function (e) {
                        let position = marker.getLatLng();
                        @this.dispatch('setKoordinat', { lat: position.lat, lng: position.lng });
                    });

                    map.on('click', function(e) {
                        marker.setLatLng(e.latlng);
                        @this.dispatch('setKoordinat', { lat: e.latlng.lat, lng: e.latlng.lng });
                    });
                } else {
                    map.setView([lat, lng], 13);
                    marker.setLatLng([lat, lng]);
                }
                map.invalidateSize();
            }, 300);
        });

        window.addEventListener('initDetailMap', event => {
            setTimeout(() => {
                let lat = event.detail.lat;
                let lng = event.detail.lng;

                if (!detailMap) {
                    detailMap = L.map('detailMapContainer', {dragging: false, tap: false, zoomControl: false}).setView([lat, lng], 14);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap'
                    }).addTo(detailMap);
                    detailMarker = L.marker([lat, lng]).addTo(detailMap);
                } else {
                    detailMap.setView([lat, lng], 14);
                    detailMarker.setLatLng([lat, lng]);
                }
                detailMap.invalidateSize();
            }, 300);
        });
    </script>
</div>