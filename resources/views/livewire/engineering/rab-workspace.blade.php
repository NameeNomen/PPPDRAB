<div class="min-h-screen font-sans transition-colors duration-300 overflow-x-hidden" style="font-family: 'Inter', sans-serif;" x-data="{ darkMode: false }" :class="darkMode ? 'bg-[#121212] text-gray-200' : 'bg-[#F8F9FA] text-gray-800'">

    @if (session()->has('sukses'))
        <div class="w-full mx-auto pt-6 px-4 md:px-6">
            <div class="p-4 rounded-xl font-bold flex items-center gap-3 shadow-sm border text-xs tracking-widest uppercase" :class="darkMode ? 'bg-emerald-900/20 border-emerald-800 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-600'">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('sukses') }}</span>
            </div>
        </div>
    @endif

    <div class="w-full px-4 md:px-6 py-6">
        <div class="w-full flex justify-between items-center mb-6 p-4 rounded-xl border shadow-sm sticky top-4 z-40 backdrop-blur-md" :class="darkMode ? 'bg-[#1E1E1E]/90 border-[#2A2A2A]' : 'bg-white/90 border-gray-200'">
            <div class="flex items-center gap-4">
                <button wire:click="kembaliKeList" class="text-xs font-bold px-3 py-2 rounded-lg transition-colors border shadow-sm" :class="darkMode ? 'bg-[#121212] border-[#333333] text-gray-300 hover:text-white' : 'bg-white border-gray-200 text-gray-700 hover:text-black'">
                    &larr; KEMBALI
                </button>
                <div class="w-px h-4 bg-gray-300 dark:bg-gray-700"></div>
                <div class="flex gap-1 bg-gray-100 dark:bg-[#121212] p-1 rounded-md border" :class="darkMode ? 'border-[#333333]' : 'border-gray-200'">
                    <button @click="darkMode = false" :class="!darkMode ? 'bg-white shadow text-gray-800 font-bold' : 'text-gray-400'" class="px-3 py-1 text-[10px] font-bold rounded transition-all uppercase">Terang</button>
                    <button @click="darkMode = true" :class="darkMode ? 'bg-[#2A2A2A] shadow text-yellow-500 font-bold' : 'text-gray-400'" class="px-3 py-1 text-[10px] font-bold rounded transition-all uppercase">Gelap</button>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @if(!$isApproved)
                    <button wire:click="submitKeDirektur" class="px-6 py-2.5 text-xs font-bold rounded-lg shadow-sm transition-all uppercase tracking-widest" :class="darkMode ? 'bg-yellow-500 text-gray-900 hover:bg-yellow-400' : 'bg-yellow-400 text-gray-900 hover:bg-yellow-500'">
                        Kirim ke Direktur
                    </button>
                @else
                    <span class="px-4 py-2.5 text-xs font-bold uppercase tracking-widest rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                        Dokumen Disetujui
                    </span>
                @endif
            </div>
        </div>

        @if ($errors->has('nama_editor') || $errors->has('commit_message'))
            <div class="mb-4 p-3 rounded-lg text-xs font-bold uppercase tracking-widest bg-rose-50 text-rose-600 border border-rose-200 dark:bg-rose-900/20 dark:text-rose-400 dark:border-rose-800">
                Peringatan: Lengkapi catatan histori di bawah tabel sebelum submit!
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6 items-start w-full">
            
            <div class="w-full lg:w-[40%] shrink-0 flex flex-col border rounded-xl overflow-hidden shadow-sm h-[85vh] sticky top-24" :class="darkMode ? 'bg-[#1E1E1E] border-[#2A2A2A]' : 'bg-white border-gray-200'">
                <div class="bg-gray-100 dark:bg-[#121212] p-3 border-b border-gray-300 dark:border-[#2A2A2A] flex justify-between items-center z-10">
                    <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Dokumen Acuan Marketing (TOR)
                    </span>
                </div>
                
                <div class="overflow-y-auto overflow-x-hidden flex-1 bg-gray-200 dark:bg-[#2B2B2B] p-2" x-data x-init="$watch('$el.clientWidth', val => $refs.scaler.style.zoom = val / 850)" @resize.window="$refs.scaler.style.zoom = $el.clientWidth / 850">
                    <div x-ref="scaler" class="origin-top flex flex-col items-center">
                        @include('components.dokumen-inisiasi', ['proyek' => $selectedProject])
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-[60%] space-y-4">
                
                <div class="rounded-xl p-4 shadow-sm border flex flex-col md:flex-row justify-between gap-4" :class="darkMode ? 'bg-[#1E1E1E] border-[#2A2A2A]' : 'bg-white border-gray-100'">
                    <div class="flex gap-4 w-full">
                        <div class="flex-1">
                            <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-wider">NO. BOQ REF</label>
                            <input type="text" wire:model.live.blur="no_boq" {{ $isApproved ? 'disabled' : '' }} class="w-full text-xs p-2.5 rounded-lg border outline-none font-mono font-bold" :class="darkMode ? 'bg-[#121212] border-[#2A2A2A] text-gray-300' : 'bg-gray-50 border-gray-200'">
                        </div>
                        <div class="flex-1">
                            <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-wider">TANGGAL UPDATE</label>
                            <input type="text" readonly value="{{ \Carbon\Carbon::parse($tanggal_dokumen)->format('d F Y') }}" class="w-full text-xs p-2.5 rounded-lg border opacity-60 font-bold" :class="darkMode ? 'bg-[#121212] border-[#2A2A2A]' : 'bg-gray-50 border-gray-200'">
                        </div>
                    </div>
                    @if(!$isApproved)
                    <div class="flex items-end shrink-0">
                        <button wire:click="$set('showRequestModal', true)" class="px-4 py-2.5 text-[10px] font-bold uppercase tracking-widest rounded-lg border shadow-sm transition-colors" :class="darkMode ? 'bg-[#121212] border-[#333333] text-yellow-500 hover:border-yellow-500' : 'bg-white border-gray-300 text-yellow-600 hover:border-yellow-500'">
                            + Req Material Baru
                        </button>
                    </div>
                    @endif
                </div>

                <div class="rounded-xl border shadow-sm overflow-hidden" :class="darkMode ? 'bg-[#1E1E1E] border-[#2A2A2A]' : 'bg-white border-gray-200'">
                    <div class="w-full">
                        <table class="w-full text-left text-[11px] border-collapse table-fixed">
                            <thead :class="darkMode ? 'bg-[#121212] text-gray-400 border-[#2A2A2A]' : 'bg-gray-50 text-gray-500 border-gray-200'" class="border-b-2">
                                <tr>
                                    <th class="px-2 py-3 text-center w-[5%] border-r" :class="darkMode?'border-[#2A2A2A]':'border-gray-200'">NO</th>
                                    <th class="px-3 py-3 w-[45%] border-r" :class="darkMode?'border-[#2A2A2A]':'border-gray-200'">DESCRIPTION <span class="block text-[9px] font-normal italic opacity-60 mt-1">(Klik 2x Untuk Edit Teks)</span></th>
                                    <th class="px-2 py-3 text-center w-[8%] border-r" :class="darkMode?'border-[#2A2A2A]':'border-gray-200'">QTY</th>
                                    <th class="px-2 py-3 text-center w-[10%] border-r" :class="darkMode?'border-[#2A2A2A]':'border-gray-200'">SAT</th>
                                    <th class="px-3 py-3 text-right w-[15%] border-r" :class="darkMode?'border-[#2A2A2A]':'border-gray-200'">HARGA SATUAN</th>
                                    <th class="px-3 py-3 text-right w-[15%] {{ !$isApproved ? 'border-r' : '' }}" :class="darkMode?'border-[#2A2A2A]':'border-gray-200'">JUMLAH (RP)</th>
                                    @if(!$isApproved) <th class="w-[2%]"></th> @endif
                                </tr>
                            </thead>
                            
                            <tbody class="divide-y" :class="darkMode ? 'divide-[#2A2A2A]' : 'divide-gray-100'">
                                @php $katNo = 1; @endphp
                                
                                @foreach($kategoris as $indexKat => $kat)
                                    <tr class="font-black bg-[#EDF2F7] dark:bg-[#2A2A2A] border-y text-gray-900 dark:text-white uppercase tracking-wider">
                                        <td class="px-2 py-2 text-center align-top">{{ $katNo++ }}.</td>
                                        
                                        <td class="px-3 py-2" colspan="4" x-data="{ editing: false, deskripsi: '{{ addslashes($kat->deskripsi_pekerjaan) }}' }">
                                            <div x-show="!editing" @dblclick="{{ !$isApproved ? 'editing = true' : '' }}" class="cursor-pointer">{{ $kat->deskripsi_pekerjaan }}</div>
                                            @if(!$isApproved)
                                                <input x-show="editing" x-model="deskripsi" x-trap="editing" 
                                                    @keydown.enter="editing = false; $wire.updateInline({{ $kat->id }}, 'deskripsi_pekerjaan', deskripsi)" 
                                                    @click.away="editing = false; $wire.updateInline({{ $kat->id }}, 'deskripsi_pekerjaan', deskripsi)"
                                                    class="w-full bg-white dark:bg-black text-black dark:text-white px-2 py-1 outline-none rounded border border-yellow-500 font-black">
                                            @endif
                                        </td>

                                        @php
                                            $subtotalKat = $kat->children->sum(function($child) {
                                                return $child->children->count() > 0 ? $child->children->sum('subtotal') : $child->subtotal;
                                            });
                                        @endphp
                                        <td class="px-3 py-2 text-right font-mono" :class="!$isApproved ? 'border-r '.(darkMode ? 'border-[#333333]' : 'border-gray-300') : ''">{{ number_format($subtotalKat, 0, ',', '.') }}</td>
                                        @if(!$isApproved)
                                            <td class="text-center align-top"><button wire:click="hapusItem({{ $kat->id }})" class="text-rose-500 font-bold hover:bg-rose-500 hover:text-white px-1 rounded transition-all">&times;</button></td>
                                        @endif
                                    </tr>

                                    @foreach($kat->children as $item)
                                        <tr :class="darkMode ? 'bg-[#1E1E1E] text-gray-200' : 'bg-white text-gray-800'" class="font-semibold">
                                            <td class="px-2 py-2 text-center border-r align-top border-transparent"></td>
                                            
                                            <td class="px-3 py-2 border-r pl-6" :class="darkMode?'border-[#2A2A2A]':'border-gray-100'" x-data="{ editing: false, deskripsi: '{{ addslashes($item->deskripsi_pekerjaan) }}' }">
                                                <div class="flex flex-col">
                                                    <span x-show="!editing" @dblclick="{{ !$isApproved ? 'editing = true' : '' }}" class="cursor-pointer">- {{ $item->deskripsi_pekerjaan }}</span>
                                                    @if(!$isApproved)
                                                        <input x-show="editing" x-model="deskripsi" x-trap="editing" 
                                                            @keydown.enter="editing = false; $wire.updateInline({{ $item->id }}, 'deskripsi_pekerjaan', deskripsi)" 
                                                            @click.away="editing = false; $wire.updateInline({{ $item->id }}, 'deskripsi_pekerjaan', deskripsi)"
                                                            class="w-full bg-gray-50 dark:bg-black text-black dark:text-white px-2 py-1 outline-none rounded border border-yellow-500 font-semibold">
                                                    @endif
                                                    @if($item->material && $item->children->count() == 0) 
                                                        <span class="text-[9px] font-normal text-yellow-600 dark:text-yellow-500 mt-1">Mat: {{ $item->material->nama_barang }}</span> 
                                                    @endif
                                                </div>
                                            </td>
                                            
                                            @if($item->children->count() > 0)
                                                <td class="px-2 py-2 border-r text-center opacity-40 text-[9px] italic align-top" colspan="3" :class="darkMode?'border-[#2A2A2A]':'border-gray-100'">(Rincian di bawah)</td>
                                                <td class="px-3 py-2 text-right font-mono font-black align-top" :class="!$isApproved ? 'border-r '.(darkMode ? 'border-[#2A2A2A]' : 'border-gray-200') : ''">{{ number_format($item->children->sum('subtotal'), 0, ',', '.') }}</td>
                                            @else
                                                <td class="px-2 py-2 text-center border-r font-mono align-top" :class="darkMode?'border-[#2A2A2A]':'border-gray-100'" x-data="{ editing: false, qty: '{{ $item->qty }}' }">
                                                    <div x-show="!editing" @dblclick="{{ !$isApproved ? 'editing = true' : '' }}" class="cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2A2A2A] rounded">{{ $item->qty }}</div>
                                                    @if(!$isApproved)
                                                        <input type="number" step="0.01" x-show="editing" x-model="qty" x-trap="editing" @keydown.enter="editing = false; $wire.updateInline({{ $item->id }}, 'qty', qty)" @click.away="editing = false; $wire.updateInline({{ $item->id }}, 'qty', qty)" class="w-full bg-white dark:bg-black text-center outline-none border border-yellow-500 rounded">
                                                    @endif
                                                </td>
                                                <td class="px-2 py-2 text-center border-r opacity-70 align-top uppercase" :class="darkMode?'border-[#2A2A2A]':'border-gray-100'">{{ $item->material->satuan ?? '-' }}</td>
                                                <td class="px-3 py-2 text-right border-r font-mono align-top" :class="darkMode?'border-[#2A2A2A]':'border-gray-100'">{{ number_format($item->harga_awal, 0, ',', '.') }}</td>
                                                <td class="px-3 py-2 text-right font-mono font-black align-top" :class="!$isApproved ? 'border-r '.(darkMode ? 'border-[#2A2A2A]' : 'border-gray-200') : ''">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            @endif
                                            
                                            @if(!$isApproved)
                                                <td class="text-center align-top pt-2"><button wire:click="hapusItem({{ $item->id }})" class="text-gray-400 hover:text-rose-500 font-bold">&times;</button></td>
                                            @endif
                                        </tr>

                                        @foreach($item->children as $sub)
                                            <tr :class="darkMode ? 'bg-[#121212] text-gray-400' : 'bg-gray-50 text-gray-600'" class="text-[10px]">
                                                <td class="border-r border-transparent"></td>
                                                
                                                <td class="px-3 py-1.5 border-r pl-12" :class="darkMode?'border-[#2A2A2A]':'border-gray-100'" x-data="{ editing: false, deskripsi: '{{ addslashes($sub->deskripsi_pekerjaan) }}' }">
                                                    <div class="flex flex-col">
                                                        <span x-show="!editing" @dblclick="{{ !$isApproved ? 'editing = true' : '' }}" class="cursor-pointer">- {{ $sub->deskripsi_pekerjaan }}</span>
                                                        @if(!$isApproved)
                                                            <input x-show="editing" x-model="deskripsi" x-trap="editing" 
                                                                @keydown.enter="editing = false; $wire.updateInline({{ $sub->id }}, 'deskripsi_pekerjaan', deskripsi)" 
                                                                @click.away="editing = false; $wire.updateInline({{ $sub->id }}, 'deskripsi_pekerjaan', deskripsi)"
                                                                class="w-full bg-white dark:bg-black text-black dark:text-white px-2 py-1 outline-none rounded border border-yellow-500">
                                                        @endif
                                                        @if($sub->material) <span class="text-[9px] italic text-yellow-600 dark:text-yellow-500 mt-0.5">Mat: {{ $sub->material->nama_barang }}</span> @endif
                                                    </div>
                                                </td>
                                                
                                                <td class="px-2 py-1.5 border-r text-center font-mono align-top" :class="darkMode?'border-[#2A2A2A]':'border-gray-100'" x-data="{ editing: false, qty: '{{ $sub->qty }}' }">
                                                    <div x-show="!editing" @dblclick="{{ !$isApproved ? 'editing = true' : '' }}" class="cursor-pointer hover:bg-gray-200 dark:hover:bg-[#2A2A2A] rounded">{{ $sub->qty }}</div>
                                                    @if(!$isApproved)
                                                        <input type="number" step="0.01" x-show="editing" x-model="qty" x-trap="editing" @keydown.enter="editing = false; $wire.updateInline({{ $sub->id }}, 'qty', qty)" @click.away="editing = false; $wire.updateInline({{ $sub->id }}, 'qty', qty)" class="w-full bg-white dark:bg-black text-center outline-none border border-yellow-500 rounded">
                                                    @endif
                                                </td>

                                                <td class="px-2 py-1.5 border-r text-center opacity-60 align-top uppercase" :class="darkMode?'border-[#2A2A2A]':'border-gray-100'">{{ $sub->material->satuan ?? '-' }}</td>
                                                <td class="px-3 py-1.5 border-r text-right font-mono align-top" :class="darkMode?'border-[#2A2A2A]':'border-gray-100'">{{ number_format($sub->harga_awal, 0, ',', '.') }}</td>
                                                <td class="px-3 py-1.5 text-right font-mono align-top" :class="!$isApproved ? 'border-r '.(darkMode ? 'border-[#2A2A2A]' : 'border-gray-200') : ''">{{ number_format($sub->subtotal, 0, ',', '.') }}</td>
                                                @if(!$isApproved)
                                                    <td class="text-center align-top pt-1.5"><button wire:click="hapusItem({{ $sub->id }})" class="text-rose-400/50 hover:text-rose-500">&times;</button></td>
                                                @endif
                                            </tr>
                                        @endforeach

                                        @if(!$isApproved)
                                            <tr class="bg-transparent border-b border-dashed" :class="darkMode ? 'border-gray-800':'border-gray-200'">
                                                <td class="border-r border-transparent"></td>
                                                <td colspan="6" class="p-1.5 pl-12 bg-gray-50/50 dark:bg-[#151515]">
                                                    @include('components.rab-row-input', ['parentId' => $item->id, 'tipe' => 'sub-rincian', 'placeholder' => '- Tambah Rincian/Material (Tekan Enter)'])
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    @if(!$isApproved)
                                        <tr class="bg-transparent border-b-2" :class="darkMode ? 'border-gray-700':'border-gray-300'">
                                            <td class="px-2 py-2 text-center border-r font-black text-gray-400" :class="darkMode?'border-[#2A2A2A]':'border-gray-100'"></td>
                                            <td colspan="6" class="p-1.5 pl-6 bg-gray-100/50 dark:bg-[#1A1A1A]">
                                                @include('components.rab-row-input', ['parentId' => $kat->id, 'tipe' => 'item', 'placeholder' => '- Tambah Uraian Pekerjaan (Tekan Enter)'])
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                @if(!$isApproved)
                                    <tr class="border-t-2 border-b-4" :class="darkMode ? 'border-gray-700 bg-[#151515]':'border-gray-300 bg-gray-100'">
                                        <td class="text-center font-black text-gray-400 text-sm border-r" :class="darkMode?'border-[#2A2A2A]':'border-gray-300'">+</td>
                                        <td colspan="6" class="p-3">
                                            <div class="flex items-center gap-3 w-full">
                                                <input type="text" wire:model="newKategori" wire:keydown.enter="tambahKategori" placeholder="Ketik Bab Kategori Utama (ex: Pekerjaan Persiapan) lalu tekan Enter..." class="w-full text-xs font-bold rounded-lg px-4 py-2.5 outline-none border shadow-inner uppercase" :class="darkMode ? 'bg-[#121212] border-[#333333] text-white focus:border-yellow-500' : 'bg-white border-gray-300 text-gray-900 focus:border-yellow-500'">
                                                <button type="button" wire:click="tambahKategori" class="px-5 py-2.5 text-[10px] font-bold uppercase tracking-widest rounded-lg border transition-colors shrink-0 shadow-sm" :class="darkMode ? 'bg-[#2A2A2A] border-gray-600 text-yellow-500 hover:bg-[#333333]' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-100'">
                                                    BUAT KATEGORI
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>

                            <tfoot class="border-t-4 font-bold" :class="darkMode ? 'border-gray-600 bg-[#121212]' : 'border-gray-300 bg-[#Edf2f7]'">
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-right text-[11px] text-gray-600 dark:text-gray-400 uppercase tracking-wider">Total Harga Pekerjaan</td>
                                    <td class="px-4 py-3 text-right font-mono text-xs" :class="darkMode?'text-white':'text-gray-900'">Rp {{ number_format($totalPekerjaan, 2, ',', '.') }}</td>
                                    @if(!$isApproved) <td></td> @endif
                                </tr>
                                <tr>
                                    <td colspan="5" class="px-4 py-2 text-right text-[11px] text-gray-600 dark:text-gray-400 uppercase tracking-wider align-middle">Overhead Cost / Biaya Tambahan</td>
                                    <td class="px-2 py-2 text-right">
                                        @if(!$isApproved)
                                            <div class="relative w-full">
                                                <span class="absolute inset-y-0 left-0 pl-2 flex items-center text-[10px] text-gray-500 font-mono">Rp</span>
                                                <input type="number" wire:model.live.blur="overhead_cost" class="w-full text-right pl-6 pr-2 py-1.5 rounded border outline-none font-mono text-xs shadow-inner" :class="darkMode ? 'bg-[#1E1E1E] border-[#333333] text-yellow-500 focus:border-yellow-500' : 'bg-white border-gray-300 text-yellow-600 focus:border-yellow-500'">
                                            </div>
                                        @else
                                            <span class="font-mono text-xs px-2" :class="darkMode?'text-yellow-500':'text-yellow-600'">Rp {{ number_format($overhead, 2, ',', '.') }}</span>
                                        @endif
                                    </td>
                                    @if(!$isApproved) <td></td> @endif
                                </tr>
                                <tr class="border-t border-gray-300 dark:border-gray-700">
                                    <td colspan="5" class="px-4 py-3 text-right text-[11px] font-black text-gray-700 dark:text-gray-300 uppercase tracking-widest">Grand Total Real</td>
                                    <td class="px-4 py-3 text-right font-mono text-sm font-black" :class="darkMode?'text-white':'text-gray-900'">Rp {{ number_format($grandTotal, 2, ',', '.') }}</td>
                                    @if(!$isApproved) <td></td> @endif
                                </tr>
                                <tr class="border-t-2" :class="darkMode ? 'border-yellow-600/30' : 'border-yellow-400/50'">
                                    <td colspan="5" class="px-4 py-4 text-right text-xs font-black text-orange-600 dark:text-orange-400 uppercase tracking-widest">GRAND TOTAL DIBULATKAN (PEMBULATAN RIBUAN)</td>
                                    <td class="px-4 py-4 text-right font-mono text-base font-black text-orange-600 dark:text-orange-400">Rp {{ number_format(floor($grandTotal/1000)*1000, 2, ',', '.') }}</td>
                                    @if(!$isApproved) <td></td> @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                @if(!$isApproved)
                    <div class="rounded-xl p-5 shadow-sm border mt-4 animate-fade-in" :class="darkMode ? 'bg-[#1E1E1E] border-[#2A2A2A]' : 'bg-white border-gray-200'">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-orange-500 dark:text-orange-400 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Otorisasi & Catatan Histori Pembuatan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                            <div class="md:col-span-1">
                                <input type="text" wire:model.live.blur="nama_editor" placeholder="Nama Anda (Estimator)..." class="w-full text-xs font-bold p-3 rounded-lg border outline-none shadow-inner" :class="darkMode ? 'bg-[#121212] border-[#333333] text-white focus:border-yellow-500' : 'bg-gray-50 border-gray-200 text-gray-900 focus:border-yellow-500'">
                                @error('nama_editor') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <input type="text" wire:model.live.blur="commit_message" placeholder="Tulis rincian versi (ex: Selesai rekap sipil dan pembulatan overhead)..." class="w-full text-xs font-bold p-3 rounded-lg border outline-none shadow-inner" :class="darkMode ? 'bg-[#121212] border-[#333333] text-white focus:border-yellow-500' : 'bg-gray-50 border-gray-200 text-gray-900 focus:border-yellow-500'">
                                @error('commit_message') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        @if($showRequestModal)
        <div class="fixed inset-0 z-[100] bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="w-full max-w-lg rounded-xl p-6 border shadow-2xl" :class="darkMode ? 'bg-[#1E1E1E] border-[#333333]' : 'bg-white border-gray-200'">
                <div class="flex justify-between items-center mb-5 border-b pb-3 dark:border-[#333333]">
                    <h2 class="text-base font-bold uppercase tracking-wide" :class="darkMode ? 'text-white' : 'text-gray-900'">Material Request Form</h2>
                    <button wire:click="$set('showRequestModal', false)" class="text-gray-500 hover:text-rose-500 text-2xl font-bold">&times;</button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Nama Barang / Material</label>
                        <input type="text" wire:model="reqNamaMaterial" placeholder="Cth: Besi Tahan Panas" class="w-full text-xs font-bold p-2.5 rounded-lg border outline-none" :class="darkMode ? 'bg-[#121212] border-[#333333] text-white focus:border-yellow-500' : 'bg-gray-50 border-gray-200 text-gray-900 focus:border-yellow-400'">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Keterangan Spesifikasi / Merk</label>
                        <textarea wire:model="reqDeskripsi" rows="2" placeholder="Cth: SNI, Grade A" class="w-full text-xs p-2.5 rounded-lg border outline-none resize-none" :class="darkMode ? 'bg-[#121212] border-[#333333] text-white focus:border-yellow-500' : 'bg-gray-50 border-gray-200 text-gray-900 focus:border-yellow-400'"></textarea>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Kuantitas</label>
                            <input type="number" step="0.1" wire:model="reqKebutuhan" class="w-full text-xs p-2.5 rounded-lg border outline-none font-mono" :class="darkMode ? 'bg-[#121212] border-[#333333] text-white' : 'bg-gray-50 border-gray-200'">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Satuan</label>
                            <input type="text" wire:model="reqSatuan" placeholder="Cth: Pcs, Kg, Sak" class="w-full text-xs p-2.5 rounded-lg border outline-none" :class="darkMode ? 'bg-[#121212] border-[#333333] text-white' : 'bg-gray-50 border-gray-200'">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Target Batas Waktu Disediakan</label>
                        <input type="date" wire:model="reqTargetWaktu" class="w-full text-xs p-2.5 rounded-lg border outline-none" :class="darkMode ? 'bg-[#121212] border-[#333333] text-white' : 'bg-gray-50 border-gray-200'">
                    </div>
                    <button wire:click="ajukanMaterialBaru" class="w-full py-3 mt-4 text-xs font-bold uppercase tracking-widest rounded-lg shadow-md transition-all text-gray-900" :class="darkMode ? 'bg-yellow-500 hover:bg-yellow-400' : 'bg-yellow-400 hover:bg-yellow-500'">
                        Kirim ke Purchasing
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>