<div class="min-h-screen bg-[#F2F7F5] p-4 md:p-8 font-sans text-[#02462E]">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <div class="bg-white p-6 md:p-8 rounded-[1.5rem] border border-[#02462E]/10 shadow-sm">
            <span class="text-[10px] font-bold text-[#02462E]/60 uppercase tracking-widest mb-1 block">Inbound Request</span>
            <h1 class="text-2xl md:text-3xl font-black text-[#02462E] tracking-tight">Review Permintaan Engineering</h1>
        </div>

        @if (session()->has('sukses'))
            <div class="p-4 bg-[#02462E]/10 text-[#02462E] rounded-xl text-xs font-bold">{{ session('sukses') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($requests as $req)
                <div class="bg-white p-6 rounded-2xl border border-[#02462E]/10 hover:shadow-md transition-all group">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 bg-[#FEC700]/20 text-[#02462E] rounded-full text-[10px] font-bold tracking-widest">MENUNGGU REVIEW</span>
                        <span class="text-xs text-[#02462E]/50">{{ $req->created_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="font-bold text-lg mb-1">{{ $req->nama_project ?? 'Request #'.$req->id }}</h3>
                    <p class="text-xs text-[#02462E]/70 mb-4">Diminta oleh: {{ $req->engineer->name ?? 'Tim Engineering' }}</p>
                    
                    <button wire:click="lihatDetail({{ $req->id }})" class="w-full py-2 bg-[#F2F7F5] text-[#02462E] text-xs font-bold rounded-lg group-hover:bg-[#02462E] group-hover:text-[#FEC700] transition-colors">
                        CEK DOKUMEN & MATERIAL
                    </button>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-[#02462E]/50 text-sm font-medium">
                    Tidak ada request baru dari tim Engineering.
                </div>
            @endforelse
        </div>

        @if($isModalOpen && $detailRequest)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-[#02462E]/40 backdrop-blur-sm p-4">
            <div class="bg-white rounded-3xl w-full max-w-3xl overflow-hidden shadow-2xl animate-fade-in-down">
                <div class="p-6 md:p-8 border-b border-[#02462E]/10">
                    <h2 class="text-xl font-bold text-[#02462E]">Detail Request: {{ $detailRequest->nama_project ?? 'Project #'.$detailRequest->id }}</h2>
                </div>
                
                <div class="p-6 md:p-8 space-y-6 max-h-[60vh] overflow-y-auto">
                    <div>
                        <h4 class="text-xs font-bold text-[#02462E]/60 uppercase tracking-widest mb-3">Dokumen Lampiran (Dari File Migrasi Lu)</h4>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($detailRequest->attachments as $file)
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="flex items-center gap-3 p-3 bg-[#F2F7F5] rounded-xl hover:bg-[#02462E]/5 transition-colors border border-[#02462E]/10">
                                    <svg class="w-6 h-6 text-[#02462E]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <div class="truncate">
                                        <div class="text-xs font-bold text-[#02462E]">{{ $file->file_name }}</div>
                                        <div class="text-[10px] text-[#02462E]/60 uppercase">{{ str_replace('_', ' ', $file->attachment_category) }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-[#F2F7F5] flex justify-end gap-3 border-t border-[#02462E]/10">
                    <button wire:click="tutupModal" class="px-6 py-2.5 bg-white border border-[#02462E]/20 text-[#02462E] font-bold text-xs rounded-xl hover:bg-gray-50">TUTUP</button>
                    <button wire:click="tolakRequest({{ $detailRequest->id }})" class="px-6 py-2.5 bg-red-100 text-red-700 font-bold text-xs rounded-xl hover:bg-red-200">TOLAK REQUEST</button>
                    <button wire:click="setujuiRequest({{ $detailRequest->id }})" class="px-6 py-2.5 bg-[#02462E] text-[#FEC700] font-bold text-xs rounded-xl hover:bg-[#03593B]">SETUJUI & PROSES</button>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>