<div class="min-h-screen flex items-center justify-center bg-[#FDDDD1] font-sans p-4 relative overflow-hidden z-0">

    <!-- Ambient Background -->
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-[#9FB878]/20 rounded-full blur-3xl -z-10 mix-blend-multiply"></div>
    
    <div class="absolute bottom-0 left-[-10%] w-[500px] h-[500px] bg-[#7F8B78]/20 rounded-full blur-3xl -z-10 mix-blend-multiply"></div>

    <div class="max-w-md w-full bg-white/75 backdrop-blur-xl rounded-[2rem] shadow-2xl border border-white/60 p-8 relative z-10 animate-fade-in-down">

        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-[#374426] tracking-tight">
                Login PPPDRAB
            </h2>

            <p class="text-sm text-[#7F8B78] font-bold mt-2">
                Sistem Manajemen Proyek & Bidding
            </p>
        </div>

        <form wire:submit="login" class="space-y-6">

            <div>
                <label class="block text-xs font-extrabold text-[#47622A] uppercase tracking-widest mb-2">
                    Username
                </label>

                <input type="text"
                    wire:model="username"
                    class="w-full px-5 py-3.5 bg-white/90 border-2 border-[#9FB878]/40 rounded-xl focus:ring-0 focus:border-[#799B51] text-sm font-bold transition-all outline-none text-[#374426] placeholder-[#7F8B78]/60 shadow-inner"
                    placeholder="Masukkan username...">

                @error('username')
                    <span class="text-red-500 text-[10px] font-bold mt-1.5 block uppercase tracking-wide">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-extrabold text-[#47622A] uppercase tracking-widest mb-2">
                    Password
                </label>

                <input type="password"
                    wire:model="password"
                    class="w-full px-5 py-3.5 bg-white/90 border-2 border-[#9FB878]/40 rounded-xl focus:ring-0 focus:border-[#799B51] text-sm font-bold transition-all outline-none text-[#374426] placeholder-[#7F8B78]/60 shadow-inner"
                    placeholder="••••••••">

                @error('password')
                    <span class="text-red-500 text-[10px] font-bold mt-1.5 block uppercase tracking-wide">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full flex justify-center items-center py-4 px-4 rounded-xl shadow-lg shadow-[#799B51]/20 text-[11px] font-black tracking-widest text-white bg-[#799B51] hover:bg-[#47622A] transition-all disabled:opacity-70 disabled:cursor-not-allowed hover:-translate-y-0.5 mt-2">

                <span wire:loading.remove wire:target="login">
                    MASUK KE SISTEM
                </span>

                <span wire:loading wire:target="login" class="flex items-center gap-2">

                    <svg class="animate-spin h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24">

                        <circle class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"></circle>

                        <path class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>

                    </svg>

                    MEMPROSES DATA...
                </span>
            </button>

        </form>

        <div class="mt-8 text-center text-xs text-[#7F8B78] font-bold tracking-wide">
            &copy; 2026 PT Tri Jaya Teknik Karawang
        </div>

    </div>

</div>