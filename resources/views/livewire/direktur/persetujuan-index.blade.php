<div class="min-h-screen bg-[#F8FAFC] p-4 md:p-8 font-sans text-[#0F172A] relative overflow-hidden z-0" style="font-family: 'Inter', sans-serif;">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#4F46E5]/5 rounded-full blur-3xl -z-10 mix-blend-multiply pointer-events-none"></div>
    <div class="absolute bottom-0 left-[-10%] w-[600px] h-[600px] bg-[#818CF8]/5 rounded-full blur-3xl -z-10 mix-blend-multiply pointer-events-none"></div>

    <div class="max-w-7xl mx-auto space-y-6 md:space-y-8 relative z-10">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 md:p-8 rounded-2xl border border-[#E2E8F0] shadow-sm relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-2 bg-gradient-to-b from-[#1E1B4B] to-[#4F46E5]"></div>
            <div>
                <span class="px-3 py-1.5 bg-[#EEF2FF] text-[#4F46E5] text-[10px] font-black uppercase tracking-widest rounded-md border border-[#C7D2FE]">Pusat Otorisasi</span>
                <h1 class="text-2xl md:text-3xl font-black text-[#0F172A] tracking-tight uppercase mt-4">Review & Persetujuan</h1>
                <p class="text-xs text-[#64748B] mt-1.5 font-medium">Pratinjau draf dokumen teknis/komersial sebelum memberikan otorisasi final.</p>
            </div>
        </div>

        @if (session()->has('sukses'))
            <div class="px-6 py-4 bg-[#EEF2FF] text-[#312E81] rounded-xl text-xs font-bold tracking-wide border border-[#C7D2FE] shadow-sm flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-[#4F46E5] animate-ping"></span> {{ session('sukses') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-[#E2E8F0] shadow-sm overflow-hidden">
            <div class="p-6 border-b border-[#E2E8F0] bg-[#1E1B4B] text-white flex justify-between items-center">
                <h3 class="text-xs font-bold uppercase tracking-widest flex items-center gap-3 text-[#EEF2FF]">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#818CF8] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#818CF8]"></span>
                    </span>
                    Antrean Proyek Membutuhkan Tinjauan
                </h3>
            </div>

            <div class="overflow-x-auto p-0 md:p-4">
                <table class="w-full text-left text-xs whitespace-nowrap min-w-[800px]">
                    <thead class="bg-[#F8FAFC] text-[#64748B] uppercase font-bold tracking-widest border-b border-[#E2E8F0]">
                        <tr>
                            <th class="px-6 py-4">No. Referensi</th>
                            <th class="px-6 py-4">Instansi / Klien</th>
                            <th class="px-6 py-4 text-center">Status Dokumen</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9]">
                        @forelse($proyekPending as $proyek)
                            @php
                                $rabCount = $proyek->rabs()->where('status_rab', 'pending')->count();
                                $biddingCount = $proyek->biddings()->where('status_bidding', 'pending')->count();
                            @endphp
                            <tr class="hover:bg-[#F8FAFC] transition-colors duration-200">
                                <td class="px-6 py-5 font-mono font-bold text-[#475569]">{{ $proyek->request_no }}</td>
                                <td class="px-6 py-5 font-black text-[#0F172A] uppercase">{{ $proyek->nama_pelanggan }}</td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($rabCount > 0) 
                                            <span class="px-3 py-1.5 bg-[#EEF2FF] text-[#4F46E5] text-[9px] font-bold rounded-md uppercase border border-[#C7D2FE]">RAB Pending</span> 
                                        @endif
                                        @if($biddingCount > 0) 
                                            <span class="px-3 py-1.5 bg-[#F1F5F9] text-[#475569] text-[9px] font-bold rounded-md uppercase border border-[#CBD5E1]">Bidding Pending</span> 
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <button wire:click="bukaProyek({{ $proyek->id }})" wire:loading.attr="disabled" class="px-6 py-2.5 bg-[#1E1B4B] hover:bg-[#312E81] text-white font-bold text-[10px] tracking-widest rounded-lg transition-colors shadow-sm w-48 focus:outline-none focus:ring-2 focus:ring-[#818CF8]">
                                        BUKA MAP DOKUMEN
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center text-[#64748B] font-bold bg-[#F8FAFC] border-y border-dashed border-[#CBD5E1]">
                                    Belum ada dokumen proyek yang mengantre untuk diperiksa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>