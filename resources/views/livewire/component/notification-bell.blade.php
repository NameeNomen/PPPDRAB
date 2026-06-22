{{-- Container utama yang punya perintah polling tiap 30 detik --}}
<div class="relative" x-data="{ open: false }" @click.away="open = false" wire:poll.30s>
    
    {{-- Tombol Lonceng --}}
    <button @click="open = !open" class="p-2 text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-50 rounded-xl transition-colors cursor-pointer relative shadow-sm border border-slate-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>

        {{-- Badge angka kalau ada notif yang belum dibaca --}}
        @if($jumlahUnread > 0)
            <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center animate-bounce">
                {{ $jumlahUnread }}
            </span>
        @endif
    </button>

    {{-- Dropdown Isi Notifikasi --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         class="absolute right-0 mt-2 w-80 bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden z-50" 
         style="display: none;">
        
        <div class="px-4 py-3 bg-slate-900 text-white flex justify-between items-center">
            <span class="text-xs font-black tracking-wider uppercase">Pemberitahuan</span>
            @if($jumlahUnread > 0)
                <span class="text-[9px] bg-rose-500 px-2 py-0.5 rounded font-bold uppercase">{{ $jumlahUnread }} Baru</span>
            @endif
        </div>

       <div class="divide-y divide-slate-100 max-h-64 overflow-y-auto">
            @forelse($notifikasi as $n)
                {{-- UBAH JADI ANCHOR TAG + WIRE:CLICK.PREVENT BIAR KLIKNYA NYANGKUT --}}
                <a href="#" 
                   wire:click.prevent="bacaNotif({{ $n->id }})" 
                   class="block w-full text-left px-4 py-3 hover:bg-slate-50 transition-colors flex flex-col gap-1 {{ !$n->is_read ? 'bg-amber-50/40' : '' }}">
                    
                    <div class="flex justify-between items-start">
                        <span class="text-xs font-black {{ !$n->is_read ? 'text-rose-600' : 'text-slate-700' }}">
                            {{ $n->judul }}
                        </span>
                        <span class="text-[9px] text-slate-400 font-medium shrink-0">
                            {{ $n->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed truncate w-full">
                        {{ $n->pesan }}
                    </p>
                </a>
            @empty
                <div class="px-4 py-8 text-center text-xs font-bold text-slate-400 bg-slate-50">
                    Tidak ada notifikasi untuk Anda.
                </div>
            @endforelse
        </div>
    </div>
</div>