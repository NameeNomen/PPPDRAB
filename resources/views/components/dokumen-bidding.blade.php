@php
// Ambil data Company Profile Global
$company = \App\Models\CompanyProfile::first();
$logo = $company && $company->logo ? asset($company->logo) : asset('gambar/tjt.png');
$isoLogo = $company && $company->iso_logo ? asset($company->iso_logo) : asset('gambar/iso.png');
$nama_perusahaan = $company->nama_perusahaan ?? 'PT TRI JAYA TEKNIK KARAWANG';
$alamat = $company->alamat ?? 'JL. Alternatif Krajan II Warung Bambu - Karawang Timur';
$telepon = $company->telepon ?? '(0267) 8615387';
$email = $company->email ?? 'pt.tjtk@yahoo.com';
$direktur = $company->direktur ?? ($bidding->user->name ?? '___________________');
$jabatan_direktur = $company->jabatan_penandatangan ?? 'Direktur';

// Amankan data RAB
$rabDokumen = $proyek->rabs->where('status_rab', 'approved')->first() ?? ($proyek->rab ?? null);

// ✅ KALKULASI HARGA (Untuk Klien)
$harga_penawaran = $bidding->total_penawaran ?? 0;
$ppn = $harga_penawaran * 0.11;
$totalDenganPPN = $harga_penawaran + $ppn;

// Fungsi Terbilang
function terbilang($angka) {
    $angka = abs($angka);
    $baca = array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas');
    $terbilang = '';
    if ($angka < 12) $terbilang = ' ' . $baca[$angka];
    elseif ($angka < 20) $terbilang = terbilang($angka - 10) . ' Belas';
    elseif ($angka < 100) $terbilang = terbilang($angka / 10) . ' Puluh' . terbilang($angka % 10);
    elseif ($angka < 200) $terbilang = ' Seratus' . terbilang($angka - 100);
    elseif ($angka < 1000) $terbilang = terbilang($angka / 100) . ' Ratus' . terbilang($angka % 100);
    elseif ($angka < 2000) $terbilang = ' Seribu' . terbilang($angka - 1000);
    elseif ($angka < 1000000) $terbilang = terbilang($angka / 1000) . ' Ribu' . terbilang($angka % 1000);
    elseif ($angka < 1000000000) $terbilang = terbilang($angka / 1000000) . ' Juta' . terbilang($angka % 1000000);
    elseif ($angka < 1000000000000) $terbilang = terbilang($angka / 1000000000) . ' Miliar' . terbilang(fmod($angka, 1000000000));
    return $terbilang;
}
$terbilang_text = strtoupper(terbilang($totalDenganPPN)) . ' RUPIAH';
@endphp

<style>
#pdf-bidding-container {
    font-family: 'Arial', sans-serif;
    color: #000;
    line-height: 1.5;
    background-color: transparent;
    font-size: 12pt;
}
#pdf-bidding-container * { box-sizing: border-box; }
#pdf-bidding-container p, #pdf-bidding-container h1, #pdf-bidding-container h2, 
#pdf-bidding-container h3, #pdf-bidding-container h4, #pdf-bidding-container table {
    margin: 0; padding: 0;
}

.paper-a4 {
    background-color: white;
    width: 210mm;
    min-height: 297mm;
    padding: 20mm 25mm;
    margin: 0 auto;
    position: relative;
}

