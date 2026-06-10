<div class="fixed inset-0 z-50 flex items-center justify-center bg-[#003057]/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-y-auto flex flex-col">
        <div class="p-6 border-b flex justify-between items-center sticky top-0 bg-white z-30 rounded-t-3xl">
            <div>
                <h2 class="text-2xl font-bold text-[#003057]">{{ $isEdit ? 'Update Proyek' : 'Inisiasi Proyek Baru' }}</h2>
                <p class="text-xs text-gray-500 mt-1">Silakan pilih metode input data untuk memulai.</p>
            </div>
            <button wire:click="tutupModal" class="text-gray-400 hover:text-red-500 text-3xl font-bold">&times;</button>
        </div>

        <div class="p-8 space-y-8">
            {{-- ERROR SESSION ALERT --}}
            @if (session()->has('gagal'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('gagal') }}</span>
                </div>
            @endif

            {{-- TOGGLE METODE --}}
            <div class="flex p-1 bg-[#F2F2F2] rounded-2xl w-fit mx-auto shadow-inner border border-gray-200">
                <button wire:click="$set('metode_input', 'manual')" class="px-8 py-3 rounded-xl text-sm font-bold transition-all {{ $metode_input === 'manual' ? 'bg-[#003057] text-white shadow-lg' : 'text-gray-500 hover:bg-gray-200' }}"> Metode A: Input Manual</button>
                <button wire:click="$set('metode_input', 'rfq')" class="px-8 py-3 rounded-xl text-sm font-bold transition-all {{ $metode_input === 'rfq' ? 'bg-[#003057] text-white shadow-lg' : 'text-gray-500 hover:bg-gray-200' }}">📄 Metode B: RFQ Customer</button>
            </div>
            
            {{-- INFO UTAMA --}}
            <div class="bg-[#F2F2F2]/50 p-6 rounded-2xl border border-gray-200">
                <h3 class="text-xs font-bold text-[#003057] uppercase tracking-widest mb-4 border-b pb-2">Informasi Utama</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-[#003057] mb-1.5">Nama Proyek *</label>
                        <input type="text" wire:model="nama_projek" class="w-full bg-white border border-gray-300 rounded-xl p-3 outline-none focus:ring-2 focus:ring-[#E8BF00]">
                        @error('nama_projek') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="relative" x-data="{ open: false }">
                        <label class="block text-sm font-semibold text-[#003057] mb-1.5">Kategori Pekerjaan *</label>
                        <input type="text" wire:model.live.debounce.300ms="search_kategori" @focus="open = true" @click.away="open = false" placeholder="{{ $nama_kategori_terpilih ?: 'Cari kategori...' }}" class="w-full bg-white border border-gray-300 rounded-xl p-3 outline-none">
                        <div x-show="open" class="absolute left-0 right-0 mt-1 bg-white border rounded-xl shadow-xl z-50 max-h-40 overflow-y-auto">
                            @foreach($listKategori as $kat)
                                <div wire:click="pilihKategori('{{ $kat->id }}', '{{ addslashes($kat->nama_kategori) }}')" @click="open = false" class="p-3 hover:bg-[#F2F2F2] cursor-pointer text-sm font-semibold">{{ $kat->nama_kategori }}</div>
                            @endforeach
                        </div>
                        @error('category_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-[#003057] mb-1.5">Prioritas *</label>
                        <select wire:model="priority" class="w-full bg-white border border-gray-300 rounded-xl p-3 outline-none">
                            <option value="low">Low</option><option value="medium">Medium</option><option value="high">High</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- INFO PELANGGAN --}}
            <div class="bg-[#F2F2F2]/50 p-6 rounded-2xl border border-gray-200">
                <h3 class="text-xs font-bold text-[#003057] uppercase tracking-widest mb-4 border-b pb-2">Detail Pelanggan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-[#003057] mb-1.5">Nama Perusahaan / Customer *</label>
                        <input type="text" wire:model="nama_pelanggan" class="w-full bg-white border border-gray-300 rounded-xl p-3 outline-none">
                        @error('nama_pelanggan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-[#003057] mb-1.5">PIC Lapangan *</label>
                        <input type="text" wire:model="pic_pelanggan" class="w-full bg-white border border-gray-300 rounded-xl p-3 outline-none">
                        @error('pic_pelanggan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-[#003057] mb-1.5">Nomor HP / WA *</label>
                        <input type="text" wire:model="no_hp" class="w-full bg-white border border-gray-300 rounded-xl p-3 outline-none">
                        @error('no_hp') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- METODE A: MANUAL --}}
            @if($metode_input === 'manual')
            <div class="bg-[#F2F2F2]/50 p-6 rounded-2xl border border-gray-200">
                <h3 class="text-xs font-bold text-[#003057] uppercase tracking-widest mb-4 border-b pb-2">Spesifikasi Manual (Semua Field Wajib)</h3>
                <div class="space-y-5">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-[#003057] mb-1.5">Target Waktu *</label>
                            <input type="date" wire:model="target_waktu" class="w-full bg-white border border-gray-300 rounded-xl p-3 outline-none">
                            @error('target_waktu') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#003057] mb-1.5">Estimasi Budget (Rp) *</label>
                            <input type="number" wire:model="estimasi_budget" class="w-full bg-white border border-gray-300 rounded-xl p-3 outline-none">
                            @error('estimasi_budget') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#003057] mb-1.5">Deskripsi Kebutuhan Teknis *</label>
                        <textarea wire:model="deskripsi_proyek" rows="4" class="w-full bg-white border border-gray-300 rounded-xl p-3 text-sm outline-none"></textarea>
                        @error('deskripsi_proyek') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-[#003057] mb-1.5">Alamat Lokasi Proyek *</label>
                        <textarea wire:model="alamat" rows="2" class="w-full bg-white border border-gray-300 rounded-xl p-3 text-sm outline-none"></textarea>
                        @error('alamat') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- FOTO REFERENSI --}}
                        <div>
                            <label class="block text-xs font-bold text-[#003057] mb-1 uppercase">Foto Referensi (Opsional)</label>
                            <input type="file" wire:model="file_referensi" multiple accept="image/*" class="text-xs block w-full text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:bg-[#A3B5E0]/30 file:text-[#003057]">
                            <div wire:loading wire:target="file_referensi" class="text-xs text-blue-500 mt-1">Sedang mengunggah...</div>
                            @error('file_referensi.*') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            
                            {{-- Preview File Baru Diupload --}}
                            @if($file_referensi)
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach($file_referensi as $file)
                                        <img src="{{ $file->temporaryUrl() }}" class="h-12 w-12 object-cover rounded border border-gray-300 shadow-sm">
                                    @endforeach
                                </div>
                            @endif

                            {{-- Tampil File Lama (Edit Mode) --}}
                            @if($isEdit && isset($existingAttachments['reference_image']) && $existingAttachments['reference_image']->count() > 0)
                                <div class="mt-3 grid grid-cols-2 gap-2">
                                    @foreach($existingAttachments['reference_image'] as $att)
                                        <div class="relative group border border-gray-200 rounded-lg overflow-hidden bg-white shadow-sm">
                                            <img src="{{ asset('storage/' . $att->file_path) }}" class="object-cover w-full h-20">
                                            <label for="replace-file-ref-{{ $att->id }}" class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center cursor-pointer transition rounded-lg">
                                                <span class="text-white text-[10px] font-bold">GANTI</span>
                                                <input type="file" id="replace-file-ref-{{ $att->id }}" class="hidden" wire:model="replaceFile" wire:change="replaceFoto({{ $att->id }})">
                                            </label>
                                            <button wire:click="hapusFoto({{ $att->id }})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow">&times;</button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- FOTO LOKASI --}}
                        <div>
                            <label class="block text-xs font-bold text-[#003057] mb-1 uppercase">Foto Lokasi (Opsional)</label>
                            <input type="file" wire:model="file_lokasi" multiple accept="image/*" class="text-xs block w-full text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:bg-[#A3B5E0]/30 file:text-[#003057]">
                            <div wire:loading wire:target="file_lokasi" class="text-xs text-blue-500 mt-1">Sedang mengunggah...</div>
                            @error('file_lokasi.*') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            
                            {{-- Preview File Baru Diupload --}}
                            @if($file_lokasi)
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach($file_lokasi as $file)
                                        <img src="{{ $file->temporaryUrl() }}" class="h-12 w-12 object-cover rounded border border-gray-300 shadow-sm">
                                    @endforeach
                                </div>
                            @endif

                            @if($isEdit && isset($existingAttachments['location_photo']) && $existingAttachments['location_photo']->count() > 0)
                                <div class="mt-3 grid grid-cols-2 gap-2">
                                    @foreach($existingAttachments['location_photo'] as $att)
                                        <div class="relative group border border-gray-200 rounded-lg overflow-hidden bg-white shadow-sm">
                                            <img src="{{ asset('storage/' . $att->file_path) }}" class="object-cover w-full h-20">
                                            <label for="replace-file-loc-{{ $att->id }}" class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center cursor-pointer transition rounded-lg">
                                                <span class="text-white text-[10px] font-bold">GANTI</span>
                                                <input type="file" id="replace-file-loc-{{ $att->id }}" class="hidden" wire:model="replaceFile" wire:change="replaceFoto({{ $att->id }})">
                                            </label>
                                            <button wire:click="hapusFoto({{ $att->id }})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow">&times;</button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- DRAWING TEKNIK --}}
                        <div>
                            <label class="block text-xs font-bold text-[#003057] mb-1 uppercase">Drawing Teknik (Opsional)</label>
                            <input type="file" wire:model="file_drawing" multiple accept="image/*" class="text-xs block w-full text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:bg-[#A3B5E0]/30 file:text-[#003057]">
                            <div wire:loading wire:target="file_drawing" class="text-xs text-blue-500 mt-1">Sedang mengunggah...</div>
                            @error('file_drawing.*') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            
                            {{-- Preview File Baru Diupload --}}
                            @if($file_drawing)
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach($file_drawing as $file)
                                        <img src="{{ $file->temporaryUrl() }}" class="h-12 w-12 object-cover rounded border border-gray-300 shadow-sm">
                                    @endforeach
                                </div>
                            @endif

                            @if($isEdit && isset($existingAttachments['technical_drawing']) && $existingAttachments['technical_drawing']->count() > 0)
                                <div class="mt-3 grid grid-cols-2 gap-2">
                                    @foreach($existingAttachments['technical_drawing'] as $att)
                                        <div class="relative group border border-gray-200 rounded-lg overflow-hidden bg-white shadow-sm">
                                            <img src="{{ asset('storage/' . $att->file_path) }}" class="object-cover w-full h-20">
                                            <label for="replace-file-dwg-{{ $att->id }}" class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center cursor-pointer transition rounded-lg">
                                                <span class="text-white text-[10px] font-bold">GANTI</span>
                                                <input type="file" id="replace-file-dwg-{{ $att->id }}" class="hidden" wire:model="replaceFile" wire:change="replaceFoto({{ $att->id }})">
                                            </label>
                                            <button wire:click="hapusFoto({{ $att->id }})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow">&times;</button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- METODE B: RFQ --}}
            @if($metode_input === 'rfq')
            <div class="bg-[#F2F2F2]/50 p-6 rounded-2xl border border-gray-200">
                <h3 class="text-xs font-bold text-[#003057] uppercase tracking-widest mb-4 border-b pb-2">Dokumen RFQ (Metode B)</h3>
                <div class="border-2 border-dashed border-gray-300 p-8 rounded-2xl text-center bg-white">
                    <label class="cursor-pointer">
                        <span class="text-4xl block mb-2">📄</span>
                        <span class="text-sm font-bold text-[#003057]">Upload Dokumen RFQ Asli (PDF)</span>
                        <input type="file" wire:model="file_rfq" accept="application/pdf" class="hidden">
                        <p class="text-xs text-gray-500 mt-2">Maksimal 10MB.</p>
                    </label>
                    <div wire:loading wire:target="file_rfq" class="text-sm font-bold text-blue-500 mt-4">Mengunggah PDF...</div>
                    
                    @if($file_rfq) 
                        <div class="mt-4 p-2 bg-green-50 text-green-700 text-xs font-bold rounded-lg border border-green-200">{{ $file_rfq->getClientOriginalName() }} Terpilih</div>
                    @elseif($isEdit && !empty($existingAttachments['proposal']))
                        <div class="mt-4 p-3 bg-blue-50 text-blue-700 text-xs rounded-lg text-left border border-blue-200">
                            <div class="font-semibold">Dokumen RFQ Saat Ini:</div>
                            <a href="{{ asset('storage/' . $existingAttachments['proposal']->file_path) }}" target="_blank" class="underline break-all">{{ $existingAttachments['proposal']->file_name }}</a>
                        </div>
                    @endif
                </div>
                @error('file_rfq') <span class="text-xs text-red-500 mt-1 block text-center">{{ $message }}</span> @enderror
            </div>
            @endif
        </div>

        <div class="p-6 border-t bg-[#FAFAFA] flex justify-end gap-4 rounded-b-3xl sticky bottom-0 z-30">
            <button wire:click="tutupModal" class="px-6 py-3 rounded-xl text-sm font-bold bg-gray-200 hover:bg-gray-300 text-[#003057] transition-colors">Batal</button>
            
            {{-- Tombol Simpan yang dikunci kalau lagi upload --}}
            <button wire:click="{{ $isEdit ? 'updateProyek' : 'simpanProyek' }}" 
                    wire:loading.attr="disabled" 
                    wire:target="simpanProyek, updateProyek, file_referensi, file_lokasi, file_drawing, file_rfq"
                    class="px-8 py-3 rounded-xl text-sm font-bold bg-[#E8BF00] hover:bg-[#D4AF37] text-[#003057] shadow-md flex items-center gap-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading wire:target="simpanProyek, updateProyek" class="animate-spin w-4 h-4 border-2 border-t-transparent border-[#003057] rounded-full"></span>
                <span wire:loading wire:target="file_referensi, file_lokasi, file_drawing, file_rfq">Menunggu File...</span>
                <span wire:loading.remove wire:target="file_referensi, file_lokasi, file_drawing, file_rfq">{{ $isEdit ? 'Simpan Perubahan' : 'Buat Proyek' }}</span>
            </button>
        </div>
    </div>
</div>