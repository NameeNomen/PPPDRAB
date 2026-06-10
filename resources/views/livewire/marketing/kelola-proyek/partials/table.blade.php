<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-bold tracking-tight text-[#003057]">Kelola Proyek & Tender</h1>
        <p class="text-sm text-[#003057]/70 mt-1">Sistem pencatatan inisiasi proyek menggunakan metode Manual atau RFQ.</p>
    </div>
    <button wire:click="bukaModal" class="bg-[#003057] hover:bg-[#001D36] text-white px-6 py-3 rounded-xl shadow-lg font-semibold transition-all flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Tambah Proyek Baru
    </button>
</div>

@if(session()->has('sukses'))
    <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded-xl mb-6 flex justify-between items-center">
        <span>{{ session('sukses') }}</span>
        <button onclick="this.parentElement.style.display='none'" class="text-green-700 hover:text-green-900 text-xl">&times;</button>
    </div>
@endif
@if(session()->has('gagal'))
    <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded-xl mb-6 flex justify-between items-center">
        <span>{{ session('gagal') }}</span>
        <button onclick="this.parentElement.style.display='none'" class="text-red-700 hover:text-red-900 text-xl">&times;</button>
    </div>
@endif

<!-- SEARCH & FILTER BAR -->
<div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 mb-6 flex flex-col md:flex-row gap-4 items-center">
    <div class="relative flex-1 w-full">
        <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama proyek, no request, atau pelanggan..." class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#E8BF00] outline-none text-sm">
    </div>
    <select wire:model.live="filterStatus" class="px-4 py-2.5 border border-gray-300 rounded-xl outline-none text-sm w-full md:w-auto bg-white">
        <option value="">Semua Status</option>
        <option value="pending">Pending</option>
        <option value="draft">Draft</option>
        <option value="bidding">Bidding</option>
        <option value="approved">Approved</option>
        <option value="on_progress">On Progress</option>
        <option value="completed">Completed</option>
    </select>
    <select wire:model.live="filterCategory" class="px-4 py-2.5 border border-gray-300 rounded-xl outline-none text-sm w-full md:w-auto bg-white">
        <option value="">Semua Kategori</option>
        @foreach($listKategori as $kat)
            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
        @endforeach
    </select>
</div>

<!-- TABLE DATA -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#F2F2F2] border-b border-gray-200 text-xs uppercase tracking-wider text-[#003057] font-bold">
                    <th class="p-4">No. Request</th>
                    <th class="p-4">Nama Proyek</th>
                    <th class="p-4">Pelanggan</th>
                    <th class="p-4">Budget (Est)</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($daftarProyek as $proyek)
                <tr class="border-b border-gray-100 hover:bg-[#F2F2F2]/60 transition-colors">
                    <td class="p-4 font-semibold text-[#003057]">{{ $proyek->request_no }}</td>
                    <td class="p-4">
                        <span class="font-semibold text-[#003057]">{{ $proyek->nama_projek }}</span>
                        <br>
                        <span class="text-xs text-gray-500">{{ $proyek->category->nama_kategori ?? '-' }}</span>
                    </td>
                    <td class="p-4">{{ $proyek->nama_pelanggan }}</td>
                    <td class="p-4 font-medium">Rp {{ number_format($proyek->estimasi_budget ?? 0, 0, ',', '.') }}</td>
                    <td class="p-4">
                        <span class="bg-[#E8BF00] text-[#003057] py-1.5 px-3 rounded-full text-xs font-bold uppercase">{{ $proyek->status_proyek }}</span>
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center items-center gap-1">
                            <button wire:click="bukaDetail({{ $proyek->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </button>
                            <button wire:click="editProyek({{ $proyek->id }})" class="p-2 text-[#E8BF00] hover:bg-yellow-50 rounded-lg transition" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </button>
                            <button onclick="confirm('Hapus data ini?') || event.stopImmediatePropagation()" wire:click="hapusProyek({{ $proyek->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-8 text-center text-gray-400">Data proyek kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>