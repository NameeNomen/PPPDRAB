<div class="fixed inset-0 z-[100] bg-[#323639] flex flex-col" id="detailOverlay">
    
    <header class="flex-none bg-[#1E1E1E] border-b border-black p-3 flex justify-between items-center shadow-md z-50 print:hidden">
        <div class="flex items-center gap-4">
            <button wire:click="tutupDetail" class="text-xs font-semibold text-gray-300 hover:text-white hover:bg-white/10 px-3 py-2 rounded transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </button>
            <div class="h-5 w-px bg-gray-600"></div>
            <h1 class="text-sm font-bold text-gray-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Preview Dokumen Inisiasi
            </h1>
        </div>
        
        <div class="flex items-center gap-4">
            <p class="text-[10px] text-gray-400 font-mono bg-black/30 px-2 py-1 rounded border border-gray-700" title="Nomor Request">
                {{ $detailProyek->request_no ?? '-' }}
            </p>
            <button onclick="window.print()" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 px-4 py-2 rounded text-xs font-bold flex items-center gap-2 transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg> 
                Cetak PDF
            </button>
        </div>
    </header>

    <style>
        /* Latar belakang viewer gelap biar kertas A4 di dalem include jadi fokus utama */
        .modal-scroll { overflow-y: auto; overflow-x: hidden; flex: 1; padding: 40px 0; background-color: #323639; }
        
        /* Kustomisasi Scrollbar biar elegan */
        .modal-scroll::-webkit-scrollbar { width: 14px; }
        .modal-scroll::-webkit-scrollbar-track { background: #1E1E1E; }
        .modal-scroll::-webkit-scrollbar-thumb { background: #555; border-radius: 7px; border: 4px solid #1E1E1E; }
        .modal-scroll::-webkit-scrollbar-thumb:hover { background: #777; }

        /* Logic Printing: Sembunyikan bingkai hitam, cuma print kertasnya aja */
        @media print {
            body * { visibility: hidden; }
            #detailScrollContainer, #detailScrollContainer * { visibility: visible; }
            #detailScrollContainer { position: absolute; left: 0; top: 0; padding: 0; background: transparent; overflow: visible; }
        }
    </style>

    <main class="modal-scroll" id="detailScrollContainer">
        
        @include('components.dokumen-inisiasi', ['proyek' => $detailProyek])

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