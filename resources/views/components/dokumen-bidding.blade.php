@php
// Ambil data Company Profile Global sesuai arsitektur Enterprise
$company = \App\Models\CompanyProfile::first();
$logo = $company && $company->logo 
    ? asset($company->logo) 
    : asset('gambar/tjt.png');

// Path untuk Logo ISO (Fallback ke gambar/iso.png jika belum ada di DB)
$isoLogo = $company && $company->iso_logo 
    ? asset($company->iso_logo) 
    : asset('gambar/iso.png');

$nama_perusahaan = $company->nama_perusahaan ?? 'PT TRI JAYA TEKNIK KARAWANG';
$alamat = $company->alamat ?? 'JL. Alternatif Krajan II Warung Bambu - Karawang Timur';
$telepon = $company->telepon ?? '(0267) 8615387';
$email = $company->email ?? 'pt.tjtk@yahoo.com';

// Amankan data RAB
$rabDokumen = $proyek->rabs->where('status_rab', 'approved')->first() ?? ($proyek->rab ?? null);
@endphp

<style>
/* CSS Scoped khusus PDF, Kebal dari Tailwind Reset */
#pdf-bidding-container {
    font-family: 'Arial', sans-serif;
    color: #000;
    line-height: 1.5;
    background-color: transparent;
}

#pdf-bidding-container p,
#pdf-bidding-container h1,
#pdf-bidding-container h2,
#pdf-bidding-container h3,
#pdf-bidding-container h4 {
    margin: 0; padding: 0;
}

/* Setingan Kertas A4 */
#pdf-bidding-container .paper-a4 {
    background-color: white;
    width: 210mm;
    min-height: 297mm;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    margin: 0 auto 30px auto;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    box-sizing: border-box;
}

/* COVER PAGE STYLES */
.cover-accent-top { position: absolute; top: 0; left: 0; right: 0; height: 15mm; background: #1B5E20; border-bottom: 5px solid #4CAF50; }
.cover-accent-bottom { position: absolute; bottom: 0; left: 0; right: 0; height: 25mm; background: #1B5E20; border-top: 5px solid #4CAF50; }
.cover-logo-area { padding: 25mm 20mm 0 20mm; display: flex; justify-content: space-between; align-items: flex-start; }
.cover-center { position: absolute; top: 45%; transform: translateY(-50%); width: 100%; padding: 0 25mm; text-align: center; }
.cover-footer { position: absolute; bottom: 35mm; left: 20mm; right: 20mm; display: flex; justify-content: space-between; align-items: flex-end; }

/* CONTENT PAGE STYLES */
#pdf-bidding-container .bidding-content {
    padding: 15mm 20mm 20mm 20mm;
    font-size: 12px;
    text-align: justify;
}

.kop-surat {
    display: flex;
    align-items: center;
    border-bottom: 3px solid #1B5E20;
    padding-bottom: 12px;
    margin-bottom: 20px;
}

/* TABLE STYLES */
#pdf-bidding-container table.bidding-table {
    width: 100%;
    border-collapse: collapse;
    margin: 15px 0;
    font-size: 11px;
}
#pdf-bidding-container table.bidding-table th,
#pdf-bidding-container table.bidding-table td {
    border: 1px solid #333;
    padding: 8px 10px;
    vertical-align: middle;
}
#pdf-bidding-container table.bidding-table th {
    background-color: #E8F5E9;
    text-transform: uppercase;
    font-weight: 900;
    text-align: center;
    color: #1B5E20;
}

/* PRINT RULES */
@media print {
    body * { visibility: hidden; }
    #pdf-bidding-container, #pdf-bidding-container * { visibility: visible; }
    #pdf-bidding-container { position: absolute; left: 0; top: 0; padding: 0; margin: 0; width: 100%; }
    #pdf-bidding-container .paper-a4 {
        margin: 0 !important;
        box-shadow: none !important;
        border: none !important;
        page-break-after: always;
        min-height: 297mm;
    }
}
</style>

