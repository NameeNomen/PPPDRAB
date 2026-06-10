<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Dokumen Proyek - {{ $proyek->request_no ?? 'RAW-DATA' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        
        /* Layout Utama: Memaksa scrollable hanya di area kontainer kertas */
        html, body {
            height: 100vh;
            margin: 0;
            padding: 0;
            background-color: #cbd5e1; 
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        /* NAVBAR ATAS (Akan sembunyi otomatis saat dicetak/print) */
        .preview-header {
            flex: 0 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 50;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        /* WRAAPER UNTUK SCROLLING KERTAS A4 */
        .preview-container {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 40px 15px; 
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 40px; /* Jarak pemisah antar halaman kertas */
        }

        /* Desain Scrollbar PDF Style */
        .preview-container::-webkit-scrollbar { width: 8px; }
        .preview-container::-webkit-scrollbar-track { background: #cbd5e1; }
        .preview-container::-webkit-scrollbar-thumb { background: #64748b; border-radius: 4px; }
        .preview-container::-webkit-scrollbar-thumb:hover { background: #475569; }

        /* STANDAR UKURAN KERTAS A4 UNTUK WEB PREVIEW */
        .paper-a4 {
            background-color: white;
            width: 210mm;
            min-height: 297mm;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            position: relative;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        /* HALAMAN 1: STYLE SPESIFIK COVER */
        .paper-cover {
            background: linear-gradient(135deg, #003057 0%, #001224 100%);
            color: white;
            padding: 60px 50px;
        }

        /* HALAMAN 2 & 3: STYLE SPESIFIK SURAT FORMAL */
        .paper-surat {
            padding: 60px 50px; 
            font-family: Arial, sans-serif; 
            font-size: 14px;
            color: #000;
            text-align: justify;
            line-height: 1.6;
        }

        .paper-surat table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px; 
            margin: 15px 0;
        }

        .paper-surat table td {
            padding: 8px 10px;
        }

        /* ATURAN ENGINE CETAK BROWSER (Ctrl + P) */
        @media print {
            html, body { height: auto; overflow: visible; background: white; }
            .preview-header { display: none !important; } 
            .preview-container { display: block; padding: 0; gap: 0; overflow: visible; }
            
            .paper-a4 {
                width: 210mm;
                height: 297mm; /* Kunci tinggi pas A4 saat cetak */
                margin: 0;
                box-shadow: none;
                page-break-after: always; /* Paksa ganti kertas fisik */
            }
            .paper-surat { padding: 25mm 20mm; font-size: 12pt; }
            .paper-surat table { font-size: 11pt; }
            .paper-surat table td { border: 1px solid black; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
    </style>
</head>
<body>

    {{-- BAR NAVIGASI ATAS --}}
    <header class="preview-header">
        <button onclick="window.close()" class="text-sm font-bold text-[#003057] hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors flex items-center gap-2 border border-transparent hover:border-gray-200">
            &times; Tutup Preview
        </button>
        
        <div class="text-center hidden sm:block">
            <h1 class="text-sm font-bold text-gray-800">Preview Dokumen Inisiasi</h1>
            <p class="text-[11px] text-gray-500 font-mono">{{ $proyek->request_no ?? '-' }}</p>
        </div>

        <button onclick="window.print()" class="bg-[#003057] hover:bg-[#001D36] text-white px-5 py-2 rounded-lg text-sm font-bold shadow flex items-center gap-2 transition-all">
            🖨️ Cetak PDF / Surat
        </button>
    </header>

    {{-- KONTEN UTAMA: AREA SCROLL HALAMAN --}}
    <main class="preview-container">
        
        {{-- ==================== HALAMAN 1: COVER ==================== --}}
        <div class="paper-a4 paper-cover">
            <div class="flex justify-between items-start">
                <img src="{{ asset('gambar/tjt.png') }}" alt="TJT Logo" class="w-24 bg-white p-3 rounded shadow-lg">
                <div class="text-right">
                    <p class="text-xs text-blue-200 tracking-widest uppercase font-semibold">TJT / Internal</p>
                    <p class="text-[10px] text-gray-400 mt-1">Industrial Engineering</p>
                </div>
            </div>
            
            <div class="my-auto py-20">
                <p class="text-[#E8BF00] font-semibold tracking-widest mb-3 uppercase text-sm">Dokumen Inisiasi Proyek</p>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 uppercase leading-snug">
                    {{ $proyek->nama_projek ?? 'NAMA PROYEK BELUM DIISI' }}
                </h1>
                <div class="w-20 h-1.5 bg-[#E8BF00]"></div>
            </div>
            
            <div class="flex justify-between items-end border-t border-white/20 pt-6 mt-auto">
                <div>
                    <p class="text-[11px] text-gray-400 uppercase tracking-widest mb-1">Project Initiator</p>
                    <p class="font-bold text-white text-base uppercase">{{ $proyek->user->name ?? 'Tim Marketing' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[11px] text-gray-400 uppercase tracking-widest mb-1">Tahun Anggaran</p>
                    <p class="font-bold text-white text-base">
                        {{ $proyek->created_at ? \Carbon\Carbon::parse($proyek->created_at)->format('Y') : date('Y') }}
                    </p>
                </div>
            </div>
        </div>


        {{-- ==================== HALAMAN 2: SURAT RESMI ==================== --}}
        <div class="paper-a4 paper-surat">
            {{-- Kop Surat --}}
            <div class="relative border-b-[3px] border-black pb-4 mb-2 flex items-center">
                <img src="{{ asset('gambar/tjt.png') }}" alt="Logo TJT" class="absolute left-0 w-20 object-contain">
                <div class="w-full text-center pl-24"> 
                    <h1 class="text-[20px] font-extrabold text-[#003057] uppercase tracking-wide m-0">PT TRI JAYA TEKNIK</h1>
                    <p class="text-[11px] font-bold text-gray-800 mt-1 uppercase m-0">Industrial Engineering & Construction Services</p>
                    <p class="text-[10px] text-gray-600 mt-1 m-0">Jl. Interchange Karawang Barat No. 12, Karawang 41361<br>Telp: (0267) 1234567 | Email: info@trijayateknik.co.id</p>
                </div>
            </div>
            <div class="border-b-[1px] border-black mb-8 mt-[-6px]"></div>

            {{-- Metadata Surat --}}
            <div class="flex justify-between mb-6">
                <div>
                    <table style="border: none; margin: 0; width: auto;">
                        <tr><td style="padding:0; width: 70px; border:none;">Nomor</td><td style="padding:0; border:none;">: <strong>{{ $proyek->request_no ?? '-' }}</strong></td></tr>
                        <tr><td style="padding:0; border:none;">Perihal</td><td style="padding:0; border:none;">: <strong>Pengajuan Inisiasi Dokumen (RAB)</strong></td></tr>
                    </table>
                </div>
                <div class="text-right">
                    <p>Karawang, {{ $proyek->created_at ? \Carbon\Carbon::parse($proyek->created_at)->isoFormat('D MMMM Y') : '-' }}</p>
                </div>
            </div>

            <div class="mb-5">
                <p class="m-0">Kepada Yth.,<br><strong>Tim Engineering / Estimator</strong><br>PT Tri Jaya Teknik</p>
            </div>

            <div class="mb-4">
                <p style="margin-bottom: 5px;">Dengan hormat,</p>
                <p style="text-indent: 30px; margin:0;">
                    Berdasarkan hasil koordinasi dengan klien dan observasi kebutuhan lapangan, dengan ini Divisi Marketing menyampaikan data awal untuk keperluan penyusunan Rencana Anggaran Biaya (RAB) dan Bill of Quantities (BOQ). Adapun rincian spesifikasi data inisiasi proyek tersebut adalah sebagai berikut:
                </p>
            </div>

            {{-- Tabel Spesifikasi Data Teknikal --}}
            <table class="border border-black w-full text-[13px]">
                <tbody>
                    <tr>
                        <td class="border border-black font-bold bg-gray-100 w-[35%]">Instansi / Klien</td>
                        <td class="border border-black font-bold uppercase">{{ $proyek->nama_pelanggan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="border border-black font-bold bg-gray-100">Judul Pekerjaan</td>
                        <td class="border border-black font-bold uppercase">{{ $proyek->nama_projek ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="border border-black font-bold bg-gray-100">Kategori Pekerjaan</td>
                        <td class="border border-black capitalize">{{ $proyek->category->nama_kategori ?? 'Umum' }}</td>
                    </tr>
                    <tr>
                        <td class="border border-black font-bold bg-gray-100">Lokasi Proyek</td>
                        <td class="border border-black capitalize">{{ $proyek->alamat ?: 'Belum ditentukan' }}</td>
                    </tr>
                    <tr>
                        <td class="border border-black font-bold bg-gray-100">Target Waktu</td>
                        <td class="border border-black">{{ $proyek->target_waktu ? \Carbon\Carbon::parse($proyek->target_waktu)->isoFormat('D MMMM Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="border border-black font-bold bg-gray-100 align-top">Catatan Tambahan</td>
                        <td class="border border-black whitespace-pre-line">{{ $proyek->deskripsi_proyek ?: 'Tidak ada instruksi teknis tambahan.' }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mb-6 mt-6">
                <p style="text-indent: 30px; margin:0;">
                    Demikian surat pengajuan inisiasi proyek ini kami sampaikan. Besar harapan kami agar dokumen RAB terkait dapat segera diproses untuk persiapan pelaksanaan teknis. Atas perhatian dan kerja sama yang baik, kami ucapkan terima kasih.
                </p>
            </div>

            {{-- Area Tanda Tangan Mandatori --}}
            <div class="mt-auto pt-10">
                <div class="flex justify-between text-center">
                    <div class="w-1/2">
                        <p style="margin-bottom: 70px;">Mengetahui,<br><strong>Direktur Utama</strong></p>
                        <p class="font-bold uppercase border-b border-black inline-block px-4 pb-1">DIREKSI PT TJT</p>
                    </div>
                    <div class="w-1/2">
                        <p style="margin-bottom: 70px;">Hormat Kami,<br><strong>Divisi Marketing</strong></p>
                        <p class="font-bold uppercase border-b border-black inline-block px-4 pb-1">{{ $proyek->user->name ?? 'Project Initiator' }}</p>
                    </div>
                </div>
            </div>
        </div>


        {{-- ==================== HALAMAN 3: LAMPIRAN FOTO (PROTECTED) ==================== --}}
        @if(isset($proyek->attachments) && $proyek->attachments->count() > 0)
        <div class="paper-a4 paper-surat">
            <div class="border-b-[3px] border-black pb-2 mb-6">
                <h2 class="text-lg font-bold uppercase">Lampiran Dokumentasi Visual</h2>
            </div>
            
            <div class="grid grid-cols-2 gap-5">
                @foreach($proyek->attachments as $file)
                    @php
                        $ext = strtolower($file->file_type ?? pathinfo($file->file_name, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg']);
                    @endphp
                    
                    @if($isImage)
                        <div class="border border-gray-300 p-2 rounded bg-gray-50 text-center shadow-sm">
                            <div class="w-full h-56 flex items-center justify-center bg-gray-200 mb-2 overflow-hidden rounded border border-gray-300">
                                <img src="{{ asset('storage/' . $file->file_path) }}" alt="Lampiran" class="object-cover w-full h-full">
                            </div>
                            <span class="text-xs text-gray-700 font-semibold truncate block w-full px-1">{{ $file->file_name }}</span>
                        </div>
                    @else
                        <div class="border border-gray-300 p-2 rounded bg-gray-50 text-center shadow-sm flex flex-col justify-center items-center min-h-[224px]">
                            <span class="text-3xl mb-2">📄</span>
                            <span class="text-xs text-gray-700 font-semibold block px-1 break-all">{{ $file->file_name }}</span>
                            <span class="text-[10px] text-gray-500 mt-1">Berkas Non-Gambar ({{ strtoupper($ext) }})</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

    </main>

</body>
</html>