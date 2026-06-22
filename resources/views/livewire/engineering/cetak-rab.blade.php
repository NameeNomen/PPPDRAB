<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAB - {{ $rabAktif->no_boq ?? 'Dokumen' }}</title>
    <style>
        /* Standarisasi Kertas A4 Mutlak */
        @page { size: A4; margin: 10mm; }
        body { 
            font-family: 'Arial', sans-serif; 
            font-size: 11px; 
            color: #333; 
            margin: 0; 
            -webkit-print-color-adjust: exact !important; 
            print-color-adjust: exact !important; 
        }

        /* Isolasi Layar Iframe (Biar nggak melar dan ada shadow kertasnya) */
        @media screen {
            body { background: #525659; padding: 20px; display: flex; justify-content: center; }
            .page { 
                background: #fff; 
                width: 210mm; 
                min-height: 297mm; 
                padding: 15mm 20mm; 
                box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
                box-sizing: border-box; 
                position: relative; 
            }
        }

        /* Mode Print Native */
        @media print { 
            body { background: #FFF; padding: 0; display: block; }
            .page { width: 100%; box-shadow: none; padding: 0; } 
        }
        
        /* KOP SURAT (Tanpa kotak, murni logo dan garis bawah tebal) */
        .kop-surat { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #4A7256; padding-bottom: 10px; margin-bottom: 25px; }
        .kop-logo { width: 120px; object-fit: contain; }
        .kop-teks { text-align: center; flex-grow: 1; padding: 0 15px; }
        .kop-teks h1 { margin: 0; color: #4A7256; font-size: 24px; font-weight: 900; letter-spacing: 1px; }
        .kop-teks h2 { margin: 5px 0; font-size: 12px; font-weight: bold; color: #444; letter-spacing: 0.5px; }
        .kop-teks p { margin: 0; font-size: 9px; font-weight: bold; color: #666; }

        /* Tabel Info */
        .info-table { width: 60%; font-weight: bold; margin-bottom: 20px; font-size: 11px; }
        .info-table td { padding: 3px 5px; vertical-align: top; }
        .info-table td:first-child { width: 120px; }

        /* Tabel RAB (Warna Pastel Elegan) */
        .table-rab { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 11px; border: 1px solid #B4CDBF; }
        .table-rab th, .table-rab td { border: 1px solid #B4CDBF; padding: 6px; }
        .table-rab th { background-color: #4A7256; color: #FFF; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        
        .row-kategori { background-color: #E2EFE7; font-weight: 900; color: #2A402B; text-transform: uppercase; }
        .row-grandtotal { background-color: #4A7256; color: white; font-weight: 900; font-size: 12px; text-transform: uppercase; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .ttd-container { width: 100%; display: flex; justify-content: flex-end; margin-top: 40px; }
        .ttd-box { width: 200px; text-align: center; }
    </style>
</head>
<body>

    <div class="page">
        <div class="kop-surat">
            <img src="{{ asset('gambar/tjt.png') }}" class="kop-logo" alt="TJT Logo" onerror="this.style.display='none'">
            <div class="kop-teks">
                <h1>PT. TRI JAYA TEKNIK KARAWANG</h1>
                <h2>MACHINING, STAMPING, FABRICATION,<br>CONSTRUCTION, AND CIVIL WORK</h2>
                <p>JL. Alternatif Krajan II Warung Bambu - Karawang Timur<br>Telp. (0267) 8615387 Fax: (0267) 8615386 Email: pt.tjtk@yahoo.com</p>
            </div>
            <img src="{{ asset('gambar/iso.png') }}" class="kop-logo" alt="ISO Logo" onerror="this.style.display='none'">
        </div>

        <table class="info-table">
            <tr><td>No. BOQ</td><td>: {{ $rabAktif->no_boq ?? '-' }}</td></tr>
            <tr><td>Nama Project</td><td>: {{ $selectedProject->nama_projek ?? '-' }}</td></tr>
            <tr><td>Tgl. Update</td><td>: {{ $rabAktif->tgl_boq ? \Carbon\Carbon::parse($rabAktif->tgl_boq)->format('d F Y') : '-' }}</td></tr>
            <tr><td>Lampiran</td><td>: {{ $selectedProject->attachments->count() > 0 ? $selectedProject->attachments->count() . ' Berkas' : '-' }}</td></tr>
            <tr><td>Customer</td><td>: {{ $selectedProject->nama_pelanggan ?? '-' }}</td></tr>
        </table>

        <table class="table-rab">
            <thead>
                <tr>
                    <th style="width: 5%;">NO.</th>
                    <th style="width: 35%;">DESCRIPTION</th>
                    <th style="width: 20%;">KIND OF MATERIALS</th>
                    <th style="width: 10%;">QTY</th>
                    <th style="width: 15%;">HARGA SATUAN<br>(RP.)</th>
                    <th style="width: 15%;">JUMLAH<br>(RP.)</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $alphabet = range('A', 'Z'); 
                    $totalPekerjaan = 0;
                @endphp

                @foreach($kategoris as $indexKat => $kat)
                    @php
                        // ALGORITMA FLATTEN & ROWSPAN MATRIX (Tidak disentuh)
                        $childrenKat = $kat->children ?? [];
                        $subtotalKat = 0;
                        
                        foreach($childrenKat as $item) {
                            $childrenItem = $item->children ?? [];
                            if(count($childrenItem) > 0) {
                                $itemSub = 0;
                                foreach($childrenItem as $sub) { $itemSub += $sub->subtotal ?? 0; }
                                $subtotalKat += $itemSub;
                            } else {
                                $subtotalKat += $item->subtotal ?? 0;
                            }
                        }
                        $totalPekerjaan += $subtotalKat;

                        $flatRows = [];
                        
                        $flatRows[] = [
                            'is_kat' => true, 'is_sub' => false, 'is_item_with_child' => false,
                            'no' => $alphabet[$indexKat] ?? ($indexKat+1),
                            'desc' => $kat->deskripsi_pekerjaan ?? '',
                            'qty_sat' => '', 'harga' => '',
                            'jumlah' => number_format($subtotalKat, 0, ',', '.'),
                            'mat_name' => ''
                        ];

                        $itemNo = 1;
                        foreach($childrenKat as $item) {
                            $childrenItem = $item->children ?? [];
                            $hasChildren = count($childrenItem) > 0;
                            
                            $itemSub = 0;
                            if($hasChildren) {
                                foreach($childrenItem as $sub) { $itemSub += $sub->subtotal ?? 0; }
                            } else {
                                $itemSub = $item->subtotal ?? 0;
                            }

                            $matName = $item->material->nama_barang ?? '';
                            $qtySat = ($item->qty ?? 0) . ' ' . ($item->material->satuan ?? 'Lot');

                            $flatRows[] = [
                                'is_kat' => false, 'is_sub' => false, 'is_item_with_child' => $hasChildren,
                                'no' => $itemNo++,
                                'desc' => '- ' . ($item->deskripsi_pekerjaan ?? ''),
                                'qty_sat' => $hasChildren ? '' : $qtySat,
                                'harga' => $hasChildren ? '' : number_format($item->harga_awal ?? 0, 0, ',', '.'),
                                'jumlah' => number_format($itemSub, 0, ',', '.'),
                                'mat_name' => $hasChildren ? '' : $matName
                            ];

                            foreach($childrenItem as $sub) {
                                $subMatName = $sub->material->nama_barang ?? '';
                                $subQtySat = ($sub->qty ?? 0) . ' ' . ($sub->material->satuan ?? 'Pcs');
                                
                                $flatRows[] = [
                                    'is_kat' => false, 'is_sub' => true, 'is_item_with_child' => false,
                                    'no' => '',
                                    'desc' => '- ' . ($sub->deskripsi_pekerjaan ?? ''),
                                    'qty_sat' => $subQtySat,
                                    'harga' => number_format($sub->harga_awal ?? 0, 0, ',', '.'),
                                    'jumlah' => number_format($sub->subtotal ?? 0, 0, ',', '.'),
                                    'mat_name' => $subMatName
                                ];
                            }
                        }

                        $currentMat = null;
                        $groupStartIndex = 0;

                        foreach($flatRows as $i => $row) {
                            $mat = $row['mat_name'];
                            if ($i === 0) {
                                $currentMat = $mat;
                                $groupStartIndex = 0;
                                $flatRows[$i]['rowspan'] = 1;
                                $flatRows[$i]['show_mat'] = true;
                            } else {
                                if ($mat === $currentMat) {
                                    $flatRows[$groupStartIndex]['rowspan']++;
                                    $flatRows[$i]['show_mat'] = false;
                                } else {
                                    $currentMat = $mat;
                                    $groupStartIndex = $i;
                                    $flatRows[$i]['rowspan'] = 1;
                                    $flatRows[$i]['show_mat'] = true;
                                }
                            }
                        }
                    @endphp

                    @foreach($flatRows as $row)
                        <tr class="{{ $row['is_kat'] ? 'row-kategori' : '' }}">
                            <td class="text-center">{{ $row['no'] }}</td>
                            <td style="{{ $row['is_sub'] ? 'padding-left: 25px;' : ($row['is_kat'] ? '' : 'padding-left: 10px;') }}">
                                {{ $row['desc'] }}
                            </td>
                            
                            @if($row['show_mat'])
                                <td rowspan="{{ $row['rowspan'] }}" style="vertical-align: middle; text-align: center; font-weight: bold; color: #333;">
                                    {{ $row['mat_name'] }}
                                </td>
                            @endif
                            
                            <td class="text-center">{{ $row['qty_sat'] }}</td>
                            <td class="text-right">{{ $row['harga'] }}</td>
                            <td class="text-right {{ $row['is_kat'] || $row['is_item_with_child'] ? 'font-bold' : '' }}">{{ $row['jumlah'] }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="5" class="text-right" style="font-weight:bold;">TOTAL HARGA PEKERJAAN (HPP)</td>
                    <td class="text-right font-bold">Rp {{ number_format($totalPekerjaan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right" style="font-weight:bold;">OVERHEAD COST</td>
                    <td class="text-right font-bold">Rp {{ number_format($rabAktif->overhead_cost, 0, ',', '.') }}</td>
                </tr>
                @php
                    $grandTotalReal = $totalPekerjaan + $rabAktif->overhead_cost;
                    $grandTotalBulat = floor($grandTotalReal / 1000) * 1000;
                @endphp
                {{-- Tambahin baris ini biar kelihatan nilai aslinya sebelum dibuletin --}}
                <tr style="background-color: #E8F5E9; font-weight: 900;">
                    <td colspan="5" class="text-right">GRAND TOTAL REAL</td>
                    <td class="text-right">Rp {{ number_format($grandTotalReal, 0, ',', '.') }}</td>
                </tr>
                
                <tr class="row-grandtotal">
                    <td colspan="5" class="text-right">GRAND TOTAL DIBULATKAN</td>
                    <td class="text-right">Rp {{ number_format($grandTotalBulat, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="ttd-container">
            <div class="ttd-box">
                <p style="margin: 0;">Karawang, {{ date('d F Y') }}<br>Dibuat Oleh,</p>
                <br><br><br><br>
                <div style="border-bottom: 1px solid #000; width: 100%; margin: 5px 0;"></div>
                <p style="margin: 0; font-weight: bold; font-size: 12px; text-transform: uppercase;">@php
                    $pembuat = \App\Models\DocumentCommit::where('id_rab', $rabAktif->id)
                        ->where('jenis_aksi', 'submitted')
                        ->orderBy('created_at', 'asc')
                        ->first();
                @endphp

                {{ strtoupper($pembuat->user_name ?? '-') }}</p>
                <p style="margin: 3px 0 0 0; font-weight: bold; font-size: 10px;">Engineering Dept.</p>
            </div>
        </div>
    </div>
</body>
</html>