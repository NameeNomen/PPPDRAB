<div class="min-h-screen bg-[#E89154]/5 p-4 md:p-8 font-sans text-[#2A0001] relative overflow-hidden z-0">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#DA7134]/10 rounded-full blur-3xl -z-10 mix-blend-multiply"></div>
    <div class="absolute bottom-0 left-[-10%] w-[600px] h-[600px] bg-[#E89154]/10 rounded-full blur-3xl -z-10 mix-blend-multiply"></div>

    <div class="max-w-7xl mx-auto space-y-6 md:space-y-8 relative z-10">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/70 backdrop-blur-xl p-6 md:p-8 rounded-[2rem] border border-[#DA7134]/20 shadow-xl shadow-[#DA7134]/5 relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-2 bg-gradient-to-b from-[#852616] to-[#DA7134]"></div>
            <div>
                <span class="px-3 py-1 bg-[#DA7134]/10 text-[#852616] text-[10px] font-black uppercase tracking-widest rounded-xl border border-[#DA7134]/20">Pusat Otorisasi</span>
                <h1 class="text-2xl md:text-3xl font-black text-[#2A0001] tracking-tight uppercase mt-3">Review & Persetujuan</h1>
                <p class="text-xs text-[#852616]/80 mt-1.5 font-bold">Pratinjau draf dokumen cetak (PDF) sebelum memberikan otorisasi final.</p>
            </div>
        </div>

        @if (session()->has('sukses'))
            <div class="px-6 py-4 bg-[#DA7134]/10 backdrop-blur-md text-[#852616] rounded-2xl text-xs font-black tracking-wide border border-[#DA7134]/30 shadow-lg flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-[#852616] animate-ping"></span> {{ session('sukses') }}
            </div>
        @endif

        <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] border border-[#DA7134]/20 shadow-xl overflow-hidden">
            <div class="p-6 border-b border-[#DA7134]/20 bg-gradient-to-r from-[#2A0001] to-[#852616] text-white flex justify-between items-center">
                <h3 class="text-xs font-black uppercase tracking-widest flex items-center gap-3 text-[#E89154]">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#E89154] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#E89154]"></span>
                    </span>
                    Antrean Proyek Membutuhkan Tinjauan
                </h3>
            </div>
            
            <div class="overflow-x-auto p-4">
                <table class="w-full text-left text-xs whitespace-nowrap min-w-[800px]">
                    <thead class="bg-[#E89154]/10 text-[#852616] uppercase font-black tracking-widest">
                        <tr>
                            <th class="px-5 py-4 rounded-l-2xl">No. Referensi</th>
                            <th class="px-5 py-4">Instansi / Klien</th>
                            <th class="px-5 py-4 text-center">Status Dokumen</th>
                            <th class="px-5 py-4 text-center rounded-r-2xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#DA7134]/10">
                        @forelse($proyekPending as $proyek)
                            @php
                                $rabCount = $proyek->rabs()->where('status_rab', 'pending')->count();
                                $biddingCount = $proyek->biddings()->where('status_bidding', 'pending')->count();
                            @endphp
                            <tr class="hover:bg-[#E89154]/10 transition-all duration-200 group">
                                <td class="px-5 py-5 font-mono font-bold text-[#852616]">{{ $proyek->request_no }}</td>
                                <td class="px-5 py-5 font-black text-[#2A0001] uppercase">{{ $proyek->nama_pelanggan }}</td>
                                <td class="px-5 py-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($rabCount > 0) <span class="px-3 py-1 bg-[#852616]/10 text-[#852616] text-[9px] font-black rounded-xl uppercase border border-[#852616]/20">RAB Pending</span> @endif
                                        @if($biddingCount > 0) <span class="px-3 py-1 bg-[#DA7134]/15 text-[#852616] text-[9px] font-black rounded-xl uppercase border border-[#DA7134]/30">Bidding Pending</span> @endif
                                    </div>
                                </td>
                                <td class="px-5 py-5 text-center">
                                    <button wire:click="bukaProyek({{ $proyek->id }})" wire:loading.attr="disabled" class="px-6 py-2.5 bg-[#2A0001] hover:bg-[#852616] hover:-translate-y-0.5 text-white font-bold text-[10px] tracking-widest rounded-xl transition-all duration-300 shadow-lg w-48">
                                        BUKA MAP DOKUMEN
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-16 text-center text-[#852616]/60 font-bold bg-white/50 rounded-2xl mt-4 block border-2 border-dashed border-[#DA7134]/20">Belum ada dokumen proyek yang mengantre untuk diperiksa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>