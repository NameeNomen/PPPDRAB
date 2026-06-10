@php
    $rfq = $detailProyek->attachments->where('attachment_category', 'proposal')->first();
    $referensi = $detailProyek->attachments->where('attachment_category', 'reference_image');
    $lokasi = $detailProyek->attachments->where('attachment_category', 'location_photo');
    $drawing = $detailProyek->attachments->where('attachment_category', 'technical_drawing');
    
    // Logika ngecek metode: kalau requires_site_survey true, berarti manual.
    $isManual = $detailProyek->requires_site_survey; 
@endphp

<div class="fixed inset-0 z-[100] bg-[#003057]/90 backdrop-blur-md flex flex-col" id="detailOverlay">
    <style>
        .detail-scroll-container { 
            flex: 1; 
            overflow-y: auto; 
            overflow-x: hidden; 
            padding: 30px 40px; 
            display: flex; 
            flex-direction: column; 
            gap: 30px; 
            align-items: center; 
            scroll-behavior: smooth; 
        }
        .detail-scroll-container::-webkit-scrollbar { width: 10px; }
        .detail-scroll-container::-webkit-scrollbar-thumb { background: #E8BF00; border-radius: 10px; }
        .paper-a4 { background-color: white; width: 210mm; min-height: 297mm; box-shadow: 0 10px 40px rgba(0,0,0,0.25); box-sizing: border-box; display: flex; flex-direction: column; flex-shrink: 0; position: relative;}
        .paper-cover { background: linear-gradient(135deg, #003057 0%, #001224 100%); color: white; padding: 60px 50px; }
        .paper-surat { padding: 50px 45px; font-size: 13px; color: #000; text-align: justify; line-height: 1.6; }
        .paper-surat table { width: 100%; border-collapse: collapse; font-size: 12px; margin: 12px 0; }
        .paper-surat table td { padding: 7px 9px; border: 1px solid #333; }
        /* Reset iframe biar full cover kertas */
        .pdf-embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; }
    </style>

    <header class="flex-none bg-white/95 backdrop-blur border-b border-gray-200 p-4 flex justify-between items-center shadow-sm z-50">
        <button wire:click="tutupDetail" class="text-sm font-bold text-[#003057] hover:bg-gray-100 px-4 py-2 rounded-lg flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg> Tutup
        </button>
        <div class="text-center">
            <h1 class="text-sm font-bold text-gray-800">Preview Dokumen Inisiasi</h1>
            <p class="text-[11px] text-gray-500 font-mono">{{ $detailProyek->request_no ?? '-' }}</p>
        </div>
        <button onclick="window.print()" class="bg-[#003057] hover:bg-[#001D36] text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg> Cetak PDF
        </button>
    </header>

    <main class="detail-scroll-container" id="detailScrollContainer">
        {{-- HALAMAN 1: COVER --}}
        <div class="paper-a4 paper-cover">
            <div class="flex justify-between items-start">
                <img src="{{ asset('gambar/tjt.png') }}" alt="TJT Logo" class="w-24 object-contain">
                <div class="text-right"><p class="text-xs text-blue-200 tracking-widest uppercase font-semibold">TJT / Internal</p><p class="text-[10px] text-gray-400 mt-1">Industrial Engineering</p></div>
            </div>
            <div class="my-auto py-20">
                <p class="text-[#E8BF00] font-semibold tracking-widest mb-3 uppercase text-sm">Dokumen Inisiasi Proyek</p>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 uppercase leading-snug">{{ $detailProyek->nama_projek ?? 'NAMA PROYEK BELUM DIISI' }}</h1>
                <div class="w-20 h-1.5 bg-[#E8BF00]"></div>
            </div>
            <div class="flex justify-between items-end border-t border-white/20 pt-6 mt-auto">
                <div><p class="text-[11px] text-gray-400 uppercase tracking-widest mb-1">Project Initiator</p><p class="font-bold text-white text-base uppercase">{{ $detailProyek->user->name ?? 'Tim Marketing' }}</p></div>
                <div class="text-right"><p class="text-[11px] text-gray-400 uppercase tracking-widest mb-1">Tahun Anggaran</p><p class="font-bold text-white text-base">{{ $detailProyek->created_at ? \Carbon\Carbon::parse($detailProyek->created_at)->format('Y') : date('Y') }}</p></div>
            </div>
        </div>

        {{-- HALAMAN 2: SURAT --}}
        <div class="paper-a4 paper-surat">
            <div class="relative border-b-[3px] border-black pb-4 mb-2 flex items-center">
                <img src="{{ asset('gambar/tjt.png') }}" alt="Logo TJT" class="absolute left-0 w-20 object-contain">
                <div class="w-full text-center pl-24">
                    <h1 class="text-[20px] font-extrabold text-[#003057] uppercase tracking-wide m-0">PT TRI JAYA TEKNIK</h1>
                    <p class="text-[11px] font-bold text-gray-800 mt-1 uppercase m-0">Industrial Engineering & Construction Services</p>
                </div>
            </div>
            <div class="border-b-[1px] border-black mb-8 mt-[-6px]"></div>
            <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
                <div><table style="border: none; margin: 0; width: auto;"><tr><td style="padding:0; width: 70px; border:none;">Nomor</td><td style="padding:0; border:none;">: <strong>{{ $detailProyek->request_no ?? '-' }}</strong></td></tr><tr><td style="padding:0; border:none;">Perihal</td><td style="padding:0; border:none;">: <strong>Pengajuan Inisiasi Dokumen (RAB)</strong></td></tr></table></div>
                <div class="text-right"><p>Karawang, {{ $detailProyek->created_at ? \Carbon\Carbon::parse($detailProyek->created_at)->isoFormat('D MMMM Y') : '-' }}</p></div>
            </div>
            <div class="mb-5"><p class="m-0">Kepada Yth.,<br><strong>Tim Engineering / Estimator</strong><br>PT Tri Jaya Teknik</p></div>
            <div class="mb-4"><p style="margin-bottom: 5px;">Dengan hormat,</p><p style="text-indent: 30px; margin:0;">Berikut ini kami sampaikan data inisiasi request proyek yang telah masuk ke dalam sistem sebagai dasar acuan awal perhitungan estimasi anggaran biaya (RAB):</p></div>
            
            <table class="border border-black w-full text-[13px]">
                <tbody>
                    <tr><td class="border border-black font-bold bg-gray-100 w-[35%]">Instansi / Klien</td><td class="border border-black font-bold uppercase">{{ $detailProyek->nama_pelanggan ?? '-' }}</td></tr>
                    <tr><td class="border border-black font-bold bg-gray-100">Judul Pekerjaan</td><td class="border border-black font-bold uppercase">{{ $detailProyek->nama_projek ?? '-' }}</td></tr>
                    <tr><td class="border border-black font-bold bg-gray-100">Kategori Pekerjaan</td><td class="border border-black capitalize">{{ $detailProyek->category->nama_kategori ?? 'Umum' }}</td></tr>
                    <tr><td class="border border-black font-bold bg-gray-100">Lokasi Proyek</td><td class="border border-black capitalize">{{ $detailProyek->alamat ?: 'Terlampir pada Dokumen RFQ' }}</td></tr>
                    <tr><td class="border border-black font-bold bg-gray-100">Target Waktu</td><td class="border border-black">{{ $detailProyek->target_waktu ? \Carbon\Carbon::parse($detailProyek->target_waktu)->isoFormat('D MMMM Y') : '-' }}</td></tr>
                    
                    {{-- PERBAIKAN LOGIKA CATATAN TAMBAHAN --}}
                    <tr>
                        <td class="border border-black font-bold bg-gray-100 align-top">Catatan Tambahan</td>
                        <td class="border border-black whitespace-pre-line p-2">
                            @if($isManual)
                                {{ $detailProyek->deskripsi_proyek ?: '-' }}
                            @else
                                Spesifikasi detail mengacu penuh pada dokumen RFQ utama yang dilampirkan secara utuh pada dokumen berikutnya.
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-10 flex flex-col md:flex-row justify-between text-center gap-8">
                <div class="w-full md:w-1/2"><p style="margin-bottom: 60px;">Mengetahui,<br><strong>Direktur Utama</strong></p><p class="font-bold uppercase border-b border-black inline-block px-4 pb-1">DIREKSI PT TJT</p></div>
                <div class="w-full md:w-1/2"><p style="margin-bottom: 60px;">Hormat Kami,<br><strong>Divisi Marketing</strong></p><p class="font-bold uppercase border-b border-black inline-block px-4 pb-1">{{ $detailProyek->user->name ?? 'Project Initiator' }}</p></div>
            </div>
        </div>

        {{-- HALAMAN 3+: LAMPIRAN (EMBED LANGSUNG) --}}
        @if($rfq)
            {{-- Kalau RFQ, langsung tempel full satu kertas, tanpa header item-item norak --}}
            <div class="paper-a4" style="background-color: transparent;">
                <iframe src="{{ asset('storage/' . $rfq->file_path) }}#toolbar=0&navpanes=0&scrollbar=0&view=FitH" class="pdf-embed"></iframe>
            </div>
        @else
            {{-- Kalau Manual, lampirin foto-foto dengan rapi --}}
            @php $adaFoto = false; @endphp
            @foreach(['Foto Referensi' => $referensi, 'Foto Lokasi' => $lokasi, 'Drawing Teknik' => $drawing] as $title => $files)
                @if($files && $files->count() > 0)
                @php $adaFoto = true; @endphp
                <div class="paper-a4 paper-surat">
                    <div class="border-b-[3px] border-black pb-2 mb-6"><h2 class="text-lg font-bold uppercase">Lampiran Dokumentasi: {{ $title }}</h2><p class="text-xs text-gray-500 mt-1">{{ $files->count() }} file terlampir</p></div>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($files as $file)
                            <div class="border border-gray-300 p-2 rounded bg-gray-50 text-center shadow-sm">
                                <div class="w-full h-56 flex items-center justify-center bg-gray-200 mb-2 overflow-hidden rounded border border-gray-300"><img src="{{ asset('storage/' . $file->file_path) }}" alt="Lampiran" class="object-contain w-full h-full"></div>
                                <span class="text-[10px] text-gray-700 font-semibold truncate block w-full px-1">{{ $file->file_name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
            
            {{-- Jaga-jaga kalau dia milih manual tapi mager masukin foto --}}
            @if(!$adaFoto)
            <div class="paper-a4 paper-surat flex flex-col items-center justify-center text-gray-400">
                <span class="text-4xl mb-4">📄</span>
                <p class="font-bold">Tidak ada dokumen atau foto teknis yang dilampirkan pada inisiasi ini.</p>
            </div>
            @endif
        @endif

        {{-- HALAMAN PENUTUP --}}
        <div class="paper-a4 paper-cover flex flex-col items-center justify-center text-center">
            <img src="{{ asset('gambar/tjt.png') }}" alt="TJT Logo" class="w-32 object-contain mb-6">
            <h2 class="text-3xl font-extrabold tracking-wider uppercase text-white mb-2">Halaman Penutup</h2>
            <div class="w-16 h-1 bg-[#E8BF00] mb-4"></div>
            <p class="text-sm text-blue-200 max-w-md">Dokumen Inisiasi ini bersifat rahasia dan hanya digunakan untuk keperluan internal PT Tri Jaya Teknik.</p>
            <p class="text-[10px] text-gray-500 mt-24 font-mono">Sistem PPDRAB - Generasi Otomatis Dokumen<br>Waktu Cetak: {{ date('d-m-Y H:i:s') }}</p>
        </div>
    </main>

    <script>
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('detailOverlay')) {
                if (e.key === 'ArrowUp') document.getElementById('detailScrollContainer').scrollBy({top: -300, behavior: 'smooth'});
                if (e.key === 'ArrowDown') document.getElementById('detailScrollContainer').scrollBy({top: 300, behavior: 'smooth'});
                if (e.key === 'Escape') @this.tutupDetail();
            }
        });
    </script>
</div>