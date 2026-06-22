<div class="min-h-screen font-sans transition-colors duration-300" style="font-family: 'Inter', sans-serif;"
     x-data="{ darkMode: false }"
     :class="darkMode ? 'bg-[#0A0A0A] text-[#F5F5F5]' : 'bg-[#FAFAFA] text-[#1A1A1A]'">

    @if (session()->has('sukses') || session()->has('success'))
        <div class="max-w-7xl mx-auto p-4 mb-4 mt-6 rounded-xl font-semibold flex items-center gap-3 shadow-xl border-2 text-xs tracking-wide uppercase"
             :class="darkMode ? 'bg-[#F5C518]/10 border-[#F5C518]/40 text-[#F5C518]' : 'bg-[#F5C518]/15 border-[#9A7B0A]/40 text-[#8B6914]'">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('sukses') ?? session('success') }}</span>
        </div>
    @endif

    <div class="max-w-7xl mx-auto p-4 md:p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 pb-5 border-b-2" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
            <div>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight flex items-center gap-3" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">
                    <span class="w-1.5 h-6 rounded-full inline-block bg-[#F5C518]"></span>
                    RAB Workspace
                </h1>
                <p class="text-xs font-medium mt-1 text-[#888888]">Sistem manajemen estimasi penawaran harga.</p>
            </div>

            <div class="flex items-center gap-1 p-1 rounded-lg border-2 shadow-sm transition-colors" :class="darkMode ? 'bg-[#1A1A1A] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                <button type="button" @click="darkMode = false" :class="!darkMode ? 'bg-[#F5C518] text-[#1A1A1A] font-bold shadow-md' : 'text-[#888888] hover:text-[#F5C518]'" class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all uppercase tracking-wider">Terang</button>
                <button type="button" @click="darkMode = true" :class="darkMode ? 'bg-[#F5C518] text-[#1A1A1A] font-bold shadow-md' : 'text-[#888888] hover:text-[#F5C518]'" class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all uppercase tracking-wider">Gelap</button>
            </div>
        </div>

        <div class="rounded-2xl p-4 mb-8 flex flex-col md:flex-row gap-4 items-center justify-between shadow-xl border-2 transition-colors"
             :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-4 h-4 shrink-0 text-[#888888]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" wire:model.live="searchProyek" placeholder="Cari proyek atau nomor request..."
                       class="w-full text-sm font-medium pl-11 pr-4 py-3 rounded-xl outline-none border-2 transition-all focus:ring-2 focus:ring-[#F5C518]/30 focus:border-[#F5C518]"
                       :class="darkMode ? 'bg-[#1A1A1A] border-[#2A2A2A] text-[#F5F5F5] placeholder-[#888888]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A] placeholder-[#888888]'">
            </div>
            <div class="flex items-center w-full md:w-auto">
                <select wire:model.live="filterStatus" class="w-full md:w-auto text-sm font-medium border-2 rounded-xl px-4 py-3 outline-none transition-all cursor-pointer focus:ring-2 focus:ring-[#F5C518]/30 focus:border-[#F5C518]"
                        :class="darkMode ? 'bg-[#1A1A1A] border-[#2A2A2A] text-[#F5F5F5]' : 'bg-[#FAFAFA] border-[#E5E5E5] text-[#1A1A1A]'">
                    <option value="all">Semua Status</option>
                    <option value="needs_action">Perlu Action Saya</option>
                    <option value="draft">Draft (Draf)</option>
                    <option value="pending">Pending (Menunggu Persetujuan)</option>
                    <option value="revision">Revisi</option>
                    <option value="approved">Approved</option>
                </select>
            </div>
        </div>

        @php
            $isSpecificFilter = !in_array($filterStatus, ['all', 'needs_action']);

            if (!$isSpecificFilter) {
                $revisionTasks = $daftarProyek->filter(fn($p) => strtolower($p->rab->status_rab ?? '') === 'revision')->values();
                $draftTasks = $daftarProyek->filter(fn($p) => !$p->rab || strtolower($p->rab->status_rab ?? '') === 'draft')->values();

                $displayProjects = $filterStatus === 'all'
                    ? $daftarProyek->filter(fn($p) => in_array(strtolower($p->rab->status_rab ?? ''), ['pending', 'approved']))->values()
                    : collect();
            } else {
                $revisionTasks = collect();
                $draftTasks = collect();
                $displayProjects = $daftarProyek; 
            }

            $hasPrioritySection = $revisionTasks->count() > 0 || $draftTasks->count() > 0;
        @endphp

        @if($hasPrioritySection)
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-black" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">Perlu Action Anda</h2>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#888888]">{{ $revisionTasks->count() + $draftTasks->count() }} dokumen menunggu</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($revisionTasks as $proyek)
                        <div class="rounded-2xl p-6 border-2 transition-all hover:-translate-y-0.5 shadow-xl"
                             :class="darkMode ? 'bg-[#111111] border-red-500/30 hover:border-red-500/60' : 'bg-white border-red-500/30 hover:border-red-500/60'">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[9px] font-bold uppercase rounded-lg bg-red-500/10 text-red-500 border border-red-500/30">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                            Perlu Revisi
                                        </span>
                                        <span class="text-[10px] font-mono text-[#888888]">{{ $proyek->request_no ?? '-' }}</span>
                                    </div>
                                    <h3 class="font-black text-lg" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">{{ $proyek->nama_pelanggan }}</h3>
                                    <p class="text-xs text-[#888888] mt-1">Status RAB: <span class="font-bold text-red-500">Revision</span></p>
                                </div>
                                <button wire:click="lihatDetail({{ $proyek->id }})"
                                        class="px-6 py-3 text-xs font-bold uppercase tracking-wider rounded-xl border-2 transition-all hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-red-500/30 bg-red-500 text-white hover:bg-red-600 border-red-500 shadow-lg shadow-red-500/30 whitespace-nowrap">
                                    Kerjakan Revisi RAB
                                </button>
                            </div>
                        </div>
                    @endforeach

                    @foreach($draftTasks as $proyek)
                        <div class="rounded-2xl p-6 border-2 transition-all hover:-translate-y-0.5 shadow-xl"
                             :class="darkMode ? 'bg-[#111111] border-[#F5C518]/30 hover:border-[#F5C518]/60' : 'bg-white border-[#F5C518]/30 hover:border-[#F5C518]/60'">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[9px] font-bold uppercase rounded-lg bg-[#F5C518]/10 text-[#9A7B0A] border border-[#9A7B0A]/30">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#F5C518]"></span>
                                            {{ $proyek->rab ? 'Draft' : 'Belum Ada RAB' }}
                                        </span>
                                        <span class="text-[10px] font-mono text-[#888888]">{{ $proyek->request_no ?? '-' }}</span>
                                    </div>
                                    <h3 class="font-black text-lg" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">{{ $proyek->nama_pelanggan }}</h3>
                                    <p class="text-xs text-[#888888] mt-1">Status: <span class="font-bold text-[#F5C518]">{{ $proyek->rab ? 'Draft' : 'Perlu Pembuatan RAB' }}</span></p>
                                </div>
                                <button wire:click="lihatDetail({{ $proyek->id }})"
                                        class="px-6 py-3 text-xs font-bold uppercase tracking-wider rounded-xl border-2 shadow-md transition-all hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-[#F5C518]/30 bg-[#F5C518] border-[#F5C518] text-[#1A1A1A] hover:bg-[#FFD700] whitespace-nowrap">
                                    Kerjakan RAB
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($displayProjects->count() > 0)
            <div>
                @if($hasPrioritySection)
                    <div class="flex items-center gap-2 mb-6 mt-12 border-t-2 pt-8" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
                        <span class="w-2 h-2 rounded-full bg-[#888888]"></span>
                        <h2 class="text-[10px] font-bold uppercase tracking-widest text-[#888888]">Proyek Lainnya</h2>
                        <span class="px-2 py-0.5 text-[9px] font-bold rounded-md bg-[#888888]/10 text-[#888888] border border-[#888888]/30">{{ $displayProjects->count() }}</span>
                    </div>
                @elseif($isSpecificFilter)
                    <div class="flex items-center gap-2 mb-6 border-b-2 pb-2" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
                        <span class="w-2 h-2 rounded-full bg-[#F5C518]"></span>
                        <h2 class="text-[10px] font-bold uppercase tracking-widest text-[#F5C518]">Hasil Filter Dokumen: {{ strtoupper($filterStatus) }}</h2>
                        <span class="px-2 py-0.5 text-[9px] font-bold rounded-md bg-[#F5C518]/10 text-[#8B6914] border border-[#F5C518]/30">{{ $displayProjects->count() }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($displayProjects as $proyek)
                        @php
                            $status = strtolower($proyek->rab->status_rab ?? 'draft');
                            $statusConfig = [
                                'draft' => ['label' => 'Draft', 'color' => 'bg-[#F5C518]', 'text' => 'text-[#9A7B0A]', 'bg' => 'bg-[#F5C518]/10', 'border' => 'border-[#9A7B0A]/30'],
                                'pending' => ['label' => 'Pending', 'color' => 'bg-orange-500', 'text' => 'text-orange-600', 'bg' => 'bg-orange-500/10', 'border' => 'border-orange-500/30'],
                                'revision' => ['label' => 'Revision', 'color' => 'bg-red-500', 'text' => 'text-red-500', 'bg' => 'bg-red-500/10', 'border' => 'border-red-500/30'],
                                'approved' => ['label' => 'Approved', 'color' => 'bg-emerald-500', 'text' => 'text-emerald-600', 'bg' => 'bg-emerald-500/10', 'border' => 'border-emerald-500/30'],
                            ];
                            $config = $statusConfig[$status] ?? $statusConfig['draft'];
                            $isLocked = in_array($status, ['pending', 'approved']);
                        @endphp

                        <div class="rounded-2xl p-6 border-2 transition-all hover:-translate-y-0.5 hover:shadow-xl"
                             :class="darkMode ? 'bg-[#111111] border-[#2A2A2A]' : 'bg-white border-[#E5E5E5]'">
                            <div class="flex justify-between items-start mb-3">
                                <span class="text-[10px] font-bold font-mono text-[#888888]">{{ $proyek->request_no ?? '-' }}</span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[9px] font-bold uppercase rounded-lg border-2 {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $config['color'] }}"></span>
                                    {{ $config['label'] }}
                                </span>
                            </div>
                            <h3 class="font-black text-sm mb-1 truncate" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">{{ $proyek->nama_pelanggan }}</h3>
                            
                            <div class="mt-4 pt-4 border-t-2" :class="darkMode ? 'border-[#2A2A2A]' : 'border-[#E5E5E5]'">
                                <button wire:click="lihatDetail({{ $proyek->id }})"
                                        class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider transition-colors hover:-translate-x-1"
                                        :class="darkMode ? 'text-[#F5C518]' : 'text-[#9A7B0A]'">
                                    {{ $isLocked ? '👁️ Lihat Dokumen (Read-Only)' : 'Edit RAB WBS' }}
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($daftarProyek->count() === 0)
            <div class="rounded-2xl border-2 border-dashed p-16 text-center" :class="darkMode ? 'border-[#2A2A2A] bg-[#111111]' : 'border-[#E5E5E5] bg-[#FAFAFA]'">
                <div class="w-24 h-24 mx-auto mb-6 rounded-2xl flex items-center justify-center bg-[#F5C518]/20">
                    <svg class="w-12 h-12 text-[#9A7B0A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-2xl font-black mb-2" :class="darkMode ? 'text-[#F5F5F5]' : 'text-[#1A1A1A]'">Tidak Ada Dokumen</h3>
                <p class="font-bold text-[#888888]">Tidak ada data proyek RAB dengan status tersebut.</p>
            </div>
        @endif
    </div>
</div>