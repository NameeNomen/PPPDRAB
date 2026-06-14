<div class="min-h-screen flex w-full font-sans bg-emerald-50 relative overflow-hidden">

    <!-- LEFT SIDE: Slider -->
    <div class="relative w-full lg:w-[50%] overflow-hidden hidden lg:block">
        
        <!-- Background Image -->
        <div class="absolute inset-0 bg-[url('/gambar/gtjtk.png')] bg-cover bg-center z-0"></div>
        
        <!-- Green Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-emerald-700 to-emerald-900 z-10"></div>
        <!-- Decorative shapes -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 z-10"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2 z-10"></div>

        <!-- Slider Track -->
        <div id="slider-track" class="relative z-20 flex w-[300%] h-full transition-transform duration-1000 ease-in-out">
            
            <!-- Slide 1 -->
            <div class="w-1/3 h-full flex items-center px-20">
                <div class="w-full max-w-lg space-y-6">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                        <span class="text-xs font-semibold text-white uppercase tracking-widest">Enterprise Solution</span>
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Commercial Project <span class="text-emerald-300">System</span>
                    </h1>
                    <p class="text-emerald-50 text-lg leading-relaxed font-light">
                        Sistem terintegrasi untuk pengelolaan proyek, penawaran, dan anggaran biaya. Meningkatkan efisiensi serta pengendalian proses bisnis secara terpusat.
                    </p>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="w-1/3 h-full flex items-center px-20">
                <div class="w-full max-w-lg space-y-6">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                        <span class="text-xs font-semibold text-white uppercase tracking-widest">Real-time Monitoring</span>
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Kelola Proyek dengan <span class="text-emerald-300">Efektif</span>
                    </h1>
                    <p class="text-emerald-50 text-lg leading-relaxed font-light">
                        Pantau progres proyek, status persetujuan, dan aktivitas operasional secara real-time. Mendukung transparansi informasi dan pengambilan keputusan yang lebih cepat.
                    </p>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="w-1/3 h-full flex items-center px-20">
                <div class="w-full max-w-lg space-y-6">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                        <span class="text-xs font-semibold text-white uppercase tracking-widest">Integrated Platform</span>
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Efisien, Transparan, <span class="text-emerald-300">Terintegrasi</span>
                    </h1>
                    <p class="text-emerald-50 text-lg leading-relaxed font-light">
                        Kelola RAB, dokumen penawaran, dan proses persetujuan dalam satu platform. Dirancang untuk mendukung tata kelola proyek yang profesional dan akuntabel.
                    </p>
                </div>
            </div>
            
        </div>

        <!-- Slider Dots -->
        <div class="absolute bottom-12 left-20 z-30 flex gap-3">
            <div class="nav-dot w-10 h-1.5 rounded-full bg-white transition-all duration-500"></div>
            <div class="nav-dot w-3 h-1.5 rounded-full bg-white/40 transition-all duration-500"></div>
            <div class="nav-dot w-3 h-1.5 rounded-full bg-white/40 transition-all duration-500"></div>
        </div>
    </div>

    <!-- RIGHT SIDE: Login Card -->
    <div class="w-full lg:w-[50%] flex flex-col items-center justify-center p-6 sm:p-12 relative">
        
        <!-- Decorative blobs -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-200/40 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-56 h-56 bg-emerald-300/30 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <!-- Login Card -->
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl shadow-emerald-900/10 p-10 sm:p-12 space-y-8">
            
            <!-- Logo -->
            <div class="flex flex-col items-center space-y-4">
                <div class="w-20 h-20 rounded-2xl bg-emerald-50 flex items-center justify-center shadow-lg shadow-emerald-100">
                    <img src="/gambar/cps.png" alt="CPS Logo" class="h-14 w-auto object-contain" />
                </div>
                <div class="text-center space-y-1">
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Hello! Welcome back</h2>
                    <p class="text-sm text-slate-500">Silakan masuk dengan kredensial Anda</p>
                </div>
            </div>

            <form wire:submit="login" class="space-y-5">
                
                <!-- Username Input -->
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700 ml-1">Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" wire:model="username" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 placeholder:text-slate-400" placeholder="Masukkan username Anda" required />
                    </div>
                    @error('username') 
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1 ml-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-slate-700 ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" wire:model="password" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 placeholder:text-slate-400 tracking-wide" placeholder="••••••••" required />
                    </div>
                    @error('password') 
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1 ml-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500/20 transition-all" />
                        <span class="text-sm text-slate-600 group-hover:text-slate-800 transition-colors">Remember me</span>
                    </label>
                    <a href="#" class="text-sm font-medium text-emerald-600 hover:text-emerald-700 hover:underline transition-all">Reset Password</a>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] text-white font-semibold py-3.5 px-8 rounded-xl transition-all duration-200 shadow-lg shadow-emerald-600/20 hover:shadow-emerald-600/30">
                        Login
                    </button>
                </div>
            </form>
            
            <!-- Footer -->
            <div class="text-center pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-400">
                    &copy; {{ date('Y') }} Commercial Project System. All rights reserved.
                </p>
            </div>
            
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const track = document.getElementById('slider-track');
        const dots = document.querySelectorAll('.nav-dot');
        let currentIndex = 0;

        if (!track || dots.length === 0) return; 

        const updateSlider = () => {
            currentIndex = (currentIndex + 1) % 3;
            track.style.transform = `translateX(-${currentIndex * 33.3333}%)`;

            dots.forEach((dot, index) => {
                if (index === currentIndex) {
                    dot.classList.remove('w-3', 'bg-white/40');
                    dot.classList.add('w-10', 'bg-white');
                } else {
                    dot.classList.remove('w-10', 'bg-white');
                    dot.classList.add('w-3', 'bg-white/40');
                }
            });
        };

        setInterval(updateSlider, 5000); 
    });
</script>