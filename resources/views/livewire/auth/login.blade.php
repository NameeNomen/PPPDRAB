<div class="min-h-screen flex items-center justify-center bg-[#f4f1de] font-inter p-4">
    <!-- Glass Effect Card -->
    <div class="max-w-md w-full bg-white/70 backdrop-blur-md rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/60 p-8">
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-[#5e503f] tracking-tight">Login PPPDRAB</h2>
            <p class="text-sm text-[#7a6a58] mt-2">Sistem Manajemen Proyek & Bidding</p>
        </div>

        <form wire:submit="login" class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-[#5e503f] mb-2">Username</label>
                <input type="text" wire:model="username" 
                    class="w-full px-4 py-2.5 bg-white/80 border border-[#ccd5ae] rounded-xl focus:ring-2 focus:ring-[#81b29a] focus:border-[#81b29a] text-sm transition-all outline-none text-[#5e503f]"
                    placeholder="Masukkan username...">
                @error('username') <span class="text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#5e503f] mb-2">Password</label>
                <input type="password" wire:model="password" 
                    class="w-full px-4 py-2.5 bg-white/80 border border-[#ccd5ae] rounded-xl focus:ring-2 focus:ring-[#81b29a] focus:border-[#81b29a] text-sm transition-all outline-none text-[#5e503f]"
                    placeholder="••••••••">
                @error('password') <span class="text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>

            <!-- Tombol Submit dengan State Loading Livewire -->
            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex justify-center items-center py-3 px-4 rounded-xl shadow-sm text-sm font-bold text-white bg-[#81b29a] hover:bg-[#689880] transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                
                <!-- Teks Normal (Hilang saat loading) -->
                <span wire:loading.remove wire:target="login">
                    MASUK KE SISTEM
                </span>

                <!-- Animasi Loading (Muncul saat proses login berjalan) -->
                <span wire:loading wire:target="login" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    MEMPROSES DATA...
                </span>
            </button>
        </form>

        <div class="mt-8 text-center text-xs text-[#a3b18a] font-medium">
            &copy; 2026 PT Tri Jaya Teknik Karawang
        </div>
    </div>
</div>