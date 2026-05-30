<div class="min-h-screen p-4 md:p-8 bg-[#FAEEF5] font-sans text-[#5C5470]">
    
    <div class="max-w-7xl mx-auto mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-6 rounded-3xl shadow-[0_8px_30px_-4px_rgba(178,164,255,0.15)] border border-[#B2A4FF]/10">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight">Kelola Proyek</h1>
                <p class="text-xs md:text-sm text-gray-500 mt-1 font-medium">Daftar inisiasi dokumen kebutuhan lapangan PT Tri Jaya Teknik.</p>
            </div>
            <button wire:click="bukaModal" class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-[#B2A4FF] to-[#9B8CFF] hover:to-[#8a7af0] text-white text-xs font-bold rounded-xl shadow-lg shadow-[#B2A4FF]/30 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                TAMBAH PROYEK BARU
            </button>
        </div>
    </div>

    @if (session()->has('sukses'))
        <div class="max-w-7xl mx-auto mb-6 p-4 bg-white border border-[#B2A4FF]/30 text-[#8a7af0] rounded-2xl text-sm font-bold flex items-center gap-3 shadow-[0_4px_15px_-4px_rgba(178,164,255,0.2)]">
            <svg class="w-5 h-5 text-[#B2A4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('sukses') }}
        </div>
    @endif

    <div class="max-w-7xl mx-auto bg-white rounded-3xl shadow-[0_8px_30px_-4px_rgba(178,164,255,0.15)] border border-pink-50 overflow-hidden mb-6">
        <div class="overflow-x-auto w-full p-2">
            <table class="w-full min-w-[900px] text-left text-sm text-[#5C5470]">
                <thead>
                    <tr>
                        <th class="px-6 py-5 bg-[#FAEEF5]/50 text-[#B2A4FF] font-extrabold text-xs tracking-widest uppercase rounded-l-2xl">Req No & Klien</th>
                        <th class="px-6 py-5 bg-[#FAEEF5]/50 text-[#B2A4FF] font-extrabold text-xs tracking-widest uppercase">Kategori & Target</th>
                        <th class="px-6 py-5 bg-[#FAEEF5]/50 text-[#B2A4FF] font-extrabold text-xs tracking-widest uppercase text-right">Budget</th>
                        <th class="px-6 py-5 bg-[#FAEEF5]/50 text-[#B2A4FF] font-extrabold text-xs tracking-widest uppercase text-center">Status</th>
                        <th class="px-6 py-5 bg-[#FAEEF5]/50 text-[#B2A4FF] font-extrabold text-xs tracking-widest uppercase text-center rounded-r-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#FAEEF5]">
                    @forelse($daftarProyek as $p)
                    <tr class="hover:bg-pink-50/40 transition-colors duration-200 group">
                        <td class="px-6 py-5">
                            <div class="text-[10px] font-bold text-[#B2A4FF] mb-1">{{ $p->request_no }}</div>
                            <div class="font-bold text-gray-800 text-base group-hover:text-[#B2A4FF] transition-colors">{{ $p->nama_pelanggan }}</div>
                            <div class="text-xs text-gray-400 mt-1 font-medium">{{ $p->pic_pelanggan }}</div>
                        </td>
                        <td class="px-6 py-5 font-medium text-gray-500">
                            <div class="mb-1 text-sm font-bold text-gray-700">{{ $p->category ? $p->category->nama_kategori : 'Tanpa Kategori' }}</div>
                            <div class="text-xs">{{ \Carbon\Carbon::parse($p->target_waktu)->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-5 font-bold text-gray-800 text-right">Rp {{ number_format($p->estimasi_budget, 0, ',', '.') }}</td>
                        <td class="px-6 py-5 text-center">
                             @if($p->status_proyek == 'waiting_rab')
                                <span class="px-3 py-1.5 bg-[#FFB4B4]/20 text-[#FFB4B4] border border-[#FFB4B4]/30 text-[10px] font-bold tracking-wide rounded-full">WAITING RAB</span>
                            @elseif($p->status_proyek == 'rab_approved' || $p->status_proyek == 'won')
                                <span class="px-3 py-1.5 bg-[#C8B6FF]/20 text-[#C8B6FF] border border-[#C8B6FF]/30 text-[10px] font-bold tracking-wide rounded-full uppercase">{{ str_replace('_', ' ', $p->status_proyek) }}</span>
                            @else
                                <span class="px-3 py-1.5 bg-gray-100 text-gray-500 border border-gray-200 text-[10px] font-bold tracking-wide rounded-full uppercase">{{ str_replace('_', ' ', $p->status_proyek) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button wire:click="lihatDetail({{ $p->id }})" class="p-2 text-[#B2A4FF] hover:bg-[#B2A4FF]/10 rounded-lg transition-colors cursor-pointer" title="Lihat Detail & Status RAB">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button wire:click="editProyek({{ $p->id }})" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors cursor-pointer" title="Edit Proyek">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button wire:click="hapusProyek({{ $p->id }})" onclick="confirm('Yakin hapus proyek beserta semua file lampirannya?') || event.stopImmediatePropagation()" class="p-2 text-rose-400 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer" title="Hapus Proyek">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center font-bold text-gray-500">Belum ada proyek yang sedang berjalan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($isModalOpen)
    <div class="fixed inset-0 z-[100] overflow-y-auto bg-gray-900/40 backdrop-blur-sm flex items-center justify-center p-4 py-8 transition-all duration-300">
        <div class="bg-white rounded-3xl shadow-[0_20px_60px_rgba(178,164,255,0.2)] w-full max-w-2xl max-h-[90vh] flex flex-col transform transition-all border border-pink-50">
            <div class="px-6 md:px-8 py-5 border-b border-[#FAEEF5] flex justify-between items-center bg-white rounded-t-3xl sticky top-0 z-10">
                <div>
                    <h3 class="text-lg font-black text-gray-800">{{ $isEdit ? 'Edit Data Proyek' : 'Form Inisiasi Proyek' }}</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5 font-semibold">{{ $isEdit ? 'Perbarui data kebutuhan klien' : 'Lampiran bisa diupload lebih dari 1 file' }}</p>
                </div>
                <button wire:click="tutupModal" class="w-8 h-8 rounded-full bg-gray-50 text-gray-400 hover:text-rose-400 flex items-center justify-center cursor-pointer"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            
            <form wire:submit.prevent="{{ $isEdit ? 'updateProyek' : 'simpanProyek' }}" class="p-6 md:p-8 space-y-5 overflow-y-auto flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[11px] font-extrabold text-[#B2A4FF] uppercase mb-1">Kategori Proyek</label>
                        <input list="list-kat" wire:model="nama_kategori" class="w-full text-sm px-4 py-2 bg-gray-50 border-transparent focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl" placeholder="Ketik baru / Pilih...">
                        <datalist id="list-kat">
                            @foreach($listKategori as $kat) <option value="{{ $kat }}"> @endforeach
                        </datalist>
                        @error('nama_kategori') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-extrabold text-[#B2A4FF] uppercase mb-1">Prioritas</label>
                        <select wire:model="priority" class="w-full text-sm px-4 py-2 bg-gray-50 border-transparent focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl cursor-pointer">
                            <option value="low">Rendah (Low)</option>
                            <option value="medium">Sedang (Medium)</option>
                            <option value="high">Mendesak (High)</option>
                        </select>
                        @error('priority') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-extrabold text-[#B2A4FF] uppercase mb-1">Nama PT / Klien</label>
                        <input list="list-pt" wire:model="nama_pelanggan" class="w-full text-sm px-4 py-2 bg-gray-50 border-transparent focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl" placeholder="Ketik / Pilih PT...">
                        <datalist id="list-pt">
                            @foreach($listPT as $pt) <option value="{{ $pt }}"> @endforeach
                        </datalist>
                        @error('nama_pelanggan') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-extrabold text-[#B2A4FF] uppercase mb-1">Nama PIC</label>
                        <input list="list-pic" wire:model="pic_pelanggan" class="w-full text-sm px-4 py-2 bg-gray-50 rounded-xl border-transparent focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20" placeholder="Ketik / Pilih PIC...">
                        <datalist id="list-pic">
                            @foreach($listPIC as $pic) <option value="{{ $pic }}"> @endforeach
                        </datalist>
                        @error('pic_pelanggan') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-extrabold text-[#B2A4FF] uppercase mb-1">Nomor WhatsApp</label>
                        <input type="text" wire:model="no_hp" class="w-full text-sm px-4 py-2 bg-gray-50 rounded-xl border-transparent focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20" placeholder="0812...">
                        @error('no_hp') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-extrabold text-[#B2A4FF] uppercase mb-1">Target Selesai</label>
                        <input type="date" wire:model="target_waktu" class="w-full text-sm px-4 py-2 bg-gray-50 rounded-xl border-transparent focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 text-gray-600">
                        @error('target_waktu') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-[#B2A4FF] uppercase mb-1">Estimasi Budget</label>
                    <input type="number" wire:model="estimasi_budget" class="w-full text-sm px-4 py-2 bg-gray-50 rounded-xl border-transparent focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20" placeholder="10000000">
                    @error('estimasi_budget') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-[#B2A4FF] uppercase mb-1">Alamat Proyek</label>
                    <input list="list-lokasi" wire:model="alamat" class="w-full text-sm px-4 py-2 bg-gray-50 border-transparent focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 rounded-xl" placeholder="Ketik lokasi / Pilih history...">
                    <datalist id="list-lokasi">
                        @foreach($listLokasi as $lok) <option value="{{ $lok }}"> @endforeach
                    </datalist>
                    @error('alamat') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-[#B2A4FF] uppercase mb-1">Deskripsi Teknis</label>
                    <textarea wire:model="deskripsi_proyek" rows="2" class="w-full text-sm px-4 py-2 bg-gray-50 rounded-xl border-transparent focus:bg-white focus:border-[#B2A4FF] focus:ring-4 focus:ring-[#B2A4FF]/20 resize-none"></textarea>
                    @error('deskripsi_proyek') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-[#B2A4FF] uppercase mb-1.5">{{ $isEdit ? 'Tambah Lampiran Baru (Opsional)' : 'Lampiran Dokumen / Gambar' }}</label>
                    <div class="relative flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full min-h-[96px] border-2 border-dashed border-[#B2A4FF]/30 rounded-2xl cursor-pointer bg-gray-50 hover:bg-pink-50/40">
                            <div class="flex flex-col items-center justify-center text-center p-4">
                                <svg class="w-5 h-5 text-[#B2A4FF] mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <p class="text-[11px] text-gray-500 font-bold"><span class="text-[#B2A4FF]">Klik untuk pilih file</span> tambahan</p>
                                @if(count($lampiran) > 0)
                                    <p class="text-[10px] text-emerald-500 mt-2 font-bold">{{ count($lampiran) }} file siap diupload.</p>
                                @endif
                            </div>
                            <input type="file" wire:model="lampiran" multiple class="hidden" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" />
                        </label>
                    </div>
                    <div wire:loading wire:target="lampiran" class="text-[11px] text-[#B2A4FF] mt-1 font-bold">Memproses file...</div>
                    @error('lampiran.*') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-[#FAEEF5] bg-white sticky bottom-0">
                    <button type="button" wire:click="tutupModal" class="px-5 py-2.5 text-sm font-bold text-gray-400 rounded-xl hover:bg-gray-50 transition-colors cursor-pointer">BATAL</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-[#B2A4FF] to-[#9B8CFF] hover:to-[#8a7af0] rounded-xl flex items-center gap-2 cursor-pointer shadow-lg shadow-[#B2A4FF]/30">
                        <span wire:loading wire:target="{{ $isEdit ? 'updateProyek' : 'simpanProyek' }}" class="animate-spin h-4 w-4 border-2 border-t-white rounded-full"></span>
                        {{ $isEdit ? 'UPDATE DATA' : 'SIMPAN DATA' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($isDetailModalOpen)
    <div class="fixed inset-0 z-[100] overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 py-8 transition-all duration-300">
        <div class="bg-white rounded-3xl w-full max-w-3xl max-h-[90vh] flex flex-col shadow-[0_20px_60px_rgba(178,164,255,0.2)] border border-[#B2A4FF]/20 overflow-hidden transform transition-all">
            
            <div class="px-6 py-5 border-b border-[#FAEEF5] flex justify-between items-center sticky top-0 bg-white z-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#FAEEF5] text-[#B2A4FF] flex items-center justify-center border border-[#B2A4FF]/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-gray-800">{{ $detail_request_no }}</h3>
                        <p class="text-[11px] text-gray-500 font-bold tracking-wide uppercase">{{ $detail_nama_pelanggan }}</p>
                    </div>
                </div>
                <button wire:click="tutupDetailModal" class="w-10 h-10 rounded-full bg-gray-50 hover:bg-rose-50 hover:text-rose-400 flex justify-center items-center transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 md:p-8 space-y-6 overflow-y-auto flex-1 bg-[#FAEEF5]/20">
                
                <div class="bg-white p-6 rounded-2xl border border-pink-50 shadow-sm space-y-6">
                    <h4 class="text-xs font-extrabold text-[#B2A4FF] uppercase tracking-widest border-b border-pink-50 pb-2">Informasi Lapangan</h4>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-[#FAEEF5]/50 p-3 rounded-xl">
                            <p class="text-[10px] tracking-widest font-bold text-gray-400 uppercase">Kategori</p>
                            <p class="text-xs font-black text-gray-800 mt-1 uppercase">{{ $detail_kategori }}</p>
                        </div>
                        <div class="bg-[#FAEEF5]/50 p-3 rounded-xl">
                            <p class="text-[10px] tracking-widest font-bold text-gray-400 uppercase">Prioritas</p>
                            <p class="text-xs font-black text-gray-800 mt-1 uppercase">{{ $detail_priority }}</p>
                        </div>
                        <div class="bg-[#FAEEF5]/50 p-3 rounded-xl">
                            <p class="text-[10px] tracking-widest font-bold text-gray-400 uppercase">Target Waktu</p>
                            <p class="text-xs font-black text-gray-800 mt-1">{{ \Carbon\Carbon::parse($detail_target_waktu)->format('d M Y') }}</p>
                        </div>
                        <div class="bg-[#B2A4FF]/10 p-3 rounded-xl border border-[#B2A4FF]/20">
                            <p class="text-[10px] tracking-widest font-bold text-[#B2A4FF] uppercase">Budget Awal</p>
                            <p class="text-sm font-black text-[#5C5470] mt-1">Rp {{ number_format((int)$detail_estimasi_budget, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-[10px] tracking-widest font-bold text-gray-400 uppercase mb-1">PIC & Kontak</p>
                            <p class="text-sm font-bold text-gray-800">{{ $detail_pic_pelanggan }} <span class="text-gray-500 font-medium">({{ $detail_no_hp }})</span></p>
                            
                            <p class="text-[10px] tracking-widest font-bold text-gray-400 uppercase mt-4 mb-1">Alamat Proyek</p>
                            <p class="text-xs font-medium text-gray-600 leading-relaxed">{{ $detail_alamat }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] tracking-widest font-bold text-gray-400 uppercase mb-1">Deskripsi Teknis</p>
                            <p class="text-xs font-medium text-gray-600 leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100 whitespace-pre-wrap">{{ $detail_deskripsi_proyek }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-pink-50 shadow-sm">
                    <h4 class="text-xs font-extrabold text-[#B2A4FF] uppercase tracking-widest border-b border-pink-50 pb-2 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Status Perhitungan RAB (Engineering)
                    </h4>
                    
                    @php
                        // Cek data RAB dari Database langsung di Blade
                        $rabTerkait = \App\Models\Rab::where('id_r_project', $detail_id)->first();
                    @endphp

                    @if($rabTerkait)
                        <div class="flex flex-col md:flex-row items-center justify-between bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $rabTerkait->no_boq }}</p>
                                <div class="flex items-center gap-3 mt-1">
                                    <p class="text-xs font-semibold text-gray-500">Nilai HPP: <span class="text-gray-800">Rp {{ number_format($rabTerkait->grand_total, 0, ',', '.') }}</span></p>
                                    <span class="text-gray-300">|</span>
                                    @if($rabTerkait->status_rab == 'approved')
                                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded uppercase">RAB APPROVED</span>
                                    @else
                                        <span class="text-[10px] font-bold text-amber-600 bg-amber-100 px-2 py-0.5 rounded uppercase">PENDING APPROVAL</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 md:mt-0">
                                @if($rabTerkait->status_rab == 'approved')
                                   <a href="{{ route('marketing.bidding', ['create_from_proyek' => $detail_id]) }}" wire:navigate class="px-5 py-2.5 text-xs font-bold text-white bg-gradient-to-r from-[#B2A4FF] to-[#9B8CFF] hover:to-[#8a7af0] rounded-xl shadow-md transition-all flex items-center gap-2 cursor-pointer">
                                        LANJUT BUAT BIDDING
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                @else
                                    <p class="text-[10px] text-gray-400 italic font-medium">Bidding dibuat setelah RAB di-Approve.</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-6 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-xs font-bold text-gray-500">Tim Engineering belum menghitung RAB untuk proyek ini.</p>
                        </div>
                    @endif
                </div>

            </div>
            
            <div class="px-6 py-4 bg-white border-t border-[#FAEEF5] flex justify-end rounded-b-3xl">
                <button wire:click="tutupDetailModal" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors cursor-pointer">TUTUP DETAIL</button>
            </div>
        </div>
    </div>
    @endif
</div>