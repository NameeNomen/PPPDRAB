<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PPPDRAB - PT Tri Jaya Teknik' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style> 
        /* Background luar menggunakan warna abu-abu keunguan (dusty lilac) seperti bingkai luar pada gambar */
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #E0DCE3; 
            min-height: 100vh;
        } 
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .livewire-navigating { opacity: 0.5; pointer-events: none; transition: opacity 0.3s ease-in-out; }
        
        body { overflow-x: hidden; }
        
        /* Scrollbar disembunyikan agar terlihat rapi */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased text-[#4A6284]">

    <!-- Navbar menggunakan warna biru laut pastel seperti warna bagian dalam koper record player -->
    <!-- Diberi border bawah agak tebal untuk meniru gaya ilustrasi 2D -->
    <nav class="bg-[#AEC9E6] border-b-4 border-[#7A98B8] sticky top-0 z-50 h-16 flex items-center transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex justify-between items-center relative">
            
            <div class="flex items-center gap-3">
                <!-- Logo TJT: Menggunakan warna biru gelap (seperti tengah piringan hitam) dengan efek 3D pop-up ala kartun -->
                <div class="w-8 h-8 bg-[#4A6284] text-[#F4F7FB] rounded-xl flex items-center justify-center font-black font-mono text-sm border-2 border-[#7A98B8] shadow-[0_3px_0_0_#7A98B8]">TJT</div>
                <!-- Teks Brand: Kontras biru gelap dan biru pastel -->
                <span class="text-xl font-black text-[#4A6284] tracking-wider">PPPD<span class="text-[#F4F7FB]">RAB</span></span>
            </div>
            
            <div class="flex space-x-1 items-center relative h-full overflow-x-auto no-scrollbar py-2">
                @auth
                    @php
                        $route = request()->route()->getName();
                        
                        // KELAS MENU AKTIF: Gaya tombol retro 2D yang seolah-olah "timbul" ke atas dengan bayangan solid
                        // Warnanya memakai warna biru gelap piringan hitam
                        $activeClass = 'bg-[#4A6284] text-[#F4F7FB] px-5 py-2.5 rounded-xl border-2 border-[#7A98B8] shadow-[0_4px_0_0_#7A98B8] transform -translate-y-1 font-black z-10 transition-all duration-300 uppercase text-[10px] tracking-widest whitespace-nowrap';
                        
                        // KELAS MENU TIDAK AKTIF: Lebih redup, saat dihover ada efek gelombang buih putih
                        $inactiveClass = 'text-[#4A6284] hover:text-[#4A6284] hover:bg-[#F4F7FB]/40 px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 uppercase tracking-wider whitespace-nowrap';
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

            <div class="flex items-center gap-4 pl-4 md:pl-6 relative">
                @auth
                
                <livewire:component.notification-bell />

                <!-- Garis pembatas warna biru laut yang lebih gelap -->
                <div class="text-right hidden md:block border-l-2 border-[#7A98B8] pl-4">
                    <p class="text-sm font-black text-[#4A6284] leading-tight">{{ auth()->user()->username }}</p>
                    <p class="text-[10px] text-[#F4F7FB] uppercase tracking-widest font-extrabold mt-0.5">{{ auth()->user()->role }}</p>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0">
                    @csrf
                    <!-- Tombol logout diubah mengikuti gaya tombol retro pada pemutar piringan hitam -->
                    <button type="submit" class="p-2 text-[#4A6284] hover:text-[#F4F7FB] hover:bg-[#4A6284] rounded-xl border-2 border-transparent hover:border-[#7A98B8] hover:shadow-[0_2px_0_0_#7A98B8] transform hover:-translate-y-0.5 transition-all cursor-pointer flex items-center justify-center group" title="Keluar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
                @endauth
            </div>

        </div>
    </nav>

    <main class="mt-6 px-4 max-w-7xl mx-auto">
        {{ $slot }}
    </main>

</body>
</html>