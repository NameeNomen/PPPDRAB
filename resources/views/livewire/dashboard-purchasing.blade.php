<div class="min-h-screen bg-zinc-50 p-4 md:p-8 font-sans text-slate-800">
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest rounded-md">Modul Pembelian</span>
                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-widest flex items-center gap-1 rounded-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Sistem Aktif
                    </span>
                </div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight uppercase">Purchasing Dashboard</h1>
            </div>
            <div class="text-left md:text-right">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Update Terakhir</p>
                <p class="font-mono text-sm font-black text-slate-700">{{ now()->format('d M Y - H:i') }} WIB</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:shadow-md hover:border-slate-300 transition-all">
                <div class="absolute -right-2 -bottom-2 text-slate-50 group-hover:text-slate-100 transition-colors">
                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 16.811c0 .864-.471 1.623-1.211 2.02l-6.718 3.624a2.198 2.198 0 01-2.142 0l-6.718-3.624A2.194 2.194 0 013 16.811V7.189a2.194 2.194 0 011.211-2.02l6.718-3.624a2.198 2.198 0 012.142 0l6.718 3.624A2.194 2.194 0 0121 7.189v9.622zm-12-6.32v8.941m6-8.941v8.941m-6-8.941l-5.656-3.051m11.656 3.051l5.656-3.051m-11.656-3.051L12 2.25l5.656 3.051"></path></svg>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Katalog Material</p>
                    <p class="text-3xl font-black text-slate-800 font-mono mt-1">{{ number_format($totalMaterial, 0, ',', '.') }}</p>
                    <p class="text-[10px] font-bold text-emerald-500 mt-2 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Terdaftar di Sistem</p>
                </div>
            </div>
            
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:shadow-md hover:border-slate-300 transition-all">
                <div class="absolute -right-2 -bottom-2 text-slate-50 group-hover:text-slate-100 transition-colors">
                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"></path></svg>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Supplier Aktif</p>
                    <p class="text-3xl font-black text-slate-800 font-mono mt-1">{{ number_format($totalSupplier, 0, ',', '.') }}</p>
                    <p class="text-[10px] font-bold text-slate-400 mt-2">Mitra Terverifikasi</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group hover:shadow-md hover:border-slate-300 transition-all">
                <div class="absolute -right-2 -bottom-2 text-slate-50 group-hover:text-slate-100 transition-colors">
                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Frekuensi Transaksi</p>
                    <p class="text-3xl font-black text-slate-800 font-mono mt-1">{{ number_format($trxBulanIni, 0, ',', '.') }}</p>
                    <p class="text-[10px] font-bold text-slate-400 mt-2">Penerbitan PO Bulan Ini</p>
                </div>
            </div>

            <div class="bg-slate-800 p-5 rounded-2xl border border-slate-700 shadow-md relative overflow-hidden group">
                <div class="absolute -right-2 -bottom-2 text-slate-700">
                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"></path></svg>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Nilai Pembelian</p>
                    <p class="text-xl md:text-2xl font-black text-emerald-400 font-mono mt-2">Rp {{ number_format($pembelianBulanIni, 0, ',', '.') }}</p>
                    <p class="text-[10px] font-bold text-slate-300 mt-2">Pengeluaran Bulan Ini</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-[11px] font-black text-slate-700 uppercase tracking-widest flex items-center gap-2">
                        <span class="p-1.5 bg-slate-100 rounded-lg"><svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></span>
                        Grafik Pengeluaran Material
                    </h3>
                    <select class="text-[10px] font-bold bg-zinc-50 border border-slate-200 outline-none py-1.5 px-3 rounded-lg cursor-pointer text-slate-600"><option>Tahun Ini</option><option>6 Bulan Terakhir</option></select>
                </div>
                <div class="h-56 w-full bg-zinc-50 rounded-xl flex items-center justify-center border border-dashed border-slate-200">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Area Render Canvas Chart.js</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-100 bg-white">
                    <h3 class="text-[11px] font-black text-slate-700 uppercase tracking-widest flex items-center gap-2">
                        <span class="p-1.5 bg-orange-50 rounded-lg"><svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></span>
                        Trend Harga Terakhir
                    </h3>
                </div>
                <div class="divide-y divide-slate-100 p-2">
                    <div class="p-3 hover:bg-zinc-50 rounded-xl transition-colors flex justify-between items-center">
                        <div>
                            <p class="text-xs font-black text-slate-700">Semen Tonasa 50kg</p>
                            <p class="text-[10px] font-bold text-slate-400 font-mono mt-0.5">Rp 65.000 / Sak</p>
                        </div>
                        <div class="flex items-center gap-1 text-rose-500 font-black text-[10px] bg-rose-50 px-2.5 py-1.5 rounded-lg border border-rose-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> +2.5%
                        </div>
                    </div>
                    <div class="p-3 hover:bg-zinc-50 rounded-xl transition-colors flex justify-between items-center">
                        <div>
                            <p class="text-xs font-black text-slate-700">Besi Beton Ulir 12mm</p>
                            <p class="text-[10px] font-bold text-slate-400 font-mono mt-0.5">Rp 112.000 / Btg</p>
                        </div>
                        <div class="flex items-center gap-1 text-emerald-600 font-black text-[10px] bg-emerald-50 px-2.5 py-1.5 rounded-lg border border-emerald-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg> -1.2%
                        </div>
                    </div>
                    <div class="p-3 hover:bg-zinc-50 rounded-xl transition-colors flex justify-between items-center">
                        <div>
                            <p class="text-xs font-black text-slate-700">Kabel NYM 3x2.5mm</p>
                            <p class="text-[10px] font-bold text-slate-400 font-mono mt-0.5">Rp 850.000 / Roll</p>
                        </div>
                        <div class="flex items-center gap-1 text-slate-500 font-black text-[10px] bg-slate-50 px-2.5 py-1.5 rounded-lg border border-slate-200">
                            <span class="font-black text-lg leading-none">-</span> STABIL
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-[11px] font-black text-slate-700 uppercase tracking-widest flex items-center gap-2">
                        <span class="p-1.5 bg-slate-100 rounded-lg"><svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg></span>
                        Referensi Harga Material
                    </h3>
                    <input type="text" wire:model.live.debounce.300ms="searchMaterial" placeholder="Cari material..." class="text-[10px] px-3 py-1.5 bg-zinc-50 border border-slate-200 rounded-lg text-slate-700 placeholder-slate-400 w-32 focus:w-48 transition-all outline-none focus:border-slate-400">
                </div>
                <div class="overflow-x-auto p-2">
                    <table class="w-full text-left text-xs whitespace-nowrap">
                        <thead class="bg-zinc-50 text-slate-400 uppercase font-black tracking-widest">
                            <tr>
                                <th class="px-4 py-3 rounded-l-lg">Nama Item</th>
                                <th class="px-4 py-3 text-right">Harga Terakhir</th>
                                <th class="px-4 py-3 text-center rounded-r-lg">Update Pada</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($daftarMaterial as $mat)
                            <tr class="hover:bg-zinc-50 transition-colors group">
                                <td class="px-4 py-3.5 font-bold text-slate-700">{{ $mat->nama_barang }}</td>
                                <td class="px-4 py-3.5 text-right font-mono font-bold text-slate-700">Rp {{ number_format($mat->harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-3.5 text-center text-[10px] text-slate-400 font-bold font-mono">{{ $mat->updated_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-4 py-8 text-center text-slate-400 font-bold bg-zinc-50 rounded-xl mt-2 block">Data material kosong / tidak ditemukan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-[11px] font-black text-slate-700 uppercase tracking-widest flex items-center gap-2">
                        <span class="p-1.5 bg-slate-100 rounded-lg"><svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></span>
                        Supplier Utama Aktif
                    </h3>
                    <button class="text-[9px] px-3 py-1.5 bg-slate-100 text-slate-600 font-bold rounded-lg uppercase hover:bg-slate-200 transition-colors">Lihat Semua</button>
                </div>
                <div class="overflow-x-auto p-2">
                    <table class="w-full text-left text-xs whitespace-nowrap">
                        <thead class="bg-zinc-50 text-slate-400 uppercase font-black tracking-widest">
                            <tr>
                                <th class="px-4 py-3 rounded-l-lg">Nama Supplier</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Total PO</th>
                                <th class="px-4 py-3 text-center rounded-r-lg">Kontak</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <tr class="hover:bg-zinc-50 transition-colors">
                                <td class="px-4 py-3.5 font-bold text-slate-700">PT Bangun Baja Perkasa</td>
                                <td class="px-4 py-3.5 text-center"><span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 text-[9px] font-black rounded-md uppercase">Aktif</span></td>
                                <td class="px-4 py-3.5 text-center font-mono font-bold text-slate-500">124</td>
                                <td class="px-4 py-3.5 text-center"><button class="text-slate-400 hover:text-slate-700 font-black text-sm transition-colors">✉</button></td>
                            </tr>
                            <tr class="hover:bg-zinc-50 transition-colors">
                                <td class="px-4 py-3.5 font-bold text-slate-700">CV Semen Indo Makmur</td>
                                <td class="px-4 py-3.5 text-center"><span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 text-[9px] font-black rounded-md uppercase">Aktif</span></td>
                                <td class="px-4 py-3.5 text-center font-mono font-bold text-slate-500">89</td>
                                <td class="px-4 py-3.5 text-center"><button class="text-slate-400 hover:text-slate-700 font-black text-sm transition-colors">✉</button></td>
                            </tr>
                            <tr class="hover:bg-zinc-50 transition-colors">
                                <td class="px-4 py-3.5 font-bold text-slate-700">Toko Listrik Sinar Abadi</td>
                                <td class="px-4 py-3.5 text-center"><span class="px-2.5 py-1 bg-slate-100 text-slate-600 border border-slate-200 text-[9px] font-black rounded-md uppercase">Pending</span></td>
                                <td class="px-4 py-3.5 text-center font-mono font-bold text-slate-500">32</td>
                                <td class="px-4 py-3.5 text-center"><button class="text-slate-400 hover:text-slate-700 font-black text-sm transition-colors">✉</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>