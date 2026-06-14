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
        
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #B4CDBF; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #7A9D8C; }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="antialiased text-[#2A402B] flex flex-col min-h-screen"> 

    <header class="w-full pt-4 px-4 md:px-6 max-w-[100rem] mx-auto z-50 relative">
        <div class="bg-white/95 backdrop-blur-xl rounded-[1.5rem] border border-[#B4CDBF]/60 shadow-[0_4px_20px_-10px_rgba(42,64,43,0.15)] p-1.5 relative transition-all">
            
            <div class="flex items-center justify-between px-4 h-[48px] relative z-10 w-full">
                
                <div class="flex items-center gap-3 shrink-0 lg:w-[25%] justify-start">
                    <div class="w-8 h-8 bg-[#2A402B] text-white rounded-xl flex items-center justify-center font-black font-mono text-[10px] shadow-sm">CPS</div>
                    <span class="text-lg font-black text-[#2A402B] tracking-tight hidden sm:block">Commercial Project <span class="text-[#648B73]">System</span></span>
                </div>
                
                <div class="flex-grow flex justify-center space-x-1 items-center overflow-x-auto no-scrollbar mx-2 md:mx-4">
                    @auth
                        @php
                            $route = request()->route()->getName();
                            
                            $activeClass = 'bg-[#E2EFE7] text-[#2A402B] font-black px-4 py-1.5 rounded-full border border-[#B4CDBF]/50 transition-all text-[10px] tracking-widest uppercase shadow-sm whitespace-nowrap';
                            $inactiveClass = 'text-[#7A9D8C] hover:text-[#2A402B] hover:bg-slate-50 px-4 py-1.5 rounded-full font-bold transition-all text-[10px] tracking-widest uppercase whitespace-nowrap';
                        @endphp

                        @if(auth()->user()->role === 'marketing')
                            <a href="{{ route('marketing.dashboard') }}" wire:navigate class="{{ $route === 'marketing.dashboard' ? $activeClass : $inactiveClass }}">Dashboard</a>
                            <a href="{{ route('marketing.proyek') }}" wire:navigate class="{{ $route === 'marketing.proyek' ? $activeClass : $inactiveClass }}">Proyek</a>
                            <a href="{{ route('marketing.bidding') }}" wire:navigate class="{{ $route === 'marketing.bidding' ? $activeClass : $inactiveClass }}">Bidding</a>
                            <a href="{{ route('marketing.bidding.histori') }}" wire:navigate class="{{ $route === 'marketing.bidding.histori' ? $activeClass : $inactiveClass }}">Histori</a>
                        
                        @elseif(auth()->user()->role === 'engineering')
                            <a href="{{ route('engineering.dashboard') }}" wire:navigate class="{{ $route === 'engineering.dashboard' ? $activeClass : $inactiveClass }}">Dashboard</a>
                            <a href="{{ route('engineering.rab.index') }}" wire:navigate class="{{ in_array($route, ['engineering.rab.index', 'engineering.rab.detail', 'engineering.rab.workspace']) ? $activeClass : $inactiveClass }}">Kelola RAB</a>
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

                <div class="hidden lg:flex items-center justify-end lg:w-[25%] text-[10px] font-bold text-[#7A9D8C] font-mono pr-2">
                    {{ date('d M Y') }}
                </div>
            </div>

            <div class="flex justify-between items-center px-4 py-2 border-t border-[#B4CDBF]/30 mt-1">
                
                <div class="flex items-center gap-3">
                    @auth
                    <div class="w-7 h-7 rounded-full bg-[#E2EFE7] text-[#2A402B] flex items-center justify-center font-black text-xs shadow-inner">
                        {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                    </div>
                    <div class="hidden md:block">
                        <p class="text-[11px] font-black leading-none text-[#2A402B]">{{ auth()->user()->username }}</p>
                        <p class="text-[9px] text-[#648B73] uppercase tracking-widest font-bold mt-0.5">{{ auth()->user()->role }}</p>
                    </div>
                    @endauth
                </div>

                <div class="flex items-center gap-3">
                    @auth
                    <div class="text-[#2A402B]">
                        <livewire:component.notification-bell />
                    </div>
                    
                    <div class="w-px h-5 bg-[#B4CDBF]/50 mx-1"></div>
                    
                    <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 text-rose-500 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors flex items-center gap-1.5 font-bold text-[10px] uppercase tracking-widest" title="Keluar Sistem">
                            <span class="hidden sm:inline">Logout</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                    @endauth
                </div>
                
            </div>
        </div>
    </header>

    <main class="w-full flex-grow pt-4 pb-8">
        {{ $slot }}
    </main>

    <footer class="w-full py-4 text-center border-t border-[#B4CDBF]/40 bg-white/60 backdrop-blur-sm mt-auto shrink-0">
        <p class="text-[10px] font-black uppercase tracking-widest text-[#648B73]">
            &copy; NameeNomen 2026. All Rights Reserved.
        </p>
    </footer>

</body>
</html>