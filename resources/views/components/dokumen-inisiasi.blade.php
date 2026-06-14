@php
    // Ambil data lampiran dari relasi proyek
    $rfq = $proyek->attachments->where('attachment_category', 'proposal')->first();
    $referensi = $proyek->attachments->where('attachment_category', 'reference_image');
    $lokasi = $proyek->attachments->where('attachment_category', 'location_photo');
    $drawing = $proyek->attachments->where('attachment_category', 'technical_drawing');
    $isManual = $proyek->requires_site_survey ?? false; 
@endphp

<style>
    .paper-a4 { 
        background-color: white; 
        width: 210mm; 
        min-height: 297mm; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
        display: flex; 
        flex-direction: column; 
        position: relative; 
        overflow: hidden; 
        margin: 0 auto; 
    }
    .paper-cover { 
        background: linear-gradient(135deg, #003057 0%, #001224 100%); 
        color: white; 
        padding: 60px 50px; 
    }
    .paper-surat { 
        padding: 50px 45px; 
        font-size: 13px; 
        color: #000; 
        text-align: justify; 
        line-height: 1.6; 
    }
    .paper-surat table { 
        width: 100%; 
        border-collapse: collapse; 
        font-size: 12px; 
        margin: 12px 0; 
    }
    .paper-surat table td { 
        padding: 7px 9px; 
        border: 1px solid #333; 
        color: #000; 
    }
    .pdf-embed { 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        border: none; 
    }
</style>

<div class="flex flex-col gap-8 w-full items-center">
    
    <!-- COVER DEPAN -->
    <div class="paper-a4 paper-cover" style="zoom: 0.7;">
        <div class="flex justify-between items-start">
            <img src="{{ asset('gambar/tjt.png') }}" alt="TJT" class="w-24 object-contain">
            <div class="text-right">
                <p class="text-xs text-blue-200 tracking-widest uppercase font-semibold">TJT / Internal</p>
                <p class="text-[10px] text-gray-400 mt-1">Industrial Engineering</p>
            </div>
        </div>
        <div class="my-auto py-20">
            <p class="text-yellow-400 font-semibold tracking-widest mb-3 uppercase text-sm">Dokumen Inisiasi Proyek</p>
            <h1 class="text-4xl font-extrabold text-white mb-4 uppercase leading-snug">{{ $proyek->nama_projek ?? 'NAMA PROYEK' }}</h1>
            <div class="w-20 h-1.5 bg-yellow-400"></div>
        </div>
        <div class="flex justify-between items-end border-t border-white/20 pt-6 mt-auto">
            <div>
                <p class="text-[11px] text-gray-400 uppercase tracking-widest mb-1">Project Initiator</p>
                <p class="font-bold text-white text-base uppercase">{{ $proyek->user->name ?? 'Tim Marketing' }}</p>
            </div>
            <div class="text-right">
                <p class="text-[11px] text-gray-400 uppercase tracking-widest mb-1">Tanggal Request</p>
                <p class="font-bold text-white text-base">{{ $proyek->created_at ? \Carbon\Carbon::parse($proyek->created_at)->format('d/m/Y') : date('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <!-- HALAMAN SURAT INISIASI -->
    <div class="paper-a4 paper-surat" style="zoom: 0.7;">
        
        <!-- KOP SURAT FORMAL RESMI (Sama Kayak RAB) -->
        <div class="grid grid-cols-[120px_1fr_120px] w-full border-2 border-black mb-8">
            <!-- Logo Kiri -->
            <div class="border-r-2 border-black p-2 flex items-center justify-center">
                <img src="{{ asset('gambar/tjt.png') }}" class="w-full object-contain" alt="TJT Logo" onerror="this.style.display='none'">
            </div>
            
            <!-- Teks Tengah -->
            <div class="p-2 flex flex-col items-center justify-center text-center">
                <h1 class="m-0 text-[#00CC00] text-2xl font-black tracking-wider" style="text-shadow: 1px 1px 0 #000;">
                    PT. TRI JAYA TEKNIK KARAWANG
                </h1>
                <h2 class="m-0 mt-1 text-xs font-bold text-black uppercase">
                    MACHINING, STAMPING, FABRICATION,<br>CONSTRUCTION, AND CIVIL WORK
                </h2>
                <p class="m-0 text-[9px] font-bold text-black mt-1">
                    JL. Alternatif Krajan II Warung Bambu - Karawang Timur<br>
                    Telp. (0267) 8615387 Fax: (0267) 8615386 Email: pt.tjtk@yahoo.com
                </p>
            </div>
            
            <!-- Logo Kanan -->
            <div class="border-l-2 border-black p-2 flex items-center justify-center">
                <img src="{{ asset('gambar/iso.png') }}" class="w-full object-contain" alt="ISO Logo" onerror="this.style.display='none'">
            </div>
        </div>
        
        <div class="mb-5">
            <p class="m-0">Kepada Yth.,<br><strong>Tim Engineering / Estimator</strong><br>PT Tri Jaya Teknik</p>
        </div>
        
        <div class="mb-6 text-justify">
            <p class="mb-4">Dengan hormat,</p>
            <p class="mb-3" style="text-indent: 30px;">
                Sehubungan dengan adanya permintaan penawaran kerja sama dan inisiasi proyek baru dari pihak klien, bersama dokumen ini kami dari Divisi Marketing meneruskan data spesifikasi teknis beserta rekapitulasi kebutuhan awal proyek.
            </p>
            <p class="mb-4" style="text-indent: 30px;">
                Dokumen ini diterbitkan secara resmi melalui sistem untuk digunakan sebagai acuan dasar <i>(Terms of Reference)</i> bagi Tim Engineering dalam melakukan kalkulasi teknis, analisis kebutuhan material, serta penyusunan Rencana Anggaran Biaya (RAB) yang komprehensif.
            </p>
            <p>Adapun rincian kerangka kerja dan identitas proyek tersebut adalah sebagai berikut:</p>
        </div>

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
                    <td class="border border-black font-bold bg-gray-100">Target Waktu</td>
                    <td class="border border-black">{{ $proyek->target_waktu ? \Carbon\Carbon::parse($proyek->target_waktu)->isoFormat('D MMMM Y') : '-' }}</td>
                </tr>
                <tr>
                    <td class="border border-black font-bold bg-gray-100 align-top">Spesifikasi & Catatan</td>
                    <td class="border border-black whitespace-pre-line p-2">
                        @if($isManual) 
                            {{ $proyek->deskripsi_proyek ?: '-' }} 
                        @else 
                            Detail spesifikasi teknis mengacu sepenuhnya pada dokumen lampiran (RFQ) yang disertakan pada halaman berikutnya. 
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-10 flex justify-end text-center">
            <div class="w-1/2">
                <p style="margin-bottom: 60px;">Hormat Kami,<br><strong>Divisi Marketing</strong></p>
                <p class="font-bold uppercase border-b border-black inline-block px-4 pb-1">{{ $proyek->user->name ?? 'Initiator' }}</p>
            </div>
        </div>
    </div>

    <!-- HALAMAN LAMPIRAN RFQ PDF -->
    @if($rfq)
        <div class="paper-a4" style="zoom: 0.7; background-color: #f0f0f0;">
            <iframe src="{{ asset('storage/' . $rfq->file_path) }}#toolbar=0&navpanes=0&scrollbar=0&view=FitH" class="pdf-embed"></iframe>
        </div>
    @else
        <!-- HALAMAN FOTO LAMPIRAN -->
        <div class="paper-a4 paper-surat" style="zoom: 0.7;">
            <div class="border-b-[3px] border-black pb-2 mb-6">
                <h2 class="text-lg font-bold uppercase">Lampiran Dokumentasi Pendukung</h2>
            </div>
            
            @php $adaFoto = false; @endphp
            
            @foreach(['Foto Referensi' => $referensi, 'Foto Lokasi' => $lokasi, 'Drawing / Sketsa' => $drawing] as $title => $files)
                @if($files && $files->count() > 0)
                    @php $adaFoto = true; @endphp
                    <h3 class="font-bold mb-2 uppercase tracking-wide border-b border-gray-300 pb-1">{{ $title }}</h3>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        @foreach($files as $file)
                            <div class="border border-gray-300 p-2 rounded bg-gray-50 text-center shadow-sm">
                                <div class="w-full h-48 flex items-center justify-center bg-gray-200 mb-2 overflow-hidden border border-gray-300">
                                    <img src="{{ asset('storage/' . $file->file_path) }}" alt="Lampiran" class="object-contain w-full h-full">
                                </div>
                                <span class="text-[10px] text-gray-700 font-semibold truncate block w-full px-1" title="{{ $file->file_name }}">
                                    {{ $file->file_name }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
            
            @if(!$adaFoto)
                <div class="flex flex-col items-center justify-center text-gray-400 h-64 border-2 border-dashed border-gray-300 rounded-lg mt-10">
                    <span class="text-4xl mb-4">📄</span>
                    <p class="font-bold uppercase tracking-wider text-sm">Tidak ada dokumen teknis yang dilampirkan.</p>
                </div>
            @endif
        </div>
    @endif
    
    <!-- HALAMAN PENUTUP -->
    <div class="paper-a4 paper-cover flex flex-col items-center justify-center text-center" style="zoom: 0.7;">
        <img src="{{ asset('gambar/tjt.png') }}" alt="TJT Logo" class="w-32 object-contain mb-6">
        <h2 class="text-3xl font-extrabold tracking-wider uppercase text-white mb-2">Halaman Penutup</h2>
        <div class="w-16 h-1 bg-yellow-400 mb-4"></div>
        <p class="text-sm text-blue-200 max-w-md">Dokumen Inisiasi ini bersifat rahasia dan hanya digunakan untuk keperluan internal PT Tri Jaya Teknik.</p>
        <p class="text-[10px] text-gray-500 mt-24 font-mono">
            Sistem Dokumen Otomatis PPDRAB<br>
            Dicetak: {{ date('d-m-Y H:i:s') }}
        </p>
    </div>

</div>