<div class="min-h-screen bg-[#F2F7F5] p-4 md:p-8 font-sans text-[#02462E]">
    <div class="max-w-7xl mx-auto space-y-6">
        
        {{-- Flash Messages --}}
        @if (session()->has('sukses'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="px-6 py-4 rounded-2xl text-xs font-bold border flex items-center justify-between shadow-sm bg-[#02462E]/10 border-[#02462E]/20 text-[#02462E]">
                <div class="flex items-center gap-3">
                    <div class="bg-[#FEC700] text-[#02462E] p-1.5 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    {{ session('sukses') }}
                </div>
                <button @click="show = false" class="text-[#02462E]/60 hover:text-[#02462E] outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 x-transition class="px-6 py-4 rounded-2xl text-xs font-bold border flex items-center justify-between shadow-sm bg-red-50 border-red-200 text-red-700">
                <div class="flex items-center gap-3">
                    <div class="bg-red-500 text-white p-1.5 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    {{ session('error') }}
                </div>
                <button @click="show = false" class="text-red-600 hover:text-red-800 outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        {{-- Header dengan Tab System --}}
        <div class="bg-white p-6 md:p-8 rounded-[1.5rem] border border-[#02462E]/10 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest mb-1 block text-[#02462E]/60">Master Data</span>
                    <h1 class="text-2xl md:text-3xl font-black tracking-tight text-[#02462E]">Katalog Material</h1>
                    <p class="text-xs font-medium mt-1 text-[#02462E]/70">Kelola material master & review request dari tim engineering.</p>
                </div>
                @if($activeTab === 'material')
                    <a href="{{ route('purchasing.material-create') }}" class="px-6 py-3 bg-[#02462E] hover:bg-[#03593B] text-[#FEC700] font-bold text-[11px] tracking-widest rounded-xl transition-all shadow-md flex items-center gap-2 hover:shadow-lg hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        TAMBAH MATERIAL
                    </a>
                @else
                    <a href="{{ route('purchasing.material-review') }}" class="px-6 py-3 bg-[#02462E] hover:bg-[#03593B] text-[#FEC700] font-bold text-[11px] tracking-widest rounded-xl transition-all shadow-md flex items-center gap-2 hover:shadow-lg hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        REVIEW SEMUA REQUEST
                    </a>
                @endif
            </div>

            {{-- Tab Navigation --}}
            <div class="flex gap-2 border-b-2 border-[#02462E]/10">
                <button wire:click="switchTab('material')" 
                        class="px-6 py-3 text-xs font-bold uppercase tracking-wider transition-all relative
                        {{ $activeTab === 'material' ? 'text-[#02462E]' : 'text-[#02462E]/50 hover:text-[#02462E]/70' }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Material Master
                        <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'material' ? 'bg-[#02462E] text-[#FEC700]' : 'bg-[#02462E]/10 text-[#02462E]/60' }}">
                            {{ $materials->total() }}
                        </span>
                    </span>
                    @if($activeTab === 'material')
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#02462E]"></div>
                    @endif
                </button>
                <button wire:click="switchTab('request')" 
                        class="px-6 py-3 text-xs font-bold uppercase tracking-wider transition-all relative
                        {{ $activeTab === 'request' ? 'text-[#02462E]' : 'text-[#02462E]/50 hover:text-[#02462E]/70' }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Request Engineering
                        <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeTab === 'request' ? 'bg-[#02462E] text-[#FEC700]' : 'bg-[#02462E]/10 text-[#02462E]/60' }}">
                            {{ $requests->total() }}
                        </span>
                    </span>
                    @if($activeTab === 'request')
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#02462E]"></div>
                    @endif
                </button>
            </div>
        </div>

        {{-- Search Bar --}}
        <div class="rounded-2xl p-4 flex flex-col md:flex-row gap-4 items-center justify-between shadow-sm border bg-white/80 backdrop-blur-md border-[#02462E]/10">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-4 h-4 shrink-0 text-[#02462E]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" wire:model.live.debounce.300ms="search" 
                       placeholder="{{ $activeTab === 'material' ? 'Cari nama material, supplier, atau deskripsi...' : 'Cari nama material atau deskripsi request...' }}"
                       class="w-full text-sm font-bold pl-11 pr-4 py-3 rounded-xl outline-none border transition-all focus:ring-2 focus:ring-[#FEC700]/30 focus:border-[#FEC700] bg-[#F2F7F5] border-[#02462E]/10 text-[#02462E] placeholder-[#02462E]/40">
            </div>
            <div class="text-xs font-bold text-[#02462E]/60">
                Total: <span class="font-black text-[#02462E]">{{ $activeTab === 'material' ? $materials->total() : $requests->total() }}</span> 
                {{ $activeTab === 'material' ? 'Material' : 'Request' }}
            </div>
        </div>

        {{-- TAB: Material Master --}}
        @if($activeTab === 'material')
            <div class="rounded-2xl shadow-sm border overflow-hidden bg-white border-[#02462E]/10">
                
                @if($materials->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="text-[10px] uppercase font-bold tracking-widest border-b bg-[#F2F7F5] text-[#02462E]/60 border-[#02462E]/10">
                                <tr>
                                    <th class="px-6 py-4">Nama Material</th>
                                    <th class="px-6 py-4">Supplier</th>
                                    <th class="px-6 py-4 text-center">QTY & Satuan</th>
                                    <th class="px-6 py-4 text-right">Harga Satuan</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#02462E]/10">
                                @foreach($materials as $material)
                                    <tr class="transition-all hover:bg-[#F2F7F5]">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg flex items-center justify-center font-black text-xs bg-[#FEC700]/20 text-[#02462E]">
                                                    {{ strtoupper(substr($material->nama_barang, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <p class="font-black text-[#02462E]">{{ $material->nama_barang }}</p>
                                                    @if($material->deskripsi)
                                                        <p class="text-[10px] mt-0.5 line-clamp-1 text-[#02462E]/60">{{ $material->deskripsi }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <p class="font-bold text-xs text-[#02462E]">{{ $material->supplier }}</p>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="inline-flex items-center gap-1 px-4 py-2 text-xs font-bold rounded-xl border
                                                {{ $material->jumlah > 0 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                                @if($material->jumlah > 0)
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                @endif
                                                {{ number_format($material->jumlah, 0, ',', '.') }} {{ $material->satuan }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <p class="font-black font-mono text-[#02462E]">
                                                Rp {{ number_format($material->harga, 0, ',', '.') }}
                                            </p>
                                            <p class="text-[10px] text-[#02462E]/50 mt-0.5">per {{ number_format($material->jumlah, 0, ',', '.') }} {{ $material->satuan }}</p>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('material.edit', $material->id) }}"
                                                   class="inline-flex items-center gap-1 px-3 py-2 text-[10px] font-bold uppercase tracking-wider rounded-lg border transition-all hover:-translate-y-0.5 bg-white hover:bg-[#02462E] text-[#02462E] hover:text-[#FEC700] border-[#02462E]/20">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </a>
                                               
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="px-6 py-4 border-t border-[#02462E]/10">
                        {{ $materials->links() }}
                    </div>
                @else
                    {{-- Empty State Material --}}
                    <div class="p-16 text-center">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-2xl flex items-center justify-center bg-[#FEC700]/20">
                            <svg class="w-12 h-12 text-[#02462E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black mb-2 text-[#02462E]">
                            @if(!empty($search))
                                Tidak Ada Hasil Pencarian
                            @else
                                Katalog Material Kosong
                            @endif
                        </h3>
                        <p class="font-bold mb-6 text-[#02462E]/60">
                            @if(!empty($search))
                                Tidak ada material yang cocok dengan pencarian "{{ $search }}"
                            @else
                                Belum ada material yang terdaftar. Mulai tambahkan material pertama Anda.
                            @endif
                        </p>
                        @if(!empty($search))
                            <button wire:click="$set('search', '')" class="px-6 py-3 bg-[#02462E] hover:bg-[#03593B] text-[#FEC700] font-bold text-[11px] tracking-widest rounded-xl transition-all shadow-md">
                                RESET PENCARIAN
                            </button>
                        @else
                            <a href="{{ route('purchasing.material-create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#02462E] hover:bg-[#03593B] text-[#FEC700] font-bold text-[11px] tracking-widest rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                </svg>
                                TAMBAH MATERIAL PERTAMA
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        {{-- TAB: Request Engineering --}}
        @if($activeTab === 'request')
            <div class="rounded-2xl shadow-sm border overflow-hidden bg-white border-[#02462E]/10">
                
                @if($requests->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="text-[10px] uppercase font-bold tracking-widest border-b bg-[#F2F7F5] text-[#02462E]/60 border-[#02462E]/10">
                                <tr>
                                    <th class="px-6 py-4">Material Diminta</th>
                                    <th class="px-6 py-4">Project</th>
                                    <th class="px-6 py-4 text-center">Estimasi Kebutuhan</th>
                                    <th class="px-6 py-4">Target Waktu</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#02462E]/10">
                                @foreach($requests as $request)
                                    <tr class="transition-all hover:bg-[#F2F7F5]">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg flex items-center justify-center font-black text-xs bg-[#FEC700]/20 text-[#02462E]">
                                                    {{ strtoupper(substr($request->nama_material, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <p class="font-black text-[#02462E]">{{ $request->nama_material }}</p>
                                                    @if($request->deskripsi)
                                                        <p class="text-[10px] mt-0.5 line-clamp-1 text-[#02462E]/60">{{ $request->deskripsi }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <p class="font-bold text-xs text-[#02462E]">{{ $request->project->nama_project ?? 'Project #' . $request->r_project_id }}</p>
                                            <p class="text-[10px] text-[#02462E]/50 mt-0.5">Oleh: {{ $request->requester->name ?? 'Engineer' }}</p>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="inline-flex items-center gap-1 px-4 py-2 text-xs font-bold rounded-xl border bg-blue-50 text-blue-700 border-blue-200">
                                                {{ number_format($request->estimasi_kebutuhan, 0, ',', '.') }} {{ $request->satuan }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <p class="font-bold text-xs text-[#02462E]">{{ \Carbon\Carbon::parse($request->target_waktu_dibutuhkan)->format('d M Y') }}</p>
                                            <p class="text-[10px] text-[#02462E]/50 mt-0.5">{{ \Carbon\Carbon::parse($request->target_waktu_dibutuhkan)->diffForHumans() }}</p>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="inline-flex items-center gap-1 px-3 py-1 text-[10px] font-bold rounded-lg border
                                                {{ $request->status === 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : ($request->status === 'approved' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200') }}">
                                                {{ strtoupper($request->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <a href="{{ route('purchasing.material-review') }}" 
                                               class="inline-flex items-center gap-1 px-3 py-2 text-[10px] font-bold uppercase tracking-wider rounded-lg border transition-all hover:-translate-y-0.5 bg-[#02462E] hover:bg-[#03593B] text-[#FEC700] border-[#02462E]">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Review
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="px-6 py-4 border-t border-[#02462E]/10">
                        {{ $requests->links() }}
                    </div>
                @else
                    {{-- Empty State Request --}}
                    <div class="p-16 text-center">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-2xl flex items-center justify-center bg-[#FEC700]/20">
                            <svg class="w-12 h-12 text-[#02462E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black mb-2 text-[#02462E]">
                            @if(!empty($search))
                                Tidak Ada Hasil Pencarian
                            @else
                                Belum Ada Request
                            @endif
                        </h3>
                        <p class="font-bold mb-6 text-[#02462E]/60">
                            @if(!empty($search))
                                Tidak ada request yang cocok dengan pencarian "{{ $search }}"
                            @else
                                Belum ada request material dari tim engineering.
                            @endif
                        </p>
                        @if(!empty($search))
                            <button wire:click="$set('search', '')" class="px-6 py-3 bg-[#02462E] hover:bg-[#03593B] text-[#FEC700] font-bold text-[11px] tracking-widest rounded-xl transition-all shadow-md">
                                RESET PENCARIAN
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>