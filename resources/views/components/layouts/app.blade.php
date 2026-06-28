<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Commercial Project System' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F4F9F6;
            overflow-x: hidden;
        }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .livewire-navigating { opacity: 0.5; filter: blur(2px); pointer-events: none; transition: all 0.3s ease-in-out; }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #B4CDBF; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #7A9D8C; }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    
    {{-- WAJIB ADA: Untuk memuat CSS bawaan Livewire --}}
    @livewireStyles
</head>

<body class="antialiased text-[#2A402B] flex flex-col min-h-screen">

    {{-- ═══════════════════════════════════════════ --}}
    {{--  NAVBAR (Udah Diperkecil & Diposisikan)     --}}
    {{-- ═══════════════════════════════════════════ --}}
    <header class="w-full pt-2 px-4 md:px-6 max-w-[100rem] mx-auto z-50 relative">
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl border border-[#B4CDBF]/60 shadow-sm relative transition-all">

            {{-- BARIS 1: User (Kiri) | Logo (Tengah) | Logout (Kanan) --}}
            <div class="flex items-center justify-between px-4 md:px-6 py-2.5 border-b border-[#B4CDBF]/30">

                {{-- KIRI UJUNG: Profil User & Avatar --}}
                <div class="flex-1 flex justify-start items-center gap-2.5">
                    @auth
                        <div class="relative w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#E2EFE7] flex items-center justify-center shadow-sm border-2 border-white overflow-hidden shrink-0">
                            @if(auth()->user()->role === 'marketing')
                                <svg viewBox="0 0 100 100" class="w-full h-full pt-2">
                                    <circle cx="50" cy="45" r="25" fill="#fcdba9"/>
                                    <path d="M 25 45 A 25 25 0 0 1 75 45" fill="none" stroke="#2A402B" stroke-width="4"/>
                                    <circle cx="25" cy="45" r="5" fill="#2A402B"/>
                                    <circle cx="75" cy="45" r="5" fill="#2A402B"/>
                                    <path d="M 75 45 L 60 55" stroke="#2A402B" stroke-width="3" fill="none"/>
                                    <path d="M 35 70 C 35 50, 65 50, 65 70 L 75 100 L 25 100 Z" fill="#10b981"/>
                                </svg>
                            @elseif(auth()->user()->role === 'engineering')
                                <svg viewBox="0 0 100 100" class="w-full h-full pt-2">
                                    <circle cx="50" cy="50" r="22" fill="#fcdba9"/>
                                    <path d="M 23 45 C 23 20, 77 20, 77 45 L 82 45 L 82 52 L 18 52 L 18 45 Z" fill="#eab308"/>
                                    <path d="M 30 75 C 30 55, 70 55, 70 75 L 85 100 L 15 100 Z" fill="#2563eb"/>
                                </svg>
                            @elseif(auth()->user()->role === 'purchasing')
                                <svg viewBox="0 0 100 100" class="w-full h-full pt-1">
                                    <path d="M 30 20 Q 50 10 70 20 Q 80 40 75 60 L 25 60 Q 20 40 30 20" fill="#475569"/>
                                    <circle cx="50" cy="45" r="20" fill="#fcdba9"/>
                                    <rect x="35" y="40" width="12" height="8" rx="2" fill="none" stroke="#2A402B" stroke-width="2"/>
                                    <rect x="53" y="40" width="12" height="8" rx="2" fill="none" stroke="#2A402B" stroke-width="2"/>
                                    <path d="M 47 44 L 53 44" stroke="#2A402B" stroke-width="2"/>
                                    <path d="M 35 65 C 35 50, 65 50, 65 65 L 80 100 L 20 100 Z" fill="#d97706"/>
                                </svg>
                            @elseif(auth()->user()->role === 'direktur')
                                <svg viewBox="0 0 100 100" class="w-full h-full pt-2">
                                    <path d="M 30 30 Q 50 10 70 30 L 70 50 L 30 50 Z" fill="#1e293b"/>
                                    <circle cx="50" cy="40" r="22" fill="#fcdba9"/>
                                    <path d="M 35 65 C 35 55, 65 55, 65 65 L 80 100 L 20 100 Z" fill="#4f46e5"/>
                                    <path d="M 40 65 L 50 85 L 60 65 Z" fill="#f8fafc"/>
                                    <path d="M 47 65 L 50 90 L 53 65 Z" fill="#dc2626"/>
                                </svg>
                            @else
                                <svg viewBox="0 0 100 100" class="w-full h-full pt-2">
                                    <circle cx="50" cy="45" r="22" fill="#fcdba9"/>
                                    <path d="M 35 70 C 35 50, 65 50, 65 70 L 80 100 L 20 100 Z" fill="#64748b"/>
                                </svg>
                            @endif
                        </div>

                        <div class="hidden md:block leading-none">
                            <p class="text-[13px] font-black text-[#2A402B]">{{ auth()->user()->username }}</p>
                            <p class="text-[9px] text-[#648B73] uppercase tracking-wider font-bold mt-0.5">{{ auth()->user()->role }}</p>
                        </div>
                    @endauth
                </div>

                {{-- TENGAH: TJT (Kiri) - Teks (Tengah) - ISO (Kanan) --}}
                <div class="flex-none flex items-center justify-center gap-2 md:gap-3 shrink-0">
                    <div class="w-8 h-8 md:w-9 md:h-9 bg-white rounded-lg p-1 border border-[#B4CDBF]/30 shadow-sm">
                        <img src="{{ asset('gambar/tjt.png') }}" alt="PT Tri Jaya Teknik" class="w-full h-full object-contain">
                    </div>

                    <h1 class="hidden sm:block text-center text-sm md:text-base font-black text-[#2A402B] tracking-tight whitespace-nowrap">
                        PT Tri Jaya Teknik Karawang
                    </h1>

                    <div class="w-8 h-8 md:w-9 md:h-9 bg-white rounded-lg p-1 border border-[#B4CDBF]/30 shadow-sm">
                        <img src="{{ asset('gambar/iso.png') }}" alt="ISO Certified" class="w-full h-full object-contain">
                    </div>
                </div>

                {{-- KANAN UJUNG: Logout --}}
                <div class="flex-1 flex justify-end items-center">
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 text-rose-500 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-all flex items-center justify-end gap-1.5 font-bold text-[10px] uppercase tracking-widest border border-transparent hover:border-rose-100" title="Keluar Sistem">
                                <span class="hidden lg:inline">Logout</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </button>
                        </form>
                    @endauth
                </div>
            </div>

            {{-- BARIS 2: Menu Navigasi (Tengah) & Lonceng Notif (Mojok Kanan) --}}
<div class="relative flex justify-center items-center px-4 md:px-6 py-2">
                {{-- Navigasi (Tengah) --}}
                <div class="flex items-center overflow-x-auto no-scrollbar gap-1 px-14 w-full justify-center">
                    @auth
                        @php
                            $route = request()->route()->getName();
                            $activeClass = 'bg-[#2A402B] text-white font-black px-4 py-1.5 rounded-lg border border-[#2A402B] transition-all text-[10px] tracking-widest uppercase shadow-sm whitespace-nowrap';
                            $inactiveClass = 'text-[#7A9D8C] hover:text-[#2A402B] hover:bg-[#E2EFE7] px-4 py-1.5 rounded-lg font-bold transition-all text-[10px] tracking-widest uppercase whitespace-nowrap';
                        @endphp

                        @if(auth()->user()->role === 'marketing')
                            <a href="{{ route('marketing.dashboard') }}" wire:navigate class="{{ $route === 'marketing.dashboard' ? $activeClass : $inactiveClass }}">Dashboard</a>
                            <a href="{{ route('marketing.proyek') }}" wire:navigate class="{{ $route === 'marketing.proyek' ? $activeClass : $inactiveClass }}">Proyek</a>
                            <a href="{{ route('marketing.bidding.index') }}" wire:navigate class="{{ $route === 'marketing.bidding.index' ? $activeClass : $inactiveClass }}">Bidding</a>
                            <a href="{{ route('marketing.bidding.histori') }}" wire:navigate class="{{ $route === 'marketing.bidding.histori' ? $activeClass : $inactiveClass }}">Histori</a>

                        @elseif(auth()->user()->role === 'engineering')
                            <a href="{{ route('engineering.dashboard') }}" wire:navigate class="{{ $route === 'engineering.dashboard' ? $activeClass : $inactiveClass }}">Dashboard</a>
                            <a href="{{ route('engineering.rab.index') }}" wire:navigate class="{{ in_array($route, ['engineering.rab.index', 'engineering.rab.detail', 'engineering.rab.workspace']) ? $activeClass : $inactiveClass }}">Kelola RAB</a>
                            <a href="{{ route('engineering.rab.histori') }}" wire:navigate class="{{ $route === 'engineering.rab.histori' ? $activeClass : $inactiveClass }}">Histori RAB</a>

                        @elseif(auth()->user()->role === 'purchasing')
                            <a href="{{ route('purchasing.dashboard') }}" wire:navigate class="{{ $route === 'purchasing.dashboard' ? $activeClass : $inactiveClass }}">Dashboard</a>
                            <a href="{{ route('purchasing.material-index') }}" wire:navigate class="{{ $route === 'purchasing.material-index' ? $activeClass : $inactiveClass }}">Master Material</a>

                        @elseif(auth()->user()->role === 'direktur')
                            <a href="{{ route('direktur.dashboard') }}" wire:navigate class="{{ $route === 'direktur.dashboard' ? $activeClass : $inactiveClass }}">Dashboard</a>
                            <a href="{{ route('direktur.persetujuan') }}" wire:navigate class="{{ request()->routeIs('direktur.persetujuan') ? $activeClass : $inactiveClass }}">Pending</a>
                        @endif
                    @endauth
                </div>

                {{-- Lonceng Notif Dinamis (Posisi Absolute Mojok Kanan) --}}
                @auth
                    <div class="absolute right-4 md:right-6 top-1/2 -translate-y-1/2">
                        {{-- PEMANGGILAN KOMPONEN ASLI. JANGAN DIUBAH JADI BUTTON STATIS! --}}
                        <livewire:component.notification-bell />
                    </div>
                @endauth

            </div>
        </div>
    </header>

    <main class="w-full flex-grow pt-4 pb-8 px-4 md:px-6 max-w-[100rem] mx-auto">
        {{ $slot }}
    </main>

    {{-- ═══════════════════════════════════════════ --}}
    {{--  FOOTER                                     --}}
    {{-- ═══════════════════════════════════════════ --}}
    <footer class="w-full py-6 border-t border-[#B4CDBF]/40 bg-white mt-auto shrink-0">
        <div class="max-w-7xl mx-auto px-6 flex flex-col items-center text-center gap-4">
            <div class="flex flex-col sm:flex-row items-center justify-center gap-2 text-[10px] font-bold text-[#7A9D8C] pt-3 w-full max-w-xs">
                <span>&copy; 2026 PT Tri Jaya Teknik</span>
                <span class="hidden sm:block w-1 h-1 bg-[#B4CDBF] rounded-full"></span>
                <span>Developed by <span class="text-[#2A402B] font-black">NameeNomen</span></span>
            </div>
        </div>
    </footer>

    {{-- WAJIB ADA: Untuk memuat JavaScript bawaan Livewire & Alpine --}}
    @livewireScripts
         <script src="autoplay-plugin.js"></script>

</body>
</html>