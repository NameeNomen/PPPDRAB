<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Permintaan Proyek - {{ $proyek->request_no }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Times+New+Roman&display=swap');
        
        /* Tema Dasar UI */
        body {
            background-color: #F2F2F2;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #003057;
        }

        /* Simulasi Kertas A4 di Layar Monitor */
        .paper-a4 {
            background-color: white;
            width: 210mm;
            min-height: 297mm;
            margin: 2rem auto;
            padding: 25mm 20mm; /* Margin standar dokumen formal */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden; /* Biar elemen dekorasi ga keluar batas kertas */
        }

        /* Font khusus untuk isi surat resmi */
        .font-surat {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }

        /* Pengaturan Khusus Saat Mode Cetak (Ctrl+P) */
        @media print {
            @page {
                size: A4;
                margin: 0; /* Margin diatur dari padding .paper-a4 */
            }
            body {
                background: white;
            }
            .no-print {
                display: none !important;
            }
            .paper-a4 {
                margin: 0;
                box-shadow: none;
                width: 100%;
                min-height: 100vh;
                page-break-after: always;
            }
            /* Memaksa background image (watermark) tetap tercetak di Chrome/Edge */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>

    <div class="max-w-4xl mx-auto mt-6 flex justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-gray-200 no-print">
        <a href="{{ route('proyek.index') }}" class="text-sm font-bold text-[#003057] hover:text-[#E8BF00] transition-colors flex items-center gap-2">
            &larr; Kembali
        </a>
        
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="bg-[#003057] hover:bg-[#001D36] text-white px-5 py-2 rounded-lg text-sm font-bold shadow flex items-center gap-2 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <div class="paper-a4">
        
        <img src="{{ asset('images/tjt.png') }}" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-2/3 opacity-[0.07] z-0 pointer-events-none" alt="Watermark TJT">

        <div class="relative z-10">
            
            <div class="flex items-center justify-between border-b-[3px] border-black pb-4 mb-1">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-[#003057] flex items-center justify-center text-white font-extrabold text-2xl tracking-widest">
                        TJT
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold uppercase tracking-tight text-[#003057]" style="font-family: 'Arial', sans-serif;">PT TRI JAYA TEKNIK</h1>
                        <p class="text-[10pt] font-semibold text-gray-700 tracking-wide mt-0.5">INDUSTRIAL ENGINEERING & CONSTRUCTION SERVICES</p>
                        <p class="text-[8.5pt] text-gray-500 mt-1">Jl. Interchange Karawang Barat No. 12, Karawang, Jawa Barat 41361<br>Telp: (0267) 1234567 | Email: info@trijayateknik.co.id</p>
                    </div>
                </div>
            </div>
            <div class="border-b-[1px] border-black mb-8"></div>

            <div class="font-surat text-justify text-black">
                
                <div class="flex justify-between mb-8">
                    <div>
                        <table class="text-[11pt]">
                            <tr>
                                <td class="py-1 pr-4">Nomor</td>
                                <td>: <strong>{{ $proyek->request_no }}</strong></td>
                            </tr>
                            <tr>
                                <td class="py-1 pr-4">Perihal</td>
                                <td>: <strong>Pengajuan Inisiasi Dokumen Rencana Anggaran Biaya (RAB)</strong></td>
                            </tr>
                            <tr>
                                <td class="py-1 pr-4">Lampiran</td>
                                <td>: 1 (Satu) Berkas Lengkap</td>
                            </tr>
                        </table>
                    </div>
                    <div class="text-right text-[11pt]">
                        <p>Karawang, {{ \Carbon\Carbon::parse($proyek->created_at)->isoFormat('D MMMM Y') }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p>Kepada Yth.,<br>
                    <strong>Tim Engineering / Estimator</strong><br>
                    PT Tri Jaya Teknik<br>
                    di Tempat</p>
                </div>

                <div class="mb-4">
                    <p>Dengan hormat,</p>
                    <p class="indent-8 mt-2">
                        Berdasarkan hasil koordinasi dengan klien dan observasi kebutuhan lapangan, dengan ini Divisi Marketing menyampaikan data awal untuk keperluan penyusunan Rencana Anggaran Biaya (RAB) dan Bill of Quantities (BOQ). Adapun rincian data proyek adalah sebagai berikut:
                    </p>
                </div>

                <div class="mb-6 mt-4">
                    <table class="w-full border-collapse border border-black text-[11pt]">
                        <tbody>
                            <tr>
                                <td class="border border-black p-2 font-bold bg-gray-100 w-[35%]">Nama Instansi / Klien</td>
                                <td class="border border-black p-2 font-bold">{{ $proyek->nama_pelanggan }}</td>
                            </tr>
                            <tr>
                                <td class="border border-black p-2 font-bold bg-gray-100">Judul Pekerjaan</td>
                                <td class="border border-black p-2 font-bold uppercase">{{ $proyek->nama_projek }}</td>
                            </tr>
                            <tr>
                                <td class="border border-black p-2 font-bold bg-gray-100">Kategori Pekerjaan</td>
                                <td class="border border-black p-2">{{ $proyek->category->nama_kategori ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="border border-black p-2 font-bold bg-gray-100">Alamat Lokasi Proyek</td>
                                <td class="border border-black p-2">{{ $proyek->alamat ?: 'Belum ditentukan' }}</td>
                            </tr>
                            <tr>
                                <td class="border border-black p-2 font-bold bg-gray-100">Tingkat Prioritas</td>
                                <td class="border border-black p-2 uppercase">{{ $proyek->priority }}</td>
                            </tr>
                            <tr>
                                <td class="border border-black p-2 font-bold bg-gray-100">Estimasi Anggaran Klien</td>
                                <td class="border border-black p-2 font-bold">Rp {{ number_format($proyek->estimasi_budget, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="border border-black p-2 font-bold bg-gray-100">Target Waktu Selesai</td>
                                <td class="border border-black p-2">{{ $proyek->target_waktu ? \Carbon\Carbon::parse($proyek->target_waktu)->isoFormat('D MMMM Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="border border-black p-2 font-bold bg-gray-100 align-top">Spesifikasi Tambahan</td>
                                <td class="border border-black p-2 whitespace-pre-line">{{ $proyek->deskripsi_proyek ?: 'Tidak ada instruksi teknis tambahan.' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-12">
                    <p class="indent-8">
                        Demikian surat pengajuan inisiasi proyek ini kami sampaikan. Besar harapan kami agar dokumen RAB terkait dapat segera diproses untuk menunjang kelancaran proses penawaran (Bidding) kepada pihak klien. Atas perhatian dan kerja sama yang baik, kami ucapkan terima kasih.
                    </p>
                </div>

                <div class="grid grid-cols-2 text-center mt-12 pt-8">
                    <div>
                        <p class="mb-24">Mengetahui,<br><strong>Direktur Utama</strong></p>
                        <p class="font-bold underline uppercase">( ........................................ )</p>
                        <p class="text-[10pt]">PT Tri Jaya Teknik</p>
                    </div>
                    <div>
                        <p class="mb-24">Hormat Kami,<br><strong>Divisi Marketing</strong></p>
                        <p class="font-bold underline uppercase">( {{ $proyek->user->name ?? '........................................' }} )</p>
                        <p class="text-[10pt]">Project Initiator</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>