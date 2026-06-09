<div class="min-h-screen font-sans transition-colors duration-300" 
     x-data="{ darkMode: true }" 
     :class="darkMode ? 'bg-[#1A0D05] text-[#FDECE2]' : 'bg-[#FCF6F0] text-[#5C2C00]'">
    
    <div class="w-full mx-auto p-4 md:p-6 relative">
        <div class="w-full flex flex-col md:flex-row items-start md:items-center justify-between mb-6 p-4 rounded-2xl border transition-colors sticky top-4 z-40 shadow-lg backdrop-blur-xl"
             :class="darkMode ? 'bg-[#1A0D05]/80 border-[#FF7A00]/30' : 'bg-white/90 border-[#E65C00]/30'">
            <div class="flex items-center gap-4 mb-4 md:mb-0 w-full md:w-auto">
                <button wire:click="kembaliKeList" class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl border transition-all flex items-center gap-2" :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FFC107]' : 'bg-[#FCF6F0] border-[#E65C00]/20 text-[#E65C00]'">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    KEMBALI KE DETAIL
                </button>
                <div class="flex items-center gap-1 p-1 rounded-xl shadow-inner border transition-colors" :class="darkMode ? 'bg-[#0D0602] border-[#331A0A]' : 'bg-[#F2E5D9] border-[#E65C00]/20'">
                    <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-white shadow text-[#E65C00] font-black' : 'text-[#5C2C00]/50'" class="px-3 py-1.5 text-[9px] rounded-lg transition-all uppercase tracking-widest">Terang</button>
                    <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-[#261308] text-[#FFC107] shadow border border-[#FF7A00]/30 font-black' : 'text-[#FDECE2]/50'" class="px-3 py-1.5 text-[9px] rounded-lg transition-all uppercase tracking-widest">Gelap</button>
                </div>
            </div>

            <div class="w-full md:w-auto flex justify-end">
                @if(!$isApproved)
                    <button wire:click="submitKeDirektur" wire:loading.attr="disabled" class="w-full md:w-auto px-6 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg transition-all border flex justify-center items-center gap-2" :class="darkMode ? 'bg-[#FF7A00] border-[#FF7A00] text-[#1A0D05]' : 'bg-[#E65C00] border-[#E65C00] text-white'">
                        <span wire:loading.remove wire:target="submitKeDirektur">SUBMIT KE DIREKTUR</span>
                        <span wire:loading wire:target="submitKeDirektur" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            MEMPROSES...
                        </span>
                    </button>
                @else
                    <span class="w-full md:w-auto px-6 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl bg-emerald-500/20 text-emerald-500 border border-emerald-500/30 text-center">DOKUMEN DIKUNCI (APPROVED)</span>
                @endif
            </div>
        </div>

        @if ($errors->has('nama_editor') || $errors->has('commit_message'))
            <div class="mb-6 p-5 border-l-4 rounded-xl shadow-sm animate-pulse" :class="darkMode ? 'bg-rose-950/40 border-rose-500 text-rose-300' : 'bg-rose-50 border-rose-500 text-rose-700'">
                <p class="font-black text-xs uppercase tracking-widest">Form Histori Belum Lengkap! Isi bagian pesan commit di panel kiri.</p>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start relative">
            
            <div class="xl:col-span-3 border rounded-3xl p-6 flex flex-col justify-between transition-colors shadow-sm sticky top-28 self-start max-h-[85vh] overflow-y-auto"
                 :class="darkMode ? 'bg-[#1F0D05] border-[#5C2000]' : 'bg-white border-[#ED9D59]/40'">
                <div>
                    <h3 class="text-[10px] font-black uppercase tracking-widest mb-6 border-b-2 pb-3" :class="darkMode ? 'text-[#FF7A00] border-[#331A0A]' : 'text-[#E65C00] border-[#F5A623]/20'">
                        INFO TARGET PROYEK
                    </h3>
                    <div class="space-y-5">
                        <div>
                            <span class="text-[9px] font-black uppercase tracking-widest opacity-50 block">INSTANSI / KLIEN</span>
                            <p class="text-sm font-black mt-1 uppercase" :class="darkMode ? 'text-white' : 'text-[#5C2C00]'">{{ $selectedProject->nama_pelanggan }}</p>
                        </div>
                        <div>
                            <span class="text-[9px] font-black uppercase tracking-widest opacity-50 block">TARGET WAKTU</span>
                            <p class="text-sm font-bold font-mono mt-1" :class="darkMode ? 'text-[#FFC107]' : 'text-[#F5A623]'">
                                {{ $selectedProject->target_waktu ? \Carbon\Carbon::parse($selectedProject->target_waktu)->format('d F Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <span class="text-[9px] font-black uppercase tracking-widest opacity-50 block">ALAMAT LOKASI</span>
                            <p class="text-xs font-bold mt-1.5 leading-relaxed opacity-80">{{ $selectedProject->alamat ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-[9px] font-black uppercase tracking-widest opacity-50 block mb-1.5">SPESIFIKASI TEKNIS</span>
                            <div class="text-[11px] font-bold p-4 rounded-xl border max-h-40 overflow-y-auto whitespace-pre-line shadow-inner"
                                 :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FDECE2]/70' : 'bg-[#FCF8F5] border-[#ED9D59]/40 text-[#A33C04]/80'">
                                {{ $selectedProject->deskripsi_proyek ?? 'Tidak ada catatan teknis.' }}
                            </div>
                        </div>
                    </div>
                </div>

                @if(!$isApproved)
                    <div class="mt-8 border-t-2 pt-6" :class="darkMode ? 'border-[#331A0A]' : 'border-[#F5A623]/20'">
                        <span class="text-[10px] font-black uppercase tracking-widest flex items-center gap-2 mb-4" :class="darkMode ? 'text-[#FF7A00]' : 'text-[#E65C00]'">
                            PESAN COMMIT HISTORI
                        </span>
                        <div class="space-y-4">
                            <div>
                                <input type="text" wire:model="nama_editor" placeholder="Nama Anda..." class="w-full text-xs font-bold px-4 py-3 rounded-xl border outline-none transition-all shadow-inner" :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-white focus:border-[#FF7A00]' : 'bg-[#FCF6F0] border-[#E65C00]/30 text-[#5C2C00] focus:border-[#E65C00]'">
                                @error('nama_editor') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest mt-1.5 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <textarea wire:model="commit_message" placeholder="Catatan revisi/draf ini..." rows="3" class="w-full text-xs font-bold px-4 py-3 rounded-xl border outline-none transition-all resize-none shadow-inner" :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-white focus:border-[#FF7A00]' : 'bg-[#FCF6F0] border-[#E65C00]/30 text-[#5C2C00] focus:border-[#E65C00]'">
                                </textarea>
                                @error('commit_message') <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest mt-1.5 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-9 space-y-6">
                @if(!$isApproved)
                    <div class="border rounded-3xl p-6 transition-colors shadow-sm" :class="darkMode ? 'bg-[#261308] border-[#331A0A]' : 'bg-white border-[#E65C00]/20'">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-[9px] font-black uppercase tracking-widest opacity-60 mb-2">NO. BOQ</label>
                                <input type="text" wire:model="no_boq" class="w-full text-sm font-mono font-black px-4 py-3 rounded-xl border outline-none transition-all shadow-inner" :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FFC107]' : 'bg-[#FCF6F0] border-[#E65C00]/30 text-[#E65C00]'">
                            </div>
                            <div>
                                <label class="block text-[9px] font-black uppercase tracking-widest opacity-60 mb-2">TANGGAL DOKUMEN</label>
                                <input type="date" wire:model="tanggal_dokumen" class="w-full text-sm font-bold px-4 py-3 rounded-xl border outline-none transition-all shadow-inner" :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FFC107]' : 'bg-[#FCF6F0] border-[#E65C00]/30 text-[#E65C00]'">
                            </div>
                            <div>
                                <label class="block text-[9px] font-black uppercase tracking-widest opacity-60 mb-2">OVERHEAD COST (RP)</label>
                                <input type="number" wire:model.live="overhead_cost" class="w-full text-sm font-mono font-black px-4 py-3 rounded-xl border outline-none transition-all shadow-inner" :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FFC107]' : 'bg-[#FCF6F0] border-[#E65C00]/30 text-[#E65C00]'">
                            </div>
                        </div>
                    </div>
                @endif

                <div class="rounded-3xl border transition-colors shadow-sm overflow-hidden" :class="darkMode ? 'bg-[#261308] border-[#331A0A]' : 'bg-white border-[#E65C00]/20'">
                    @if(!$isApproved)
                        <div class="p-4 border-b flex justify-between items-center gap-3" :class="darkMode ? 'bg-[#1A0D05]/50 border-[#331A0A]' : 'bg-[#FCF6F0] border-[#E65C00]/20'">
                            <div class="flex items-center gap-3 w-full max-w-lg">
                                <input type="text" wire:model="newKategori" placeholder="Ketik nama kategori (ex: Sipil)..." class="text-xs font-bold rounded-xl px-4 py-3 w-full border outline-none shadow-inner transition-all" :class="darkMode ? 'bg-[#0D0602] border-[#331A0A] text-[#FFC107]' : 'bg-white border-[#E65C00]/30 text-[#5C2C00]'">
                                <button type="button" wire:click="tambahKategori" class="px-5 py-3 text-[10px] font-black rounded-xl transition-all shrink-0 uppercase tracking-widest shadow-md border" :class="darkMode ? 'bg-[#FF7A00] border-[#FF7A00] text-[#1A0D05]' : 'bg-[#E65C00] border-[#E65C00] text-white'">TAMBAH</button>
                            </div>
                        </div>
                    @endif

                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left text-xs border-collapse min-w-[950px]">
                            <thead class="font-black uppercase tracking-widest border-b" :class="darkMode ? 'bg-[#0D0602] text-[#D96D06] border-[#5C2000]' : 'bg-[#FCF8F5] text-[#D96D06] border-[#ED9D59]/40'">
                                <tr>
                                    <th class="px-4 py-4 text-center w-12 border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">NO</th>
                                    <th class="px-4 py-4 w-[30%] border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">DESKRIPSI PEKERJAAN</th>
                                    <th class="px-4 py-4 w-[25%] border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">MATERIAL</th>
                                    <th class="px-4 py-4 text-center w-16 border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">VOL</th>
                                    <th class="px-4 py-4 text-right w-32 border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">HARGA SATUAN</th>
                                    <th class="px-4 py-4 text-right w-40 {{ !$isApproved ? 'border-r' : '' }}" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">SUBTOTAL (RP)</th>
                                    @if(!$isApproved) <th class="px-4 py-4 text-center w-16">ACT</th> @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y font-bold relative" :class="darkMode ? 'divide-[#5C2000]' : 'divide-[#ED9D59]/30'">
                                @php $noIndex = 1; @endphp
                                @foreach($kategoris as $kat)
                                    <tr wire:key="kategori-{{ $kat->id }}" :class="darkMode ? 'bg-[#3B1500]/40 text-[#FAB64A]' : 'bg-[#FFF6ED] text-[#A33C04]'" class="font-black border-y-2" :style="darkMode ? 'border-color: #5C2000' : 'border-color: #ED9D59'">
                                        <td class="px-4 py-3 text-center font-mono border-r" :class="darkMode?'border-[#5C2000]':'border-[#ED9D59]/30'">{{ $noIndex++ }}</td>
                                        <td class="px-4 py-3 border-r uppercase tracking-wide" :class="darkMode?'border-[#5C2000]':'border-[#ED9D59]/30'" colspan="2">{{ $kat->deskripsi_pekerjaan }}</td>
                                        <td class="px-4 py-3 text-center border-r" :class="darkMode?'border-[#5C2000]':'border-[#ED9D59]/30'">-</td>
                                        <td class="px-4 py-3 text-right border-r" :class="darkMode?'border-[#5C2000]':'border-[#ED9D59]/30'">-</td>
                                        <td class="px-4 py-3 text-right font-mono font-black {{ !$isApproved ? 'border-r' : '' }}" :class="darkMode?'border-[#5C2000] text-white':'border-[#ED9D59]/30 text-[#5C2C00]'">Rp {{ number_format($kat->children->sum('subtotal'), 0, ',', '.') }}</td>
                                        @if(!$isApproved)
                                            <td class="px-4 py-3 text-center"><button type="button" wire:click="hapusItem({{ $kat->id }})" class="text-rose-500 hover:text-white bg-rose-500/10 hover:bg-rose-500 p-1.5 rounded transition-colors" title="Hapus Kategori">X</button></td>
                                        @endif
                                    </tr>

                                    @foreach($kat->children as $item)
                                        <tr wire:key="item-{{ $item->id }}" :class="darkMode ? 'hover:bg-[#1A0D05]/40 text-[#FDECE2]/80' : 'hover:bg-[#FCF6F0] text-[#5C2C00]/90'">
                                            <td class="px-4 py-2 text-center font-mono border-r opacity-40" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'"></td>
                                            <td class="px-4 py-2 border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">{{ $item->deskripsi_pekerjaan }}</td>
                                            <td class="px-4 py-2 border-r font-mono opacity-80" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">
                                                {{ $item->material->nama_barang ?? 'Custom/Tenaga' }}
                                                <span class="text-[10px] opacity-60 ml-1">({{ $item->material->satuan ?? '-' }})</span>
                                            </td>
                                            <td class="px-4 py-2 text-center border-r font-mono" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">{{ $item->qty }}</td>
                                            <td class="px-4 py-2 text-right border-r font-mono" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/20'">Rp {{ number_format($item->harga_awal, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-right border-r font-mono font-black" :class="darkMode ? 'border-[#5C2000] text-[#FFC107]':'border-[#ED9D59]/20 text-[#E65C00]'">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            @if(!$isApproved)
                                                <td class="px-4 py-2 text-center"><button type="button" wire:click="hapusItem({{ $item->id }})" class="text-rose-500/70 hover:text-rose-500 p-1" title="Hapus Item">X</button></td>
                                            @endif
                                        </tr>
                                    @endforeach

                                    @if(!$isApproved)
                                        <tr wire:key="form-input-{{ $kat->id }}" :class="darkMode ? 'bg-[#0D0602]/50' : 'bg-[#FCF6F0]/50'" class="border-b relative">
                                            <td class="px-3 py-2 border-r opacity-30 text-center text-lg font-black" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/30'">+</td>
                                            <td class="px-3 py-2 border-r" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/30'">
                                                <input type="text" wire:model="deskripsiInput.{{ $kat->id }}" placeholder="Rincian..." class="w-full text-xs font-bold rounded-lg px-3 py-2 outline-none border shadow-inner" :class="darkMode ? 'bg-[#1A0D05] border-[#331A0A] text-white focus:border-[#FF7A00]' : 'bg-white border-[#E65C00]/40 text-[#5C2C00] focus:border-[#E65C00]'">
                                            </td>
                                            <td class="px-3 py-2 border-r relative" :class="darkMode ? 'border-[#5C2000]':'border-[#ED9D59]/30'">
                                                @if(!empty($selectedMaterial[$kat->id]))
                                                    <div class="flex items-center justify-between p-2 rounded-lg font-mono text-[10px] font-black border transition-all" :class="darkMode ? 'bg-[#1A0D05] border-[#FF7A00]/50 text-[#FFC107]' : 'bg-[#FFF6ED] border-[#E65C00]/50 text-[#E65C00]'">
                                                        <div class="flex items-center gap-2 truncate pr-2"><span class="truncate">{{ $selectedMaterial[$kat->id]['nama'] }}</span></div>
                                                        <button type="button" wire:click="batalPilihMaterial({{ $kat->id }})" class="text-rose-500 hover:text-rose-400 p-1 focus:outline-none">X</button>
                                                    </div>
                                                @else
                                                    <input type="text" wire:model.live.debounce.300ms="materialSearch.{{ $kat->id }}" placeholder="Cari material..." class="w-full text-xs font-bold rounded-lg px-3 py-2 outline-none border font-mono shadow-inner" :class="darkMode ? 'bg-[#1A0D05] border-[#331A0A] text-white focus:border-[#FF7A00]' : 'bg-white border-[#E65C00]/40 text-[#5C2C00] focus:border-[#E65C00]'">
                                                    @if(!empty($materialResults[$kat->id]))
                                                        <div class="absolute left-0 right-0 top-full rounded-xl shadow-2xl z-50 max-h-48 overflow-y-auto mt-2 p-1 border w-72" :class="darkMode ? 'bg-[#1A0D05] border-[#FF7A00]' : 'bg-white border-[#E65C00]'">
                                                            @foreach($materialResults[$kat->id] as $m)
                                                                <div wire:click="pilihMaterial({{ $kat->id }}, {{ $m->id }}, '{{ addslashes($m->nama_barang) }}', {{ $m->harga }}, '{{ $m->satuan ?? '-' }}')" class="p-3 cursor-pointer text-[10px] flex flex-col rounded-lg transition-colors border-b last:border-b-0" :class="darkMode ? 'hover:bg-[#261308] border-[#331A0A] text-[#FDECE2]' : 'hover:bg-[#FFF6ED] border-[#E65C00]/20 text-[#5C2C00]'">
                                                                    <span class="truncate font-black">{{ $m->nama_barang }}</span>
                                                                    <span class="font-mono text-[#E65C00] font-bold" :class="darkMode ? 'text-[#FFC107]' : 'text-[#E65C00]'">Rp {{ number_format($m->harga, 0, ',', '.') }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 border-r" :class="darkMode ? 'border-[#331A0A]':'border-[#E65C00]/30'">
                                                <input type="number" step="0.01" wire:model="volumeInput.{{ $kat->id }}" placeholder="0" class="w-full text-xs font-bold rounded-lg px-2 py-2 text-center border font-mono outline-none shadow-inner" :class="darkMode ? 'bg-[#1A0D05] border-[#331A0A] text-white' : 'bg-white border-[#E65C00]/40 text-[#5C2C00]'">
                                            </td>
                                            <td class="px-3 py-2 border-r text-center" :class="darkMode ? 'border-[#331A0A]':'border-[#E65C00]/30'">
                                                <input type="number" wire:model="hargaInput.{{ $kat->id }}" placeholder="Harga..." class="w-full text-xs font-bold rounded-lg px-3 py-2 text-right outline-none border font-mono shadow-inner" :class="darkMode ? 'bg-[#1A0D05] border-[#331A0A] text-white' : 'bg-white border-[#E65C00]/40 text-[#5C2C00]'">
                                            </td>
                                            <td class="px-3 py-2 border-r text-right" :class="darkMode ? 'border-[#331A0A]':'border-[#E65C00]/30'" colspan="2">
                                                <button type="button" wire:click="simpanItemBaru({{ $kat->id }})" class="px-3 py-2 text-[10px] font-black rounded-lg transition-all w-full uppercase tracking-widest flex items-center justify-center gap-1.5 shadow-md border" :class="darkMode ? 'bg-[#FF7A00] border-[#FF7A00] text-[#1A0D05]' : 'bg-[#E65C00] border-[#E65C00] text-white'">SIMPAN</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                            <tfoot class="border-t-4" :class="darkMode ? 'border-[#FF7A00] bg-[#0D0602]' : 'border-[#E65C00] bg-[#FCF6F0]'">
                                <tr class="border-b" :class="darkMode ? 'border-[#331A0A]' : 'border-[#E65C00]/40'">
                                    <td colspan="4" class="px-5 py-3 text-right font-black text-[10px] uppercase tracking-widest" :class="darkMode ? 'text-[#FDECE2]/50' : 'text-[#5C2C00]/60'">Total Pekerjaan</td>
                                    <td colspan="2" class="px-5 py-3 text-right font-black font-mono text-sm border-l" :class="darkMode ? 'border-[#331A0A] text-white' : 'border-[#E65C00]/40 text-[#5C2C00]'">Rp {{ number_format($totalPekerjaan, 2, ',', '.') }}</td>
                                    @if(!$isApproved) <td></td> @endif
                                </tr>
                                <tr class="border-b" :class="darkMode ? 'border-[#331A0A]' : 'border-[#E65C00]/40'">
                                    <td colspan="4" class="px-5 py-3 text-right font-black text-[10px] uppercase tracking-widest" :class="darkMode ? 'text-[#FDECE2]/50' : 'text-[#5C2C00]/60'">Over Head Cost</td>
                                    <td colspan="2" class="px-5 py-3 text-right font-black font-mono text-sm border-l" :class="darkMode ? 'border-[#331A0A] text-white' : 'border-[#E65C00]/40 text-[#5C2C00]'">Rp {{ number_format($overhead, 2, ',', '.') }}</td>
                                    @if(!$isApproved) <td></td> @endif
                                </tr>
                                <tr class="border-b" :class="darkMode ? 'border-[#331A0A]' : 'border-[#E65C00]/40'">
                                    <td colspan="4" class="px-5 py-3 text-right font-black text-[10px] uppercase tracking-widest" :class="darkMode ? 'text-[#FDECE2]/50' : 'text-[#5C2C00]/60'">Total</td>
                                    <td colspan="2" class="px-5 py-3 text-right font-black font-mono text-sm border-l" :class="darkMode ? 'border-[#331A0A] text-[#FFC107]' : 'border-[#E65C00]/40 text-[#E65C00]'">Rp {{ number_format($grandTotal, 2, ',', '.') }}</td>
                                    @if(!$isApproved) <td></td> @endif
                                </tr>
                                <tr>
                                    <td colspan="4" class="px-5 py-4 text-right font-black text-sm uppercase tracking-widest" :class="darkMode ? 'text-[#FF7A00]' : 'text-[#E65C00]'">Grand Total Dibulatkan</td>
                                    <td colspan="2" class="px-5 py-4 text-right font-black font-mono text-lg border-l" :class="darkMode ? 'border-[#331A0A] text-[#FF7A00]' : 'border-[#E65C00]/40 text-[#E65C00]'">Rp {{ number_format(floor($grandTotal/1000)*1000, 2, ',', '.') }}</td>
                                    @if(!$isApproved) <td></td> @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>