<style>
    /* Scope khusus untuk surat penawaran biar gak bentrok sama CSS global aplikasi lo */
    .surat-penawaran-container {
        font-family: 'Helvetica', 'Arial', sans-serif;
        font-size: 11pt;
        line-height: 1.6;
        color: #2c3e50;
        background: #fff; /* Pastikan background putih kalau dirender di web */
        padding: 20px; /* Jarak aman kalau di web, abaikan kalau print PDF */
    }

    /* Kop Surat */
    .surat-penawaran-container .kop-surat {
        border-bottom: 2px solid #1e3a8a;
        padding-bottom: 15px;
        margin-bottom: 30px;
        text-align: center;
    }
    .surat-penawaran-container .kop-surat h1 {
        margin: 0 0 5px 0;
        font-size: 22pt;
        color: #1e3a8a;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .surat-penawaran-container .kop-surat p {
        margin: 3px 0;
        font-size: 9.5pt;
        color: #555;
    }

    /* Info Surat */
    .surat-penawaran-container .info-surat {
        margin-bottom: 30px;
    }
    .surat-penawaran-container .info-surat table {
        width: 100%;
        border-collapse: collapse;
    }
    .surat-penawaran-container .info-surat td {
        vertical-align: top;
        padding: 2px 0;
        border: none; /* Reset border sapa tau kena dari global CSS */
    }

    /* Konten Surat */
    .surat-penawaran-container .penerima {
        margin-bottom: 25px;
        background-color: #f8f9fa;
        padding: 15px;
        border-left: 4px solid #1e3a8a;
        border-radius: 4px;
    }
    .surat-penawaran-container .penerima p {
        margin: 0;
        line-height: 1.5;
    }

    .surat-penawaran-container .isi-surat {
        text-align: justify;
        margin-bottom: 25px;
    }

    /* Tabel Harga */
    .surat-penawaran-container .tabel-harga {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }
    .surat-penawaran-container .tabel-harga th, 
    .surat-penawaran-container .tabel-harga td {
        padding: 12px 10px;
        border-bottom: 1px solid #e2e8f0;
        border-top: none;
        border-left: none;
        border-right: none;
    }
    .surat-penawaran-container .tabel-harga th {
        background-color: #f1f5f9;
        color: #1e293b;
        text-align: left;
        font-weight: bold;
        font-size: 10pt;
        text-transform: uppercase;
    }
    .surat-penawaran-container .tabel-harga th.center, 
    .surat-penawaran-container .tabel-harga td.center {
        text-align: center;
    }
    .surat-penawaran-container .tabel-harga th.right, 
    .surat-penawaran-container .tabel-harga td.right {
        text-align: right;
    }

    /* Syarat & Ketentuan */
    .surat-penawaran-container .syarat-ketentuan {
        background-color: #f8f9fa;
        padding: 15px 20px;
        border: 1px solid #e2e8f0;
        border-radius: 5px;
        margin-bottom: 30px;
    }
    .surat-penawaran-container .syarat-ketentuan p {
        margin-top: 0;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .surat-penawaran-container .syarat-ketentuan ul {
        margin: 0;
        padding-left: 20px;
    }

    /* Tanda Tangan */
    .surat-penawaran-container .tanda-tangan {
        width: 100%;
        margin-top: 40px;
        page-break-inside: avoid; /* Penting biar TTD gak kepotong beda halaman kalau di PDF */
    }
    .surat-penawaran-container .tanda-tangan td {
        width: 50%;
        text-align: center;
        vertical-align: top;
        border: none;
    }
    .surat-penawaran-container .ttd-nama {
        font-weight: bold;
        text-decoration: underline;
        margin-top: 70px;
        display: inline-block;
    }
</style>

<div class="surat-penawaran-container">
    <div class="kop-surat">
        <h1>PT. TRI JAYA TEKNIK KARAWANG</h1>
        <p>Jl. Raya Karawang - Cikampek No. 123, Karawang, Jawa Barat</p>
        <p>Email: info@trijayateknik.co.id &nbsp;|&nbsp; Telp: (0267) 123456</p>
    </div>

    <div class="info-surat">
        <table>
            <tr>
                <td width="12%">Nomor</td>
                <td width="3%">:</td>
                <td width="45%">{{ $bidding->no_penawaran }}</td>
                <td width="15%">Karawang,</td>
                <td width="25%">{{ \Carbon\Carbon::parse($bidding->tgl_penawaran)->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>1 (Satu) Berkas BOQ</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td><strong>Penawaran Harga Proyek</strong></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="penerima">
        <p>Kepada Yth.,<br>
        <strong>Pimpinan / Bpk. {{ $bidding->project->pic_pelanggan ?? 'Pimpinan Perusahaan' }}</strong><br>
        {{ $bidding->nama_perusahaan }}<br>
        {{ $bidding->alamat_perusahaan }}</p>
    </div>

    <div class="isi-surat">
        <p>Dengan hormat,</p>
        <p>Sesuai dengan permintaan penawaran harga untuk pekerjaan <strong>{{ $bidding->project->nama_pelanggan ?? 'Proyek Terkait' }}</strong> ({{ $bidding->project->deskripsi_proyek ?? '-' }}), bersama surat ini kami PT. Tri Jaya Teknik Karawang bermaksud mengajukan penawaran harga untuk pekerjaan tersebut.</p>
        <p>Adapun rincian total nilai penawaran yang kami ajukan adalah sebagai berikut:</p>
    </div>

    <table class="tabel-harga">
        <thead>
            <tr>
                <th width="5%" class="center">No.</th>
                <th width="65%">Uraian Pekerjaan</th>
                <th width="30%" class="right">Total Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="center">1</td>
                <td>Pelaksanaan Proyek {{ $bidding->project->nama_pelanggan ?? 'Terkait' }}</td>
                <td class="right" style="font-weight: bold; font-size: 11pt;">
                    {{ number_format($bidding->total_penawaran, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="syarat-ketentuan">
        <p>Syarat & Ketentuan Penawaran:</p>
        <ul>
            <li><strong>Masa Berlaku:</strong> {{ $bidding->masa_berlaku }} Hari sejak tanggal surat ini diterbitkan.</li>
            <li><strong>Term of Payment:</strong> {{ $bidding->term_of_payment }}</li>
            <li><strong>Catatan Tambahan:</strong> {{ $bidding->surat_pengantar }}</li>
        </ul>
    </div>

    <div class="isi-surat">
        <p>Demikian surat penawaran ini kami sampaikan. Besar harapan kami untuk dapat menjalin kerjasama dengan perusahaan yang Bapak/Ibu pimpin. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
    </div>

    <table class="tanda-tangan">
        <tr>
            <td></td>
            <td>
                Hormat Kami,<br>
                <strong>PT. Tri Jaya Teknik Karawang</strong>
                <br>
                <span class="ttd-nama">Direktur Utama</span>
            </td>
        </tr>
    </table>
</div>