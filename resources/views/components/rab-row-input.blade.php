<div class="flex gap-2 w-full items-center relative">
    <div class="w-[35%]">
        <input type="text" wire:model="deskripsiInput.{{ $parentId }}" wire:keydown.enter="simpanItemBaru({{ $parentId }}, '{{ $tipe }}')" placeholder="{{ $placeholder }} (Tekan Enter utk Save)" class="w-full text-[10px] p-2 rounded border outline-none shadow-inner" :class="darkMode ? 'bg-[#121212] border-[#2A2A2A] text-white focus:border-yellow-500' : 'bg-white border-gray-200 focus:border-yellow-500'">
    </div>
    <div class="w-[30%] relative">
        @if(!empty($selectedMaterial[$parentId]))
            <div class="flex items-center justify-between bg-yellow-50 dark:bg-[#1A1500] border border-yellow-200 dark:border-yellow-700 text-yellow-700 dark:text-yellow-500 p-1.5 rounded">
                <span class="truncate text-[9px] font-bold">{{ $selectedMaterial[$parentId]['nama'] }}</span>
                <button wire:click="batalPilihMaterial({{ $parentId }})" class="text-rose-500 ml-1 font-bold focus:outline-none">&times;</button>
            </div>
        @else
            <input type="text" wire:model.live.debounce.300ms="materialSearch.{{ $parentId }}" placeholder="Ketik material..." class="w-full text-[10px] p-2 rounded border outline-none shadow-inner" :class="darkMode ? 'bg-[#121212] border-[#2A2A2A] text-white focus:border-yellow-500' : 'bg-white border-gray-200 focus:border-yellow-500'">
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
        <input type="number" step="0.01" wire:model="volumeInput.{{ $parentId }}" wire:keydown.enter="simpanItemBaru({{ $parentId }}, '{{ $tipe }}')" placeholder="Vol" class="w-full text-[10px] p-2 text-center rounded border outline-none font-mono shadow-inner" :class="darkMode ? 'bg-[#121212] border-[#2A2A2A] text-white' : 'bg-white border-gray-200'">
    </div>
    <div class="w-[20%]">
        <input type="number" wire:model="hargaInput.{{ $parentId }}" wire:keydown.enter="simpanItemBaru({{ $parentId }}, '{{ $tipe }}')" placeholder="Harga (Enter utk Save)" class="w-full text-[10px] p-2 text-right rounded border outline-none font-mono shadow-inner" :class="darkMode ? 'bg-[#121212] border-[#2A2A2A] text-white' : 'bg-white border-gray-200'">
    </div>
</div>