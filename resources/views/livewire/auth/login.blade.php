<div class="min-h-screen flex items-center justify-center bg-[#C7EFEB] font-sans p-4">

    <!-- Main Card Container -->
    <div class="w-full max-w-4xl bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[550px]">

        <!-- LEFT PANEL - Turquoise -->
        <div class="w-full md:w-5/12 bg-[#4ECDC4] relative p-8 flex flex-col items-center justify-center overflow-hidden">
            
            <!-- Decorative Curved Shape -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-[#45B7AA]/30 rounded-full translate-y-1/3 -translate-x-1/3 blur-xl"></div>

            <!-- Vertical Welcome Text -->
            <div class="absolute left-6 top-1/2 -translate-y-1/2 -rotate-90 origin-center z-10">
                <h2 class="text-4xl font-bold text-white tracking-wider">
                    Welcome
                </h2>
            </div>

            <!-- Isometric Phone Illustration -->
            <div class="relative z-10 w-full max-w-xs mx-auto mt-4">
                <div class="relative transform rotate-[-12deg] hover:rotate-[-6deg] transition-transform duration-500">
                    <!-- Phone Body -->
                    <div class="bg-white rounded-[2rem] shadow-2xl p-5 relative border-4 border-white/40">
                        <!-- Phone Notch -->
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-24 h-5 bg-white rounded-b-xl"></div>
                        
                        <!-- Screen Content -->
                        <div class="mt-3 space-y-3">
                            <!-- Bar Chart -->
                            <div class="flex items-end justify-between h-20 gap-1.5 px-1">
                                <div class="w-full bg-[#4ECDC4]/30 rounded-t" style="height: 45%"></div>
                                <div class="w-full bg-[#4ECDC4]/50 rounded-t" style="height: 65%"></div>
                                <div class="w-full bg-[#4ECDC4]/70 rounded-t" style="height: 55%"></div>
                                <div class="w-full bg-[#4ECDC4] rounded-t" style="height: 80%"></div>
                                <div class="w-full bg-[#45B7AA] rounded-t" style="height: 70%"></div>
                            </div>
                            
                            <!-- Pie Chart -->
                            <div class="bg-[#F0F9F8] rounded-xl p-3 flex items-center gap-3">
                                <div class="relative w-12 h-12 flex-shrink-0">
                                    <svg viewBox="0 0 36 36" class="w-full h-full transform -rotate-90">
                                        <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#4ECDC4" stroke-width="3" opacity="0.2"/>
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831" fill="none" stroke="#4ECDC4" stroke-width="3" stroke-dasharray="60, 100"/>
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831" fill="none" stroke="#F4D03F" stroke-width="3" stroke-dasharray="25, 100" stroke-dashoffset="-60"/>
                                    </svg>
                                </div>
                                <div class="space-y-1.5 flex-1">
                                    <div class="h-1.5 w-full bg-[#4ECDC4]/30 rounded"></div>
                                    <div class="h-1.5 w-2/3 bg-[#4ECDC4]/20 rounded"></div>
                                </div>
                            </div>

                            <!-- Bottom Stats -->
                            <div class="flex gap-1.5">
                                <div class="flex-1 bg-[#4ECDC4]/10 rounded-lg p-2 text-center">
                                    <div class="text-[8px] font-bold text-[#45B7AA]">Revenue</div>
                                </div>
                                <div class="flex-1 bg-[#F4D03F]/20 rounded-lg p-2 text-center">
                                    <div class="text-[8px] font-bold text-[#D4AC0D]">Users</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Phone Shadow -->
                    <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-4/5 h-3 bg-black/20 rounded-full blur-sm"></div>
                </div>
            </div>

            <!-- Bottom Text -->
            <div class="relative z-10 mt-6 text-center px-4">
                <p class="text-white/90 text-[10px] font-bold tracking-widest uppercase">
                    INTRODUCING BROKER OPERATING SYSTEM
                </p>
            </div>
        </div>

        <!-- RIGHT PANEL - White Login Form -->
        <div class="w-full md:w-7/12 bg-white p-10 flex flex-col justify-center relative">
            
            <!-- LOGIN Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-[#4ECDC4] tracking-tight">
                    LOGIN
                </h1>
            </div>

            <!-- Form -->
            <form wire:submit="login" class="space-y-5">
                
                <!-- Username Field -->
                <div>
                    <label class="block text-xs font-semibold text-[#7F8B88] mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <input 
                            type="text"
                            wire:model="username"
                            class="w-full px-4 py-3 bg-transparent border-b-2 border-[#C7EFEB] focus:border-[#4ECDC4] text-sm font-medium text-[#2C3E50] placeholder-[#B8E8E0] outline-none transition-all pr-10"
                            placeholder="Username"
                        >
                        <!-- User Icon - Right Side -->
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#4ECDC4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    @error('username')
                        <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-xs font-semibold text-[#7F8B88] mb-2">
                        password
                    </label>
                    <div class="relative">
                        <input 
                            type="password"
                            wire:model="password"
                            class="w-full px-4 py-3 bg-transparent border-b-2 border-[#C7EFEB] focus:border-[#4ECDC4] text-sm font-medium text-[#2C3E50] placeholder-[#B8E8E0] outline-none transition-all pr-10"
                            placeholder="password"
                        >
                        <!-- Lock Icon - Right Side -->
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#4ECDC4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    @error('password')
                        <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full py-3.5 px-6 rounded-full shadow-lg shadow-[#4ECDC4]/30 text-sm font-bold text-white bg-[#4ECDC4] hover:bg-[#45B7AA] transition-all disabled:opacity-70 disabled:cursor-not-allowed hover:-translate-y-0.5 mt-6">

                    <span wire:loading.remove wire:target="login">
                        Login
                    </span>

                    <span wire:loading wire:target="login" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Loading...
                    </span>
                </button>

                <!-- Forgot & Help Links -->
                <div class="flex flex-col items-end mt-4 space-y-1">
                    <button type="button" class="text-[#4ECDC4] text-xs font-semibold hover:text-[#45B7AA] transition-colors">
                        Forgot
                    </button>
                    <button type="button" class="text-[#4ECDC4] text-xs font-semibold hover:text-[#45B7AA] transition-colors">
                        Help
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>