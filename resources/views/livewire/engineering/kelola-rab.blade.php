<div class="min-h-screen font-sans transition-colors duration-300" 
     x-data="{ darkMode: true }" 
     :class="darkMode ? 'bg-[#1E1D1B] text-[#E4E4E4]' : 'bg-[#FAFCFF] text-[#5E6175]'">
    
    <!-- NOTIFIKASI SUKSES (ALERT) -->
    @if (session()->has('sukses') || session()->has('success'))
        <div class="max-w-7xl mx-auto p-4 mb-4 rounded-xl font-medium flex items-center gap-3 shadow-md border animate-fade-in"
             :class="darkMode ? 'bg-[#2A2E27] border-[#435334] text-[#A6E22E]' : 'bg-emerald-50 border-emerald-200 text-emerald-800'">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('sukses') ?? session('success') }}</span>
        </div>
    @endif

    <!-- ========================================== -->
    <!-- 1. VIEW 'LIST': HALAMAN UTAMA DAFTAR PROYEK-->
    <!-- ========================================== -->
    @if($view === 'list')
        <div class="max-w-7xl mx-auto p-4 md:p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold tracking-tight flex items-center gap-2" :class="darkMode ? 'text-[#D9B35A]' : 'text-[#5E6175]'">
                        <span class="w-2 h-8 rounded-full inline-block bg-[#D9B35A]"></span>
                        Bidding Workspace & RAB Engineering
                    </h1>
                    <p class="text-sm opacity-70 mt-1">Sistem kalkulator estimasi penawaran harga dan spesifikasi material proyek.</p>
                </div>
                
                <div class="flex items-center gap-2 p-1.5 rounded-xl border transition-colors" :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-slate-100 border-slate-200'">
                    <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-white shadow text-slate-950 font-bold' : 'text-slate-400'" class="px-3 py-1.5 text-xs rounded-lg uppercase tracking-wide transition-all">💡 Light</button>
                    <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-[#1E1D1B] text-[#D9B35A] shadow font-bold' : 'text-slate-500'" class="px-3 py-1.5 text-xs rounded-lg uppercase tracking-wide transition-all">🕶️ Dark</button>
                </div>
            </div>

            <div class="rounded-2xl p-4 mb-6 border flex flex-col md:flex-row gap-4 items-center justify-between transition-colors shadow-sm"
                 :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/50'">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none opacity-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" wire:model.live="searchProyek" placeholder="Cari data proyek atau no request..." 
                           class="w-full text-sm pl-10 pr-4 py-2.5 rounded-xl border outline-none font-medium transition-all"
                           :class="darkMode ? 'bg-[#1E1D1B] border-[#3D3A36] text-white focus:border-[#D9B35A]' : 'bg-[#FAFCFF] border-[#C7D9F1] text-[#5E6175] focus:border-[#D9B35A]'">
                </div>
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <select wire:model.live="filterStatus" class="text-sm border rounded-xl px-4 py-2.5 font-medium outline-none shadow-sm transition-all"
                            :class="darkMode ? 'bg-[#1E1D1B] border-[#3D3A36] text-white' : 'bg-white border-[#C7D9F1] text-[#5E6175]'">
                        <option value="all">Semua Dokumen</option>
                        <option value="draft">Status: Draft</option>
                        <option value="pending">Status: Pending</option>
                        <option value="approved">Status: Approved</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- GRID DAFTAR PROYEK -->
                @forelse($daftarProyek as $proyek)
                    <!-- UBAH overflow-hidden MENJADI overflow-visible AGAR TITIK MERAH TIDAK TERPOTONG -->
                    <div class="border rounded-2xl p-5 shadow-sm flex flex-col justify-between relative overflow-visible group transition-all"
                         :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/50'">
                        
                        <!-- TITIK MERAH BERKEDIP (MUNCUL JIKA STATUS REVISI) -->
                        @if(strtolower($proyek->rab->status_rab ?? '') === 'revisi')
                            <span class="absolute -top-2 -right-2 flex h-4 w-4 z-10">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-4 w-4 bg-rose-600 border-2" :class="darkMode ? 'border-[#2D2B28]' : 'border-white'"></span>
                            </span>
                        @endif

                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded tracking-wide" :class="darkMode ? 'bg-[#1E1D1B] text-[#D9B35A]' : 'bg-[#C7D9F1]/30 text-[#5E6175]'">
                                    PROJECT
                                </span>
                                @if(!$proyek->rab)
                                    <span class="px-2.5 py-0.5 text-[11px] font-bold rounded bg-amber-500/10 text-amber-500 border border-amber-500/20">Belum Ada RAB</span>
                                @else
                                    <!-- Warnai badge merah jika statusnya revisi agar lebih mencolok -->
                                    @php $isRevisiList = strtolower($proyek->rab->status_rab) === 'revisi'; @endphp
                                    <span class="px-2.5 py-0.5 text-[11px] font-bold rounded uppercase" 
                                          :class="darkMode ? ($isRevisiList ? 'bg-rose-500/20 text-rose-500' : 'bg-[#D9B35A]/10 text-[#D9B35A]') : ($isRevisiList ? 'bg-rose-100 text-rose-600' : 'bg-[#D9B35A]/20 text-[#D9B35A]')">
                                        {{ $proyek->rab->status_rab ?? 'DRAFT' }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="font-bold text-base leading-snug mb-1" :class="darkMode ? 'text-white' : 'text-[#5E6175]'">{{ $proyek->nama_pelanggan }}</h3>
                            <p class="text-xs opacity-50 font-mono mb-4">REQ-NO: {{ $proyek->request_no ?? '-' }}</p>
                            <div class="space-y-2 border-t pt-3 text-xs" :class="darkMode ? 'border-[#3D3A36]' : 'border-slate-100'">
                                <div class="flex justify-between">
                                    <span class="opacity-60">Status Proyek:</span>
                                    <span class="font-bold uppercase tracking-wide text-[11px]">{{ str_replace('_', ' ', $proyek->status_proyek) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="opacity-60">Total Budget RAB:</span>
                                    <span class="font-bold font-mono">Rp {{ $proyek->rab ? number_format($proyek->rab->grand_total, 0, ',', '.') : '0' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 pt-3 border-t" :class="darkMode ? 'border-[#3D3A36]' : 'border-slate-100'">
                            <button wire:click="bukaWorkspace({{ $proyek->id }})" 
                                    class="w-full py-2.5 text-xs font-bold tracking-wider rounded-xl transition-all flex items-center justify-center gap-2 uppercase"
                                    :class="darkMode ? 'bg-[#1E1D1B] text-[#D9B35A] hover:bg-[#1E1D1B]/80' : 'bg-[#C7D9F1]/40 text-[#5E6175] hover:bg-[#C7D9F1]'">
                                Buka Workspace →
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full border rounded-2xl p-12 text-center" :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/50'">
                        <p class="opacity-50 text-sm font-medium">Tidak ada data proyek dengan kriteria filter tersebut.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @elseif($view === 'card')
        <div class="max-w-5xl mx-auto p-4 md:p-8">
            <button wire:click="kembaliKeList" class="mb-6 flex items-center gap-2 text-xs font-bold uppercase tracking-wider px-4 py-2 rounded-xl border transition-all"
                    :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36] text-[#E4E4E4] hover:bg-[#1E1D1B]' : 'bg-white border-[#C7D9F1]/50 text-[#5E6175] hover:bg-[#FAFCFF]'">
                ← Kembali ke Daftar Proyek
            </button>
            
            @if(!$rabAktif)
                <div class="border rounded-2xl p-8 shadow-sm relative overflow-hidden transition-colors flex flex-col items-center text-center" 
                     :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/50'">
                    <span class="text-4xl mb-4 opacity-50">📂</span>
                    <h2 class="text-xl font-black" :class="darkMode ? 'text-white' : 'text-[#5E6175]'">{{ $selectedProject->nama_pelanggan }}</h2>
                    <p class="text-xs font-mono opacity-50 mt-1 mb-6">ID PROYEK: #{{ $selectedProject->id }} | Dokumen estimasi belum tersedia.</p>
                    
                    <button wire:click="editRab" class="px-6 py-3 text-xs font-black tracking-widest rounded-xl transition-all flex items-center gap-2 uppercase shadow-lg"
                            :class="darkMode ? 'bg-[#D9B35A] hover:bg-[#D9B35A]/90 text-slate-900' : 'bg-[#C7D9F1] hover:bg-[#C7D9F1]/80 text-[#5E6175]'">
                        + INISIASI & BUAT RAB BARU
                    </button>
                </div>
            @else
                @php
                    $isRevisi = strtolower($rabAktif->status_rab ?? '') === 'revisi';
                    $isApproved = strtolower($rabAktif->status_rab ?? '') === 'approved';
                @endphp
                <div class="border rounded-2xl p-6 shadow-sm relative overflow-hidden transition-all duration-300" 
                     :class="darkMode ? ($isRevisi ? 'bg-[#1e293b]/80 border-[#3b82f6]/50 shadow-[0_0_15px_rgba(59,130,246,0.15)]' : 'bg-[#2D2B28] border-[#3D3A36]') : ($isRevisi ? 'bg-blue-50 border-blue-200' : 'bg-white border-[#C7D9F1]/50')">
                    
                    <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-6">
                        <div>
                            <span class="text-[11px] font-black tracking-widest uppercase px-2.5 py-1 rounded" 
                                  :class="darkMode ? ($isRevisi ? 'bg-[#3b82f6]/20 text-[#60a5fa]' : ($isApproved ? 'bg-emerald-500/20 text-emerald-500' : 'bg-[#1E1D1B] text-[#D9B35A]')) : ($isRevisi ? 'bg-blue-200 text-blue-800' : ($isApproved ? 'bg-emerald-100 text-emerald-700' : 'bg-[#D9B35A]/10 text-[#D9B35A]'))">
                                DOKUMEN AKTIF
                            </span>
                            <h2 class="text-2xl font-black mt-3" :class="darkMode ? 'text-white' : 'text-[#5E6175]'">{{ $selectedProject->nama_pelanggan }}</h2>
                            <p class="text-xs font-mono opacity-50 mt-1">NO: {{ $rabAktif->no_boq }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs opacity-50 block mb-1 font-medium">Status Validasi Dokumen:</span>
                            <span class="px-3 py-1.5 text-xs font-black rounded-lg uppercase border tracking-wider" 
                                  :class="darkMode ? ($isRevisi ? 'bg-[#3b82f6]/20 text-[#60a5fa] border-[#3b82f6]/50' : ($isApproved ? 'bg-emerald-500/20 text-emerald-500 border-emerald-500/30' : 'bg-[#D9B35A]/10 text-[#D9B35A] border-[#D9B35A]/30')) : ($isRevisi ? 'bg-blue-100 text-blue-700 border-blue-300' : ($isApproved ? 'bg-emerald-100 text-emerald-700 border-emerald-300' : 'bg-[#D9B35A]/20 text-[#D9B35A] border-[#D9B35A]/30'))">
                                {{ $rabAktif->status_rab ?? 'DRAFT' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-xl border mb-6 transition-colors" 
                         :class="darkMode ? 'bg-[#1E1D1B]/50 border-[#3D3A36]' : 'bg-[#FAFCFF] border-[#C7D9F1]/40'">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider opacity-50">Overhead Cost</p>
                            <p class="text-sm font-bold font-mono mt-0.5">Rp {{ number_format($rabAktif->overhead_cost, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider" :class="darkMode ? 'text-[#D9B35A]' : 'text-slate-800'">Grand Total RAB</p>
                            <p class="text-xl font-black font-mono mt-0.5">Rp {{ number_format($rabAktif->grand_total, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3 pt-4 border-t" :class="darkMode ? 'border-[#3D3A36]' : 'border-slate-100'">
                        
                        <button wire:click="editRab" class="px-4 py-2 text-xs font-black tracking-widest rounded-xl transition-all uppercase flex items-center gap-2"
                                :class="darkMode ? 'bg-[#D9B35A] hover:bg-[#D9B35A]/90 text-slate-900' : 'bg-[#C7D9F1] hover:bg-[#C7D9F1]/80 text-[#5E6175]'">
                            {{ $isApproved ? '👁️ BACA SPREADSHEET' : '✏️ EDIT SPREADSHEET' }}
                        </button>
                        
                        <button onclick="confirm('Yakin ingin menghapus seluruh dokumen RAB ini beserta historinya?') || event.stopImmediatePropagation()" 
                                wire:click="hapusDokumenRab" class="px-4 py-2 bg-rose-500/10 hover:bg-rose-500/20 text-rose-500 text-xs font-black tracking-widest rounded-xl transition-all border border-rose-500/20 uppercase">
                            🗑️ HAPUS
                        </button>

                        <div class="w-px bg-gray-500/30 mx-2"></div> 

                        <button {{ $isRevisi ? 'disabled' : '' }} 
                                class="px-4 py-2 text-xs font-black tracking-widest rounded-xl transition-all uppercase flex items-center gap-2 border"
                                :class="$isRevisi 
                                        ? 'opacity-40 cursor-not-allowed ' . (darkMode ? 'bg-transparent border-[#3D3A36] text-slate-500' : 'bg-slate-100 border-slate-200 text-slate-400') 
                                        : (darkMode ? 'bg-[#1E1D1B] hover:bg-emerald-900/40 text-emerald-500 border-emerald-500/30' : 'bg-white hover:bg-emerald-50 text-emerald-600 border-emerald-200')">
                            📊 CETAK EXCEL {!! $isRevisi ? '<span class="text-[9px] font-normal tracking-normal">(Terkunci)</span>' : '' !!}
                        </button>

                        <button {{ $isRevisi ? 'disabled' : '' }} 
                                class="px-4 py-2 text-xs font-black tracking-widest rounded-xl transition-all uppercase flex items-center gap-2 border"
                                :class="$isRevisi 
                                        ? 'opacity-40 cursor-not-allowed ' . (darkMode ? 'bg-transparent border-[#3D3A36] text-slate-500' : 'bg-slate-100 border-slate-200 text-slate-400') 
                                        : (darkMode ? 'bg-[#1E1D1B] hover:bg-rose-900/40 text-rose-500 border-rose-500/30' : 'bg-white hover:bg-rose-50 text-rose-600 border-rose-200')">
                            📄 CETAK PDF {!! $isRevisi ? '<span class="text-[9px] font-normal tracking-normal">(Terkunci)</span>' : '' !!}
                        </button>
                    </div>
                </div>
            @endif
        </div>

    <!-- ========================================== -->
    <!-- 3. VIEW 'SPREADSHEET': WORKSTATION RAB FULL-->
    <!-- ========================================== -->
    @elseif($view === 'spreadsheet')
        @php
            $isApproved = strtolower($rabAktif->status_rab ?? '') === 'approved';
        @endphp
        
        <div class="w-full mx-auto p-4 md:p-6">
            <div class="w-full flex items-center justify-between mb-6 p-3 rounded-xl border transition-colors sticky top-4 z-40 shadow-sm"
                 :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/50'">
                <button wire:click="{{ $rabAktif ? 'kembaliKeWorkspace' : 'kembaliKeList' }}" 
                        class="px-4 py-2 text-xs font-black uppercase tracking-wider rounded-lg border transition-all"
                        :class="darkMode ? 'bg-[#1E1D1B] border-[#3D3A36] text-[#E4E4E4] hover:bg-[#1E1D1B]/70' : 'bg-[#FAFCFF] border-[#C7D9F1] text-[#5E6175] hover:bg-[#C7D9F1]/20'">
                    ✕ BATAL & KELUAR
                </button>
                <div class="flex items-center gap-2 bg-black/10 p-1 rounded-lg">
                    <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-white shadow text-black font-bold' : 'text-slate-400'" class="px-2.5 py-1 text-[11px] rounded transition-all uppercase">💡 Terang</button>
                    <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-[#1E1D1B] text-[#D9B35A] shadow font-bold' : 'text-slate-500'" class="px-2.5 py-1 text-[11px] rounded transition-all uppercase">🕶️ Gelap</button>
                </div>
                
                <!-- TOMBOL SUBMIT DENGAN LOADING ANIMATION (DISEMBUNYIKAN KALAU APPROVED) -->
                @if(!$isApproved)
                    <button wire:click="submitKeDirektur" wire:loading.attr="disabled" class="px-5 py-2 text-xs font-black uppercase tracking-wider rounded-lg shadow transition-all relative overflow-hidden"
                            :class="darkMode ? 'bg-[#D9B35A] text-slate-950 hover:bg-[#D9B35A]/90 disabled:opacity-70' : 'bg-slate-800 text-white hover:bg-slate-700 disabled:opacity-70'">
                        <div wire:loading.remove wire:target="submitKeDirektur" class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            SUBMIT KE DIREKTUR
                        </div>
                        <div wire:loading wire:target="submitKeDirektur" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            MEMPROSES...
                        </div>
                    </button>
                @else
                    <span class="px-5 py-2 text-xs font-black uppercase tracking-wider rounded-lg bg-emerald-500/20 text-emerald-500 border border-emerald-500/30">
                        🔒 DOKUMEN DIKUNCI (APPROVED)
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                <div class="lg:col-span-4 border rounded-2xl p-5 flex flex-col justify-between transition-colors shadow-sm h-full min-h-full"
                     :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/60'">
                    <div class="flex flex-col h-full justify-between">
                        <div>
                            <h3 class="text-xs font-black uppercase tracking-widest mb-5 border-b pb-2" 
                                :class="darkMode ? 'text-[#D9B35A] border-[#3D3A36]' : 'text-[#5E6175] border-slate-100'">
                                INFORMASI TARGET PROYEK
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <span class="text-[10px] font-bold uppercase opacity-50 tracking-wider block">INSTANSI / KLIEN</span>
                                    <p class="text-sm font-black mt-0.5" :class="darkMode ? 'text-white' : 'text-slate-800'">
                                        {{ $selectedProject->nama_pelanggan }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase opacity-50 tracking-wider block">TARGET WAKTU</span>
                                    <p class="text-sm font-bold font-mono text-[#D9B35A] mt-0.5">
                                        {{ $selectedProject->target_waktu ? \Carbon\Carbon::parse($selectedProject->target_waktu)->format('d-F-Y') : '-' }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase opacity-50 tracking-wider block">ALAMAT LOKASI</span>
                                    <p class="text-xs font-medium mt-1 leading-relaxed opacity-80">
                                        {{ $selectedProject->alamat ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <span class="text-[10px] font-bold uppercase opacity-50 tracking-wider block">DESKRIPSI BIDDING & SPESIFIKASI</span>
                            <div class="text-xs italic p-3 rounded mt-1.5 border font-medium leading-relaxed max-h-60 lg:max-h-80 overflow-y-auto scrollbar-thin whitespace-pre-line shadow-inner"
                                 :class="darkMode ? 'bg-[#1E1D1B] border-[#3D3A36] text-slate-300' : 'bg-[#FAFCFF] border-[#C7D9F1]/60 text-slate-600'">
                                {{ $selectedProject->deskripsi_proyek ?? 'Tidak ada catatan deskripsi teknis proyek.' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8 space-y-6">
                    
                    @if(!$isApproved)
                        <!-- SETUP HEADER HANYA MUNCUL JIKA BELUM APPROVED -->
                        <div class="border rounded-2xl p-5 transition-colors shadow-sm"
                             :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/60'">
                            <h3 class="text-xs font-black uppercase tracking-widest mb-4" :class="darkMode ? 'text-[#D9B35A]' : 'text-[#5E6175]'">
                                SETUP HEADER & HISTORI DOKUMEN
                            </h3>
                            
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-[11px] font-bold uppercase opacity-70 mb-1">NO. BOQ</label>
                                        <input type="text" wire:model="no_boq" class="w-full text-sm font-mono p-2.5 rounded-lg border outline-none font-bold"
                                               :class="darkMode ? 'bg-[#1E1D1B] border-[#3D3A36] text-white focus:border-[#D9B35A]' : 'bg-[#FAFCFF] border-[#C7D9F1] text-black focus:border-[#D9B35A]'">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold uppercase opacity-70 mb-1">TANGGAL BUAT</label>
                                        <input type="date" wire:model="tanggal_dokumen" class="w-full text-sm p-2.5 rounded-lg border outline-none font-bold"
                                               :class="darkMode ? 'bg-[#1E1D1B] border-[#3D3A36] text-white focus:border-[#D9B35A]' : 'bg-[#FAFCFF] border-[#C7D9F1] text-black focus:border-[#D9B35A]'">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold uppercase opacity-70 mb-1">OVERHEAD (RP)</label>
                                        <input type="number" wire:model.live="overhead_cost" class="w-full text-sm font-mono p-2.5 rounded-lg border outline-none font-bold"
                                               :class="darkMode ? 'bg-[#1E1D1B] border-[#3D3A36] text-white focus:border-[#D9B35A]' : 'bg-[#FAFCFF] border-[#C7D9F1] text-black focus:border-[#D9B35A]'">
                                    </div>
                                </div>
                                
                                <div class="p-4 rounded-xl border mt-2" :class="darkMode ? 'bg-[#1E1D1B] border-[#3D3A36]' : 'bg-[#FAFCFF] border-[#C7D9F1]/60'">
                                    <span class="text-[11px] font-black uppercase tracking-wider block mb-3" :class="darkMode ? 'text-[#D9B35A]' : 'text-slate-700'">
                                        📥 PESAN HISTORI COMMIT & EDITOR (WAJIB)
                                    </span>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                        <div class="md:col-span-1">
                                            <input type="text" wire:model="nama_editor" placeholder="Nama Anda (Wajib)..." 
                                                   class="w-full text-xs p-2.5 rounded-lg border outline-none font-bold"
                                                   :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36] text-white focus:border-[#D9B35A]' : 'bg-white border-[#C7D9F1] text-black focus:border-[#D9B35A]'">
                                            @error('nama_editor') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="md:col-span-3">
                                            <input type="text" wire:model="commit_message" placeholder="Tulis catatan rincian perubahan data versi ini..." 
                                                   class="w-full text-xs p-2.5 rounded-lg border outline-none font-medium"
                                                   :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36] text-white focus:border-[#D9B35A]' : 'bg-white border-[#C7D9F1] text-black focus:border-[#D9B35A]'">
                                            @error('commit_message') <span class="text-rose-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="rounded-2xl border transition-colors shadow-sm overflow-visible"
                         :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36]' : 'bg-white border-[#C7D9F1]/50'">
                        
                        @if(!$isApproved)
                            <!-- ADD KATEGORI HANYA MUNCUL JIKA BELUM APPROVED -->
                            <div class="p-3 border-b flex justify-between items-center gap-3" :class="darkMode ? 'bg-[#1E1D1B]/50 border-[#3D3A36]' : 'bg-slate-50 border-slate-200'">
                                <div class="flex items-center gap-2 w-full max-w-md">
                                    <input type="text" wire:model="newKategori" placeholder="Ketik nama kategori utama pekerjaan baru..." 
                                           class="text-xs rounded-lg px-3 py-2 w-full border outline-none"
                                           :class="darkMode ? 'bg-[#1E1D1B] border-[#3D3A36] text-white focus:border-[#D9B35A]' : 'bg-white border-slate-300 text-black focus:border-[#D9B35A]'">
                                    <button type="button" wire:click="tambahKategori" class="px-4 py-2 text-xs font-black rounded-lg transition-colors shrink-0 uppercase"
                                            :class="darkMode ? 'bg-[#A2B69D] text-slate-900 hover:bg-[#A2B69D]/80' : 'bg-slate-800 text-white hover:bg-slate-700'">
                                        + KATEGORI
                                    </button>
                                </div>
                            </div>
                        @endif
                        
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-left text-xs border-collapse min-w-[800px]">
                                <thead class="font-black uppercase tracking-wider border-b" :class="darkMode ? 'bg-[#1E1D1B] text-gray-400 border-[#3D3A36]' : 'bg-[#FAFCFF] text-slate-700 border-slate-200'">
                                    <tr>
                                        <th class="px-3 py-3 text-center w-12 border-r" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">NO</th>
                                        <th class="px-3 py-3 w-1/3 border-r" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">DESKRIPSI PEKERJAAN</th>
                                        <th class="px-3 py-3 w-1/4 border-r" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">MATERIAL</th>
                                        <th class="px-3 py-3 text-center w-16 border-r" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">VOL</th>
                                        <th class="px-3 py-3 text-right w-28 border-r" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">HARGA (RP)</th>
                                        <th class="px-3 py-3 text-right w-32 {{ !$isApproved ? 'border-r' : '' }}" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">SUBTOTAL (RP)</th>
                                        @if(!$isApproved) <th class="px-3 py-3 text-center w-12">ACT</th> @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y font-medium relative" :class="darkMode ? 'divide-[#3D3A36]' : 'divide-slate-200'">
                                    @php $noIndex = 1; @endphp
                                    @foreach($kategoris as $kat)
                                        <tr :class="darkMode ? 'bg-[#1E1D1B]/40 text-white' : 'bg-slate-100 text-slate-900'" class="font-bold border-y">
                                            <td class="px-3 py-2 text-center font-mono border-r" :class="darkMode?'border-[#3D3A36]/40':'border-slate-200'">{{ $noIndex++ }}</td>
                                            <td class="px-3 py-2 border-r" :class="darkMode?'border-[#3D3A36]/40':'border-slate-200'" colspan="2">
                                                <span :class="darkMode?'text-[#D9B35A]':'text-slate-800'">{{ $kat->deskripsi_pekerjaan }}</span>
                                            </td>
                                            <td class="px-3 py-2 text-center border-r" :class="darkMode?'border-[#3D3A36]/40':'border-slate-200'">-</td>
                                            <td class="px-3 py-2 text-right border-r" :class="darkMode?'border-[#3D3A36]/40':'border-slate-200'">-</td>
                                            <td class="px-3 py-2 text-right font-mono font-black {{ !$isApproved ? 'border-r' : '' }} text-[#D9B35A]" :class="darkMode?'border-[#3D3A36]/40':'border-slate-200'">
                                                Rp {{ number_format($kat->children->sum('subtotal'), 0, ',', '.') }}
                                            </td>
                                            @if(!$isApproved)
                                                <td class="px-3 py-2 text-center">
                                                    <button type="button" wire:click="hapusItem({{ $kat->id }})" class="text-rose-500 hover:text-rose-400 font-bold">✕</button>
                                                </td>
                                            @endif
                                        </tr>
                                        
                                        @foreach($kat->children as $item)
                                            <tr :class="darkMode ? 'hover:bg-[#1E1D1B]/20 text-slate-300' : 'hover:bg-slate-50 text-black'">
                                                <td class="px-3 py-1.5 text-center font-mono border-r opacity-40" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'"></td>
                                                <td class="px-3 py-1.5 border-r" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">{{ $item->deskripsi_pekerjaan }}</td>
                                                <td class="px-3 py-1.5 border-r font-mono opacity-80" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">
                                                    {{ $item->material->nama_barang ?? 'Custom Item' }} 
                                                    <span class="text-[10px] opacity-60">({{ $item->material->satuan ?? '-' }})</span>
                                                </td>
                                                <td class="px-3 py-1.5 text-center border-r font-mono" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">{{ $item->qty }}</td>
                                                <td class="px-3 py-1.5 text-right border-r font-mono" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">Rp {{ number_format($item->harga_awal, 0, ',', '.') }}</td>
                                                <td class="px-3 py-1.5 text-right border-r font-mono font-bold" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                                @if(!$isApproved)
                                                    <td class="px-3 py-1.5 text-center">
                                                        <button type="button" wire:click="hapusItem({{ $item->id }})" class="text-slate-400 hover:text-rose-500">✕</button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        
                                        @if(!$isApproved)
                                            <!-- FORM INLINE INPUT ITEM HANYA MUNCUL JIKA BELUM APPROVED -->
                                            <tr :class="darkMode ? 'bg-[#1E1D1B]/10' : 'bg-slate-50/50'" class="border-b relative">
                                                <td class="px-3 py-2 border-r opacity-30" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'"></td>
                                                <td class="px-3 py-2 border-r" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">
                                                    <input type="text" wire:model="deskripsiInput.{{ $kat->id }}" placeholder="Ketik nama rincian..." 
                                                           class="w-full text-xs rounded px-2 py-1.5 outline-none border transition-colors font-medium"
                                                           :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36] text-white focus:border-[#D9B35A]' : 'bg-white border-slate-300 text-black focus:border-[#D9B35A]'">
                                                </td>
                                                
                                                <td class="px-3 py-2 border-r relative" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">
                                                    @if(!empty($selectedMaterial[$kat->id]))
                                                        <div class="flex items-center justify-between p-1.5 px-2 rounded font-mono text-[10px] border transition-all"
                                                             :class="darkMode ? 'bg-[#1E1C1B] border-[#D9B35A]/50 text-[#D9B35A]' : 'bg-amber-50 border-amber-300 text-amber-800'">
                                                            <div class="flex flex-col truncate pr-2">
                                                                <span class="font-bold truncate">📦 {{ $selectedMaterial[$kat->id]['nama'] }}</span>
                                                                <span class="opacity-80">Rp {{ number_format($selectedMaterial[$kat->id]['harga'], 0, ',', '.') }}</span>
                                                            </div>
                                                            <button type="button" wire:click="batalPilihMaterial({{ $kat->id }})" class="text-red-500 hover:text-red-400 font-bold focus:outline-none">✕</button>
                                                        </div>
                                                    @else
                                                        <input type="text" wire:model.live.debounce.300ms="materialSearch.{{ $kat->id }}" placeholder="Cari material..." 
                                                               class="w-full text-xs rounded px-2 py-1.5 outline-none border transition-colors font-mono"
                                                               :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36] text-white focus:border-[#D9B35A]' : 'bg-white border-slate-300 text-black focus:border-[#D9B35A]'">
                                                        
                                                        @if(!empty($materialResults[$kat->id]))
                                                            <div class="absolute left-0 right-0 top-full rounded-lg shadow-2xl z-50 max-h-48 overflow-y-auto mt-1 p-1 border w-64"
                                                                 :class="darkMode ? 'bg-[#252322] border-[#3D3A36]' : 'bg-white border-slate-200'">
                                                                @foreach($materialResults[$kat->id] as $m)
                                                                    <div wire:click="pilihMaterial({{ $kat->id }}, {{ $m->id }}, '{{ addslashes($m->nama_barang) }}', {{ $m->harga }}, '{{ $m->satuan ?? '-' }}')" 
                                                                         class="p-2 cursor-pointer text-[10px] flex flex-col rounded-md transition-colors border-b last:border-b-0"
                                                                         :class="darkMode ? 'hover:bg-[#4A3F2A]/60 border-[#3D3A36] text-[#EBE7E4]' : 'hover:bg-slate-100 border-slate-100 text-slate-700'">
                                                                        <span class="truncate font-bold">{{ $m->nama_barang }}</span>
                                                                        <span class="font-mono text-[#D9B35A] font-semibold">Rp {{ number_format($m->harga, 0, ',', '.') }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @endif
                                                </td>

                                                <td class="px-3 py-2 border-r" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">
                                                    <input type="number" step="0.01" wire:model="volumeInput.{{ $kat->id }}" placeholder="0" class="w-full text-xs rounded px-1 py-1.5 text-center border font-mono outline-none" :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36] text-white focus:border-[#D9B35A]' : 'bg-white border-slate-300 text-black'">
                                                </td>
                                                <td class="px-3 py-2 border-r text-center" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'">
                                                    <input type="number" wire:model="hargaInput.{{ $kat->id }}" placeholder="0" class="w-full text-xs rounded px-2 py-1.5 text-right outline-none border font-mono" :class="darkMode ? 'bg-[#2D2B28] border-[#3D3A36] text-white focus:border-[#D9B35A]' : 'bg-white border-slate-300 text-black'">
                                                </td>
                                                <td class="px-3 py-2 border-r text-right" :class="darkMode ? 'border-[#3D3A36]':'border-slate-200'" colspan="2">
                                                    <button type="button" wire:click="simpanItemBaru({{ $kat->id }})" class="px-3 py-1.5 text-[11px] font-black rounded transition-all w-full uppercase tracking-wide"
                                                            :class="darkMode ? 'bg-[#A2B69D] text-slate-900 hover:bg-[#A2B69D]/80' : 'bg-slate-700 text-white hover:bg-slate-800'">
                                                        + ADD
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                
                                <tfoot class="border-t-4" :class="darkMode ? 'border-[#D9B35A]/50 bg-[#1E1D1B]' : 'border-slate-400 bg-slate-100'">
                                    <tr class="border-b" :class="darkMode ? 'border-[#3D3A36]' : 'border-slate-200'">
                                        <td colspan="4" class="px-4 py-2.5 text-right font-bold text-xs uppercase" :class="darkMode ? 'text-slate-300' : 'text-slate-700'">
                                            Total : 1 sd {{ count($kategoris) }} =
                                        </td>
                                        <td colspan="2" class="px-4 py-2.5 text-right font-bold font-mono text-sm border-l" :class="darkMode ? 'border-[#3D3A36] text-white' : 'border-slate-200 text-slate-900'">
                                            Rp {{ number_format($totalPekerjaan, 2, ',', '.') }}
                                        </td>
                                        @if(!$isApproved) <td></td> @endif
                                    </tr>
                                    <tr class="border-b" :class="darkMode ? 'border-[#3D3A36]' : 'border-slate-200'">
                                        <td colspan="4" class="px-4 py-2.5 text-right font-bold text-xs uppercase" :class="darkMode ? 'text-slate-300' : 'text-slate-700'">
                                            Over Head Cost
                                        </td>
                                        <td colspan="2" class="px-4 py-2.5 text-right font-bold font-mono text-sm border-l" :class="darkMode ? 'border-[#3D3A36] text-white' : 'border-slate-200 text-slate-900'">
                                            Rp {{ number_format($overhead, 2, ',', '.') }}
                                        </td>
                                        @if(!$isApproved) <td></td> @endif
                                    </tr>
                                    <tr class="border-b" :class="darkMode ? 'border-[#3D3A36]' : 'border-slate-200'">
                                        <td colspan="4" class="px-4 py-2.5 text-right font-bold text-xs uppercase" :class="darkMode ? 'text-slate-300' : 'text-slate-700'">
                                            Total
                                        </td>
                                        <td colspan="2" class="px-4 py-2.5 text-right font-bold font-mono text-sm border-l" :class="darkMode ? 'border-[#3D3A36] text-white' : 'border-slate-200 text-slate-900'">
                                            Rp {{ number_format($grandTotal, 2, ',', '.') }}
                                        </td>
                                        @if(!$isApproved) <td></td> @endif
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-right font-black text-sm uppercase tracking-widest" :class="darkMode ? 'text-[#D9B35A]' : 'text-slate-900'">
                                            Grand Total
                                        </td>
                                        <td colspan="2" class="px-4 py-3 text-right font-black font-mono text-base border-l" :class="darkMode ? 'border-[#3D3A36] text-[#D9B35A]' : 'border-slate-200 text-slate-900'">
                                            Rp {{ number_format(floor($grandTotal/1000)*1000, 2, ',', '.') }}
                                        </td>
                                        @if(!$isApproved) <td></td> @endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>