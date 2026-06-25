<div class="min-h-screen flex bg-[#064E3B] relative overflow-hidden font-sans">

    {{-- ═══════════════════════════════════════════ --}}
    {{--  LEFT SIDE — OPTIMIZED SLIDER              --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div x-data="slider()" x-init="init()" class="w-[58%] relative overflow-hidden">

        {{-- Simple gradient background (no mesh) --}}
        <div class="absolute inset-0 bg-gradient-to-br from-[#064E3B] via-[#065F46] to-[#047857]"></div>

        {{-- Static decorative circles (no blur, no animation) --}}
        <div class="absolute top-[20%] right-[15%] w-64 h-64 bg-emerald-400/5 rounded-full"></div>
        <div class="absolute bottom-[25%] left-[10%] w-80 h-80 bg-teal-300/5 rounded-full"></div>

        {{-- Simple dot grid (lightweight) --}}
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 40px 40px;"></div>

        {{-- Slides container --}}
        <div class="relative h-full flex items-center justify-center px-16 py-12">

            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="current === index"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-300 absolute"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="w-full max-w-lg flex flex-col items-center text-center">

                    {{-- Simplified illustration (no floating elements) --}}
                    <div class="relative mb-8">
                        <div class="w-32 h-32 bg-emerald-400/10 border-2 border-emerald-300/30 rounded-3xl flex items-center justify-center">
                            <div x-html="slide.icon" class="w-16 h-16 text-emerald-300"></div>
                        </div>
                    </div>

                    {{-- Badge --}}
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-400/10 border border-emerald-400/20 rounded-full mb-4">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                        <span class="text-[10px] font-bold text-emerald-300/80 tracking-[0.15em] uppercase" x-text="slide.badge"></span>
                    </div>

                    {{-- Title --}}
                    <h3 class="text-2xl font-bold text-white leading-tight mb-3 tracking-tight" x-text="slide.title"></h3>

                    {{-- Description --}}
                    <p class="text-sm text-emerald-100/50 leading-relaxed mb-6 max-w-md font-medium" x-text="slide.description"></p>

                    {{-- Keywords --}}
                    <div class="flex flex-wrap justify-center gap-2">
                        <template x-for="keyword in slide.keywords" :key="keyword">
                            <span class="px-3 py-1.5 bg-white/[0.06] border border-white/10 rounded-lg text-[10px] font-semibold text-emerald-200/70 tracking-wider uppercase" x-text="keyword"></span>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        {{-- Simple indicators --}}
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 flex items-center gap-3 z-20">
            <template x-for="(slide, index) in slides" :key="'dot-' + index">
                <button @click="goTo(index)" class="relative">
                    <div class="transition-all duration-300 rounded-full"
                        :class="current === index ? 'w-8 h-2 bg-emerald-400' : 'w-2 h-2 bg-white/30 hover:bg-white/50'">
                    </div>
                </button>
            </template>
        </div>

        {{-- Counter --}}
        <div class="absolute bottom-12 right-12 text-right z-20">
            <span class="text-3xl font-black text-white/90 tabular-nums" x-text="String(current + 1).padStart(2, '0')"></span>
            <span class="text-sm text-white/20 font-bold mx-1">/</span>
            <span class="text-sm text-white/30 font-bold tabular-nums" x-text="String(slides.length).padStart(2, '0')"></span>
        </div>

        {{-- Progress bar --}}
        <div class="absolute top-0 left-0 w-full h-[2px] bg-white/5 z-20">
            <div class="h-full bg-emerald-400 origin-left"
                :style="`transform: scaleX(${progress}); transition: transform 0.1s linear;`">
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{--  RIGHT SIDE — OPTIMIZED LOGIN FORM         --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="w-[42%] flex flex-col justify-center items-center px-12 py-10 relative z-10">

        {{-- Logo --}}
        <div class="mb-6 flex flex-col items-center">
            <div class="bg-white rounded-2xl p-3 shadow-lg mb-5">
                <img src="{{ asset('gambar/cps.png') }}" alt="CPS Logo" class="w-14 h-14 object-contain">
            </div>
            <p class="text-emerald-300/70 text-xs font-semibold tracking-[0.25em] uppercase mt-1">
                Commercial Project System
            </p>
        </div>

        {{-- Login Card (NO backdrop-blur) --}}
        <div class="w-full max-w-sm bg-white/[0.08] rounded-3xl border border-white/10 p-8 shadow-xl relative">

            <div class="text-center mb-7">
                <h2 class="text-xl font-bold text-white tracking-tight">Selamat Datang</h2>
                <p class="text-emerald-300/50 text-xs font-medium mt-1.5">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <form wire:submit="login" class="space-y-5">

                {{-- Username --}}
                <div>
                    <label class="block text-[10px] font-bold text-emerald-300/70 uppercase tracking-[0.2em] mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-emerald-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text"
                            wire:model="username"
                            class="w-full pl-11 pr-4 py-3.5 bg-white/[0.06] border border-white/10 rounded-xl text-sm font-medium text-white placeholder-white/25 focus:outline-none focus:border-emerald-400/50 focus:bg-white/[0.08] transition-all"
                            placeholder="Masukkan username...">
                    </div>
                    @error('username')
                        <span class="text-red-400 text-[10px] font-bold mt-1.5 block tracking-wide">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-[10px] font-bold text-emerald-300/70 uppercase tracking-[0.2em] mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-emerald-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password"
                            wire:model="password"
                            class="w-full pl-11 pr-4 py-3.5 bg-white/[0.06] border border-white/10 rounded-xl text-sm font-medium text-white placeholder-white/25 focus:outline-none focus:border-emerald-400/50 focus:bg-white/[0.08] transition-all"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <span class="text-red-400 text-[10px] font-bold mt-1.5 block tracking-wide">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    wire:loading.attr="disabled"
                    class="w-full flex justify-center items-center py-3.5 px-4 rounded-xl text-xs font-bold tracking-[0.15em] text-white bg-emerald-600 hover:bg-emerald-500 shadow-lg transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed mt-3">

                    <span wire:loading.remove wire:target="login">
                        MASUK KE SISTEM
                    </span>

                    <span wire:loading wire:target="login" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        MEMPROSES...
                    </span>
                </button>
            </form>

            <div class="mt-6 text-center text-[10px] text-white/20 font-medium tracking-wide">
                &copy; 2026 PT Tri Jaya Teknik Karawang
            </div>
        </div>
    </div>

</div>

{{-- Alpine.js Slider Logic --}}
<script>
function slider() {
    return {
        current: 0,
        progress: 0,
        interval: null,
        progressInterval: null,
        duration: 10000,
        slides: [
            {
                badge: 'Slide 01 — RFQ',
                title: 'Kelola Permintaan Proyek Secara Terstruktur',
                description: 'Terima RFQ dari klien, simpan dokumen pendukung, dan kelola kebutuhan proyek dalam satu sistem terintegrasi.',
                keywords: ['RFQ', 'Client Request', 'Project Reference'],
                icon: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>`
            },
            {
                badge: 'Slide 02 — PT Tri Jaya Teknik',
                title: 'Mendukung Ekosistem Smart Factory',
                description: 'Sistem terintegrasi untuk menyusun anggaran, mengelola proyek komersial, dan mempercepat alur kerja di PT Tri Jaya Teknik Karawang.',
                keywords: ['TJT Karawang', 'Smart Factory', 'Integration'],
                // Ini logonya udah gw bungkus div putih pakai efek shadow 3D ala logo CPS
                icon: `<div class="bg-white rounded-2xl p-2 shadow-lg shadow-black/20 w-full h-full flex items-center justify-center transform transition-all hover:scale-105">
                           <img src="{{ asset('gambar/tjt.png') }}" alt="TJT Logo" class="w-full h-full object-contain" />
                       </div>`
            },
            {
                badge: 'Slide 03 — Approval',
                title: 'Bidding dan Persetujuan dalam Satu Alur',
                description: 'Kelola dokumen penawaran, proses revisi, dan persetujuan direktur dengan workflow yang terdokumentasi.',
                keywords: ['Bidding', 'Approval', 'Commercial Process'],
                icon: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>`
            }
        ],
        init() {
            this.startAutoPlay();
        },
        startAutoPlay() {
            this.stopAutoPlay();
            this.progress = 0;
            let elapsed = 0;
            const tick = 50;
            this.progressInterval = setInterval(() => {
                elapsed += tick;
                this.progress = elapsed / this.duration;
            }, tick);
            this.interval = setInterval(() => {
                this.next();
            }, this.duration);
        },
        stopAutoPlay() {
            if (this.interval) clearInterval(this.interval);
            if (this.progressInterval) clearInterval(this.progressInterval);
        },
        next() {
            this.current = (this.current + 1) % this.slides.length;
            this.progress = 0;
            this.startAutoPlay();
        },
        goTo(index) {
            this.current = index;
            this.progress = 0;
            this.startAutoPlay();
        }
    }
}
</script>