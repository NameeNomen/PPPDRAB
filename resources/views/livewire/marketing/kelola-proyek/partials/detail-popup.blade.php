<div class="fixed inset-0 z-[100] bg-[#323639] flex flex-col transition-colors duration-300" id="detailOverlay">
    
    <!-- HEADER NAVBAR OVERLAY -->
    <header class="flex-none p-4 flex justify-between items-center shadow-lg z-50 print:hidden transition-colors border-b-2"
            :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
        
        <!-- Bagian Kiri: Tombol Kembali & Judul -->
        <div class="flex items-center gap-4">
            <button wire:click="tutupDetail" class="group text-xs font-bold px-4 py-2.5 rounded-lg transition-all border-2 shadow-sm flex items-center gap-2"
                    :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#F5C518] hover:border-[#F5C518] hover:bg-[#F5C518]/10' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A] hover:border-[#F5C518] hover:bg-[#F5C518]/10'">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                KEMBALI
            </button>
            
            <div class="w-px h-6 transition-colors" :class="darkMode ? 'bg-[#333333]' : 'bg-[#E5E5E5]'"></div>
            
            <h1 class="text-sm font-black flex items-center gap-2 uppercase tracking-widest transition-colors" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">
                <svg class="w-4 h-4 text-[#F5C518]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Preview Dokumen Inisiasi
            </h1>
        </div>
        
        <!-- Bagian Kanan: Info & Cetak -->
        <div class="flex items-center gap-3">
            <p class="text-[10px] font-mono px-3 py-2 rounded-md border-2 font-bold shadow-inner tracking-wider transition-colors" 
               :class="darkMode ? 'bg-[#1A1A1A] border-[#333333] text-[#888888]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#666666]'" 
               title="Nomor Request">
                REF: {{ $detailProyek->request_no ?? '-' }}
            </p>
            
            <button onclick="window.print()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-xs font-bold uppercase tracking-wide rounded-lg transition-all shadow-md text-[#1A1A1A] bg-[#F5C518] hover:bg-[#FFD700] hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-[#F5C518]/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg> 
                CETAK PDF
            </button>
        </div>
    </header>

    <style>
        /* Latar belakang viewer gelap biar kertas A4 di dalem jadi fokus utama */
        .modal-scroll { overflow-y: auto; overflow-x: hidden; flex: 1; padding: 40px 0; background-color: #323639; }
        
        /* Kustomisasi Scrollbar */
        .modal-scroll::-webkit-scrollbar { width: 14px; }
        .modal-scroll::-webkit-scrollbar-track { background: #1E1E1E; }
        .modal-scroll::-webkit-scrollbar-thumb { background: #555; border-radius: 7px; border: 4px solid #1E1E1E; }
        .modal-scroll::-webkit-scrollbar-thumb:hover { background: #777; }

        /* Logic Printing: Biar pas dicetak murni ukuran kertas aja */
        @media print {
            body * { visibility: hidden; }
            #detailScrollContainer, #detailScrollContainer * { visibility: visible; }
            #detailScrollContainer { position: absolute; left: 0; top: 0; padding: 0; background: transparent; overflow: visible; display: block; }
            .kertas-print { margin: 0 !important; padding: 0 !important; box-shadow: none !important; max-width: 100% !important; width: 100% !important; border: none !important; }
        }
    </style>

    <!-- AREA SCROLL UTAMA -->
    <main class="modal-scroll flex justify-center" id="detailScrollContainer">
        
        <!-- KERTAS A4 VIRTUAL -->
        <div class="kertas-print bg-white shadow-2xl w-[210mm] min-h-[297mm] p-[10mm] text-black my-8" style="font-family: 'Arial', sans-serif;">
            
            <!-- KOP SURAT FORMAL PERSIS SEPERTI GAMBAR REFERENSI LU -->
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

            <!-- ISI DOKUMEN INISIASI DARI COMPONENT LU -->
            <div class="w-full">
                @include('components.dokumen-inisiasi', ['proyek' => $detailProyek])
            </div>
            
        </div>

    </main>

    <script>
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('detailOverlay')) {
                if (e.key === 'ArrowUp') document.getElementById('detailScrollContainer').scrollBy({top: -300, behavior: 'smooth'});
                if (e.key === 'ArrowDown') document.getElementById('detailScrollContainer').scrollBy({top: 300, behavior: 'smooth'});
                if (e.key === 'Escape') {
                    @this.tutupDetail();
                }
            }
        });
    </script>
</div>