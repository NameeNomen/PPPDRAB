<div class="min-h-screen bg-[#F2F7F5] p-4 md:p-8 font-sans text-[#02462E]">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Flash Messages --}}
        @if (session()->has('sukses'))
            <div class="p-4 bg-[#02462E]/10 text-[#02462E] rounded-xl text-xs font-bold mb-4">{{ session('sukses') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="p-4 bg-red-100 text-red-700 rounded-xl text-xs font-bold mb-4">{{ session('error') }}</div>
        @endif

        {{-- Header Panel --}}
        <div class="bg-white p-6 md:p-8 rounded-[1.5rem] border border-[#02462E]/10 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest mb-1 block text-[#02462E]/60">MASTER DATA</span>
                    <h1 class="text-2xl md:text-3xl font-black tracking-tight text-[#02462E]">Katalog Material</h1>
                    <p class="text-xs font-medium mt-1 text-[#02462E]/70">Kelola material master & review request dari tim engineering.</p>
                </div>
                <a href="{{ route('purchasing.material-create') }}" class="px-6 py-3 bg-[#02462E] hover:bg-[#03593B] text-[#FEC700] font-bold text-[11px] tracking-widest rounded-xl transition-all shadow-md flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    TAMBAH MATERIAL
                </a>
            </div>

            {{-- Tab Navigation --}}
            <div class="flex gap-6 border-b border-[#02462E]/10">
                <a href="{{ route('purchasing.material-index') }}" 
                   class="pb-3 text-[11px] font-bold uppercase tracking-wider transition-all relative text-[#02462E]/50 hover:text-[#02462E]/80">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        MATERIAL MASTER
                        <span class="px-2 py-0.5 rounded-full text-[10px] bg-[#02462E]/10 text-[#02462E]/60">
                            {{ $countMaterial }}
                        </span>
                    </span>
                </a>

                <a href="javascript:void(0)" 
                   class="pb-3 text-[11px] font-bold uppercase tracking-wider transition-all relative text-[#02462E]">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        REQUEST ENGINEERING
                        <span class="px-2 py-0.5 rounded-full text-[10px] bg-[#02462E] text-[#FEC700]">
                            {{ $countRequest }}
                        </span>
                    </span>
                    <div class="absolute bottom-0 left-0 right-0 h-[2px] bg-[#02462E]"></div>
                </a>
            </div>
        </div>

        {{-- Tabel Request Engineering --}}
        <div class="rounded-2xl shadow-sm border overflow-hidden bg-white border-[#02462E]/10 mt-6">
            @if($requests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="text-[10px] uppercase font-bold tracking-widest border-b bg-[#F2F7F5] text-[#02462E]/60 border-[#02462E]/10">
                            <tr>
                                <th class="px-6 py-4">Material Diminta</th>
                                <th class="px-6 py-4 text-center">Estimasi Kebutuhan</th>
                                <th class="px-6 py-4">Target Waktu (Deadline)</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#02462E]/10">
                            @foreach($requests as $req)
                                @php
                                    $deadline = \Carbon\Carbon::parse($req->target_waktu_dibutuhkan);
                                    // Cek apakah udah lewat deadline dan masih diabaikan (pending)
                                    $isOverdue = $deadline->isPast() && $req->status === 'pending';
                                @endphp
                                <tr class="transition-all hover:bg-[#F2F7F5] {{ $isOverdue ? 'bg-red-50/30' : '' }}">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center font-black text-xs bg-[#FEC700]/20 text-[#02462E]">
                                                {{ strtoupper(substr($req->nama_material, 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="font-black text-[#02462E]">{{ $req->nama_material }}</p>
                                                @if($req->deskripsi) <p class="text-[10px] mt-0.5 text-[#02462E]/60">{{ $req->deskripsi }}</p> @endif
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-5 text-center">
                                        <span class="inline-flex items-center gap-1 px-4 py-2 text-xs font-bold rounded-xl border bg-blue-50 text-blue-700 border-blue-200">
                                            {{ rtrim(rtrim(number_format($req->estimasi_kebutuhan, 2, ',', '.'), '0'), ',') }} {{ $req->satuan }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-5">
                                        {{-- Jamnya udah gua tambahin di sini format H:i --}}
                                        <p class="font-bold text-xs {{ $isOverdue ? 'text-red-600' : 'text-[#02462E]' }}">
                                            {{ $deadline->format('d M Y - H:i') }} WIB
                                        </p>
                                        
                                        @if($isOverdue)
                                            <span class="inline-flex mt-1 items-center gap-1 px-2 py-0.5 text-[9px] font-bold tracking-widest uppercase rounded bg-red-100 text-red-700 border border-red-200">
                                                ⚠️ OVERDUE
                                            </span>
                                        @else
                                            <p class="text-[10px] text-[#02462E]/50 mt-0.5">Tersisa: {{ $deadline->diffForHumans() }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <button wire:click="lihatDetail({{ $req->id }})" class="inline-flex items-center gap-1 px-4 py-2 text-[10px] font-bold uppercase tracking-wider rounded-lg transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5 {{ $isOverdue ? 'bg-red-600 text-white' : 'bg-[#02462E] text-[#FEC700]' }}">
                                            {{ $isOverdue ? 'PROSES SEGERA' : 'Review' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-[#02462E]/10">{{ $requests->links() }}</div>
            @else
                <div class="p-16 text-center">
                    <h3 class="text-xl font-black text-[#02462E]">Tidak Ada Request Masuk</h3>
                </div>
            @endif
        </div>

        {{-- MODAL DETAIL --}}
        @if($isModalOpen && $detailRequest)
            @php
                $modalDeadline = \Carbon\Carbon::parse($detailRequest->target_waktu_dibutuhkan);
                $modalIsOverdue = $modalDeadline->isPast() && $detailRequest->status === 'pending';
            @endphp
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-[#02462E]/40 backdrop-blur-sm p-4">
                <div class="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl">
                    <div class="p-6 border-b border-[#02462E]/10 {{ $modalIsOverdue ? 'bg-red-50' : '' }}">
                        <h2 class="text-xl font-bold text-[#02462E]">Review: {{ $detailRequest->nama_material }}</h2>
                        @if($modalIsOverdue)
                            <p class="text-xs font-bold text-red-600 mt-1">⚠️ Peringatan: Batas waktu permintaan material ini sudah lewat!</p>
                        @endif
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-2 gap-4 bg-[#F2F7F5] p-4 rounded-xl border border-[#02462E]/10">
                            <div>
                                <span class="block text-[10px] font-bold text-[#02462E]/60 uppercase">Kebutuhan</span>
                                <span class="font-bold text-[#02462E]">{{ rtrim(rtrim(number_format($detailRequest->estimasi_kebutuhan, 2, ',', '.'), '0'), ',') }} {{ $detailRequest->satuan }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold text-[#02462E]/60 uppercase">Deadline (Termasuk Jam)</span>
                                <span class="font-bold {{ $modalIsOverdue ? 'text-red-600' : 'text-[#02462E]' }}">
                                    {{ $modalDeadline->format('d M Y - H:i') }} WIB
                                </span>
                            </div>
                        </div>

                        <div class="space-y-2">
    <label class="text-xs font-bold text-[#02462E]/60 uppercase">Catatan Purchasing</label>
    <textarea wire:model="catatan_purchasing" 
              rows="3" 
              placeholder="Opsional jika disetujui. WAJIB diisi jika menolak request!" 
              class="w-full p-3 rounded-xl border border-[#02462E]/20 outline-none focus:ring-2 focus:ring-[#FEC700]/50 focus:border-[#FEC700] transition-all"></textarea>
    @error('catatan_purchasing') 
        <span class="text-xs text-red-600 font-bold">{{ $message }}</span> 
    @enderror
</div>
                    </div>

                    <div class="p-6 bg-[#F2F7F5] flex justify-end gap-3 border-t border-[#02462E]/10">
                        <button wire:click="tutupModal" class="px-6 py-2.5 bg-white border border-[#02462E]/20 text-[#02462E] font-bold text-xs rounded-xl">TUTUP</button>
                        <button wire:click="tolakRequest({{ $detailRequest->id }})" class="px-6 py-2.5 bg-red-100 text-red-700 font-bold text-xs rounded-xl hover:bg-red-200">TOLAK</button>
                        <button wire:click="setujuiRequest({{ $detailRequest->id }})" class="px-6 py-2.5 bg-[#02462E] text-[#FEC700] font-bold text-xs rounded-xl shadow-md hover:bg-[#03593B]">SETUJUI</button>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>