<div class="min-h-screen flex items-center justify-center bg-gray-50 font-inter">
    <div class="max-w-md w-full bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Login PPPDRAB</h2>
            <p class="text-sm text-gray-500 mt-2">Sistem Manajemen Proyek & Bidding</p>
        </div>

        <form wire:submit="login" class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                <input type="text" wire:model="username" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-slate-500 focus:border-slate-500 text-sm transition-all"
                    placeholder="Masukkan username...">
                @error('username') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input type="password" wire:model="password" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-slate-500 focus:border-slate-500 text-sm transition-all"
                    placeholder="••••••••">
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" 
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-slate-800 hover:bg-slate-900 transition-all">
                MASUK KE SISTEM
            </button>
        </form>

        <div class="mt-6 text-center text-xs text-gray-400">
            &copy; 2026 PT Tri Jaya Teknik Karawang
        </div>
    </div>
</div>