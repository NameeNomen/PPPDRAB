<div class="min-h-screen pb-10 font-sans transition-colors duration-500 bg-[#F2F7F5]">
    <div class="max-w-7xl mx-auto space-y-8 p-6 md:p-10">
        
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-8 rounded-[1.5rem] border border-[#02462E]/10 shadow-sm">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-3 py-1 bg-[#02462E]/10 text-[#02462E] text-[10px] font-bold uppercase tracking-widest rounded-lg">Modul Pembelian</span>
                    <span class="px-3 py-1 bg-[#FEC700]/20 text-[#02462E] text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 rounded-lg">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#FEC700] animate-pulse"></span> Sistem Aktif
                    </span>
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-[#02462E] tracking-tight">Purchasing Dashboard</h1>
            </div>
            <div class="text-left md:text-right">
                <p class="text-[10px] font-bold text-[#02462E]/60 uppercase tracking-widest">Pembaruan Terakhir</p>
                <p class="font-mono text-sm font-bold text-[#02462E] mt-1">{{ now()->format('d M Y - H:i') }} WIB</p>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-[#02462E]/10 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-[#02462E]/60 uppercase tracking-widest">Katalog Material</p>
                    <div class="p-2 bg-[#02462E]/5 rounded-xl text-[#02462E] group-hover:bg-[#FEC700]/20 group-hover:scale-110 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 16.811c0 .864-.471 1.623-1.211 2.02l-6.718 3.624a2.198 2.198 0 01-2.142 0l-6.718-3.624A2.194 2.194 0 013 16.811V7.189a2.194 2.194 0 011.211-2.02l6.718-3.624a2.198 2.198 0 012.142 0l6.718 3.624A2.194 2.194 0 0121 7.189v9.622zm-12-6.32v8.941m6-8.941v8.941m-6-8.941l-5.656-3.051m11.656 3.051l5.656-3.051m-11.656-3.051L12 2.25l5.656 3.051"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-[#02462E] font-mono">{{ number_format($totalMaterial, 0, ',', '.') }}</p>
                <p class="text-[11px] font-medium text-[#02462E]/70 mt-2 flex items-center gap-1"><svg class="w-3.5 h-3.5 text-[#FEC700]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Terdaftar di Sistem</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-[#02462E]/10 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-[#02462E]/60 uppercase tracking-widest">Supplier Aktif</p>
                    <div class="p-2 bg-[#02462E]/5 rounded-xl text-[#02462E] group-hover:bg-[#FEC700]/20 group-hover:scale-110 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.25 8.25h-10.5m10.5 0c.621 0 1.125.504 1.125 1.125v10.5c0 .621-.504 1.125-1.125 1.125h-10.5c-.621 0-1.125-.504-1.125-1.125v-10.5c0-.621.504-1.125 1.125-1.125h10.5z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-[#02462E] font-mono">{{ number_format($totalSupplier, 0, ',', '.') }}</p>
                <p class="text-[11px] font-medium text-[#02462E]/70 mt-2 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-[#FEC700]"></span> Mitra Terverifikasi</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-[#02462E]/10 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-[#02462E]/60 uppercase tracking-widest">Total Transaksi</p>
                    <div class="p-2 bg-[#02462E]/5 rounded-xl text-[#02462E] group-hover:bg-[#FEC700]/20 group-hover:scale-110 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-[#02462E] font-mono">{{ number_format($trxBulanIni, 0, ',', '.') }}</p>
                <p class="text-[11px] font-medium text-[#02462E]/70 mt-2">Penerbitan PO Bulan Ini</p>
            </div>

            <div class="bg-gradient-to-br from-[#02462E] to-[#03593B] p-6 rounded-2xl shadow-md relative overflow-hidden group">
                <div class="absolute right-0 bottom-0 opacity-10 group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <p class="text-[10px] font-bold text-[#FEC700] uppercase tracking-widest mb-4">Total Nilai Pembelian</p>
                    <div>
                        <p class="text-xl md:text-2xl font-black text-white font-mono">Rp {{ number_format($pembelianBulanIni, 0, ',', '.') }}</p>
                        <p class="text-[11px] font-medium text-white/70 mt-2">Pengeluaran Bulan Ini</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            <div class="lg:col-span-2 bg-white rounded-[1.5rem] border border-[#02462E]/10 shadow-sm p-6 md:p-8 flex flex-col">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xs font-bold uppercase tracking-widest text-[#02462E]">Grafik Pengeluaran Material</h2>
                    <select class="text-xs font-medium bg-[#F2F7F5] border border-[#02462E]/10 py-2 px-4 rounded-lg text-[#02462E] focus:outline-none focus:border-[#02462E] focus:ring-2 focus:ring-[#02462E]/10 transition-all cursor-pointer">
                        <option>Tahun Ini</option>
                        <option>6 Bulan Terakhir</option>
                    </select>
                </div>
                <div class="flex-1 min-h-[250px] w-full bg-[#F2F7F5] rounded-xl flex items-center justify-center border border-dashed border-[#02462E]/20">
                    <span class="text-[#02462E]/50 text-xs font-medium uppercase tracking-widest">Area Integrasi Chart.js</span>
                </div>
            </div>
            
            <div class="bg-white rounded-[1.5rem] border border-[#02462E]/10 shadow-sm flex flex-col overflow-hidden">
                <div class="p-6 md:p-8 border-b border-[#02462E]/5">
                    <h2 class="text-xs font-bold uppercase tracking-widest text-[#02462E]">Trend Harga Terakhir</h2>
                </div>
                <div class="divide-y divide-[#02462E]/5 px-4 pb-4">
                    <div class="py-4 hover:bg-[#F2F7F5] rounded-xl px-4 transition-colors flex justify-between items-center">
                        <div>
                            <p class="text-xs font-bold text-[#02462E]">Semen Tonasa 50kg</p>
                            <p class="text-[11px] text-[#02462E]/60 font-mono mt-1">Rp 65.000 / Sak</p>
                        </div>
                        <div class="flex items-center gap-1 text-[#02462E] font-bold text-[10px] bg-[#FEC700]/30 px-2.5 py-1.5 rounded-lg">
                            <svg class="w-3 h-3 text-[#02462E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> +2.5%
                        </div>
                    </div>
                    <div class="py-4 hover:bg-[#F2F7F5] rounded-xl px-4 transition-colors flex justify-between items-center">
                        <div>
                            <p class="text-xs font-bold text-[#02462E]">Besi Beton Ulir 12mm</p>
                            <p class="text-[11px] text-[#02462E]/60 font-mono mt-1">Rp 112.000 / Btg</p>
                        </div>
                        <div class="flex items-center gap-1 text-white font-bold text-[10px] bg-[#02462E] px-2.5 py-1.5 rounded-lg">
                            <svg class="w-3 h-3 text-[#FEC700]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg> -1.2%
                        </div>
                    </div>
                    <div class="py-4 hover:bg-[#F2F7F5] rounded-xl px-4 transition-colors flex justify-between items-center">
                        <div>
                            <p class="text-xs font-bold text-[#02462E]">Kabel NYM 3x2.5mm</p>
                            <p class="text-[11px] text-[#02462E]/60 font-mono mt-1">Rp 850.000 / Roll</p>
                        </div>
                        <div class="flex items-center gap-1 text-[#02462E]/70 font-bold text-[10px] bg-[#02462E]/10 px-2.5 py-1.5 rounded-lg">
                            STABIL
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 md:gap-8">
            <div class="bg-white rounded-[1.5rem] border border-[#02462E]/10 shadow-sm flex flex-col overflow-hidden">
                <div class="p-6 border-b border-[#02462E]/5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-[#02462E]">Referensi Harga Material</h3>
                    <div class="relative w-full sm:w-56">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-[#02462E]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="searchMaterial" placeholder="Cari material..." class="w-full text-xs pl-9 pr-4 py-2 bg-[#F2F7F5] border border-[#02462E]/10 rounded-lg text-[#02462E] focus:outline-none focus:border-[#02462E] focus:ring-2 focus:ring-[#02462E]/20 transition-all">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs whitespace-nowrap">
                        <thead class="bg-[#F2F7F5] text-[#02462E]/70 uppercase tracking-widest border-b border-[#02462E]/10">
                            <tr>
                                <th class="px-6 py-4 font-medium">Nama Item</th>
                                <th class="px-6 py-4 text-right font-medium">Harga Terakhir</th>
                                <th class="px-6 py-4 text-center font-medium">Update</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#02462E]/5">
                            @forelse($daftarMaterial as $mat)
                            <tr class="hover:bg-[#F2F7F5]/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-[#02462E]">{{ $mat->nama_barang }}</td>
                                <td class="px-6 py-4 text-right font-mono font-medium text-[#02462E]">Rp {{ number_format($mat->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center text-[11px] text-[#02462E]/60">{{ $mat->updated_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-6 py-10 text-center text-[#02462E]/50 font-medium">Data material kosong.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-[1.5rem] border border-[#02462E]/10 shadow-sm flex flex-col overflow-hidden">
                <div class="p-6 border-b border-[#02462E]/5 flex justify-between items-center">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-[#02462E]">Supplier Utama Aktif</h3>
                    <button class="text-[10px] px-4 py-2 bg-[#F2F7F5] text-[#02462E] font-semibold rounded-lg border border-[#02462E]/10 hover:bg-[#02462E]/5 transition-colors">Lihat Semua</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs whitespace-nowrap">
                        <thead class="bg-[#F2F7F5] text-[#02462E]/70 uppercase tracking-widest border-b border-[#02462E]/10">
                            <tr>
                                <th class="px-6 py-4 font-medium">Nama Supplier</th>
                                <th class="px-6 py-4 text-center font-medium">Status</th>
                                <th class="px-6 py-4 text-center font-medium">Total PO</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#02462E]/5">
                            <tr class="hover:bg-[#F2F7F5]/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-[#02462E]">PT Bangun Baja Perkasa</td>
                                <td class="px-6 py-4 text-center"><span class="px-2.5 py-1 bg-[#02462E]/10 text-[#02462E] text-[10px] font-bold rounded-md">Aktif</span></td>
                                <td class="px-6 py-4 text-center font-mono text-[#02462E]">124</td>
                            </tr>
                            <tr class="hover:bg-[#F2F7F5]/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-[#02462E]">CV Semen Indo Makmur</td>
                                <td class="px-6 py-4 text-center"><span class="px-2.5 py-1 bg-[#02462E]/10 text-[#02462E] text-[10px] font-bold rounded-md">Aktif</span></td>
                                <td class="px-6 py-4 text-center font-mono text-[#02462E]">89</td>
                            </tr>
                            <tr class="hover:bg-[#F2F7F5]/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-[#02462E]">Toko Listrik Sinar Abadi</td>
                                <td class="px-6 py-4 text-center"><span class="px-2.5 py-1 bg-[#FEC700]/20 text-[#02462E] text-[10px] font-bold rounded-md">Pending</span></td>
                                <td class="px-6 py-4 text-center font-mono text-[#02462E]">32</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>