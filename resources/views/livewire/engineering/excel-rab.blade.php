<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="UTF-8">
    <style>
        /* Desain Tabel Formal Excel */
        .title-company { font-family: 'Arial'; font-size: 16px; font-weight: bold; color: #1B5E20; text-align: center; }
        .title-sub { font-family: 'Arial'; font-size: 11px; text-align: center; font-weight: bold; }
        .info-label { font-family: 'Arial'; font-size: 11px; font-weight: bold; }
        
        .table-excel { border-collapse: collapse; font-family: 'Arial'; font-size: 11px; width: 100%; }
        .table-excel th { background-color: #2E7D32; color: #FFFFFF; font-weight: bold; border: 1px solid #000000; text-align: center; height: 30px; }
        .table-excel td { border: 1px solid #000000; padding: 5px; vertical-align: top; }
        
        /* Highlight Klasik RAB */
        .row-kategori { background-color: #A5D6A7; font-weight: bold; uppercase: true; }
        .row-subtotal { background-color: #E8F5E9; font-style: italic; font-weight: bold; }
        .row-grandtotal { background-color: #1B5E20; color: #FFFFFF; font-weight: bold; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <table width="100%">
        <tr>
            <td colspan="6" class="title-company">PT. TRI JAYA TEKNIK KARAWANG</td>
        </tr>
        <tr>
            <td colspan="6" class="title-sub">MACHINING, STAMPING, FABRICATION, CONSTRUCTION, AND CIVIL WORK</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center; font-size: 9px; font-family: Arial;">JL. Alternatif Krajan II Warung Bambu - Karawang Timur</td>
        </tr>
        <tr><td colspan="6"></td></tr> </table>

    <table>
        <tr>
            <td class="info-label">No. BOQ Ref</td>
            <td>: {{ $rabAktif->no_boq ?? '-' }}</td>
            <td colspan="2"></td>
            <td class="info-label">Customer</td>
            <td>: {{ $selectedProject->nama_pelanggan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Nama Project</td>
            <td>: {{ $selectedProject->nama_projek ?? '-' }}</td>
            <td colspan="2"></td>
            <td class="info-label">Tgl. Pembuatan</td>
            <td>: {{ date('d F Y') }}</td>
        </tr>
    </table>
    
    <br>

    <table class="table-excel">
        <thead>
            <tr>
                <th>NO</th>
                <th>DESCRIPTION / URAIAN PEKERJAAN</th>
                <th>QTY</th>
                <th>SAT</th>
                <th>HARGA SATUAN (RP)</th>
                <th>JUMLAH HARGA (RP)</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $alphabet = range('A', 'Z'); 
                $totalPekerjaan = 0;
            @endphp

            @foreach($kategoris as $indexKat => $kat)
                @php
                    $subtotalKat = collect($kat->children)->sum(function($child) {
                        return count($child->children) > 0 ? collect($child->children)->sum('subtotal') : $child->subtotal;
                    });
                    $totalPekerjaan += $subtotalKat;
                @endphp

                <tr class="row-kategori">
                    <td class="text-center">{{ $alphabet[$indexKat] ?? ($indexKat+1) }}.</td>
                    <td colspan="4">{{ $kat->deskripsi_pekerjaan }}</td>
                    <td class="text-right">{{ $subtotalKat }}</td>
                </tr>

                @php $itemNo = 1; @endphp
                @foreach($kat->children as $item)
                    <tr>
                        <td class="text-center">{{ $itemNo++ }}</td>
                        <td>{{ $item->deskripsi_pekerjaan }}</td>
                        
                        @if(count($item->children) > 0)
                            <td colspan="3" class="text-center" style="color: #888; font-size: 9px;">(Rincian Detail di Bawah)</td>
                            <td class="text-right" style="font-weight: bold;">{{ collect($item->children)->sum('subtotal') }}</td>
                        @else
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-center">{{ $item->material->satuan ?? 'Lot' }}</td>
                            <td class="text-right">{{ $item->harga_awal }}</td>
                            <td class="text-right">{{ $item->subtotal }}</td>
                        @endif
                    </tr>

                    @foreach($item->children as $sub)
                        <tr>
                            <td></td>
                            <td style="padding-left: 15px;">- {{ $sub->deskripsi_pekerjaan }}</td>
                            <td class="text-center">{{ $sub->qty }}</td>
                            <td class="text-center">{{ $sub->material->satuan ?? 'Pcs' }}</td>
                            <td class="text-right">{{ $sub->harga_awal }}</td>
                            <td class="text-right">{{ $sub->subtotal }}</td>
                        </tr>
                    @endforeach
                @endforeach

                <tr class="row-subtotal">
                    <td></td>
                    <td colspan="4">Sub Total Bagian {{ $alphabet[$indexKat] ?? ($indexKat+1) }}</td>
                    <td class="text-right">{{ $subtotalKat }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr><td colspan="6" style="border: none; height: 10px;"></td></tr>
            <tr>
                <td colspan="5" class="text-right" style="font-weight: bold;">TOTAL HARGA PEKERJAAN (HPP)</td>
                <td class="text-right" style="font-weight: bold;">{{ $totalPekerjaan }}</td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="font-weight: bold;">OVERHEAD COST / BIAYA OPERASIONAL</td>
                <td class="text-right" style="font-weight: bold;">{{ $rabAktif->overhead_cost }}</td>
            </tr>
            @php
                $grandTotalReal = $totalPekerjaan + $rabAktif->overhead_cost;
                $grandTotalBulat = floor($grandTotalReal / 1000) * 1000;
            @endphp
            <tr class="row-grandtotal">
                <td colspan="5" class="text-right">GRAND TOTAL DIBULATKAN (RUMUS)</td>
                <td class="text-right">{{ $grandTotalBulat }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>