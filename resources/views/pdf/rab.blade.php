<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>RAB - {{ $rab->no_boq }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 9pt; color: #333; }
        .kop-surat { border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .kop-surat h1 { margin: 0; font-size: 16pt; color: #1e3a8a; }
        .kop-surat p { margin: 2px 0; font-size: 8pt; }
        .judul-dokumen { text-align: center; font-size: 12pt; font-weight: bold; margin-bottom: 20px; text-transform: uppercase; }
        .info-tabel { width: 100%; margin-bottom: 15px; font-size: 9pt; }
        .info-tabel td { padding: 3px 0; }
        .wbs-tabel { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .wbs-tabel th, .wbs-tabel td { border: 1px solid #000; padding: 6px; }
        .wbs-tabel th { background-color: #e2e8f0; text-align: center; font-weight: bold; }
        .parent-row { background-color: #f8fafc; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .ttd-area { width: 100%; margin-top: 40px; text-align: center; }
        .ttd-area td { width: 33%; vertical-align: bottom; height: 100px; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h1>PT. TRI JAYA TEKNIK KARAWANG</h1>
        <p>Divisi Engineering & Estimator | Jl. Raya Karawang - Cikampek No. 123</p>
    </div>

    <div class="judul-dokumen">
        RENCANA ANGGARAN BIAYA (RAB) / BILL OF QUANTITIES
    </div>

    <table class="info-tabel">
        <tr>
            <td width="15%"><strong>No. Dokumen</strong></td>
            <td width="35%">: {{ $rab->no_boq }}</td>
            <td width="15%"><strong>Klien / Proyek</strong></td>
            <td width="35%">: {{ $rab->project->nama_pelanggan ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal</strong></td>
            <td>: {{ \Carbon\Carbon::parse($rab->tgl_boq)->format('d/m/Y') }}</td>
            <td><strong>Status</strong></td>
            <td>: {{ strtoupper($rab->status_rab) }}</td>
        </tr>
    </table>

    <table class="wbs-tabel">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="40%">Uraian Pekerjaan / Material</th>
                <th width="10%">Satuan</th>
                <th width="10%">Vol</th>
                <th width="15%">Harga Satuan (Rp)</th>
                <th width="20%">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($wbsStruktur as $index => $parent)
                <tr class="parent-row">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td colspan="5">{{ $parent->deskripsi_pekerjaan }}</td>
                </tr>
                
                @foreach($parent->children as $child)
                <tr>
                    <td></td>
                    <td style="padding-left: 15px;">- {{ $child->deskripsi_pekerjaan }}</td>
                    <td class="text-center">{{ $child->material->satuan ?? '-' }}</td>
                    <td class="text-center">{{ $child->qty }}</td>
                    <td class="text-right">{{ number_format($child->harga_awal, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($child->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="6" class="text-center">Rincian WBS belum disusun.</td>
                </tr>
            @endforelse

            <tr>
                <td colspan="5" class="text-right" style="font-weight: bold;">OVERHEAD COST / BIAYA LAINNYA</td>
                <td class="text-right" style="font-weight: bold;">{{ number_format($rab->overhead_cost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="font-weight: bold; background-color: #e2e8f0;">GRAND TOTAL ANGGARAN</td>
                <td class="text-right" style="font-weight: bold; background-color: #e2e8f0;">{{ number_format($rab->grand_total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table class="ttd-area">
        <tr>
            <td>
                Dibuat Oleh,<br><br><br><br><br>
                <strong>( Estimator / Engineering )</strong>
            </td>
            <td>
                Diperiksa Oleh,<br><br><br><br><br>
                <strong>( Manager Operasional )</strong>
            </td>
            <td>
                Disetujui Oleh,<br><br><br><br><br>
                <strong>( Direktur Utama )</strong>
            </td>
        </tr>
    </table>

</body>
</html>