<div class="min-h-screen bg-[#E89154]/5 p-4 md:p-8 font-sans text-[#2A0001] relative overflow-hidden z-0">
    <!-- DECORATIVE BACKGROUND BLOBS BIAR GAK KOSONG -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#DA7134]/10 rounded-full blur-3xl -z-10 mix-blend-multiply"></div>
    <div class="absolute bottom-0 left-[-10%] w-[600px] h-[600px] bg-[#E89154]/10 rounded-full blur-3xl -z-10 mix-blend-multiply"></div>

    <div class="max-w-7xl mx-auto space-y-6 md:space-y-8 relative z-10">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/70 backdrop-blur-xl p-6 md:p-8 rounded-[2rem] border border-[#DA7134]/20 shadow-xl shadow-[#DA7134]/5 relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-2 bg-gradient-to-b from-[#852616] to-[#DA7134]"></div>
            <div>
                <span class="px-3 py-1 bg-[#DA7134]/10 text-[#852616] text-[10px] font-black uppercase tracking-widest rounded-xl border border-[#DA7134]/20">Pusat Otorisasi</span>
                <h1 class="text-2xl md:text-3xl font-black text-[#2A0001] tracking-tight uppercase mt-3">Review & Persetujuan</h1>
                <p class="text-xs text-[#852616]/80 mt-1.5 font-bold">Pratinjau draf dokumen cetak (PDF) sebelum memberikan otorisasi final.</p>
            </div>
        </div>

        @if (session()->has('sukses')) 
            <div class="px-6 py-4 bg-[#DA7134]/10 backdrop-blur-md text-[#852616] rounded-2xl text-xs font-black tracking-wide border border-[#DA7134]/30 shadow-lg shadow-[#DA7134]/5 flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-[#852616] animate-ping"></span> {{ session('sukses') }}
            </div> 
        @endif
        @if (session()->has('error')) 
            <div class="px-6 py-4 bg-[#852616]/10 backdrop-blur-md text-[#2A0001] rounded-2xl text-xs font-black tracking-wide border border-[#852616]/20 shadow-lg shadow-[#852616]/5 flex items-center gap-3">
                <span class="text-[#2A0001] text-lg">⚠</span> {{ session('error') }}
            </div> 
        @endif

        <!-- ================= FASE 1: DAFTAR PROYEK ================= -->
        @if($view === 'list')
            <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] border border-[#DA7134]/20 shadow-xl shadow-[#DA7134]/5 overflow-hidden">
                <div class="p-6 border-b border-[#DA7134]/20 bg-gradient-to-r from-[#2A0001] to-[#852616] text-white flex justify-between items-center">
                    <h3 class="text-xs font-black uppercase tracking-widest flex items-center gap-3 text-[#E89154]">
                        <span class="relative flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#E89154] opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#E89154]"></span>
                        </span>
                        Antrean Proyek Membutuhkan Tinjauan
                    </h3>
                </div>
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-left text-xs whitespace-nowrap min-w-[800px]">
                        <thead class="bg-[#E89154]/10 text-[#852616] uppercase font-black tracking-widest">
                            <tr>
                                <th class="px-5 py-4 rounded-l-2xl">No. Referensi</th>
                                <th class="px-5 py-4">Instansi / Klien</th>
                                <th class="px-5 py-4 text-center">Status Dokumen</th>
                                <th class="px-5 py-4 text-center rounded-r-2xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#DA7134]/10">
                            @forelse($proyekPending as $proyek)
                                @php 
                                    $rabCount = $proyek->rabs()->where('status_rab', 'pending_approval')->count();
                                    $biddingCount = $proyek->biddings()->where('status_bidding', 'draft')->count();
                                @endphp
                                <tr class="hover:bg-[#E89154]/10 transition-all duration-200 group">
                                    <td class="px-5 py-5 font-mono font-bold text-[#852616]">{{ $proyek->request_no }}</td>
                                    <td class="px-5 py-5 font-black text-[#2A0001] uppercase">{{ $proyek->nama_pelanggan }}</td>
                                    <td class="px-5 py-5 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($rabCount > 0) <span class="px-3 py-1 bg-[#852616]/10 text-[#852616] text-[9px] font-black rounded-xl uppercase border border-[#852616]/20 shadow-sm">RAB Pending</span> @endif
                                            @if($biddingCount > 0) <span class="px-3 py-1 bg-[#DA7134]/15 text-[#852616] text-[9px] font-black rounded-xl uppercase border border-[#DA7134]/30 shadow-sm">Bidding Pending</span> @endif
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 text-center">
                                        <!-- ANIMASI LOADING PAS KLIK BUKA MAP DOKUMEN -->
                                        <button wire:click="lihatDokumenProyek({{ $proyek->id }})" wire:loading.attr="disabled" wire:target="lihatDokumenProyek({{ $proyek->id }})" class="px-6 py-2.5 bg-[#2A0001] hover:bg-[#852616] hover:-translate-y-0.5 text-white font-bold text-[10px] tracking-widest rounded-xl transition-all duration-300 shadow-lg shadow-[#2A0001]/20 w-48">
                                            <span wire:loading.remove wire:target="lihatDokumenProyek({{ $proyek->id }})">BUKA MAP DOKUMEN</span>
                                            <span wire:loading wire:target="lihatDokumenProyek({{ $proyek->id }})" class="flex items-center justify-center gap-2">
                                                <svg class="animate-spin h-3.5 w-3.5 text-[#E89154]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> MEMUAT...
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-16 text-center text-[#852616]/60 font-bold bg-white/50 rounded-2xl mt-4 block border-2 border-dashed border-[#DA7134]/20">Belum ada dokumen proyek yang mengantre untuk diperiksa.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        <!-- ================= FASE 2: LIST KARTU DOKUMEN PROYEK ================= -->
        @elseif($view === 'document_list')
            <div class="flex items-center gap-4 mb-6">
                <button wire:click="kembaliKeList" class="p-3 bg-white/80 backdrop-blur-md border border-[#DA7134]/30 text-[#852616] hover:text-[#2A0001] hover:bg-[#E89154]/20 rounded-2xl transition-all shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </button>
                <div>
                    <h2 class="text-xs md:text-sm font-black text-[#2A0001] uppercase tracking-widest">MAP DOKUMEN: <span class="text-[#852616]">{{ $selectedProject->nama_pelanggan }}</span></h2>
                    <p class="text-[10px] font-bold text-[#852616]/70 mt-0.5">Pilih dokumen yang ingin dipratinjau dalam format PDF.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                <!-- KARTU DOKUMEN RAB -->
                @foreach($selectedProject->rabs as $rab)
                    <div class="group bg-white/70 backdrop-blur-xl p-8 rounded-[2rem] border-2 border-[#E89154]/20 hover:border-[#DA7134]/60 shadow-lg shadow-[#DA7134]/5 hover:shadow-xl hover:shadow-[#DA7134]/10 hover:-translate-y-1 flex flex-col justify-between items-start transition-all duration-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-[#DA7134]/10 to-transparent rounded-bl-full -z-10"></div>
                        <div class="w-full z-10">
                            <span class="px-3 py-1 bg-[#852616]/10 text-[#852616] text-[9px] font-black rounded-xl uppercase border border-[#852616]/10">Dokumen RAB WBS</span>
                            <h4 class="text-2xl font-black text-[#2A0001] font-mono mt-4">{{ $rab->no_boq }}</h4>
                            <p class="text-xs text-[#852616] font-bold mt-2">Total Usulan: <span class="text-[#2A0001] font-black font-mono bg-[#E89154]/20 px-2 py-0.5 rounded-lg ml-1">Rp {{ number_format($rab->grand_total, 0, ',', '.') }}</span></p>
                        </div>
                        <div class="mt-10 w-full text-right z-10">
                            <button wire:click="lihatDetailRab({{ $rab->id }})" wire:loading.attr="disabled" wire:target="lihatDetailRab({{ $rab->id }})" class="w-full md:w-auto px-6 py-3 bg-[#2A0001] hover:bg-[#852616] text-white font-bold text-[10px] tracking-widest rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg shadow-[#2A0001]/20 group-hover:shadow-[#852616]/30">
                                <span wire:loading.remove wire:target="lihatDetailRab({{ $rab->id }})" class="flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> PRATINJAU CETAK</span>
                                <span wire:loading wire:target="lihatDetailRab({{ $rab->id }})" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-3.5 w-3.5 text-[#E89154]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> MENYIAPKAN PDF...
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach

                <!-- KARTU DOKUMEN BIDDING -->
                @foreach($selectedProject->biddings as $bidding)
                    <div class="group bg-white/70 backdrop-blur-xl p-8 rounded-[2rem] border-2 border-[#E89154]/20 hover:border-[#DA7134]/60 shadow-lg shadow-[#DA7134]/5 hover:shadow-xl hover:shadow-[#DA7134]/10 hover:-translate-y-1 flex flex-col justify-between items-start transition-all duration-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-[#DA7134]/10 to-transparent rounded-bl-full -z-10"></div>
                        <div class="w-full z-10">
                            <span class="px-3 py-1 bg-[#DA7134]/15 text-[#852616] text-[9px] font-black rounded-xl uppercase border border-[#DA7134]/20">Dokumen Surat Penawaran</span>
                            <h4 class="text-2xl font-black text-[#2A0001] font-mono mt-4">{{ $bidding->no_penawaran }}</h4>
                            <p class="text-xs text-[#852616] font-bold mt-2">Nilai Tawar: <span class="text-[#2A0001] font-black font-mono bg-[#E89154]/20 px-2 py-0.5 rounded-lg ml-1">Rp {{ number_format($bidding->total_penawaran, 0, ',', '.') }}</span></p>
                        </div>
                        <div class="mt-10 w-full text-right z-10">
                            <button wire:click="lihatDetailBidding({{ $bidding->id }})" wire:loading.attr="disabled" wire:target="lihatDetailBidding({{ $bidding->id }})" class="w-full md:w-auto px-6 py-3 bg-[#2A0001] hover:bg-[#852616] text-white font-bold text-[10px] tracking-widest rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg shadow-[#2A0001]/20 group-hover:shadow-[#852616]/30">
                                <span wire:loading.remove wire:target="lihatDetailBidding({{ $bidding->id }})" class="flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> PRATINJAU CETAK</span>
                                <span wire:loading wire:target="lihatDetailBidding({{ $bidding->id }})" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-3.5 w-3.5 text-[#E89154]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> MENYIAPKAN PDF...
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

        <!-- ================= FASE 3: PDF PREVIEW DOKUMEN RAB ================= -->
        @elseif($view === 'detail_rab')
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <button wire:click="kembaliKeDocumentList" class="px-5 py-2.5 bg-white/60 backdrop-blur-md border border-[#DA7134]/30 hover:bg-white text-[#852616] text-xs font-bold rounded-xl transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg> Tutup Pratinjau
                </button>
                <div class="flex gap-2 w-full md:w-auto shadow-xl shadow-[#2A0001]/10 rounded-2xl overflow-hidden">
                    <button wire:click="bukaModalRevisi({{ $selectedRab->id }}, 'rab')" class="flex-1 md:flex-none px-6 py-3.5 bg-white border-y border-l border-[#DA7134]/40 text-[#852616] hover:bg-[#E89154]/10 font-black text-xs tracking-widest transition-colors">✕ REVISI</button>
                    
                    <!-- TOMBOL SAHKAN DENGAN LOADING STATE -->
                    <button wire:click="setujuiDokumen({{ $selectedRab->id }}, 'rab')" wire:loading.attr="disabled" wire:target="setujuiDokumen" class="flex-1 md:flex-none px-6 py-3.5 bg-[#2A0001] hover:bg-[#852616] text-[#E89154] hover:text-white font-black text-xs tracking-widest transition-all flex items-center justify-center min-w-[200px]">
                        <span wire:loading.remove wire:target="setujuiDokumen">✓ SAHKAN DOKUMEN</span>
                        <span wire:loading wire:target="setujuiDokumen" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-[#E89154]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> 
                            MEMPROSES...
                        </span>
                    </button>
                </div>
            </div>

            <!-- KERTAS A4 SIMULASI PDF RAB -->
            <!-- Catatan: Sengaja dibiarkan putih hitam murni karena ini simulasi cetak kertas -->
            <div class="max-w-[210mm] mx-auto bg-white p-8 md:p-[20mm] shadow-2xl border border-gray-200 min-h-[297mm] text-black">
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
                    <thead class="bg-gray-100">
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
                            <tr class="bg-gray-50 font-bold">
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
                        <tr class="font-black bg-gray-100 text-xs">
                            <td colspan="4" class="border border-black p-2 text-right uppercase">GRAND TOTAL ESTIMASI</td>
                            <td class="border border-black p-2 text-right underline">Rp {{ number_format($selectedRab->grand_total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex justify-between mt-12 text-xs text-center font-bold">
                    <div class="w-48"><p>Dibuat Oleh,</p><p class="mt-16 underline">Divisi Engineering</p><p>PT Tri Jaya Teknik</p></div>
                    <div class="w-48"><p>Menyetujui,</p><p class="mt-16 text-black border border-dashed border-black rounded p-1">Tanda Tangan Elektronik<br>Akan tercetak otomatis</p><p class="mt-1">Direktur Utama</p></div>
                </div>
            </div>

        <!-- ================= FASE 4: PDF PREVIEW DOKUMEN BIDDING ================= -->
        @elseif($view === 'detail_bidding')
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <button wire:click="kembaliKeDocumentList" class="px-5 py-2.5 bg-white/60 backdrop-blur-md border border-[#DA7134]/30 hover:bg-white text-[#852616] text-xs font-bold rounded-xl transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg> Tutup Pratinjau
                </button>
                <div class="flex gap-2 w-full md:w-auto shadow-xl shadow-[#2A0001]/10 rounded-2xl overflow-hidden">
                    <button wire:click="bukaModalRevisi({{ $selectedBidding->id }}, 'bidding')" class="flex-1 md:flex-none px-6 py-3.5 bg-white border-y border-l border-[#DA7134]/40 text-[#852616] hover:bg-[#E89154]/10 font-black text-xs tracking-widest transition-colors">✕ REVISI</button>
                    
                    <!-- TOMBOL SAHKAN DENGAN LOADING STATE -->
                    <button wire:click="setujuiDokumen({{ $selectedBidding->id }}, 'bidding')" wire:loading.attr="disabled" wire:target="setujuiDokumen" class="flex-1 md:flex-none px-6 py-3.5 bg-[#2A0001] hover:bg-[#852616] text-[#E89154] hover:text-white font-black text-xs tracking-widest transition-all flex items-center justify-center min-w-[200px]">
                        <span wire:loading.remove wire:target="setujuiDokumen">✓ SAHKAN SURAT</span>
                        <span wire:loading wire:target="setujuiDokumen" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-[#E89154]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> 
                            MEMPROSES...
                        </span>
                    </button>
                </div>
            </div>

            <div class="max-w-[210mm] mx-auto bg-white p-8 md:p-[20mm] shadow-2xl border border-gray-200 min-h-[297mm] text-black font-serif">
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
                    
                    <div class="my-6 p-4 border border-black bg-gray-50 text-center">
                        <p class="text-sm uppercase tracking-widest font-bold">Total Nilai Penawaran (Include PPN)</p>
                        <p class="text-2xl font-black mt-2">Rp {{ number_format($selectedBidding->total_penawaran, 0, ',', '.') }}</p>
                    </div>

                    <p>Harga tersebut telah mencakup jasa eksekusi, material terlampir, serta overhead pelaksanaan proyek. Rincian lebih lanjut dapat dilihat pada lampiran *Bill of Quantities* (BOQ) yang menyertai surat ini.</p>
                    <p class="mt-4">Demikian surat penawaran ini kami sampaikan. Kami berharap dapat menjalin kerjasama yang baik dengan perusahaan Bapak/Ibu. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
                </div>

                <div class="flex justify-end mt-16 text-sm text-center font-bold">
                    <div class="w-48">
                        <p>Hormat Kami,</p>
                        <p class="mt-16 text-black border border-dashed border-black rounded p-1 text-[10px] font-mono">Tanda Tangan Elektronik<br>Disetujui via Sistem</p>
                        <p class="mt-1 underline uppercase">Direktur Utama</p>
                        <p class="text-xs font-normal">PT Tri Jaya Teknik</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- ================= MODAL REVISI DENGAN LOADING STATE ================= -->
    @if($isRevisiModalOpen)
        <div class="fixed inset-0 bg-[#2A0001]/50 backdrop-blur-md z-50 flex items-center justify-center p-4">
            <div class="bg-white/95 backdrop-blur-xl rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden border border-[#DA7134]/30 animate-fade-in-down">
                <div class="px-6 py-5 border-b border-[#DA7134]/20 bg-gradient-to-r from-[#E89154]/20 to-white flex justify-between items-center">
                    <h3 class="text-xs font-black text-[#852616] uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#DA7134]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Berikan Instruksi Revisi
                    </h3>
                    <button wire:click="tutupModalRevisi" class="text-[#852616]/50 hover:text-[#2A0001] bg-white p-1 rounded-full font-bold text-lg transition-colors">✕</button>
                </div>
                
                <form wire:submit.prevent="kirimRevisi" class="p-6 space-y-5">
                    <p class="text-xs font-bold text-[#852616]/80 leading-relaxed">Berikan arahan spesifik perbaikan dokumen ini. Dokumen akan dikembalikan ke status *Draft* atau *Revision*.</p>
                    <div>
                        <textarea wire:model="komentar_commit" rows="4" placeholder="Ketik alasan penolakan, contoh: Margin penawaran terlalu rendah, naikkan 5%..." class="w-full text-xs font-bold bg-[#E89154]/5 border border-[#DA7134]/30 text-[#2A0001] rounded-2xl p-4 outline-none focus:border-[#852616] focus:ring-4 focus:ring-[#852616]/10 focus:bg-white transition-all resize-none shadow-inner"></textarea>
                        @error('komentar_commit') <span class="text-[#852616] text-[10px] font-bold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-5 border-t border-[#DA7134]/10">
                        <button type="button" wire:click="tutupModalRevisi" class="px-5 py-2.5 text-xs font-bold text-[#852616] hover:text-[#2A0001] hover:bg-[#E89154]/10 rounded-xl transition-colors">BATAL</button>
                        
                        <!-- TOMBOL KIRIM REVISI DENGAN LOADING STATE -->
                        <button type="submit" wire:loading.attr="disabled" wire:target="kirimRevisi" class="px-6 py-2.5 bg-gradient-to-r from-[#852616] to-[#2A0001] hover:from-[#2A0001] hover:to-[#2A0001] text-[#E89154] text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-[#2A0001]/20 transition-all min-w-[200px] flex items-center justify-center">
                            <span wire:loading.remove wire:target="kirimRevisi">TOLAK & KEMBALIKAN</span>
                            <span wire:loading wire:target="kirimRevisi" class="flex items-center gap-2">
                                <svg class="animate-spin h-3 w-3 text-[#E89154]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> 
                                MENGIRIM...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>