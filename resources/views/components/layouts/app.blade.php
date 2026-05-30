<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PPPDRAB - PT Tri Jaya Teknik' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; } 
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .livewire-navigating { opacity: 0.5; pointer-events: none; transition: opacity 0.2s ease-in-out; }
        
        /* Mencegah scrollbar horizontal muncul kalau tombol active offsetnya kebesaran */
        body { overflow-x: hidden; }
    </style>
</head>
<body class="antialiased text-slate-800">

    <nav class="bg-[#E6F4F1] border-b border-white sticky top-0 z-50 h-16 shadow-sm flex items-center transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex justify-between items-center relative">
            
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-teal-500 text-white rounded-xl flex items-center justify-center font-black font-mono text-sm shadow-md shadow-teal-300/50">TJT</div>
                <span class="text-xl font-black text-teal-900 tracking-wider">PPPD<span class="text-teal-500">RAB</span></span>
            </div>
            
            <div class="flex space-x-1 items-center relative h-full">
                @auth
                    @php
                        // Deteksi route aktif buat nentuin menu mana yang harus 'nongol'
                        $route = request()->route()->getName();
                        
                        // KELAS UNTUK MENU AKTIF (NONGOL KE DEPAN)
                        // translate-y-3 = ditarik turun | scale-110 = dibesarin | border-4 border-[#E6F4F1] = ilusi potongan
                        $activeClass = 'bg-teal-500 text-white px-5 py-2.5 rounded-2xl shadow-lg shadow-teal-500/40 transform translate-y-3 scale-110 border-4 border-[#E6F4F1] font-black z-10 transition-all duration-300 uppercase text-[10px] tracking-widest';
                        
                        // KELAS UNTUK MENU TIDAK AKTIF (BIASA AJA)
                        $inactiveClass = 'text-teal-800 hover:bg-white/60 px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 uppercase tracking-wider';
                    @endphp

                    @if(auth()->user()->role === 'marketing')
                        <a href="{{ route('marketing.dashboard') }}" wire:navigate class="{{ $route === 'marketing.dashboard' ? $activeClass : $inactiveClass }}">Dashboard</a>
                        <a href="{{ route('marketing.proyek') }}" wire:navigate class="{{ $route === 'marketing.proyek' ? $activeClass : $inactiveClass }}">Proyek</a>
                        <a href="{{ route('marketing.bidding') }}" wire:navigate class="{{ $route === 'marketing.bidding' ? $activeClass : $inactiveClass }}">Bidding</a>
                        <a href="{{ route('marketing.bidding.histori') }}" wire:navigate class="{{ $route === 'marketing.bidding.histori' ? $activeClass : $inactiveClass }}">Histori</a>
                    
                    @elseif(auth()->user()->role === 'engineering')
                        <a href="{{ route('engineering.dashboard') }}" wire:navigate class="{{ $route === 'engineering.dashboard' ? $activeClass : $inactiveClass }}">Dashboard</a>
                        <a href="{{ route('engineering.rab') }}" wire:navigate class="{{ $route === 'engineering.rab' ? $activeClass : $inactiveClass }}">Kelola RAB</a>
                        <a href="{{ route('engineering.rab.histori') }}" wire:navigate class="{{ $route === 'engineering.rab.histori' ? $activeClass : $inactiveClass }}">Histori RAB</a>
                    
                    @elseif(auth()->user()->role === 'purchasing')
                        <a href="{{ route('purchasing.dashboard') }}" wire:navigate class="{{ $route === 'purchasing.dashboard' ? $activeClass : $inactiveClass }}">Dashboard</a>
                        <a href="{{ route('purchasing.material') }}" wire:navigate class="{{ $route === 'purchasing.material' ? $activeClass : $inactiveClass }}">Master Material</a>
                    
                    @elseif(auth()->user()->role === 'direktur')
                        <a href="{{ route('direktur.dashboard') }}" wire:navigate class="{{ $route === 'direktur.dashboard' ? $activeClass : $inactiveClass }}">Dashboard</a>
<a href="{{ route('direktur.persetujuan') }}" wire:navigate class="{{ request()->routeIs('direktur.persetujuan') ? $activeClass : $inactiveClass }}">Otorisasi</a>                    @endif
                @endauth
            </div>

            <div class="flex items-center gap-4 pl-6 relative">
                @auth
                
                <livewire:component.notification-bell />

                <div class="text-right hidden md:block border-l border-white/60 pl-4">
                    <p class="text-sm font-black text-teal-950 leading-tight">{{ auth()->user()->username }}</p>
                    <p class="text-[10px] text-teal-600 uppercase tracking-widest font-extrabold mt-0.5">{{ auth()->user()->role }}</p>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0">
                    @csrf
                    <button type="submit" class="p-2 text-rose-400 hover:text-white hover:bg-rose-400 rounded-xl transition-colors cursor-pointer flex items-center justify-center group shadow-sm bg-white border border-white" title="Keluar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
                @endauth
            </div>

        </div>
    </nav>

    <main class="mt-4">
        {{ $slot }}
    </main>

</body>
</html>