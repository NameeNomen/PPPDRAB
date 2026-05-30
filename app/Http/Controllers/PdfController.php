<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidding;
use App\Models\Rab;
use App\Models\RabItem;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    // =========================
    // CETAK PDF BIDDING
    // =========================
    public function cetakBidding($id_bidding)
    {
        // Ambil data bidding + relasi project
        $bidding = Bidding::with('project')->findOrFail($id_bidding);

        // Generate PDF dari blade
        $pdf = Pdf::loadView('pdf.bidding', compact('bidding'));

        // Set ukuran kertas
        $pdf->setPaper('A4', 'portrait');

        // Bikin filename aman dari slash
        $filename = 'Surat_Penawaran_' .
            str_replace(['/', '\\'], '-', $bidding->no_penawaran) .
            '.pdf';

        // Tampilkan PDF di browser
        return $pdf->stream($filename);
    }

    // =========================
    // CETAK PDF RAB
    // =========================
    public function cetakRab($id_rab)
    {
        // Ambil data RAB + relasi project
        $rab = Rab::with('project')->findOrFail($id_rab);

        // Ambil struktur WBS parent + children
        $wbsStruktur = RabItem::with('children.material')
            ->where('id_rab', $id_rab)
            ->whereNull('parent_id')
            ->get();

        // Generate PDF dari blade
        $pdf = Pdf::loadView('pdf.rab', compact('rab', 'wbsStruktur'));

        // Set ukuran kertas
        $pdf->setPaper('A4', 'portrait');

        // Bikin filename aman
        $filename = 'Dokumen_RAB_' .
            str_replace(['/', '\\'], '-', $rab->no_boq) .
            '.pdf';

        // Stream PDF ke browser
        return $pdf->stream($filename);
    }
}