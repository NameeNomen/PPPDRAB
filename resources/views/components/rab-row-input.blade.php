<div class="flex gap-2 w-full items-center relative">
    <div class="w-[35%]">
        <input type="text" wire:model="deskripsiInput.{{ $parentId }}" wire:keydown.enter="simpanItemBaru({{ $parentId }}, '{{ $tipe }}')" placeholder="{{ $placeholder }} (Tekan Enter utk Save)" class="w-full text-[10px] p-2 rounded border outline-none shadow-inner transition-colors focus:ring-2 focus:ring-yellow-500/50" :class="darkMode ? 'bg-[#121212] border-[#2A2A2A] text-white focus:border-yellow-500' : 'bg-white border-gray-200 focus:border-yellow-500'">
    </div>
    <div class="w-[30%] relative">
        @if(!empty($selectedMaterial[$parentId]))
            <div class="flex items-center justify-between bg-yellow-50 dark:bg-[#1A1500] border border-yellow-200 dark:border-yellow-700 text-yellow-700 dark:text-yellow-500 p-1.5 rounded transition-all">
                <span class="truncate text-[9px] font-bold">{{ $selectedMaterial[$parentId]['nama'] }}</span>
                <button wire:click="batalPilihMaterial({{ $parentId }})" class="text-rose-500 ml-1 font-bold focus:outline-none hover:text-rose-700 hover:scale-110 transition-transform">&times;</button>
            </div>
        @else
            <input type="text" wire:model.live.debounce.300ms="materialSearch.{{ $parentId }}" placeholder="Ketik material..." class="w-full text-[10px] p-2 rounded border outline-none shadow-inner focus:ring-2 focus:ring-yellow-500/50" :class="darkMode ? 'bg-[#121212] border-[#2A2A2A] text-white focus:border-yellow-500' : 'bg-white border-gray-200 focus:border-yellow-500'">
            
            <div wire:loading wire:target="materialSearch.{{ $parentId }}" class="absolute right-2 top-2">
                <svg class="animate-spin h-4 w-4 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </div>

            @if(!empty($materialResults[$parentId]))
                <div class="absolute z-50 w-[420px] rounded-lg shadow-2xl border overflow-hidden bottom-full mb-2 -left-10" :class="darkMode ? 'bg-[#1E1E1E] border-[#333333]' : 'bg-white border-gray-200'">
                    <table class="w-full text-[9px] text-left border-collapse">
                        <thead :class="darkMode ? 'bg-[#121212] text-gray-400' : 'bg-gray-100 text-gray-500'" class="border-b">
                            <tr><th class="p-2">Nama Barang</th><th class="p-2 text-right">Harga</th><th class="p-2 text-center">Kemasan</th></tr>
                        </thead>
                        <tbody class="divide-y" :class="darkMode ? 'divide-[#2A2A2A]' : 'divide-gray-100'">
                            @foreach($materialResults[$parentId] as $m)
                                <tr wire:click="pilihMaterial({{ $parentId }}, {{ $m->id }}, '{{ addslashes($m->nama_barang) }}', {{ $m->harga }}, '{{ $m->satuan ?? '-' }}', {{ $m->jumlah ?? 1 }})" class="cursor-pointer transition-colors" :class="darkMode ? 'hover:bg-[#2A2A2A] text-gray-200' : 'hover:bg-gray-50 text-gray-700'">
                                    <td class="p-2 font-bold">{{ $m->nama_barang }}</td>
                                    <td class="p-2 text-right font-mono font-bold text-yellow-600">{{ number_format($m->harga, 0, ',', '.') }}</td>
                                    <td class="p-2 text-center font-bold">{{ $m->jumlah }} {{ $m->satuan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
    </div>
    <div class="w-[15%]">
        <input type="number" step="0.01" wire:model="volumeInput.{{ $parentId }}" wire:keydown.enter="simpanItemBaru({{ $parentId }}, '{{ $tipe }}')" placeholder="Vol" class="w-full text-[10px] p-2 text-center rounded border outline-none font-mono shadow-inner focus:ring-2 focus:ring-yellow-500/50" :class="darkMode ? 'bg-[#121212] border-[#2A2A2A] text-white' : 'bg-white border-gray-200'">
    </div>
    <div class="w-[20%]">
        <input type="number" wire:model="hargaInput.{{ $parentId }}" wire:keydown.enter="simpanItemBaru({{ $parentId }}, '{{ $tipe }}')" placeholder="Harga (Enter utk Save)" class="w-full text-[10px] p-2 text-right rounded border outline-none font-mono shadow-inner focus:ring-2 focus:ring-yellow-500/50" :class="darkMode ? 'bg-[#121212] border-[#2A2A2A] text-white' : 'bg-white border-gray-200'">
    </div>
    <div class="w-[10%]">
        <button wire:click="simpanItemBaru({{ $parentId }}, '{{ $tipe }}')" wire:loading.attr="disabled" class="w-full text-[9px] font-bold py-2 rounded transition-colors text-center border relative overflow-hidden" :class="darkMode ? 'bg-[#2A2A2A] border-[#333333] text-yellow-500 hover:bg-[#333333]' : 'bg-gray-100 border-gray-200 text-gray-700 hover:bg-gray-200'">
            <span wire:loading.remove wire:target="simpanItemBaru({{ $parentId }}, '{{ $tipe }}')">SAVE</span>
            <span wire:loading wire:target="simpanItemBaru({{ $parentId }}, '{{ $tipe }}')">⏳...</span>
        </button>
    </div>
</div>