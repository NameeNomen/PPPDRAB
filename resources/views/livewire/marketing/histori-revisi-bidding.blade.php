<div class="min-h-screen p-4 md:p-8 bg-[#FAEEF5] font-sans text-[#5C5470]">
    <div class="max-w-6xl mx-auto">

        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-[#B2A4FF]/10 mb-8 flex justify-between items-center">
            <div>
                <span class="px-3 py-1 text-[10px] font-extrabold text-[#B2A4FF] bg-[#B2A4FF]/10 rounded-full uppercase tracking-widest">
                    {{ $view === 'project-list' ? 'Dashboard Arsip' : ($view === 'bidding-list' ? 'Daftar Versi' : 'Detail Dokumen') }}
                </span>
                <h1 class="text-2xl font-black text-gray-800 tracking-tight mt-3">
                    {{ $view === 'project-list' ? 'Histori Revisi & Otorisasi' : ($selectedProject->nama_pelanggan ?? 'Detail') }}
                </h1>
            </div>
            @if($view !== 'project-list')
                <button wire:click="goBack" class="px-5 py-2.5 text-xs font-bold text-gray-400 hover:text-[#B2A4FF] transition-colors cursor-pointer">← KEMBALI</button>
            @endif
        </div>

        @if($view === 'project-list')
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($projects as $proj)
                    <div wire:click="showBiddings({{ $proj->id }})" class="bg-white p-8 rounded-[2rem] border border-pink-50 hover:border-[#B2A4FF] hover:shadow-xl transition-all cursor-pointer group">
                        <h3 class="text-lg font-black text-gray-800 group-hover:text-[#B2A4FF]">{{ $proj->nama_pelanggan }}</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">REF: {{ $proj->request_no }}</p>
                        <div class="mt-6 px-3 py-1 bg-indigo-50 text-indigo-600 w-fit text-[10px] font-black rounded-lg uppercase">
                            {{ $proj->biddings->count() }} Versi Bidding
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center py-20 font-bold text-gray-400">Belum ada proyek yang memiliki data bidding.</p>
                @endforelse
            </div>

        @elseif($view === 'bidding-list')
            <div class="bg-white rounded-[2rem] shadow-sm border border-pink-50 overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#FAEEF5]/50 text-[#B2A4FF] text-[10px] uppercase font-black tracking-widest">
                        <tr><th class="px-8 py-5">Versi</th><th class="px-8 py-5">No. Penawaran</th><th class="px-8 py-5 text-right">Nilai Akhir</th><th class="px-8 py-5 text-center">Aksi</th></tr>
                    </thead>
                    <tbody class="divide-y divide-[#FAEEF5]">
                        @foreach($biddings as $index => $b)
                            <tr class="hover:bg-pink-50/20 transition-all">
                                <td class="px-8 py-5 font-black text-[#B2A4FF]">V{{ $loop->iteration }}</td>
                                <td class="px-8 py-5 font-mono font-bold text-gray-700">{{ $b->no_penawaran }}</td>
                                <td class="px-8 py-5 font-bold text-right text-gray-800">Rp {{ number_format($b->total_penawaran, 0, ',', '.') }}</td>
                                <td class="px-8 py-5 text-center">
                                    <button wire:click="showDetail({{ $b->id }})" class="px-5 py-2 bg-[#B2A4FF] hover:bg-[#9B8CFF] text-white font-bold text-[10px] rounded-xl transition-all">LIHAT DETAIL</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 bg-white p-4 rounded-[2rem] shadow-sm border border-pink-50 h-[700px] flex flex-col">
                    <div class="flex justify-between items-center px-4 py-3">
                        <h4 class="text-xs font-black text-[#B2A4FF] uppercase tracking-widest">Preview: {{ $selectedBidding->no_penawaran }}</h4>
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black rounded-lg">DOKUMEN: {{ $selectedBidding->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex-grow bg-gray-50 rounded-2xl overflow-hidden mt-2 border border-gray-100">
                        <iframe src="{{ route('cetak.bidding', $selectedBidding->id) }}#toolbar=0&navpanes=0" class="w-full h-full border-none"></iframe>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-pink-50 space-y-6">
                        <h2 class="text-[10px] font-black uppercase tracking-widest text-[#B2A4FF] border-b border-pink-50 pb-2">Informasi Dokumen</h2>
                        <div class="space-y-4">
                            <div><p class="text-[9px] font-bold text-gray-400 uppercase">Perusahaan</p><p class="text-sm font-bold text-gray-800">{{ $selectedBidding->nama_perusahaan }}</p></div>
                            <div><p class="text-[9px] font-bold text-gray-400 uppercase">No. Penawaran</p><p class="font-mono text-sm font-bold text-[#B2A4FF]">{{ $selectedBidding->no_penawaran }}</p></div>
                            <div><p class="text-[9px] font-bold text-gray-400 uppercase">Nilai Total</p><p class="text-lg font-black text-gray-800">Rp {{ number_format($selectedBidding->total_penawaran, 0, ',', '.') }}</p></div>
                        </div>
                    </div>

                    <div class="bg-indigo-50/50 p-8 rounded-[2rem] border border-indigo-100 space-y-4">
                        <h2 class="text-[10px] font-black uppercase tracking-widest text-indigo-400 border-b border-indigo-100 pb-2">Jejak Perubahan</h2>
                        
                        <div>
                            <p class="text-[9px] font-bold text-gray-400 uppercase">Created By:</p>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="w-6 h-6 rounded-full bg-indigo-500 text-white flex items-center justify-center text-[10px] font-bold">
                                    {{ substr($selectedBidding->documentCommits->last()->user_name ?? 'S', 0, 1) }}
                                </div>
                                <p class="text-sm font-black text-gray-800">{{ $selectedBidding->documentCommits->last()->user_name ?? 'Sistem' }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[9px] font-bold text-gray-400 uppercase">Komentar Revisi:</p>
                            <p class="text-xs font-medium text-gray-700 italic bg-white p-4 rounded-xl border border-indigo-100 mt-1">
                                "{{ $selectedBidding->documentCommits->last()->komentar_commit ?? 'Tidak ada catatan revisi.' }}"
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('cetak.bidding', $selectedBidding->id) }}" target="_blank" class="block w-full text-center py-4 bg-gradient-to-r from-[#B2A4FF] to-[#9B8CFF] hover:to-[#8a7af0] text-white font-black text-xs rounded-2xl shadow-lg transition-all">CETAK DOKUMEN (PDF)</a>
                </div>
            </div>
        @endif
    </div>
</div>