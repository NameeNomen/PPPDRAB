<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PPPDRAB - PT Tri Jaya Teknik' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style> 
        /* Background utama dibikin lebih "dingin" dengan hint hijau sangat pucat */
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #F4F9F6; 
            min-height: 100vh;
            overflow-x: hidden;
        } 
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .livewire-navigating { opacity: 0.5; filter: blur(2px); pointer-events: none; transition: all 0.3s ease-in-out; }
        
        /* Custom scrollbar yang lebih membaur tapi tetap kelihatan */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #B4CDBF; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #7A9D8C; }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased text-[#2A402B]"> <!-- Warna teks digelapin biar kontrasnya dapet -->

    <!-- Navbar: Shadow dibikin lebih smooth dan border disesuaikan -->
    <nav class="bg-white/85 backdrop-blur-xl border-b border-[#B4CDBF]/50 sticky top-0 z-50 h-[72px] shadow-[0_8px_30px_-12px_rgba(122,157,140,0.3)] flex items-center transition-all duration-300">
        <div class="max-w-[100rem] mx-auto px-6 lg:px-12 w-full flex justify-between items-center relative">
            
            <div class="flex items-center gap-4">
                <!-- Logo dibikin lebih hijau gelap -->
                <div class="w-10 h-10 bg-[#354F37] text-[#F4F9F6] rounded-xl flex items-center justify-center font-black font-mono text-sm shadow-md shadow-[#354F37]/30">TJT</div>
                <span class="text-2xl font-black text-[#2A402B] tracking-tight">PPPD<span class="text-[#648B73]">RAB</span></span>
            </div>
            
            <div class="flex space-x-3 items-center relative h-full overflow-x-auto no-scrollbar py-2">
                @auth
                    @php
                        $route = request()->route()->getName();
                        
                        /* Sistem Logika Menu:
                           Aktif: Background hijau solid, shadow hijau, teks putih.
                           Non-aktif: Teks hijau pudar, hover dapet background mint transparan.
                        */
                        $activeClass = 'bg-[#4A7256] text-white px-6 py-2.5 rounded-full shadow-[0_4px_16px_rgba(74,114,86,0.35)] font-bold z-10 transition-all duration-300 text-[12px] tracking-widest whitespace-nowrap';
                        
                        $inactiveClass = 'text-[#5C7E65] hover:text-[#2A402B] hover:bg-[#E2EFE7] px-5 py-2.5 rounded-full text-[12px] font-semibold transition-all duration-300 tracking-wider whitespace-nowrap';
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

            <div class="flex items-center gap-4 pl-6 md:pl-8 relative border-l border-[#B4CDBF]/50">
                @auth
                
                <livewire:component.notification-bell />

                <div class="text-right hidden md:block pl-2">
                    <p class="text-[14px] font-black text-[#2A402B] leading-none">{{ auth()->user()->username }}</p>
                    <p class="text-[10px] text-[#648B73] uppercase tracking-widest font-bold mt-1.5">{{ auth()->user()->role }}</p>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0 ml-2">
                    @csrf
                    <button type="submit" class="p-2.5 text-[#7A9D8C] hover:text-[#E55A5A] hover:bg-[#FCE8E8] rounded-full transition-colors cursor-pointer flex items-center justify-center group" title="Keluar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
                @endauth
            </div>

        </div>
    </nav>

    <!-- Konten Utama: Max width dibesarin drastis, padding ditambah -->
    <main class="mt-10 md:mt-14 px-6 lg:px-12 max-w-[100rem] mx-auto pb-24">
        {{ $slot }}
    </main>

</body>
</html>