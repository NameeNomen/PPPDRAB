<div class="min-h-screen bg-slate-100 p-4 md:p-8 font-sans text-slate-800 relative">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-2 bg-slate-800"></div>
            <div>
                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest rounded">Pusat Otorisasi</span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase mt-1">Review & Persetujuan Dokumen</h1>
                <p class="text-xs text-slate-500 mt-0.5 font-medium">Pratinjau draf dokumen cetak (PDF) sebelum memberikan otorisasi final.</p>
            </div>
        </div>

        @if (session()->has('sukses')) <div class="px-5 py-3 bg-emerald-50 text-emerald-700 rounded-2xl text-xs font-bold border border-emerald-200 shadow-sm">{{ session('sukses') }}</div> @endif
        @if (session()->has('error')) <div class="px-5 py-3 bg-amber-50 text-amber-700 rounded-2xl text-xs font-bold border border-amber-200 shadow-sm">{{ session('error') }}</div> @endif

        <!-- ================= FASE 1: DAFTAR PROYEK ================= -->
        @if($view === 'list')
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-900 text-white flex justify-between items-center">
                    <h3 class="text-xs font-black uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span> Antrean Proyek Membutuhkan Tinjauan
                    </h3>
                </div>
                <div class="overflow-x-auto p-2">
                    <table class="w-full text-left text-xs whitespace-nowrap min-w-[800px]">
                        <thead class="bg-slate-50 text-slate-400 uppercase font-black tracking-widest">
                            <tr>
                                <th class="px-4 py-3 rounded-l-lg">No. Referensi</th>
                                <th class="px-4 py-3">Instansi / Klien</th>
                                <th class="px-4 py-3 text-center">Status Dokumen</th>
                                <th class="px-4 py-3 text-center rounded-r-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($proyekPending as $proyek)
                                @php 
                                    $rabCount = $proyek->rabs()->where('status_rab', 'pending_approval')->count();
                                    $biddingCount = $proyek->biddings()->where('status_bidding', 'draft')->count();
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-4 py-4 font-mono font-bold text-slate-800">{{ $proyek->request_no }}</td>
                                    <td class="px-4 py-4 font-black text-slate-900 uppercase">{{ $proyek->nama_pelanggan }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($rabCount > 0) <span class="px-2 py-0.5 bg-rose-100 text-rose-700 text-[9px] font-black rounded uppercase">RAB Pending</span> @endif
                                            @if($biddingCount > 0) <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[9px] font-black rounded uppercase">Bidding Pending</span> @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <!-- ANIMASI LOADING PAS KLIK BUKA MAP DOKUMEN -->
                                        <button wire:click="lihatDokumenProyek({{ $proyek->id }})" wire:loading.attr="disabled" wire:target="lihatDokumenProyek({{ $proyek->id }})" class="px-5 py-2 bg-slate-800 hover:bg-slate-700 text-white font-bold text-[10px] tracking-widest rounded-lg transition-all shadow-sm w-44">
                                            <span wire:loading.remove wire:target="lihatDokumenProyek({{ $proyek->id }})">BUKA MAP DOKUMEN</span>
                                            <span wire:loading wire:target="lihatDokumenProyek({{ $proyek->id }})" class="flex items-center justify-center gap-2">
                                                <svg class="animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> MEMUAT...
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-12 text-center text-slate-400 font-bold bg-slate-50 rounded-xl mt-2 block">Bersih! Tidak ada dokumen proyek yang mengantre.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        <!-- ================= FASE 2: LIST KARTU DOKUMEN PROYEK ================= -->
        @elseif($view === 'document_list')
            <div class="flex items-center gap-3 mb-4">
                <button wire:click="kembaliKeList" class="p-2 bg-white border border-slate-200 text-slate-500 hover:text-slate-800 hover:bg-slate-50 rounded-xl transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </button>
                <div>
                    <h2 class="text-sm font-black text-slate-700 uppercase tracking-widest">MAP DOKUMEN: {{ $selectedProject->nama_pelanggan }}</h2>
                    <p class="text-[10px] font-bold text-slate-400">Pilih dokumen yang ingin dipratinjau dalam format PDF.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- KARTU DOKUMEN RAB -->
                @foreach($selectedProject->rabs as $rab)
                    <div class="bg-white p-6 rounded-2xl border-2 border-rose-100 shadow-sm flex flex-col justify-between items-start">
                        <div class="w-full">
                            <span class="px-2 py-0.5 bg-rose-100 text-rose-700 text-[9px] font-black rounded uppercase">Dokumen RAB WBS</span>
                            <h4 class="text-xl font-black text-slate-800 font-mono mt-2">{{ $rab->no_boq }}</h4>
                            <p class="text-xs text-slate-500 font-bold mt-1">Total Usulan: <span class="text-slate-900 font-black font-mono">Rp {{ number_format($rab->grand_total, 0, ',', '.') }}</span></p>
                        </div>
                        <div class="mt-6 w-full text-right">
                            <button wire:click="lihatDetailRab({{ $rab->id }})" wire:loading.attr="disabled" wire:target="lihatDetailRab({{ $rab->id }})" class="w-full md:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-bold text-[10px] tracking-widest rounded-xl transition-all flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="lihatDetailRab({{ $rab->id }})" class="flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> PRATINJAU CETAK</span>
                                <span wire:loading wire:target="lihatDetailRab({{ $rab->id }})" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> MENYIAPKAN PDF...
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach

                <!-- KARTU DOKUMEN BIDDING -->
                @foreach($selectedProject->biddings as $bidding)
                    <div class="bg-white p-6 rounded-2xl border-2 border-blue-100 shadow-sm flex flex-col justify-between items-start">
                        <div class="w-full">
                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[9px] font-black rounded uppercase">Dokumen Surat Penawaran</span>
                            <h4 class="text-xl font-black text-slate-800 font-mono mt-2">{{ $bidding->no_penawaran }}</h4>
                            <p class="text-xs text-slate-500 font-bold mt-1">Nilai Tawar: <span class="text-slate-900 font-black font-mono">Rp {{ number_format($bidding->total_penawaran, 0, ',', '.') }}</span></p>
                        </div>
                        <div class="mt-6 w-full text-right">
                            <button wire:click="lihatDetailBidding({{ $bidding->id }})" wire:loading.attr="disabled" wire:target="lihatDetailBidding({{ $bidding->id }})" class="w-full md:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-bold text-[10px] tracking-widest rounded-xl transition-all flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="lihatDetailBidding({{ $bidding->id }})" class="flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> PRATINJAU CETAK</span>
                                <span wire:loading wire:target="lihatDetailBidding({{ $bidding->id }})" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> MENYIAPKAN PDF...
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

        <!-- ================= FASE 3: PDF PREVIEW DOKUMEN RAB ================= -->
        @elseif($view === 'detail_rab')
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <button wire:click="kembaliKeDocumentList" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg> Tutup Pratinjau
                </button>
                <div class="flex gap-2 w-full md:w-auto shadow-lg">
                    <button wire:click="bukaModalRevisi({{ $selectedRab->id }}, 'rab')" class="flex-1 md:flex-none px-6 py-3 bg-white border-y border-l border-rose-200 text-rose-600 hover:bg-rose-50 font-black text-xs tracking-widest rounded-l-xl transition-all">✕ REVISI</button>
                    
                    <!-- TOMBOL SAHKAN DENGAN LOADING STATE -->
                    <button wire:click="setujuiDokumen({{ $selectedRab->id }}, 'rab')" wire:loading.attr="disabled" wire:target="setujuiDokumen" class="flex-1 md:flex-none px-6 py-3 bg-emerald-600 border border-emerald-600 hover:bg-emerald-700 text-white font-black text-xs tracking-widest rounded-r-xl transition-all shadow-md flex items-center justify-center min-w-[180px]">
                        <span wire:loading.remove wire:target="setujuiDokumen">✓ SAHKAN DOKUMEN</span>
                        <span wire:loading wire:target="setujuiDokumen" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> 
                            MEMPROSES...
                        </span>
                    </button>
                </div>
            </div>

            <!-- KERTAS A4 SIMULASI PDF RAB -->
            <div class="max-w-[210mm] mx-auto bg-white p-8 md:p-[20mm] shadow-2xl border border-slate-300 min-h-[297mm] text-black">
                <div class="border-b-4 border-black pb-4 mb-6 flex justify-between items-end">
                    <div>
                        <h1 class="text-2xl font-black font-serif uppercase tracking-tight">PT Tri Jaya Teknik</h1>
                        <p class="text-[10px] mt-1 font-mono">Jl. Engineering No. 12, Karawang, Jawa Barat<br>Telp: (0267) 123456 | Email: info@trijayateknik.com</p>
                    </div>
                    <div class="text-right"><span class="text-xs font-bold border border-black px-2 py-1 uppercase tracking-widest">Divisi Engineering</span></div>
                </div>

                <div class="text-center mb-8">
                    <h2 class="text-xl font-black uppercase underline underline-offset-4">Rencana Anggaran Biaya (RAB)</h2>
                    <p class="text-sm font-semibold mt-1">No. Dokumen: {{ $selectedRab->no_boq }}</p>
                </div>

                <table class="w-full text-xs font-semibold mb-6">
                    <tr><td class="w-32 py-1">Pekerjaan</td><td class="w-4">:</td><td class="uppercase">{{ $selectedProject->deskripsi_proyek }}</td></tr>
                    <tr><td class="w-32 py-1">Klien/Instansi</td><td class="w-4">:</td><td class="uppercase">{{ $selectedProject->nama_pelanggan }}</td></tr>
                    <tr><td class="w-32 py-1">Tanggal Buat</td><td class="w-4">:</td><td>{{ \Carbon\Carbon::parse($selectedRab->tgl_boq)->format('d F Y') }}</td></tr>
                </table>

                <table class="w-full text-[10px] border-collapse border border-black mb-8">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="border border-black p-2 w-10 text-center">NO</th>
                            <th class="border border-black p-2 text-center">URAIAN PEKERJAAN</th>
                            <th class="border border-black p-2 w-12 text-center">VOL</th>
                            <th class="border border-black p-2 w-24 text-center">HARGA SATUAN<br>(Rp)</th>
                            <th class="border border-black p-2 w-28 text-center">JUMLAH HARGA<br>(Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wbsStruktur as $idxKat => $kat)
                            <tr class="bg-slate-50 font-bold">
                                <td class="border border-black p-2 text-center">{{ \Carbon\Carbon::createFromDate()->addMonths($idxKat)->format('A') }}</td>
                                <td class="border border-black p-2 uppercase" colspan="3">{{ $kat->deskripsi_pekerjaan }}</td>
                                <td class="border border-black p-2 text-right">{{ number_format($kat->children->sum('subtotal'), 0, ',', '.') }}</td>
                            </tr>
                            @foreach($kat->children as $idxIt => $item)
                                <tr>
                                    <td class="border border-black p-1.5 text-center">{{ $idxIt+1 }}</td>
                                    <td class="border border-black p-1.5">{{ $item->deskripsi_pekerjaan }}</td>
                                    <td class="border border-black p-1.5 text-center">{{ $item->qty }}</td>
                                    <td class="border border-black p-1.5 text-right">{{ number_format($item->harga_awal, 0, ',', '.') }}</td>
                                    <td class="border border-black p-1.5 text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @empty
                            <tr><td colspan="5" class="border border-black p-4 text-center italic">Rincian pekerjaan belum dilampirkan.</td></tr>
                        @endforelse
                        <tr class="font-bold">
                            <td colspan="4" class="border border-black p-2 text-right uppercase">Total Rincian Pekerjaan</td>
                            <td class="border border-black p-2 text-right">{{ number_format($selectedRab->grand_total - $selectedRab->overhead_cost, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="font-bold">
                            <td colspan="4" class="border border-black p-2 text-right uppercase">Overhead / Jasa & Profit</td>
                            <td class="border border-black p-2 text-right">{{ number_format($selectedRab->overhead_cost, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="font-black bg-slate-100 text-xs">
                            <td colspan="4" class="border border-black p-2 text-right uppercase">GRAND TOTAL ESTIMASI</td>
                            <td class="border border-black p-2 text-right underline">Rp {{ number_format($selectedRab->grand_total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex justify-between mt-12 text-xs text-center font-bold">
                    <div class="w-48"><p>Dibuat Oleh,</p><p class="mt-16 underline">Divisi Engineering</p><p>PT Tri Jaya Teknik</p></div>
                    <div class="w-48"><p>Menyetujui,</p><p class="mt-16 text-rose-500 border border-dashed border-rose-500 rounded p-1">Tanda Tangan Elektronik<br>Akan tercetak otomatis</p><p class="mt-1">Direktur Utama</p></div>
                </div>
            </div>

        <!-- ================= FASE 4: PDF PREVIEW DOKUMEN BIDDING ================= -->
        @elseif($view === 'detail_bidding')
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <button wire:click="kembaliKeDocumentList" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg> Tutup Pratinjau
                </button>
                <div class="flex gap-2 w-full md:w-auto shadow-lg">
                    <button wire:click="bukaModalRevisi({{ $selectedBidding->id }}, 'bidding')" class="flex-1 md:flex-none px-6 py-3 bg-white border-y border-l border-amber-200 text-amber-600 hover:bg-amber-50 font-black text-xs tracking-widest rounded-l-xl transition-all">✕ REVISI</button>
                    
                    <!-- TOMBOL SAHKAN DENGAN LOADING STATE -->
                    <button wire:click="setujuiDokumen({{ $selectedBidding->id }}, 'bidding')" wire:loading.attr="disabled" wire:target="setujuiDokumen" class="flex-1 md:flex-none px-6 py-3 bg-emerald-600 border border-emerald-600 hover:bg-emerald-700 text-white font-black text-xs tracking-widest rounded-r-xl transition-all shadow-md flex items-center justify-center min-w-[180px]">
                        <span wire:loading.remove wire:target="setujuiDokumen">✓ SAHKAN SURAT</span>
                        <span wire:loading wire:target="setujuiDokumen" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> 
                            MEMPROSES...
                        </span>
                    </button>
                </div>
            </div>

            <div class="max-w-[210mm] mx-auto bg-white p-8 md:p-[20mm] shadow-2xl border border-slate-300 min-h-[297mm] text-black font-serif">
                <div class="border-b-4 border-black pb-4 mb-8 flex justify-between items-end">
                    <div>
                        <h1 class="text-2xl font-black uppercase tracking-tight">PT Tri Jaya Teknik</h1>
                        <p class="text-[10px] mt-1 font-mono">Jl. Industrial Raya No. 45, Karawang, Jawa Barat<br>Telp: (0267) 123456 | Email: marketing@trijayateknik.com</p>
                    </div>
                </div>

                <div class="flex justify-between text-sm mb-8">
                    <table class="w-1/2">
                        <tr><td class="w-20">Nomor</td><td class="w-4">:</td><td class="font-bold">{{ $selectedBidding->no_penawaran }}</td></tr>
                        <tr><td>Lampiran</td><td>:</td><td>1 (Satu) Berkas Proposal</td></tr>
                        <tr><td>Perihal</td><td>:</td><td class="font-bold underline">Penawaran Harga Pekerjaan</td></tr>
                    </table>
                    <div class="text-right"><p>Karawang, {{ now()->format('d F Y') }}</p></div>
                </div>

                <div class="text-sm mb-8 leading-relaxed">
                    <p>Kepada Yth,</p>
                    <p class="font-bold uppercase">{{ $selectedProject->nama_pelanggan }}</p>
                    <p>Di Tempat.</p>
                </div>

                <div class="text-sm leading-loose text-justify mb-8">
                    <p>Dengan hormat,</p>
                    <p>Bersama surat ini, kami dari PT Tri Jaya Teknik bermaksud mengajukan penawaran harga untuk pekerjaan <span class="font-bold uppercase">{{ $selectedProject->deskripsi_proyek }}</span> sesuai dengan permintaan dan spesifikasi yang telah didiskusikan sebelumnya.</p>
                    <p class="mt-4">Adapun total nilai penawaran yang kami ajukan adalah sebesar:</p>
                    
                    <div class="my-6 p-4 border border-black bg-slate-50 text-center">
                        <p class="text-sm uppercase tracking-widest font-bold">Total Nilai Penawaran (Include PPN)</p>
                        <p class="text-2xl font-black mt-2">Rp {{ number_format($selectedBidding->total_penawaran, 0, ',', '.') }}</p>
                    </div>

                    <p>Harga tersebut telah mencakup jasa eksekusi, material terlampir, serta overhead pelaksanaan proyek. Rincian lebih lanjut dapat dilihat pada lampiran *Bill of Quantities* (BOQ) yang menyertai surat ini.</p>
                    <p class="mt-4">Demikian surat penawaran ini kami sampaikan. Kami berharap dapat menjalin kerjasama yang baik dengan perusahaan Bapak/Ibu. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
                </div>

                <div class="flex justify-end mt-16 text-sm text-center font-bold">
                    <div class="w-48">
                        <p>Hormat Kami,</p>
                        <p class="mt-16 text-emerald-600 border border-dashed border-emerald-500 rounded p-1 text-[10px] font-mono">Tanda Tangan Elektronik<br>Disetujui via Sistem</p>
                        <p class="mt-1 underline uppercase">Direktur Utama</p>
                        <p class="text-xs font-normal">PT Tri Jaya Teknik</p>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <!-- ================= MODAL REVISI DENGAN LOADING STATE ================= -->
    @if($isRevisiModalOpen)
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden border border-slate-100 animate-fade-in-down">
                <div class="px-6 py-4 border-b border-slate-100 bg-rose-50 flex justify-between items-center">
                    <h3 class="text-xs font-black text-rose-800 uppercase tracking-widest flex items-center gap-2">⚠ Berikan Instruksi Revisi</h3>
                    <button wire:click="tutupModalRevisi" class="text-rose-400 hover:text-rose-700 font-bold text-lg transition-colors">✕</button>
                </div>
                
                <form wire:submit.prevent="kirimRevisi" class="p-6 space-y-4">
                    <p class="text-xs font-bold text-slate-500 leading-relaxed">Berikan arahan spesifik perbaikan dokumen ini. Dokumen akan dikembalikan ke status *Draft* atau *Revision*.</p>
                    <div>
                        <textarea wire:model="komentar_commit" rows="4" placeholder="Ketik alasan penolakan, contoh: Margin penawaran terlalu rendah, naikkan 5%..." class="w-full text-xs font-bold bg-zinc-50 border border-slate-200 text-slate-800 rounded-xl p-4 outline-none focus:border-rose-400 focus:bg-white transition-all resize-none shadow-inner"></textarea>
                        @error('komentar_commit') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="tutupModalRevisi" class="px-5 py-2 text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">BATAL</button>
                        
                        <!-- TOMBOL KIRIM REVISI DENGAN LOADING STATE -->
                        <button type="submit" wire:loading.attr="disabled" wire:target="kirimRevisi" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-md transition-all min-w-[200px] flex items-center justify-center">
                            <span wire:loading.remove wire:target="kirimRevisi">TOLAK & KEMBALIKAN DOKUMEN</span>
                            <span wire:loading wire:target="kirimRevisi" class="flex items-center gap-2">
                                <svg class="animate-spin h-3 w-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> 
                                MENGIRIM REVISI...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>