<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="min-h-screen flex w-full relative overflow-hidden" style="font-family: 'Inter', sans-serif; background-color: #EEF2E6;">

    <!-- LEFT SIDE: Slider -->
    <div class="relative w-full lg:w-[55%] overflow-hidden hidden lg:block shadow-[15px_0_40px_rgba(0,0,0,0.1)] z-10" style="background-color: #31572C;">
        
        <!-- Background Image -->
        <div class="absolute inset-0 bg-[url('/gambar/gtjtk.png')] bg-cover bg-center z-0 opacity-10"></div>
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 z-10" style="background: linear-gradient(to bottom right, #31572C 20%, rgba(37, 66, 33, 0.9) 100%);"></div>

        <!-- Simple Diagonal Pattern -->
        <div class="absolute inset-0 z-10 pointer-events-none">
            <div class="absolute top-[-10%] right-[15%] w-[3%] h-[150%] bg-[#ECF39E] transform -skew-x-[25deg] opacity-80"></div>
            <div class="absolute top-[-10%] right-[19%] w-[1%] h-[150%] bg-[#ECF39E] transform -skew-x-[25deg] opacity-60"></div>
        </div>

        <!-- Slider Track -->
        <div id="slider-track" class="relative z-20 flex w-[300%] h-full transition-transform duration-1000 ease-in-out">
            
            <!-- Slide 1 -->
            <div class="w-1/3 h-full flex flex-col justify-center px-12 xl:px-20">
                <div class="w-full max-w-lg">
                    <span class="inline-block text-xs font-bold uppercase tracking-widest mb-4" style="color: #ECF39E;">Enterprise Solution</span>
                    <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight tracking-tight mb-4">
                        Commercial Project<br><span style="color: #ECF39E;">System</span>
                    </h1>
                    <p class="text-sm leading-relaxed font-light" style="color: rgba(250, 249, 246, 0.85);">
                        Sistem terintegrasi untuk pengelolaan proyek, penawaran, dan anggaran biaya secara terpusat.
                    </p>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="w-1/3 h-full flex flex-col justify-center px-12 xl:px-20">
                <div class="w-full max-w-lg">
                    <span class="inline-block text-xs font-bold uppercase tracking-widest mb-4" style="color: #ECF39E;">Real-time Monitoring</span>
                    <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight tracking-tight mb-4">
                        Kelola Proyek<br><span style="color: #ECF39E;">dengan Efektif</span>
                    </h1>
                    <p class="text-sm leading-relaxed font-light" style="color: rgba(250, 249, 246, 0.85);">
                        Pantau progres proyek, status persetujuan, dan aktivitas operasional secara real-time.
                    </p>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="w-1/3 h-full flex flex-col justify-center px-12 xl:px-20">
                <div class="w-full max-w-lg">
                    <span class="inline-block text-xs font-bold uppercase tracking-widest mb-4" style="color: #ECF39E;">Integrated Platform</span>
                    <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight tracking-tight mb-4">
                        Efisien, Transparan,<br><span style="color: #ECF39E;">Terintegrasi</span>
                    </h1>
                    <p class="text-sm leading-relaxed font-light" style="color: rgba(250, 249, 246, 0.85);">
                        Kelola RAB, dokumen penawaran, dan proses persetujuan dalam satu platform profesional.
                    </p>
                </div>
            </div>

        </div>

        <!-- Slider Dots -->
        <div class="absolute bottom-10 left-12 xl:left-20 z-30 flex gap-2">
            <div class="nav-dot h-1.5 rounded-full transition-all duration-500" style="width: 40px; background-color: #ECF39E;"></div>
            <div class="nav-dot h-1.5 rounded-full transition-all duration-500" style="width: 12px; background-color: rgba(236, 243, 158, 0.35);"></div>
            <div class="nav-dot h-1.5 rounded-full transition-all duration-500" style="width: 12px; background-color: rgba(236, 243, 158, 0.35);"></div>
        </div>
    </div>

    <!-- RIGHT SIDE: Login -->
    <div class="w-full lg:w-[45%] flex flex-col items-center justify-center p-8 sm:p-12 relative z-20" style="background-color: #EEF2E6;">
        
        <div class="relative w-full max-w-sm bg-white rounded-xl overflow-hidden shadow-[0_20px_40px_rgba(0,0,0,0.08)] z-30 p-8 border border-gray-100 lg:-ml-16">
            
            <!-- Logo & Header -->
            <div class="flex flex-col items-center space-y-3 mb-8">
                <img src="/gambar/cps.png" alt="CPS Logo" class="h-12 w-auto object-contain" />
                <div class="text-center mt-2">
                    <h2 class="text-2xl font-extrabold tracking-tight text-[#31572C]">Welcome Back</h2>
                    <p class="text-xs font-semibold mt-1" style="color: #40916C;">Log in to your account</p>
                </div>
            </div>

            <!-- Form -->
            <form wire:submit="login" class="space-y-5">
                
                <!-- Username -->
                <div class="space-y-1.5 group">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-[#40916C]">Username</label>
                    <input type="text" wire:model="username" class="w-full px-4 py-3 bg-white text-[#31572C] rounded-md border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#A3B18A] focus:border-transparent transition-all duration-300 placeholder:text-gray-400 font-medium" placeholder="direktur" required />
                    @error('username') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-1.5 group">
                    <div class="flex justify-between items-center">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-[#40916C]">Password</label>
                        <a href="#" class="text-[10px] font-bold tracking-wide text-[#31572C] hover:text-[#40916C] hover:underline transition-colors">Forgot?</a>
                    </div>
                    <input type="password" wire:model="password" class="w-full px-4 py-3 bg-white text-[#31572C] rounded-md border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#A3B18A] focus:border-transparent transition-all duration-300 placeholder:text-gray-400 tracking-widest font-medium" placeholder="••••••••" required />
                    @error('password') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Show Password -->
                <label class="flex items-center gap-2 cursor-pointer w-max pt-1 group">
                    <input type="checkbox" class="w-3.5 h-3.5 appearance-none rounded-sm border-2 border-gray-300 checked:bg-[#40916C] checked:border-[#40916C] relative after:content-['✔'] after:absolute after:text-white after:text-[10px] after:left-[1px] after:top-[-2px] after:opacity-0 checked:after:opacity-100 transition-all cursor-pointer" />
                    <span class="text-xs font-semibold text-gray-500 group-hover:text-[#31572C] transition-colors">Show Password</span>
                </label>

                <!-- Submit -->
                <button type="submit" class="w-full font-bold py-3.5 rounded-md text-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 mt-2" style="background-color: #31572C; color: white;">
                    LOGIN
                </button>
            </form>
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
                    dot.style.width = '40px';
                    dot.style.backgroundColor = '#ECF39E';
                } else {
                    dot.style.width = '12px';
                    dot.style.backgroundColor = 'rgba(236, 243, 158, 0.35)';
                }
            });
        };

        setInterval(updateSlider, 5000); 
    });
</script>