<div class="min-h-screen font-sans transition-colors duration-300" style="font-family: 'Inter', sans-serif;" x-data="{ darkMode: true }" :class="darkMode ? 'bg-[#121212] text-gray-200' : 'bg-gray-50 text-gray-800'">

    <div class="w-full mx-auto p-4 md:p-6 relative">
        <div class="w-full flex flex-col md:flex-row items-start md:items-center justify-between mb-6 p-4 rounded-2xl border transition-colors sticky top-4 z-40 shadow-sm backdrop-blur-xl" :class="darkMode ? 'bg-gray-900/90 border-gray-800' : 'bg-white/90 border-gray-200'">
            <div class="flex items-center gap-4 mb-4 md:mb-0 w-full md:w-auto">
                <button wire:click="kembaliKeList" class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-xl border transition-all flex items-center gap-2" :class="darkMode ? 'bg-[#181818] border-gray-800 text-gray-300 hover:bg-gray-800' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-white'">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg> KEMBALI
                </button>
                <div class="flex items-center gap-1 p-1 rounded-xl border transition-colors" :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-gray-100 border-gray-200'">
                    <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-white shadow text-orange-600 font-bold' : 'text-gray-500'" class="px-3 py-1.5 text-[9px] rounded-lg transition-all uppercase tracking-widest">Terang</button>
                    <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-gray-900 text-orange-500 shadow border border-gray-700 font-bold' : 'text-gray-500'" class="px-3 py-1.5 text-[9px] rounded-lg transition-all uppercase tracking-widest">Gelap</button>
                </div>
            </div>

            <div class="w-full md:w-auto flex justify-end">
                @if(!$isApproved)
                    <button wire:click="submitKeDirektur" wire:loading.attr="disabled" class="w-full md:w-auto px-6 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl shadow-md transition-all border flex justify-center items-center gap-2" :class="darkMode ? 'bg-orange-600 border-orange-600 text-white hover:bg-orange-500' : 'bg-orange-600 border-orange-600 text-white hover:bg-orange-700'">
                        <span wire:loading.remove wire:target="submitKeDirektur">SUBMIT KE DIREKTUR</span>
                        <span wire:loading wire:target="submitKeDirektur">⏳ MEMPROSES...</span>
                    </button>
                @else
                    <span class="px-6 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl bg-emerald-900/30 text-emerald-400 border border-emerald-800">DOKUMEN DIKUNCI (APPROVED)</span>
                @endif
            </div>
        </div>

        @if ($errors->has('nama_editor') || $errors->has('commit_message'))
            <div class="mb-6 p-4 border-l-4 rounded-xl shadow-sm animate-pulse" :class="darkMode ? 'bg-rose-900/30 border-rose-500 text-rose-400' : 'bg-rose-50 border-rose-500 text-rose-700'">
                <p class="font-black text-xs uppercase tracking-widest">Peringatan: Form histori di panel kiri belum lengkap!</p>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start relative">
            
            <div class="xl:col-span-4 border rounded-3xl p-6 flex flex-col shadow-sm sticky top-28 self-start max-h-[85vh] overflow-y-auto" :class="darkMode ? 'bg-gray-900 border-gray-800' : 'bg-white border-gray-200'">
                <div>
                    <h3 class="text-[10px] font-black uppercase tracking-widest mb-4 border-b pb-3" :class="darkMode ? 'text-orange-500 border-gray-800' : 'text-orange-600 border-gray-200'">DATA PROYEK (MARKETING)</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="text-[9px] font-black uppercase tracking-widest opacity-50 block">INSTANSI / KLIEN</span>
                            <p class="text-sm font-black mt-1 uppercase" :class="darkMode ? 'text-white' : 'text-gray-900'">{{ $selectedProject->nama_pelanggan }}</p>
                        </div>
                        <div>
                            <span class="text-[9px] font-black uppercase tracking-widest opacity-50 block">SPESIFIKASI TEKNIS</span>
                            <div class="text-[11px] font-bold p-4 rounded-xl border max-h-32 overflow-y-auto whitespace-pre-line" :class="darkMode ? 'bg-[#181818] border-gray-800 text-gray-400' : 'bg-gray-50 border-gray-200 text-gray-600'">{{ $selectedProject->deskripsi_proyek ?? 'Tidak ada catatan teknis.' }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 border-t pt-4" :class="darkMode ? 'border-gray-800' : 'border-gray-200'">
                    <h3 class="text-[10px] font-black uppercase tracking-widest mb-3" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">LAMPIRAN / RFQ</h3>
                    <div class="grid grid-cols-1 gap-2">
                        @forelse($selectedProject->attachments ?? [] as $file)
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl border transition-all hover:-translate-y-0.5" :class="darkMode ? 'bg-[#181818] border-gray-700 hover:border-orange-500' : 'bg-gray-50 border-gray-300 hover:border-orange-500 shadow-sm'">
                                <div class="flex items-center gap-3 truncate">
                                    <svg class="w-5 h-5 shrink-0" :class="darkMode ? 'text-orange-500' : 'text-orange-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <div class="truncate">
                                        <p class="text-[10px] font-black truncate" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">{{ $file->file_name }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs italic opacity-50">Tidak ada lampiran.</p>
                        @endforelse
                    </div>
                </div>

                @if(!$isApproved)
                    <div class="mt-6 border-t pt-5" :class="darkMode ? 'border-gray-800' : 'border-gray-200'">
                        <span class="text-[10px] font-black uppercase tracking-widest flex items-center gap-2 mb-4" :class="darkMode ? 'text-orange-500' : 'text-orange-600'">PESAN COMMIT HISTORI</span>
                        <div class="space-y-3">
                            <div>
                                <input type="text" wire:model="nama_editor" placeholder="Nama Anda..." class="w-full text-xs font-bold px-4 py-2.5 rounded-xl border outline-none" :class="darkMode ? 'bg-[#181818] border-gray-800 text-white focus:border-orange-500' : 'bg-white border-gray-300 text-gray-900 focus:border-orange-500'">
                                @error('nama_editor') <span class="text-rose-500 text-[9px] font-black uppercase mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <textarea wire:model="commit_message" placeholder="Catatan versi ini..." rows="3" class="w-full text-xs font-bold px-4 py-2.5 rounded-xl border outline-none resize-none" :class="darkMode ? 'bg-[#181818] border-gray-800 text-white focus:border-orange-500' : 'bg-white border-gray-300 text-gray-900 focus:border-orange-500'"></textarea>
                                @error('commit_message') <span class="text-rose-500 text-[9px] font-black uppercase mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="xl:col-span-8 space-y-6 overflow-hidden w-full">
                @if(!$isApproved)
                    <div class="border rounded-3xl p-5 shadow-sm" :class="darkMode ? 'bg-gray-900 border-gray-800' : 'bg-white border-gray-200'">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[9px] font-black uppercase tracking-widest opacity-60 mb-1.5">NO. BOQ</label>
                                <input type="text" wire:model="no_boq" class="w-full text-xs font-mono font-black px-4 py-2.5 rounded-xl border outline-none" :class="darkMode ? 'bg-[#181818] border-gray-800 text-gray-300 focus:border-orange-500' : 'bg-white border-gray-300 text-gray-800 focus:border-orange-500'">
                            </div>
                            <div>
                                <label class="block text-[9px] font-black uppercase tracking-widest opacity-60 mb-1.5">OVERHEAD COST (RP)</label>
                                <input type="number" wire:model.live="overhead_cost" class="w-full text-xs font-mono font-black px-4 py-2.5 rounded-xl border outline-none" :class="darkMode ? 'bg-[#181818] border-gray-800 text-orange-400 focus:border-orange-500' : 'bg-white border-gray-300 text-orange-600 focus:border-orange-500'">
                            </div>
                        </div>
                    </div>
                @endif

                <div class="rounded-3xl border shadow-sm overflow-hidden" :class="darkMode ? 'bg-gray-900 border-gray-800' : 'bg-white border-gray-200'">
                    @if(!$isApproved)
                        <div class="p-4 border-b flex justify-between items-center gap-3" :class="darkMode ? 'bg-gray-800/50 border-gray-800' : 'bg-gray-50 border-gray-200'">
                            <div class="flex items-center gap-3 w-full max-w-lg">
                                <input type="text" wire:model="newKategori" placeholder="Kategori Baru..." class="text-xs font-bold rounded-xl px-4 py-2.5 w-full border outline-none" :class="darkMode ? 'bg-[#181818] border-gray-700 text-white focus:border-orange-500' : 'bg-white border-gray-300 text-gray-900 focus:border-orange-500'">
                                <button type="button" wire:click="tambahKategori" class="px-5 py-2.5 text-[10px] font-black rounded-xl uppercase tracking-widest shadow-sm border" :class="darkMode ? 'bg-orange-600 border-orange-600 text-white hover:bg-orange-500' : 'bg-orange-600 border-orange-600 text-white hover:bg-orange-700'">TAMBAH</button>
                            </div>
                        </div>
                    @endif

                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left text-xs border-collapse min-w-[850px]">
                            <thead class="font-black uppercase tracking-widest border-b" :class="darkMode ? 'bg-[#181818] text-gray-400 border-gray-800' : 'bg-gray-100 text-gray-600 border-gray-200'">
                                <tr>
                                    <th class="px-3 py-4 text-center w-12">NO</th>
                                    <th class="px-3 py-4 w-[35%]">DESKRIPSI PEKERJAAN</th>
                                    <th class="px-3 py-4 w-[20%]">MATERIAL</th>
                                    <th class="px-3 py-4 text-center w-14">VOL</th>
                                    <th class="px-3 py-4 text-right w-28">HARGA</th>
                                    <th class="px-3 py-4 text-right w-36">SUBTOTAL</th>
                                    @if(!$isApproved) <th class="px-3 py-4 text-center w-12">ACT</th> @endif
                                </tr>
                            </thead>
                            
                            <tbody class="divide-y font-bold" :class="darkMode ? 'divide-gray-800' : 'divide-gray-200'">
                                @php $noIndex = 1; @endphp
                                @foreach($kategoris as $kat)
                                    <tr wire:key="kategori-{{ $kat->id }}" class="border-y" :class="darkMode ? 'bg-gray-800/80 text-orange-400 border-gray-700' : 'bg-gray-50 text-gray-800 border-gray-200'">
                                        <td class="px-3 py-3 text-center font-mono">{{ $noIndex++ }}</td>
                                        <td class="px-3 py-3 uppercase tracking-wide" colspan="2">{{ $kat->deskripsi_pekerjaan }}</td>
                                        <td class="px-3 py-3 text-center">-</td>
                                        <td class="px-3 py-3 text-right">-</td>
                                        <td class="px-3 py-3 text-right font-mono font-black" :class="darkMode?'text-white':'text-gray-900'">Rp {{ number_format($kat->children->sum('subtotal'), 0, ',', '.') }}</td>
                                        @if(!$isApproved)
                                            <td class="px-3 py-3 text-center"><button type="button" wire:click="hapusItem({{ $kat->id }})" class="text-rose-500 hover:bg-rose-500 hover:text-white p-1.5 rounded transition-colors">X</button></td>
                                        @endif
                                    </tr>

                                    @foreach($kat->children as $item)
                                        <tr wire:key="item-{{ $item->id }}" :class="darkMode ? 'hover:bg-[#181818] text-gray-300' : 'hover:bg-gray-50 text-gray-700'">
                                            <td class="px-3 py-2 text-center font-mono opacity-40"></td>
                                            <td class="px-3 py-2">{{ $item->deskripsi_pekerjaan }}</td>
                                            <td class="px-3 py-2 font-mono opacity-80 text-[10px]">{{ $item->material->nama_barang ?? 'Custom/Tenaga' }}</td>
                                            <td class="px-3 py-2 text-center font-mono">{{ $item->qty }}</td>
                                            <td class="px-3 py-2 text-right font-mono">{{ number_format($item->harga_awal, 0, ',', '.') }}</td>
                                            <td class="px-3 py-2 text-right font-mono font-black" :class="darkMode ? 'text-orange-400':'text-orange-600'">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            @if(!$isApproved)
                                                <td class="px-3 py-2 text-center"><button type="button" wire:click="hapusItem({{ $item->id }})" class="text-rose-500/70 hover:text-rose-500 p-1">X</button></td>
                                            @endif
                                        </tr>
                                    @endforeach

                                    @if(!$isApproved)
                                        <tr wire:key="form-input-{{ $kat->id }}" :class="darkMode ? 'bg-[#181818]' : 'bg-white'" class="border-b">
                                            <td class="px-2 py-2 opacity-30 text-center text-lg font-black">+</td>
                                            <td class="px-2 py-2"><input type="text" wire:model="deskripsiInput.{{ $kat->id }}" placeholder="Rincian..." class="w-full text-xs font-bold rounded-lg px-2 py-2 outline-none border" :class="darkMode ? 'bg-gray-900 border-gray-700 text-white' : 'bg-gray-50 border-gray-300 text-gray-900'"></td>
                                            <td class="px-2 py-2 relative">
                                                @if(!empty($selectedMaterial[$kat->id]))
                                                    <div class="flex items-center justify-between p-2 rounded-lg font-mono text-[9px] font-black border" :class="darkMode ? 'bg-gray-800 border-orange-500/50 text-orange-400' : 'bg-orange-50 border-orange-300 text-orange-600'">
                                                        <div class="truncate"><span class="truncate">{{ $selectedMaterial[$kat->id]['nama'] }}</span></div>
                                                        <button type="button" wire:click="batalPilihMaterial({{ $kat->id }})" class="text-rose-500 hover:text-rose-400 p-0.5">X</button>
                                                    </div>
                                                @else
                                                    <input type="text" wire:model.live.debounce.300ms="materialSearch.{{ $kat->id }}" placeholder="Cari..." class="w-full text-[10px] font-bold rounded-lg px-2 py-2 outline-none border font-mono" :class="darkMode ? 'bg-gray-900 border-gray-700 text-white' : 'bg-gray-50 border-gray-300 text-gray-900'">
                                                    @if(!empty($materialResults[$kat->id]))
                                                        <div class="absolute left-0 top-full rounded-xl shadow-xl z-50 mt-2 p-1 border w-64" :class="darkMode ? 'bg-gray-900 border-gray-700' : 'bg-white border-gray-200'">
                                                            @foreach($materialResults[$kat->id] as $m)
                                                                <div wire:click="pilihMaterial({{ $kat->id }}, {{ $m->id }}, '{{ addslashes($m->nama_barang) }}', {{ $m->harga }}, '{{ $m->satuan ?? '-' }}')" class="p-2 cursor-pointer text-[9px] flex flex-col rounded-lg border-b last:border-b-0" :class="darkMode ? 'hover:bg-gray-800 border-gray-800 text-gray-300' : 'hover:bg-gray-50 border-gray-100 text-gray-700'">
                                                                    <span class="truncate font-black">{{ $m->nama_barang }}</span><span class="font-mono" :class="darkMode ? 'text-orange-400' : 'text-orange-600'">Rp {{ number_format($m->harga, 0, ',', '.') }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="px-2 py-2"><input type="number" step="0.01" wire:model="volumeInput.{{ $kat->id }}" placeholder="0" class="w-full text-[10px] font-bold rounded-lg px-1 py-2 text-center border font-mono outline-none" :class="darkMode ? 'bg-gray-900 border-gray-700 text-white' : 'bg-gray-50 border-gray-300 text-gray-900'"></td>
                                            <td class="px-2 py-2 text-center"><input type="number" wire:model="hargaInput.{{ $kat->id }}" placeholder="Harga..." class="w-full text-[10px] font-bold rounded-lg px-2 py-2 text-right border font-mono outline-none" :class="darkMode ? 'bg-gray-900 border-gray-700 text-white' : 'bg-gray-50 border-gray-300 text-gray-900'"></td>
                                            <td class="px-2 py-2 text-right" colspan="2"><button type="button" wire:click="simpanItemBaru({{ $kat->id }})" class="px-2 py-2 text-[9px] font-black rounded-lg transition-all w-full uppercase border" :class="darkMode ? 'bg-gray-800 border-gray-700 text-orange-500 hover:bg-gray-700' : 'bg-white border-gray-300 text-orange-600 hover:bg-gray-50'">SIMPAN</button></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                            <tfoot class="border-t-2" :class="darkMode ? 'border-gray-700 bg-[#181818]' : 'border-gray-300 bg-gray-50'">
                                <tr class="border-b" :class="darkMode ? 'border-gray-800' : 'border-gray-200'">
                                    <td colspan="4" class="px-4 py-3 text-right font-black text-[10px] uppercase tracking-widest text-gray-500">Total Pekerjaan</td>
                                    <td colspan="2" class="px-4 py-3 text-right font-black font-mono text-sm" :class="darkMode ? 'text-white' : 'text-gray-900'">Rp {{ number_format($totalPekerjaan, 2, ',', '.') }}</td>
                                    @if(!$isApproved) <td></td> @endif
                                </tr>
                                <tr class="border-b" :class="darkMode ? 'border-gray-800' : 'border-gray-200'">
                                    <td colspan="4" class="px-4 py-3 text-right font-black text-[10px] uppercase tracking-widest text-gray-500">Over Head Cost</td>
                                    <td colspan="2" class="px-4 py-3 text-right font-black font-mono text-sm" :class="darkMode ? 'text-white' : 'text-gray-900'">Rp {{ number_format($overhead, 2, ',', '.') }}</td>
                                    @if(!$isApproved) <td></td> @endif
                                </tr>
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-right font-black text-sm uppercase tracking-widest" :class="darkMode ? 'text-orange-500' : 'text-orange-600'">Grand Total Dibulatkan</td>
                                    <td colspan="2" class="px-4 py-4 text-right font-black font-mono text-lg" :class="darkMode ? 'text-orange-500' : 'text-orange-600'">Rp {{ number_format(floor($grandTotal/1000)*1000, 2, ',', '.') }}</td>
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