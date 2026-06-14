<div class="min-h-screen flex w-full font-sans bg-gray-50 relative overflow-hidden">

    <div class="relative w-full lg:w-[60%] overflow-hidden hidden lg:block border-r border-gray-200">
        
        <div class="absolute inset-0 bg-[url('/gambar/gtjtk.png')] bg-cover bg-center z-0 scale-105"></div>
        
        <div class="absolute inset-0 bg-green-900/60 mix-blend-multiply z-10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-green-950/80 to-transparent z-10"></div>

        <div id="slider-track" class="relative z-20 flex w-[300%] h-full transition-transform duration-1000 ease-in-out">
            
            <div class="w-1/3 h-full flex items-center justify-center p-16 text-center">
                <div class="w-full max-w-2xl px-8">
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-6 tracking-tight drop-shadow-lg">
                        Commercial Project System
                    </h1>
                    <div class="h-1 w-20 bg-green-400 mx-auto mb-6 rounded-full"></div>
                    <p class="text-green-50 text-lg leading-relaxed font-light drop-shadow-md">
                        Sistem terintegrasi untuk pengelolaan proyek, penawaran, dan anggaran biaya. Meningkatkan efisiensi serta pengendalian proses bisnis secara terpusat.
                    </p>
                </div>
            </div>

            <div class="w-1/3 h-full flex items-center justify-center p-16 text-center">
                <div class="w-full max-w-2xl px-8">
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-6 tracking-tight drop-shadow-lg">
                        Kelola Proyek dengan Efektif
                    </h1>
                    <div class="h-1 w-20 bg-green-400 mx-auto mb-6 rounded-full"></div>
                    <p class="text-green-50 text-lg leading-relaxed font-light drop-shadow-md">
                        Pantau progres proyek, status persetujuan, dan aktivitas operasional secara real-time. Mendukung transparansi informasi dan pengambilan keputusan yang lebih cepat.
                    </p>
                </div>
            </div>

            <div class="w-1/3 h-full flex items-center justify-center p-16 text-center">
                <div class="w-full max-w-2xl px-8">
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-6 tracking-tight drop-shadow-lg">
                        Efisien, Transparan, Terintegrasi
                    </h1>
                    <div class="h-1 w-20 bg-green-400 mx-auto mb-6 rounded-full"></div>
                    <p class="text-green-50 text-lg leading-relaxed font-light drop-shadow-md">
                        Kelola RAB, dokumen penawaran, dan proses persetujuan dalam satu platform. Dirancang untuk mendukung tata kelola proyek yang profesional dan akuntabel.
                    </p>
                </div>
            </div>
            
        </div>

        <div class="absolute bottom-10 left-0 right-0 z-30 flex justify-center gap-3">
            <div class="nav-dot w-10 h-1.5 rounded-full bg-green-400 transition-all duration-300 shadow-[0_0_10px_rgba(74,222,128,0.5)]"></div>
            <div class="nav-dot w-3 h-1.5 rounded-full bg-white/40 transition-all duration-300"></div>
            <div class="nav-dot w-3 h-1.5 rounded-full bg-white/40 transition-all duration-300"></div>
        </div>
    </div>

    <div class="w-full lg:w-[40%] flex flex-col items-center justify-center p-8 sm:p-12 bg-white relative z-20 shadow-2xl">
        <div class="w-full max-w-sm">
            
            <div class="mb-10 text-center">
                <h2 class="text-3xl font-extrabold text-green-900 tracking-tight mb-2">Selamat Datang</h2>
                <p class="text-sm text-gray-500">Silakan masukkan kredensial staf Anda.</p>
            </div>

            <form wire:submit="login" class="space-y-6">
                
                <div class="relative group">
                    <label class="text-xs font-bold text-green-700 uppercase tracking-wider mb-2 block">Username / Email</label>
                    <input type="text" wire:model="username" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all" placeholder="Masukkan ID Anda" required />
                    @error('username') <span class="text-red-500 text-xs absolute -bottom-5 left-0">{{ $message }}</span> @enderror
                </div>

                <div class="relative group">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-xs font-bold text-green-700 uppercase tracking-wider block">Password</label>
                        <a href="#" class="text-xs text-gray-500 hover:text-green-700 transition-colors">Lupa Password?</a>
                    </div>
                    <input type="password" wire:model="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all tracking-widest" placeholder="••••••••" required />
                    @error('password') <span class="text-red-500 text-xs absolute -bottom-5 left-0">{{ $message }}</span> @enderror
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-green-800 hover:bg-green-700 text-white font-bold py-3.5 px-8 rounded-lg transition-all duration-300 shadow-lg shadow-green-900/20 hover:-translate-y-0.5">
                        LOGIN SISTEM
                    </button>
                </div>
            </form>
            
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const track = document.getElementById('slider-track');
        const dots = document.querySelectorAll('.nav-dot');
        let currentIndex = 0;

        if (!track) return; 

        setInterval(() => {
            currentIndex = (currentIndex + 1) % 3;
            track.style.transform = `translateX(-${currentIndex * 33.3333}%)`;

            dots.forEach((dot, index) => {
                if (index === currentIndex) {
                    dot.classList.replace('w-3', 'w-10');
                    dot.classList.replace('bg-white/40', 'bg-green-400');
                    dot.classList.add('shadow-[0_0_10px_rgba(74,222,128,0.5)]');
                } else {
                    dot.classList.replace('w-10', 'w-3');
                    dot.classList.replace('bg-green-400', 'bg-white/40');
                    dot.classList.remove('shadow-[0_0_10px_rgba(74,222,128,0.5)]');
                }
            });
        }, 5000); 
    });
</script>