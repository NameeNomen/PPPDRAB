<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PPPDRAB - PT Tri Jaya Teknik' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style> 
        /* Background utama sangat cerah (tint terang dari D9E2E0) agar tetap bersih dan nyaman di mata */
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #F2F5F4; 
            min-height: 100vh;
        } 
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .livewire-navigating { opacity: 0.5; filter: blur(2px); pointer-events: none; transition: all 0.3s ease-in-out; }
        
        body { overflow-x: hidden; }
        
        /* Custom scrollbar menggunakan palet hijau sage */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #A0BDB4; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #557752; }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased text-[#435F42]">

    <nav class="bg-white/80 backdrop-blur-xl border-b border-[#A0BDB4]/40 sticky top-0 z-50 h-16 shadow-[0_4px_20px_-10px_rgba(160,189,180,0.25)] flex items-center transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex justify-between items-center relative">
            
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-[#5B4E3F] text-[#D9E2E0] rounded-xl flex items-center justify-center font-black font-mono text-xs shadow-sm shadow-[#5B4E3F]/20">TJT</div>
                <span class="text-xl font-black text-[#435F42] tracking-tight">PPPD<span class="text-[#A0BDB4]">RAB</span></span>
            </div>
            
            <div class="flex space-x-2 items-center relative h-full overflow-x-auto no-scrollbar py-2">
                @auth
                    @php
                        $route = request()->route()->getName();
                        
                        // KELAS MENU AKTIF: Background hijau daun, teks putih, shadow hijau halus
                        $activeClass = 'bg-[#557752] text-white px-5 py-2 rounded-full shadow-[0_4px_12px_rgba(85,119,82,0.3)] font-bold z-10 transition-all duration-300 text-[11px] tracking-widest whitespace-nowrap';
                        
                        // KELAS MENU TIDAK AKTIF: Teks forest green, hover berubah ke background frost abu-abu dan teks coklat gelap
                        $inactiveClass = 'text-[#435F42] hover:text-[#5B4E3F] hover:bg-[#D9E2E0]/60 px-4 py-2 rounded-full text-[11px] font-semibold transition-all duration-300 tracking-wider whitespace-nowrap';
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
                        <a href="{{ route('direktur.persetujuan') }}" wire:navigate class="{{ request()->routeIs('direktur.persetujuan') ? $activeClass : $inactiveClass }}">Pending</a>                    
                    @endif
                @endauth
            </div>

            <div class="flex items-center gap-3 pl-4 md:pl-6 relative border-l border-[#A0BDB4]/40">
                @auth
                
                <livewire:component.notification-bell />

                <div class="text-right hidden md:block pl-2">
                    <p class="text-[13px] font-black text-[#435F42] leading-none">{{ auth()->user()->username }}</p>
                    <p class="text-[9px] text-[#A0BDB4] uppercase tracking-widest font-bold mt-1">{{ auth()->user()->role }}</p>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0 ml-1">
                    @csrf
                    <button type="submit" class="p-2 text-[#A0BDB4] hover:text-[#5B4E3F] hover:bg-[#D9E2E0]/50 rounded-full transition-all cursor-pointer flex items-center justify-center group border border-transparent hover:border-[#D9E2E0]" title="Keluar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
                @endauth
            </div>

        </div>
    </nav>

    <main class="mt-6 md:mt-10 px-4 max-w-7xl mx-auto pb-16">
        {{ $slot }}
    </main>

</body>
</html>