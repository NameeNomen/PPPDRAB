<div class="min-h-screen font-sans transition-colors duration-300 bg-[#F4F9F6] text-[#2A402B]" 
     style="font-family: 'Inter', sans-serif;" 
     x-data="{ darkMode: false }" 
     :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5]' : 'bg-[#F4F9F6] text-[#2A402B]'">
    
    @if (session()->has('sukses'))
        <div class="max-w-[95rem] mx-auto pt-6 px-4 md:px-6">
            <div class="p-4 rounded-xl font-semibold flex items-center gap-3 shadow-xl border-2 text-xs tracking-wide uppercase bg-[#4A7256]/15 border-[#4A7256]/40 text-[#2A402B]">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('sukses') }}</span>
            </div>
        </div>
    @endif

    <div class="max-w-[95rem] mx-auto p-4 md:p-6">
        
        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-5 border-b-2 border-[#B4CDBF]/50">
            <button wire:click="kembaliKeList" 
                    class="group flex items-center gap-2 text-sm font-semibold px-5 py-2.5 rounded-lg transition-all border-2 text-[#2A402B] border-[#B4CDBF]/50 hover:border-[#4A7256] hover:bg-[#4A7256]/10 shadow-sm">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Board
            </button>
            <div class="flex items-center gap-1 p-1 rounded-lg border-2 shadow-sm bg-white border-[#B4CDBF]/50">
                <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-[#4A7256] text-white font-bold shadow-md' : 'text-[#648B73] hover:text-[#4A7256]'" 
                        class="px-5 py-2 text-xs font-semibold rounded-md transition-all uppercase tracking-wider">Terang</button>
                <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-[#4A7256] text-white font-bold shadow-md' : 'text-[#648B73] hover:text-[#4A7256]'" 
                        class="px-5 py-2 text-xs font-semibold rounded-md transition-all uppercase tracking-wider">Gelap</button>
            </div>
        </div>

        <!-- MAIN GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            
            <!-- KIRI: PANEL KONTROL & REVISI -->
            <div class="rounded-2xl border-2 overflow-hidden shadow-xl bg-white border-[#B4CDBF]/50">
                @php $stat = strtolower($biddingAktif->status_bidding ?? ''); @endphp
                <div class="p-4 border-b-2 flex justify-between items-center transition-colors
                    {{ $stat === 'revision' ? 'bg-red-600 border-red-600 text-white' : 'bg-[#4A7256] border-[#4A7256] text-white' }}">
                    <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Lembar Kendali & Detail Revisi Direksi
                    </span>
                    <span class="text-[10px] font-black uppercase bg-black/20 px-2.5 py-0.5 rounded">DIREKTUR</span>
                </div>
                <div class="p-6 space-y-6 overflow-y-auto" style="max-height: calc(100vh - 220px);">
                    
                    @if($stat === 'revision')
                        <div class="p-5 rounded-xl bg-red-500/10 border-2 border-red-500/20 text-red-500">
                            <p class="text-xs font-black uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                                Instruksi Perbaikan Dokumen:
                            </p>
                            <p class="text-xs font-medium leading-relaxed font-mono">
                                "{{ $biddingAktif->catatan_revisi ?? 'Mohon periksa kembali kalkulasi margin dan sesuaikan term of payment dengan kesepakatan terbaru.' }}"
                            </p>
                        </div>
                    @elseif($stat === 'approved')
                        <div class="p-5 rounded-xl bg-[#4A7256]/10 border-2 border-[#4A7256]/30 text-[#2A402B]">
                            <p class="text-xs font-black uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Dokumen Disetujui
                            </p>
                            <p class="text-xs font-medium mt-2">Dokumen penawaran telah divalidasi oleh Direktur dan siap dikirimkan ke klien.</p>
                        </div>
                    @elseif($stat === 'pending')
                        <div class="p-5 rounded-xl bg-orange-500/10 border-2 border-orange-500/30 text-orange-600">
                            <p class="text-xs font-black uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Menunggu Persetujuan Direktur
                            </p>
                            <p class="text-xs font-medium mt-2">Dokumen penawaran sudah diajukan dan sedang menunggu review dari Direktur.</p>
                        </div>
                    @else
                        <div class="p-5 rounded-xl bg-[#4A7256]/10 border-2 border-[#4A7256]/30 text-[#2A402B]">
                            <p class="text-xs font-black uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Draf Dokumen
                            </p>
                            <p class="text-xs font-medium mt-2">Dokumen masih dalam tahap penyusunan oleh tim marketing.</p>
                        </div>
                    @endif

                    <div class="text-xs p-4 rounded-xl border border-dashed border-[#B4CDBF]/50 text-[#648B73]">
                        <p class="font-bold mb-1 uppercase tracking-wide text-[10px]">Catatan Manajemen Versi:</p>
                        Setiap perubahan pada dokumen penawaran akan terekam otomatis sebagai log commit sebelum diajukan kembali ke direksi.
                    </div>
                </div>
            </div>

            <!-- KANAN: INFO DOKUMEN -->
            <div class="rounded-2xl p-6 md:p-8 border-2 shadow-xl bg-white border-[#B4CDBF]/50">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 pb-6 border-b-2 border-[#B4CDBF]/50">
                    <div>
                        <span class="inline-block text-[10px] font-bold uppercase px-3 py-1.5 rounded-lg mb-3 bg-[#4A7256] text-white">Dokumen Aktif</span>
                        <p class="text-[10px] font-semibold uppercase tracking-wider mb-1 text-[#648B73]">No. Penawaran</p>
                        <p class="text-xl font-bold text-[#2A402B]">{{ $biddingAktif->no_penawaran }}</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-[10px] font-semibold uppercase tracking-wider block mb-2 text-[#648B73]">Status Persetujuan</span>
                        @php
                            $statusConfig = [
                                'draft' => ['bg' => 'bg-[#648B73]/10', 'text' => 'text-[#648B73]', 'border' => 'border-[#648B73]/30', 'dot' => 'bg-[#648B73]'],
                                'pending' => ['bg' => 'bg-orange-500/10', 'text' => 'text-orange-600', 'border' => 'border-orange-500/30', 'dot' => 'bg-orange-500'],
                                'revision' => ['bg' => 'bg-red-500/10', 'text' => 'text-red-500', 'border' => 'border-red-500/30', 'dot' => 'bg-red-500'],
                                'approved' => ['bg' => 'bg-[#4A7256]/10', 'text' => 'text-[#4A7256]', 'border' => 'border-[#4A7256]/30', 'dot' => 'bg-[#4A7256]'],
                                'sent' => ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-600', 'border' => 'border-blue-500/30', 'dot' => 'bg-blue-500'],
                                'won' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-600', 'border' => 'border-emerald-500/30', 'dot' => 'bg-emerald-500'],
                                'lost' => ['bg' => 'bg-gray-500/10', 'text' => 'text-gray-600', 'border' => 'border-gray-500/30', 'dot' => 'bg-gray-500'],
                                'rejected' => ['bg' => 'bg-red-500/10', 'text' => 'text-red-500', 'border' => 'border-red-500/30', 'dot' => 'bg-red-500'],
                            ][$stat] ?? ['bg' => 'bg-gray-500/10', 'text' => 'text-gray-500', 'border' => 'border-gray-500/30', 'dot' => 'bg-gray-500'];
                        @endphp
                        <span class="inline-flex items-center gap-1.5 text-sm font-bold uppercase px-4 py-2 rounded-xl border-2 {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                            <span class="w-2 h-2 rounded-full {{ $statusConfig['dot'] }}"></span>
                            {{ $biddingAktif->status_bidding }}
                        </span>
                    </div>
                </div>

                <!-- INFO GRID -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div class="p-5 rounded-xl border-2 bg-[#F4F9F6] border-[#B4CDBF]/50">
                        <p class="text-[10px] font-semibold uppercase tracking-wider mb-2 text-[#648B73]">Klien / Instansi</p>
                        <p class="text-sm font-bold text-[#2A402B]">{{ $biddingAktif->nama_pelanggan_snapshot }}</p>
                        @if($biddingAktif->pic_pelanggan_snapshot)
                            <p class="text-[10px] mt-1 text-[#648B73]">u.p. {{ $biddingAktif->pic_pelanggan_snapshot }}</p>
                        @endif
                    </div>
                    <div class="p-5 rounded-xl border-2 bg-[#F4F9F6] border-[#B4CDBF]/50">
                        <p class="text-[10px] font-semibold uppercase tracking-wider mb-2 text-[#648B73]">Tanggal Penawaran</p>
                        <p class="text-sm font-bold font-mono text-[#2A402B]">
                            {{ \Carbon\Carbon::parse($biddingAktif->tgl_penawaran)->format('d M Y') }}
                        </p>
                        <p class="text-[10px] mt-1 text-[#648B73]">Berlaku {{ $biddingAktif->masa_berlaku }} hari</p>
                    </div>
                    <div class="p-5 rounded-xl border-2 border-[#B4CDBF]/50 bg-[#F4F9F6]">
                        <p class="text-[10px] font-semibold uppercase tracking-wider mb-2 text-[#648B73]">Harga Dasar (dari RAB)</p>
                        <p class="text-lg font-bold font-mono text-[#2A402B]">Rp {{ number_format($biddingAktif->harga_dasar, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-5 rounded-xl border-2 border-[#4A7256]/50 bg-[#4A7256]/5">
                        <p class="text-[10px] font-bold uppercase tracking-wider mb-2 text-[#2A402B]">Total Penawaran Final</p>
                        <p class="text-2xl font-bold font-mono text-[#2A402B]">Rp {{ number_format($biddingAktif->total_penawaran, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t-2 border-[#B4CDBF]/50">
                    <button wire:click="editBidding" 
                            class="inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-bold uppercase tracking-wide rounded-xl transition-all flex-1 text-white bg-[#4A7256] hover:bg-[#354F37] shadow-md hover:shadow-xl hover:shadow-[#4A7256]/30 focus:outline-none focus:ring-4 focus:ring-[#4A7256]/30">
                        <span wire:loading.remove wire:target="editBidding" class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            {{ $stat === 'approved' ? 'Lihat Dokumen' : 'Buka Workspace Bidding' }}
                        </span>
                        <span wire:loading wire:target="editBidding" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Memuat...
                        </span>
                    </button>
                    @if($stat !== 'approved' && $stat !== 'sent' && $stat !== 'won')
                        <button onclick="return confirm('Yakin ingin menghapus dokumen bidding ini?')" 
                                wire:click="hapusDokumenBidding" 
                                class="inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-bold uppercase tracking-wide rounded-xl transition-all border-2 text-red-600 border-red-500/30 hover:bg-red-500 hover:text-white hover:border-red-500 hover:shadow-lg hover:shadow-red-500/20 focus:outline-none focus:ring-4 focus:ring-red-500/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus
                        </button>
                    @endif
                </div>

              
            </div>
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #B4CDBF; border-radius: 3px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #4A7256; }
</style>