<div id="pdf-bidding-container">

    <div class="paper-a4">
        <div class="cover-accent-top"></div>

        <div class="cover-logo-area">
            <img src="{{ $logo }}" alt="Logo" style="height: 60px; object-fit: contain;">
            <div style="text-align: right;">
                <p style="font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; color: #1B5E20;">Dokumen Penawaran Resmi</p>
                <p style="font-size: 12px; font-weight: bold; font-family: monospace; color: #666; margin-top: 4px;">{{ $bidding->no_penawaran ?? 'DOC-PEN-000' }}</p>
            </div>
        </div>

        <div class="cover-center">
            <h1 style="font-size: 28px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; color: #1B5E20; margin-bottom: 15px;">Proposal Penawaran</h1>
            <div style="height: 4px; width: 80px; background-color: #4CAF50; margin: 0 auto 25px auto;"></div>

            <h2 style="font-size: 22px; font-weight: 900; text-transform: uppercase; color: #000; line-height: 1.4; margin-bottom: 50px;">
                {{ $proyek->nama_projek ?? 'NAMA PROYEK' }}
            </h2>

            <div style="background-color: #F4F9F6; border: 1px solid #E8F5E9; padding: 20px; border-radius: 10px; display: inline-block; min-width: 300px;">
                <p style="font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 8px;">Dipersiapkan Untuk:</p>
                <h3 style="font-size: 18px; font-weight: 900; text-transform: uppercase; color: #1B5E20;">
                    {{ $bidding->kepada ?? ($proyek->nama_pelanggan ?? 'NAMA KLIEN') }}
                </h3>
            </div>
        </div>

        <div class="cover-footer">
            <div>
                <p style="font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 4px;">Disusun Oleh:</p>
                <p style="font-size: 13px; font-weight: 900; text-transform: uppercase; color: #000;">Divisi Commercial</p>
                <p style="font-size: 13px; font-weight: 900; color: #1B5E20;">{{ $nama_perusahaan }}</p>
            </div>
            <div style="text-align: right;">
                <p style="font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 4px;">Tanggal Terbit:</p>
                <p style="font-size: 13px; font-weight: 900; color: #000;">
                    {{ $bidding->tgl_penawaran ? \Carbon\Carbon::parse($bidding->tgl_penawaran)->isoFormat('D MMMM Y') : date('d M Y') }}
                </p>
            </div>
        </div>

        <div class="cover-accent-bottom"></div>
    </div>

    <div class="paper-a4 bidding-content">

        <div class="kop-surat">
            <img src="{{ $logo }}" style="height: 65px; object-fit: contain; margin-right: 20px;" alt="Logo">
            <div style="flex-grow: 1; text-align: center;">
                <h2 style="color: #1B5E20; font-size: 20px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">{{ $nama_perusahaan }}</h2>
                <p style="font-size: 10px; font-weight: 900; color: #333; margin-bottom: 4px;">INDUSTRIAL ENGINEERING, PROCUREMENT & CONSTRUCTION</p>
                <p style="font-size: 9px; color: #555;">{{ $alamat }}</p>
                <p style="font-size: 9px; color: #555;">Telp: {{ $telepon }} | Email: {{ $email }}</p>
            </div>
            <img src="{{ $isoLogo }}" style="height: 65px; object-fit: contain;" alt="ISO Certification">
        </div>

        <div style="margin-bottom: 25px;">
            <p style="margin-bottom: 15px;">Karawang, {{ $bidding->tgl_penawaran ? \Carbon\Carbon::parse($bidding->tgl_penawaran)->isoFormat('D MMMM Y') : date('d M Y') }}</p>

            <p style="line-height: 1.6;">
                <strong>Kepada Yth.,<br>
                @if($bidding->up)
                    {{ $bidding->up }} <br>
                @else
                    Pimpinan / Manajemen <br>
                @endif
                {{ $bidding->kepada ?? $proyek->nama_pelanggan }}</strong><br>
                
                {{ $proyek->alamat ?? '-' }}
            </p>

            <p style="margin-top: 20px; margin-bottom: 10px;">
                <strong>Perihal: Penawaran Harga Pekerjaan {{ $proyek->nama_projek ?? '-' }}</strong>
            </p>

            <p>Dengan hormat,</p>
            <div style="text-indent: 30px; margin-top: 10px; line-height: 1.8; white-space: pre-line;">
                {{ $bidding->surat_pengantar ?? 'Sehubungan dengan rencana pekerjaan '.$proyek->nama_projek.', bersama surat ini kami mengajukan proposal penawaran harga untuk pelaksanaan pekerjaan tersebut.' }}
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <h4 style="font-weight: 900; color: #1B5E20; text-transform: uppercase; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px;">1. Ruang Lingkup Pekerjaan & Jadwal</h4>
            <p style="margin-bottom: 10px;">Pekerjaan yang ditawarkan meliputi persiapan, pengadaan material, fabrikasi, hingga penyelesaian dengan rincian:</p>
            <table class="bidding-table">
                <tr>
                    <td style="width: 30%; font-weight: bold; background-color: #f9f9f9;">Nama Pekerjaan</td>
                    <td style="font-weight: bold; text-transform: uppercase;">{{ $proyek->nama_projek ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background-color: #f9f9f9; vertical-align: top;">Deskripsi Pekerjaan</td>
                    <td style="white-space: pre-line;">{{ $proyek->deskripsi_proyek ?? 'Sesuai dengan gambar kerja dan spesifikasi teknis.' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background-color: #f9f9f9;">Estimasi Waktu</td>
                    <td style="font-weight: bold;">{{ $bidding->waktu_pengerjaan ?? '-' }} Hari Kalender</td>
                </tr>
            </table>
        </div>

        <div style="margin-bottom: 20px;">
            <h4 style="font-weight: 900; color: #1B5E20; text-transform: uppercase; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px;">2. Rekapitulasi Harga Penawaran</h4>
            <table class="bidding-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">NO</th>
                        <th style="width: 60%;">URAIAN PEKERJAAN</th>
                        <th style="width: 30%;">SUBTOTAL (RP)</th>
                    </tr>
                </thead>
                <tbody>
                    @if($rabDokumen && $rabDokumen->items && count($rabDokumen->items) > 0)
                        @php
                            // Ambil item yang tipe-nya kategori dan tidak memiliki parent
                            $kategoris = $rabDokumen->items->where('tipe', 'kategori')->whereNull('parent_id');
                            $alphabet = range('A', 'Z');
                            $index = 0;
                        @endphp

                        @foreach($kategoris as $kat)
                            @php
                                // Jumlahkan subtotal dari anak-anak kategori ini
                                $anakKategori = $rabDokumen->items->where('parent_id', $kat->id);
                                $totalDariAnak = $anakKategori->sum('subtotal');

                                // Gunakan subtotal kategori (jika ada), atau gunakan total dari anaknya
                                $subtotalFinal = $kat->subtotal > 0 ? $kat->subtotal : $totalDariAnak;
                            @endphp
                            <tr>
                                <td style="text-align: center; font-weight: bold;">{{ $alphabet[$index] ?? ($index+1) }}</td>
                                <td style="font-weight: bold;">{{ $kat->deskripsi_pekerjaan }}</td>
                                <td style="text-align: right; font-weight: bold;">{{ number_format($subtotalFinal, 0, ',', '.') }}</td>
                            </tr>
                            @php $index++; @endphp
                        @endforeach
                    @else
                        <tr><td colspan="3" style="text-align: center; font-style: italic; padding: 15px;">Rincian terlampir pada dokumen RAB/BOQ terpisah.</td></tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align: right; font-weight: 900;">GRAND TOTAL PENAWARAN</td>
                        <td style="text-align: right; font-weight: 900; font-size: 13px; background-color: #E8F5E9; color: #1B5E20;">
                            Rp {{ number_format($bidding->total_penawaran ?? $rabDokumen->grand_total ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
            <p style="font-size: 10px; font-style: italic; color: #666; margin-top: 5px;">*Harga di atas belum termasuk Pajak Pertambahan Nilai (PPN) yang berlaku.</p>
        </div>

        <div style="margin-bottom: 30px;">
            <h4 style="font-weight: 900; color: #1B5E20; text-transform: uppercase; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px;">3. Syarat & Ketentuan (Term & Condition)</h4>
            <ul style="padding-left: 20px; margin-top: 5px; line-height: 1.6;">
                <li><strong>Masa Berlaku Penawaran:</strong> {{ $bidding->masa_berlaku ?? '14' }} Hari kalender sejak tanggal diterbitkan.</li>
                <li><strong>Masa Garansi:</strong> {{ $bidding->garansi ?? 'Sesuai kesepakatan' }}.</li>
                <li><strong>Sistem Pembayaran (Term of Payment):</strong></li>
            </ul>
            <div style="white-space: pre-line; border-left: 3px solid #1B5E20; padding: 8px 15px; background-color: #F4F9F6; font-weight: bold; margin-left: 20px; margin-top: 5px;">
                {{ $bidding->term_of_payment ?? "DP 30% Setelah PO terbit.\nPelunasan 70% Setelah Berita Acara Serah Terima (BAST)." }}
            </div>

            @if(!empty($bidding->catatan))
            <p style="margin-top: 10px;"><strong>Catatan Tambahan:</strong><br>
                {{ $bidding->catatan }}
            </p>
            @endif
        </div>

        <div>
            <p style="margin-bottom: 30px;">Demikian proposal penawaran ini kami sampaikan. Atas perhatian dan kesempatan yang diberikan, kami ucapkan terima kasih.</p>

            <div style="margin-top: 40px; display: flex; justify-content: flex-end; width: 100%;">
                <div style="width: 250px; text-align: center; font-size: 11px; line-height: 1.5;">
                    <p style="margin: 0; font-weight: bold; text-transform: uppercase;">Hormat Kami,</p>
                    <p style="margin: 2px 0 0 0; font-weight: 900; color: #1B5E20; text-transform: uppercase; font-size: 12px;">{{ $nama_perusahaan }}</p>

                    <div style="height: 90px; display: flex; align-items: center; justify-content: center; position: relative; margin: 10px 0;">
                        @if($company && $company->stempel)
                            <img src="{{ asset('storage/' . $company->stempel) }}" style="max-height: 80px; max-width: 80px; opacity: 0.9; position: absolute;" alt="Stempel">
                        @endif
                    </div>

                    <div style="border-bottom: 1px solid #000; margin: 0 auto 4px auto; width: 90%;">
                        <p style="margin: 0; font-weight: 900; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">
                            {{ $company->direktur ?? ($bidding->user->name ?? 'Tim Commercial') }}
                        </p>
                    </div>
                    <p style="margin: 0; font-size: 10px; font-weight: bold; text-transform: uppercase; color: #555; letter-spacing: 0.5px;">
                        {{ $company->jabatan_penandatangan ?? 'Direktur' }}
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>