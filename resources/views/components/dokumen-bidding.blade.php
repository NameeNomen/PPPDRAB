<style>
    .paper-a4 { background-color: white; width: 210mm; min-height: 297mm; display: flex; flex-direction: column; position: relative; overflow: hidden; margin: 0 auto 20px auto; box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-family: 'Arial', sans-serif; color: #000; }
    .page-break { page-break-before: always; }
    .bidding-content { padding: 40px 50px; font-size: 13px; line-height: 1.6; text-align: justify; }
    
    /* Cover Styling */
    .cover-border-top { position: absolute; top: 0; left: 0; right: 0; height: 15mm; background: #2E7D32; }
    .cover-border-bottom { position: absolute; bottom: 0; left: 0; right: 0; height: 8mm; background: #1B5E20; }
    .cover-box { position: absolute; top: 50%; transform: translateY(-50%); width: 100%; padding: 0 50px; }
    
    /* Table Styling */
    .bidding-table { width: 100%; border-collapse: collapse; margin: 15px 0; font-size: 11px; }
    .bidding-table th, .bidding-table td { border: 1px solid #333; padding: 8px; }
    .bidding-table th { background-color: #E8F5E9; text-transform: uppercase; font-weight: bold; text-align: center; color: #1B5E20; }
    .td-kategori { background-color: #F4F9F6; font-weight: bold; }
    
    @media print {
        body * { visibility: hidden; }
        #pdf-bidding-container, #pdf-bidding-container * { visibility: visible; }
        #pdf-bidding-container { position: absolute; left: 0; top: 0; padding: 0; background: transparent; overflow: visible; display: block; width: 100%; }
        .paper-a4 { margin: 0 !important; box-shadow: none !important; border: none !important; page-break-after: always; }
    }
</style>

<div id="pdf-bidding-container" class="flex flex-col w-full items-center">

    <div class="paper-a4">
        <div class="cover-border-top"></div>
        <div class="cover-border-bottom"></div>
        
        <div class="pt-16 px-12 flex justify-between items-center relative z-10">
            <img src="{{ asset('gambar/tjt.png') }}" alt="Logo TJT" class="w-32 object-contain" onerror="this.style.display='none'">
            <div class="text-right">
                <p class="text-[10px] font-bold uppercase tracking-widest text-[#2E7D32]">Penawaran Resmi</p>
                <p class="text-[10px] text-gray-500 font-mono">{{ $bidding->no_penawaran ?? 'DOC-PEN-000' }}</p>
            </div>
        </div>

        <div class="cover-box text-center">
            <p class="text-[#2E7D32] font-black tracking-widest mb-4 uppercase text-lg">Dokumen Proposal Penawaran</p>
            <h1 class="text-4xl font-black text-black mb-6 uppercase leading-tight">{{ $proyek->nama_projek ?? 'NAMA PROYEK' }}</h1>
            <div class="w-24 h-1.5 bg-[#2E7D32] mx-auto mb-6"></div>
            
            <p class="text-sm font-bold text-gray-600 uppercase tracking-widest mb-1">Dipersiapkan Untuk:</p>
            <h2 class="text-2xl font-extrabold text-black uppercase">{{ $bidding->nama_perusahaan ?? $proyek->nama_pelanggan }}</h2>
        </div>

        <div class="absolute bottom-16 left-12 right-12 flex justify-between items-end border-t-2 border-[#2E7D32] pt-4">
            <div>
                <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">Disusun Oleh</p>
                <p class="font-bold text-black text-sm uppercase">Divisi Marketing</p>
                <p class="font-bold text-black text-sm uppercase">PT Tri Jaya Teknik Karawang</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">Tanggal</p>
                <p class="font-bold text-black text-sm">{{ $bidding->tgl_penawaran ? \Carbon\Carbon::parse($bidding->tgl_penawaran)->isoFormat('D MMMM Y') : date('d M Y') }}</p>
            </div>
        </div>
    </div>

    <div class="paper-a4 bidding-content">
        <div class="border-b-2 border-[#2E7D32] pb-3 mb-8 flex items-center justify-between">
            <img src="{{ asset('gambar/tjt.png') }}" class="w-24 object-contain" alt="Logo">
            <div class="text-right">
                <h3 class="m-0 text-[#2E7D32] text-sm font-black tracking-wider">PT TRI JAYA TEKNIK</h3>
                <p class="m-0 text-[9px] font-bold uppercase">Industrial Engineering & Construction</p>
            </div>
        </div>

        <div class="mb-8">
            <p>Karawang, {{ $bidding->tgl_penawaran ? \Carbon\Carbon::parse($bidding->tgl_penawaran)->isoFormat('D MMMM Y') : date('d M Y') }}</p>
            <p class="mt-4"><strong>Kepada Yth.,<br>Pimpinan / Manajemen {{ $bidding->nama_perusahaan ?? $proyek->nama_pelanggan }}</strong><br>
               {{ $bidding->alamat_perusahaan ?? '-' }}</p>
            
            <p class="mt-6 mb-2"><strong>Perihal: Penawaran Harga Pekerjaan {{ $proyek->nama_projek ?? '-' }}</strong></p>
            <p>Dengan hormat,</p>
            <div class="whitespace-pre-line text-justify mt-2" style="text-indent: 30px;">
                {{ $bidding->surat_pengantar ?? 'Sehubungan dengan rencana pekerjaan '.$proyek->nama_projek.', bersama surat ini kami PT Tri Jaya Teknik Karawang mengajukan proposal penawaran harga untuk pelaksanaan pekerjaan tersebut.' }}
            </div>
        </div>

        <div class="mb-8">
            <h4 class="font-bold text-[#1B5E20] uppercase border-b border-gray-300 pb-1 mb-2">1. Ruang Lingkup Pekerjaan</h4>
            <p>Pekerjaan yang ditawarkan meliputi persiapan, pengadaan material, fabrikasi, hingga penyelesaian yang dirincikan sebagai berikut:</p>
            <table class="bidding-table mt-2">
                <tr>
                    <td class="w-[30%] font-bold bg-gray-100">Nama Pekerjaan</td>
                    <td class="font-bold uppercase">{{ $proyek->nama_projek ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-bold bg-gray-100 align-top">Deskripsi Pekerjaan</td>
                    <td class="whitespace-pre-line">{{ $proyek->deskripsi_proyek ?? 'Sesuai dengan gambar kerja dan BQ.' }}</td>
                </tr>
            </table>
        </div>

        <div class="mb-8">
            <h4 class="font-bold text-[#1B5E20] uppercase border-b border-gray-300 pb-1 mb-2">2. Jadwal Pelaksanaan</h4>
            <p>Estimasi waktu pelaksanaan pekerjaan disesuaikan dengan tingkat kesulitan dan ketersediaan material:</p>
            <table class="bidding-table mt-2">
                <tr>
                    <td class="w-[30%] font-bold bg-gray-100">Target Waktu</td>
                    <td class="font-bold">{{ $proyek->target_waktu ? \Carbon\Carbon::parse($proyek->target_waktu)->isoFormat('D MMMM Y') : '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="paper-a4 bidding-content">
        <div class="mb-8">
            <h4 class="font-bold text-[#1B5E20] uppercase border-b border-gray-300 pb-1 mb-2">3. Rekapitulasi Rencana Anggaran Biaya (RAB)</h4>
            <p>Total penawaran harga untuk pekerjaan ini diuraikan berdasarkan sub-pekerjaan berikut:</p>
            
            <table class="bidding-table mt-3">
                <thead>
                    <tr>
                        <th class="w-[10%]">NO</th>
                        <th class="w-[60%]">URAIAN PEKERJAAN</th>
                        <th class="w-[30%]">SUBTOTAL (RP)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rabAktif = $proyek->rab; @endphp
                    
                    @if($rabAktif && $rabAktif->items)
                        @php 
                            $kategoris = $rabAktif->items->where('tipe', 'kategori')->whereNull('parent_id');
                            $alphabet = range('A', 'Z'); 
                            $index = 0;
                        @endphp
                        
                        @foreach($kategoris as $kat)
                            <tr>
                                <td class="text-center font-bold">{{ $alphabet[$index] ?? ($index+1) }}</td>
                                <td class="font-bold">{{ $kat->deskripsi_pekerjaan }}</td>
                                <td class="text-right font-bold">{{ number_format($kat->subtotal ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            @php $index++; @endphp
                        @endforeach
                    @else
                        <tr><td colspan="3" class="text-center italic">Rincian terlampir pada dokumen BQ terpisah.</td></tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right font-bold">GRAND TOTAL PENAWARAN</td>
                        <td class="text-right font-black text-base bg-[#E8F5E9] text-[#1B5E20]">Rp {{ number_format($bidding->total_penawaran ?? 0, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mb-10">
            <h4 class="font-bold text-[#1B5E20] uppercase border-b border-gray-300 pb-1 mb-2">4. Syarat & Ketentuan (Term & Condition)</h4>
            <ul style="padding-left: 20px; margin-top: 5px;">
                <li class="mb-1"><strong>Masa Berlaku Penawaran:</strong> {{ $bidding->masa_berlaku ?? '14 (Empat Belas) Hari' }} sejak tanggal penawaran diterbitkan.</li>
                <li class="mb-1"><strong>Sistem Pembayaran (Term of Payment):</strong></li>
            </ul>
            <div class="whitespace-pre-line border border-gray-300 p-3 bg-gray-50 text-xs ml-5">
                {{ $bidding->term_of_payment ?? "DP 30% Setelah PO terbit.\nPelunasan 70% Setelah Berita Acara Serah Terima (BAST) ditandatangani." }}
            </div>
            <ul style="padding-left: 20px; margin-top: 10px;">
                <li class="mb-1">Harga yang tertera belum termasuk pajak yang berlaku (PPN) kecuali dinyatakan lain.</li>
                <li class="mb-1">Pekerjaan tambahan (CWO) di luar lingkup penawaran ini akan diperhitungkan kemudian.</li>
            </ul>
        </div>

        <div>
            <p>Demikian surat penawaran harga ini kami ajukan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
            
            <div class="w-full flex justify-end mt-12">
                <div class="w-[250px] text-center">
                    <p class="mb-20 font-bold uppercase">Hormat Kami,<br>PT TRI JAYA TEKNIK</p>
                    <div class="border-b border-black font-black uppercase tracking-wider text-sm">{{ $bidding->user->name ?? 'M A R K E T I N G' }}</div>
                    <p class="mt-1 text-[10px] font-bold uppercase text-gray-600">Marketing & Estimator</p>
                </div>
            </div>
        </div>
    </div>
</div>