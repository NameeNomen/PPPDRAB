<div class="min-h-screen p-4 md:p-8 bg-[#FAEEF5] font-sans text-[#5C5470]">
    <div class="max-w-7xl mx-auto">
        
        <!-- HEADER LILAC-PINK -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8 bg-white p-6 rounded-3xl shadow-[0_8px_30px_-4px_rgba(178,164,255,0.15)] border border-[#B2A4FF]/10">
            <div>
                <span class="px-3 py-1 text-[10px] font-extrabold text-[#B2A4FF] bg-[#B2A4FF]/10 rounded-full uppercase tracking-widest">
                    Layanan Marketing & Penawaran
                </span>
                <h1 class="text-2xl md:text-3xl font-black text-gray-800 tracking-tight mt-3">Dokumen Bidding</h1>
                <p class="text-xs md:text-sm text-gray-500 mt-1 font-medium">Kelola surat penawaran harga dan otorisasi klien.</p>
            </div>
            
            <button wire:click="bukaModal" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-[#B2A4FF] to-[#9B8CFF] hover:to-[#8a7af0] text-white text-xs font-bold rounded-xl shadow-lg shadow-[#B2A4FF]/30 transition-all duration-300 w-full md:w-auto cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                BUAT PENAWARAN BARU
            </button>
        </div>

        <!-- SEARCH & FILTER -->
        <div class="mb-6 flex flex-col md:flex-row gap-4 justify-between items-center bg-white p-4 rounded-2xl shadow-[0_4px_15px_-4px_rgba(178,164,255,0.1)] border border-pink-50">
            <div class="w-full md:w-1/3 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-[#B2A4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari PT atau No Surat..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border-transparent focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl transition-all text-sm font-medium text-gray-700">
            </div>
            <div class="w-full md:w-1/4">
                <select wire:model.live="filterStatus" class="w-full px-4 py-2 bg-gray-50 border-transparent focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl transition-all text-sm font-bold text-[#5C5470] uppercase tracking-wider text-[11px] cursor-pointer appearance-none">
                    <option value="">Semua Status</option>
                    <option value="draft">Draft</option>
                    <option value="sent">Menunggu / Sent</option>
                    <option value="approved">Disetujui</option>
                    <option value="won">Tembus (Won)</option>
                    <option value="rejected">Ditolak / Revisi</option>
                </select>
            </div>
        </div>

        @if (session()->has('sukses'))
            <div class="max-w-7xl mx-auto mb-6 p-4 bg-white border border-[#B2A4FF]/30 text-[#8a7af0] rounded-2xl text-sm font-bold flex items-center gap-3 shadow-[0_4px_15px_-4px_rgba(178,164,255,0.2)]">
                <svg class="w-5 h-5 text-[#B2A4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('sukses') }}
            </div>
        @endif

        <!-- TABEL DATA -->
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_-4px_rgba(178,164,255,0.15)] border border-pink-50 overflow-hidden mb-6">
            <div class="overflow-x-auto p-2">
                <table class="w-full text-left text-sm text-[#5C5470] min-w-[900px]">
                    <thead>
                        <tr>
                            <th class="px-6 py-5 bg-[#FAEEF5]/50 text-[#B2A4FF] font-extrabold text-xs tracking-widest uppercase rounded-l-2xl">No. Penawaran</th>
                            <th class="px-6 py-5 bg-[#FAEEF5]/50 text-[#B2A4FF] font-extrabold text-xs tracking-widest uppercase">Klien / Proyek</th>
                            <th class="px-6 py-5 bg-[#FAEEF5]/50 text-[#B2A4FF] font-extrabold text-xs tracking-widest uppercase text-right">Nilai Penawaran</th>
                            <th class="px-6 py-5 bg-[#FAEEF5]/50 text-[#B2A4FF] font-extrabold text-xs tracking-widest uppercase text-center">Status</th>
                            <th class="px-6 py-5 bg-[#FAEEF5]/50 text-[#B2A4FF] font-extrabold text-xs tracking-widest uppercase text-center rounded-r-2xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#FAEEF5]">
                        @forelse($daftarBidding as $b)
                            <tr class="hover:bg-pink-50/40 transition-colors duration-200 group">
                                <td class="px-6 py-5 font-mono font-bold text-[#B2A4FF] text-xs">{{ $b->no_penawaran }}</td>
                                <td class="px-6 py-5">
                                    <div class="font-bold text-gray-800 text-base group-hover:text-[#B2A4FF] transition-colors">{{ $b->nama_perusahaan }}</div>
                                    <div class="text-xs text-gray-400 mt-1 font-medium flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        <span>Proyek: {{ $b->project->nama_pelanggan ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 font-bold text-gray-800 text-right">
                                    Rp {{ number_format($b->total_penawaran, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($b->status_bidding == 'draft')
                                    <span class="px-3 py-1.5 bg-gray-100 text-gray-500 border border-gray-200 text-[10px] font-bold tracking-wide rounded-full uppercase flex items-center justify-center gap-1.5">
                                        @if($b->documentCommits()->where('jenis_aksi', 'revised')->exists())
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                        @endif
                                        DRAFT
                                    </span>
                               
                                    @elseif($b->status_bidding == 'sent')
                                        <span class="px-3 py-1.5 bg-[#FFDEB4]/30 text-amber-600 border border-[#FFDEB4] text-[10px] font-bold tracking-wide rounded-full uppercase">TERKIRIM</span>
                                    @elseif($b->status_bidding == 'approved' || $b->status_bidding == 'won')
                                        <span class="px-3 py-1.5 bg-[#C8B6FF]/20 text-[#C8B6FF] border border-[#C8B6FF]/30 text-[10px] font-bold tracking-wide rounded-full uppercase">{{ $b->status_bidding == 'won' ? 'WON' : 'DISETUJUI' }}</span>
                                    @else
                                        <span class="px-3 py-1.5 bg-[#FFB4B4]/20 text-[#FFB4B4] border border-[#FFB4B4]/30 text-[10px] font-bold tracking-wide rounded-full uppercase">{{ $b->status_bidding }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- LOGIKA TOMBOL ARSIP VS REVISI -->
                                        @if($b->status_bidding == 'approved' || $b->status_bidding == 'won')
                                            <a href="{{ route('marketing.bidding.histori', ['bidding_id' => $b->id]) }}" wire:navigate class="p-2 text-indigo-500 hover:text-white hover:bg-indigo-500 rounded-lg transition-colors border border-indigo-100 cursor-pointer flex items-center justify-center shadow-sm" title="Arsip: Lihat di Histori Bidding">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </a>
                                        @else
                                            <button wire:click="lihatRevisi({{ $b->id }})" class="p-2 text-sky-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors border border-sky-100 cursor-pointer" title="Cek Komentar & Revisi">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                            </button>
                                        @endif
                                        
                                        <!-- TOMBOL CETAK -->
                                        @if($b->status_bidding == 'approved' || $b->status_bidding == 'won')
                                            <a href="{{ route('cetak.bidding', $b->id) }}" target="_blank" class="p-2 text-emerald-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors border border-emerald-100 cursor-pointer" title="Cetak PDF">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            </a>
                                        @else
                                            <button disabled title="Belum Disetujui" class="p-2 text-gray-300 bg-gray-50 rounded-lg border border-gray-100 cursor-not-allowed">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center font-bold text-gray-500">Belum ada dokumen bidding yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{ $daftarBidding->links() }}
        </div>

        <!-- MODAL FORM TAMBAH/EDIT UX TINGKAT DEWA -->
        @if($isModalOpen)
            <div class="fixed inset-0 z-[100] bg-gray-900/60 backdrop-blur-md flex items-center justify-center p-2 md:p-4 transition-all duration-300">
                <div class="bg-[#FAEEF5] rounded-[2rem] shadow-[0_20px_60px_rgba(178,164,255,0.3)] w-[95vw] h-[95vh] flex flex-col border border-white overflow-hidden">
                    
                    <!-- HEADER MODAL -->
                    <div class="px-8 py-5 border-b border-white bg-white/50 flex justify-between items-center sticky top-0 z-10 backdrop-blur-xl">
                        <div>
                            <h3 class="text-xl font-black text-[#5C5470]">{{ $isEdit ? 'Edit Dokumen Penawaran' : 'Buat Penawaran Baru' }}</h3>
                            <p class="text-[11px] text-gray-500 mt-1 font-bold uppercase tracking-wider">Lengkapi form dan jadikan PDF RAB di sebelah kanan sebagai acuan.</p>
                        </div>
                        <button wire:click="tutupModal" class="w-10 h-10 rounded-full bg-white text-gray-400 hover:text-rose-400 hover:shadow-md flex items-center justify-center cursor-pointer transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    
                    <!-- BODY 40/60 -->
                    <div class="flex flex-col lg:flex-row flex-1 overflow-hidden">
                        
                        <!-- 40% KIRI: FORM INPUT DENGAN CARD SECTION -->
                        <div class="w-full lg:w-[40%] overflow-y-auto p-4 md:p-6 space-y-6">
                            <form id="biddingForm" wire:submit.prevent="simpanBidding" class="space-y-6">
                                
                                <!-- NOTIFIKASI ERROR GLOBAL (MUNCUL KALAU ADA YANG KOSONG) -->
                                @if ($errors->any())
                                    <div class="p-4 bg-rose-50 border-l-4 border-rose-400 text-rose-700 rounded-r-xl shadow-sm flex items-start gap-3 animate-pulse">
                                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        <div>
                                            <p class="text-[11px] font-black uppercase tracking-widest mb-0.5">Validasi Gagal!</p>
                                            <p class="text-xs font-medium">Semua kolom wajib diisi dengan benar. Cek peringatan merah di bawah kolom yang masih kosong!</p>
                                        </div>
                                    </div>
                                @endif

                                <!-- SECTION 1: REFERENSI -->
                                <div class="bg-white p-6 rounded-3xl shadow-sm border border-pink-50">
                                    <h4 class="text-[10px] font-extrabold text-[#B2A4FF] uppercase tracking-widest border-b border-pink-50 pb-2 mb-4 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                        Sumber Referensi
                                    </h4>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-2">Pilih Proyek (Wajib)</label>
                                        <div class="relative">
                                            <select wire:model.live="id_r_project" class="appearance-none w-full text-sm px-4 py-3 bg-gray-50 border border-gray-100 hover:border-[#B2A4FF]/50 focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-2xl transition-all text-gray-800 font-bold cursor-pointer outline-none">
                                                <option value="" class="text-gray-400">Pilih proyek yang sedang berjalan...</option>
                                                @foreach($daftarProyek as $p)
                                                    <option value="{{ $p->id }}">{{ $p->nama_pelanggan }} - {{ $p->request_no }}</option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </div>
                                        </div>
                                        @error('id_r_project') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- SECTION 2: DETAIL HARGA -->
                                <div class="bg-white p-6 rounded-3xl shadow-sm border border-pink-50 space-y-4">
                                    <h4 class="text-[10px] font-extrabold text-[#B2A4FF] uppercase tracking-widest border-b border-pink-50 pb-2 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Detail Penawaran Harga
                                    </h4>
                                    
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1.5">No. Penawaran</label>
                                        <input type="text" wire:model="no_penawaran" placeholder="e.g. 014/BID/2026" class="w-full text-sm px-4 py-3 bg-gray-50 border border-gray-100 focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl font-mono text-[#B2A4FF] font-bold transition-all">
                                        @error('no_penawaran') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Tanggal Dibuat</label>
                                            <input type="date" wire:model="tgl_penawaran" class="w-full text-sm px-4 py-3 bg-gray-50 border border-gray-100 focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl text-gray-700 font-bold transition-all">
                                            @error('tgl_penawaran') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Masa Berlaku (Hari)</label>
                                            <input type="number" wire:model="masa_berlaku" placeholder="14" class="w-full text-sm px-4 py-3 bg-gray-50 border border-gray-100 focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl text-gray-700 font-bold transition-all">
                                            @error('masa_berlaku') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Total Harga (Berdasarkan RAB)</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 font-bold">Rp</div>
                                            <input type="number" wire:model="total_penawaran" placeholder="15000000" class="w-full text-lg px-4 py-3 pl-12 bg-emerald-50/50 border border-emerald-100 focus:bg-white focus:border-emerald-400 focus:ring-4 focus:ring-emerald-400/20 rounded-xl font-mono text-[#5C5470] font-black transition-all">
                                        </div>
                                        @error('total_penawaran') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Termin Pembayaran</label>
                                        <input type="text" wire:model="term_of_payment" placeholder="e.g. DP 40%, Pelunasan 60%" class="w-full text-sm px-4 py-3 bg-gray-50 border border-gray-100 focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl text-gray-700 transition-all">
                                        @error('term_of_payment') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- SECTION 3: INFO KLIEN -->
                                <div class="bg-white p-6 rounded-3xl shadow-sm border border-pink-50 space-y-4">
                                    <h4 class="text-[10px] font-extrabold text-[#B2A4FF] uppercase tracking-widest border-b border-pink-50 pb-2 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        Informasi Klien Tujuan
                                    </h4>
                                    
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Instansi Tujuan</label>
                                        <input type="text" wire:model="nama_perusahaan" placeholder="PT. ABC..." class="w-full text-sm px-4 py-3 bg-gray-50 border border-gray-100 focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl text-gray-800 font-bold transition-all">
                                        @error('nama_perusahaan') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Email Klien</label>
                                        <input type="email" wire:model="email_perusahaan" placeholder="email@klien.com" class="w-full text-sm px-4 py-3 bg-gray-50 border border-gray-100 focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl text-gray-800 transition-all">
                                        @error('email_perusahaan') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Alamat Surat</label>
                                        <textarea wire:model="alamat_perusahaan" rows="2" class="w-full text-sm px-4 py-3 bg-gray-50 border border-gray-100 focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl resize-none text-gray-800 transition-all"></textarea>
                                        @error('alamat_perusahaan') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Catatan Pengantar</label>
                                        <textarea wire:model="surat_pengantar" rows="2" class="w-full text-sm px-4 py-3 bg-gray-50 border border-gray-100 focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl resize-none text-gray-800 transition-all"></textarea>
                                        @error('surat_pengantar') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                               @if($isEdit)
<div class="bg-indigo-50 p-5 rounded-3xl border border-indigo-100 mt-6 animate-fade-in-down">
    <label class="block text-xs font-black text-indigo-800 uppercase tracking-widest mb-3 flex items-center gap-2">
        Catatan & Identitas Revisi
    </label>

    <div class="mb-4">
        <label class="block text-[10px] font-bold text-indigo-600 uppercase mb-1">Nama Penulis Revisi</label>
        <input type="text" wire:model="nama_penulis" placeholder="Contoh: Budi Marketing" class="w-full text-sm px-4 py-2 bg-white border border-indigo-200 rounded-xl outline-none focus:border-indigo-500">
        @error('nama_penulis') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
    </div>
    
    <textarea 
        wire:model="komentar_commit" 
        rows="3" 
        placeholder="Jelaskan alasan perubahan dokumen ini..." 
        class="w-full text-sm px-4 py-3 bg-white border border-indigo-200 focus:border-indigo-500 rounded-xl transition-all shadow-inner resize-none font-medium text-gray-800 outline-none"></textarea>
    
    @error('komentar_commit') 
        <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> 
    @enderror
</div>
@endif
                            </form>
                        </div>

                        <!-- 60% KANAN: PDF PREVIEW VIEWER -->
                        <div class="w-full lg:w-[60%] bg-[#f3f4f6]/50 p-4 md:p-6 flex flex-col h-full relative border-l border-white">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-sm font-black text-[#5C5470] flex items-center gap-2">
                                    <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                                    PDF Dokumen RAB Asli
                                </h4>
                                @if($previewRab)
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-600 text-[10px] font-black rounded-lg border border-emerald-200 uppercase tracking-widest shadow-sm">
                                        APPROVED: {{ $previewRab->no_boq }}
                                    </span>
                                @endif
                            </div>
                            
                            <!-- PDF CONTAINER -->
                            <div class="flex-grow bg-white rounded-3xl shadow-inner border-2 border-gray-200 overflow-hidden relative group">
                                @if($previewRab)
                                    <iframe src="{{ route('cetak.rab', $previewRab->id) }}#toolbar=0&navpanes=0" class="w-full h-full border-none"></iframe>
                                @else
                                    <!-- KONDISI KOSONG -->
                                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-gray-50/80 backdrop-blur-sm">
                                        <div class="w-24 h-24 mb-4 rounded-full bg-white shadow-sm flex items-center justify-center border border-gray-100">
                                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-500">Preview PDF RAB Belum Tersedia</p>
                                        <p class="text-[11px] text-gray-400 mt-1 max-w-xs text-center">Silakan pilih proyek di sebelah kiri yang sudah memiliki perhitungan RAB yang disetujui.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- FOOTER KONTROL BAWAH -->
                    <div class="px-8 py-5 bg-white/50 border-t border-white flex justify-end gap-4 sticky bottom-0 z-10 backdrop-blur-xl">
                        <button type="button" wire:click="tutupModal" class="px-6 py-3 text-sm font-bold text-gray-500 border-2 border-transparent hover:border-gray-200 bg-gray-100 hover:bg-white rounded-2xl transition-all cursor-pointer">BATAL</button>
                        <button type="submit" form="biddingForm" class="px-8 py-3 text-sm font-bold text-white bg-gradient-to-r from-[#B2A4FF] to-[#9B8CFF] hover:to-[#8a7af0] rounded-2xl shadow-lg shadow-[#B2A4FF]/30 transition-all flex items-center gap-2 cursor-pointer hover:-translate-y-1">
                            <span wire:loading wire:target="simpanBidding" class="animate-spin h-4 w-4 border-2 border-t-white rounded-full"></span>
                            {{ $isEdit ? 'UPDATE DOKUMEN PENAWARAN' : 'SIMPAN & TERBITKAN PENAWARAN' }}
                        </button>
                    </div>

                </div>
            </div>
        @endif

        <!-- MODAL DETAIL REVISI (Z-50) -->
        @if($isRevisiModalOpen && $detailBidding)
            <div class="fixed inset-0 z-[110] overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
                <div class="bg-white rounded-3xl shadow-xl w-full max-w-2xl border border-sky-100 overflow-hidden transition-all">
                    <div class="px-6 py-5 border-b border-sky-100 flex justify-between items-center bg-sky-50">
                        <div>
                            <h3 class="text-lg font-extrabold text-[#0369a1]">Detail & Catatan Dokumen</h3>
                            <p class="text-[11px] text-sky-600 mt-0.5 font-semibold">Penawaran: {{ $detailBidding->no_penawaran }}</p>
                        </div>
                        <button wire:click="tutupRevisiModal" class="text-sky-400 hover:text-sky-700 transition-colors p-1.5 rounded-lg hover:bg-sky-100 cursor-pointer"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Klien Tujuan</p>
                                <p class="text-sm font-bold text-gray-800 mt-1">{{ $detailBidding->nama_perusahaan }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Nilai Penawaran</p>
                                <p class="text-sm font-black text-[#5C5470] mt-1">Rp {{ number_format($detailBidding->total_penawaran, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-extrabold text-gray-500 uppercase tracking-widest mb-3 border-b border-gray-100 pb-2">Riwayat Otorisasi</h4>
                            <div class="space-y-4 mt-4">
                                @forelse($historiRevisi as $history)
                                    <div class="pl-4 border-l-[3px] @if($history->jenis_aksi == 'approved') border-emerald-400 @elseif($history->jenis_aksi == 'rejected') border-rose-400 @else border-sky-400 @endif">
                                        <p class="text-xs font-bold text-gray-800">{{ $history->user->username ?? 'Sistem' }} <span class="text-[10px] text-gray-400 font-semibold ml-2">({{ \Carbon\Carbon::parse($history->created_at)->format('d M Y - H:i') }})</span></p>
                                        <p class="text-sm text-gray-600 mt-1.5 leading-relaxed bg-gray-50 p-2.5 rounded-lg border border-gray-100">"{{ $history->komentar_commit }}"</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400 italic font-medium bg-gray-50 p-4 rounded-xl text-center">Belum ada catatan persetujuan atau revisi dari Direktur.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-white border-t border-gray-100 flex justify-end gap-3 rounded-b-3xl">
                        <button wire:click="tutupRevisiModal" class="px-5 py-2.5 text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors cursor-pointer">TUTUP</button>
                        
                        @if($detailBidding->status_bidding != 'approved' && $detailBidding->status_bidding != 'won')
                            <button wire:click="bukaEditDariRevisi" wire:loading.attr="disabled" class="px-6 py-2.5 text-sm font-bold text-white bg-sky-500 hover:bg-sky-600 rounded-xl shadow-md transition-all flex items-center gap-2 cursor-pointer disabled:opacity-70 disabled:cursor-not-allowed">
    
    <svg wire:loading.remove wire:target="bukaEditDariRevisi" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
    
    <svg wire:loading wire:target="bukaEditDariRevisi" class="animate-spin -ml-1 mr-1 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>

    <span>EDIT DOKUMEN</span>
</button>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>