.kop-surat {
    display: flex;
    align-items: center;
    border-bottom: 2px solid #2E7D32;
    padding-bottom: 12px;
    margin-bottom: 25px;
}
.kop-surat img.logo { height: 65px; object-fit: contain; margin-right: 20px; }
.kop-surat img.iso { height: 55px; object-fit: contain; margin-left: auto; }
.kop-text { flex-grow: 1; text-align: center; }
.kop-text h1 { 
    color: #2E7D32; 
    font-size: 14pt; 
    font-weight: 600; 
    text-transform: uppercase; 
    letter-spacing: 0.5px; 
    margin-bottom: 3px; 
}
.kop-text p { font-size: 9pt; margin: 2px 0; color: #333; }

.doc-title { text-align: center; margin-bottom: 25px; }
.doc-title h2 { 
    font-size: 14pt; 
    font-weight: 700; 
    text-transform: uppercase; 
    text-decoration: underline; 
    margin-bottom: 5px;
    color: #1B5E20;
}
.doc-meta { 
    display: flex; 
    justify-content: space-between; 
    font-size: 11pt; 
    margin-bottom: 20px; 
}

.recipient { margin-bottom: 25px; font-size: 12pt; line-height: 1.6; }
.recipient strong { display: block; }

.section-header {
    font-size: 12pt;
    font-weight: 700;
    text-transform: uppercase;
    margin: 25px 0 10px 0;
    padding-bottom: 5px;
    border-bottom: 2px solid #2E7D32;
    color: #2E7D32;
}

table.formal-table {
    width: 100%;
    border-collapse: collapse;
    margin: 10px 0;
    font-size: 11pt;
}
table.formal-table td {
    border: 1px solid #333;
    padding: 8px 10px;
    vertical-align: top;
}
table.formal-table td.label {
    width: 30%;
    background-color: #f4f4f4;
    font-weight: 600;
}

table.rekap-table {
    width: 100%;
    border-collapse: collapse;
    margin: 15px 0;
    font-size: 11pt;
}
table.rekap-table th {
    background-color: #2E7D32;
    color: white;
    padding: 10px;
    text-align: left;
    font-weight: 600;
    border: 1px solid #000;
}
table.rekap-table td {
    border: 1px solid #333;
    padding: 8px 10px;
}
table.rekap-table .text-right { text-align: right; }
table.rekap-table .text-center { text-align: center; }
table.rekap-table tfoot td { font-weight: 600; }
table.rekap-table tr.total-row { 
    background-color: #2E7D32; 
    color: white; 
    font-size: 12pt; 
}
table.rekap-table tr.total-row td { border-color: #2E7D32; }

.terbilang-box {
    background-color: #f9f9f9;
    border-left: 3px solid #2E7D32;
    padding: 10px 15px;
    margin: 15px 0;
    font-style: italic;
    font-size: 11pt;
}

ol.syarat-list { padding-left: 20px; margin: 10px 0; line-height: 1.8; font-size: 11pt; }
ol.syarat-list li { margin-bottom: 5px; }

.signature-area {
    margin-top: 40px;
    display: flex;
    justify-content: flex-end;
}
.signature-box {
    width: 250px;
    text-align: center;
}
.signature-space { height: 75px; }
.signature-name {
    font-weight: 600;
    text-transform: uppercase;
    border-bottom: 1px solid #000;
    padding-bottom: 3px;
    margin-bottom: 3px;
    font-size: 11pt;
}
.signature-jabatan { font-size: 10pt; }

p { font-size: 12pt; margin-bottom: 10px; }

@media print {
    body * { visibility: hidden; }
    #pdf-bidding-container, #pdf-bidding-container * { visibility: visible; }
    #pdf-bidding-container { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 0; }
    .paper-a4 { margin: 0; box-shadow: none; page-break-after: always; }
}
</style>

<div id="pdf-bidding-container">
    <div class="paper-a4">
        <!-- KOP SURAT -->
        <div class="kop-surat">
            <img src="{{ $logo }}" class="logo" alt="Logo">
            <div class="kop-text">
                <h1>{{ $nama_perusahaan }}</h1>
                <p style="font-weight: 600;">INDUSTRIAL ENGINEERING, PROCUREMENT & CONSTRUCTION</p>
                <p>{{ $alamat }}</p>
                <p>Telp: {{ $telepon }} | Email: {{ $email }}</p>
            </div>
            <img src="{{ $isoLogo }}" class="iso" alt="ISO">
        </div>

        <!-- JUDUL & META -->
        <div class="doc-title">
            <h2>SURAT PENAWARAN HARGA</h2>
        </div>
        <div class="doc-meta">
            <div>
                <p><strong>No. Penawaran:</strong> {{ $bidding->no_penawaran }}</p>
                <p><strong>Lampiran:</strong> 1 (Satu) Berkas BOQ/RAB</p>
            </div>
            <div style="text-align: right;">
                <p>Karawang, {{ \Carbon\Carbon::parse($bidding->tgl_penawaran)->isoFormat('D MMMM Y') }}</p>
            </div>
        </div>

        <!-- TUJUAN -->
        <div class="recipient">
            <p>Kepada Yth.</p>
            {{-- ✅ AMBIL DARI SNAPSHOT (KOLOM YANG ADA DI MIGRATION) --}}
            <strong>{{ $bidding->nama_pelanggan_snapshot }}</strong>
            @if($bidding->pic_pelanggan_snapshot)
                <strong>u.p. {{ $bidding->pic_pelanggan_snapshot }}</strong>
            @endif
            <p>{{ $proyek->alamat ?? 'Di Tempat' }}</p>
        </div>

        <!-- PERIHAL -->
        <p style="margin-bottom: 20px;"><strong>Perihal: {{ $bidding->perihal }}</strong></p>

        <!-- PEMBUKAAN -->
        <p style="margin-bottom: 15px;">Dengan hormat,</p>
        <div style="text-align: justify; margin-bottom: 20px; white-space: pre-line;">
            {{ $bidding->surat_pengantar }}
        </div>

        <!-- I. INFORMASI PEKERJAAN -->
        <div class="section-header">I. INFORMASI PEKERJAAN</div>
        <table class="formal-table">
            <tr>
                <td class="label">Nama Pekerjaan</td>
                <td>{{ $proyek->nama_projek }}</td>
            </tr>
            <tr>
                <td class="label">Lokasi Pekerjaan</td>
                <td>{{ $proyek->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Deskripsi Pekerjaan</td>
                <td>{{ $proyek->deskripsi_proyek ?? '-' }}</td>
            </tr>
        </table>
        <p style="font-size: 11pt; margin-top: 5px;">Ruang lingkup pekerjaan meliputi pelaksanaan pekerjaan sesuai dengan kebutuhan dan spesifikasi yang telah disepakati bersama.</p>

        <!-- II. REKAPITULASI PENAWARAN -->
        <div class="section-header">II. REKAPITULASI PENAWARAN</div>
        <table class="rekap-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 65%;">Uraian Pekerjaan</th>
                    <th style="width: 30%;" class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @if($rabDokumen && $rabDokumen->items && count($rabDokumen->items) > 0)
                    @php
                        $kategoris = $rabDokumen->items->where('tipe', 'kategori')->whereNull('parent_id');
                        $alphabet = range('A', 'Z');
                        $index = 0;
                    @endphp
                    @foreach($kategoris as $kat)
                        @php
                            $anakKategori = $rabDokumen->items->where('parent_id', $kat->id);
                            $totalDariAnak = $anakKategori->sum('subtotal');
                            $subtotalFinal = $kat->subtotal > 0 ? $kat->subtotal : $totalDariAnak;
                        @endphp
                        <tr>
                            <td class="text-center" style="font-weight: 600;">{{ $alphabet[$index] ?? ($index+1) }}</td>
                            <td style="font-weight: 600;">{{ $kat->deskripsi_pekerjaan }}</td>
                            <td class="text-right" style="font-weight: 600;">{{ number_format($subtotalFinal, 0, ',', '.') }}</td>
                        </tr>
                        @php $index++; @endphp
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center" style="font-style: italic; padding: 15px;">Rincian detail terlampir dalam dokumen BOQ/RAB.</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-right">Harga Penawaran (Sebelum PPN)</td>
                    <td class="text-right">{{ number_format($harga_penawaran, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">PPN 11%</td>
                    <td class="text-right">{{ number_format($ppn, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="2" class="text-right">TOTAL PENAWARAN</td>
                    <td class="text-right">Rp {{ number_format($totalDenganPPN, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="terbilang-box">
            <strong>Terbilang:</strong> {{ $terbilang_text }}
        </div>

        <!-- III. SYARAT DAN KETENTUAN -->
        <div class="section-header">III. SYARAT DAN KETENTUAN</div>
        <ol class="syarat-list">
            <li>Masa berlaku penawaran: <strong>{{ $bidding->masa_berlaku }} hari kalender</strong> sejak tanggal diterbitkan.</li>
            <li>Waktu pengerjaan: <strong>{{ $bidding->waktu_pengerjaan ?? '-' }} hari kalender</strong> setelah diterimanya Purchase Order (PO).</li>
            <li>Term of Payment:
                <div style="white-space: pre-line; margin-top: 5px; padding-left: 10px; border-left: 2px solid #2E7D32;">{{ $bidding->term_of_payment }}</div>
            </li>
            @if($bidding->garansi)
            <li>Garansi pekerjaan: <strong>{{ $bidding->garansi }}</strong>.</li>
            @endif
            <li>Perubahan ruang lingkup pekerjaan di luar penawaran ini akan dibahas dan disepakati lebih lanjut.</li>
            <li>Detail teknis dan material mengikuti RFQ pelanggan, hasil engineering, dan persetujuan kedua belah pihak.</li>
        </ol>

        @if(!empty($bidding->catatan))
        <div style="margin-top: 15px; padding: 10px; background-color: #fffbe6; border: 1px solid #ffd700; font-size: 11pt;">
            <strong>Catatan Tambahan:</strong>
            <p style="margin-top: 5px;">{{ $bidding->catatan }}</p>
        </div>
        @endif

        <!-- PENUTUP -->
        <div style="margin-top: 25px; text-align: justify;">
            <p>Demikian penawaran ini kami sampaikan. Atas perhatian dan kesempatan yang diberikan, kami ucapkan terima kasih.</p>
        </div>

        <!-- TANDA TANGAN -->
        <div class="signature-area">
            <div class="signature-box">
                <p>Hormat kami,</p>
                <p style="font-weight: 600; margin-bottom: 5px;">{{ $nama_perusahaan }}</p>
                <div class="signature-space">
                    @if($company && $company->stempel)
                        <img src="{{ asset('storage/' . $company->stempel) }}" style="max-height: 65px; max-width: 65px; opacity: 0.7; position: absolute; margin-left: 80px; margin-top: 5px;" alt="Stempel">
                    @endif
                </div>
                <div class="signature-name">{{ $direktur }}</div>
                <div class="signature-jabatan">{{ $jabatan_direktur }}</div>
            </div>
        </div>
    </div>
</div>