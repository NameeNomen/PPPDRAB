<div class="p-4 md:p-8 space-y-6 bg-[#FAEEF5] min-h-screen font-sans">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- GREETING CARD -->
    <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_-4px_rgba(178,164,255,0.15)] border border-[#B2A4FF]/10 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-4">
            <!-- FOTO PROFILE PAKE SVG BUNDAR LILAC -->
            <div class="w-16 h-16 bg-[#FAEEF5] rounded-full flex items-center justify-center shadow-inner border-2 border-white ring-2 ring-[#FFB4B4]/50">
                <svg class="w-9 h-9 text-[#B2A4FF]" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12 8.25a3 3 0 100 6 3 3 0 000-6zM6.608 17.5a5.975 5.975 0 0110.784 0 7.464 7.464 0 01-10.784 0z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-gray-800">Welcome Back !</h1>
                <p class="text-sm text-gray-500 font-medium">To Dashboard {{ auth()->user()->username ?? 'Marketing' }}</p>
            </div>
        </div>
        <a href="{{ route('marketing.proyek') }}" wire:navigate class="px-5 py-2.5 bg-gradient-to-r from-[#B2A4FF] to-[#9B8CFF] hover:to-[#8a7af0] text-white text-sm font-bold rounded-xl shadow-lg shadow-[#B2A4FF]/30 transition-all cursor-pointer">
            + Proyek Baru
        </a>
    </div>

    <!-- 4 KOTAK METRIK -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_-4px_rgba(178,164,255,0.1)] border border-pink-50 flex flex-col justify-center transition-transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-3xl font-black text-[#5C5470]">{{ $totalProyek }}</h3>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide mt-1">Total Proyek</p>
                </div>
                <div class="w-10 h-10 rounded-full border-4 border-[#B2A4FF]/20 flex items-center justify-center">
                    <div class="w-6 h-6 rounded-full bg-[#B2A4FF]"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_-4px_rgba(255,180,180,0.1)] border border-pink-50 flex flex-col justify-center transition-transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-3xl font-black text-[#5C5470]">{{ $menungguEngineering }}</h3>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide mt-1">Antrean Teknik</p>
                </div>
                <div class="w-10 h-10 rounded-full border-4 border-[#FFB4B4]/30 flex items-center justify-center">
                    <div class="w-6 h-6 rounded-full bg-[#FFB4B4]"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_-4px_rgba(255,222,180,0.1)] border border-pink-50 flex flex-col justify-center transition-transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-3xl font-black text-[#5C5470]">{{ $biddingAktif }}</h3>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide mt-1">Bidding Aktif</p>
                </div>
                <div class="w-10 h-10 rounded-full border-4 border-[#FFDEB4]/40 flex items-center justify-center">
                    <div class="w-6 h-6 rounded-full bg-[#FFDEB4]"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_-4px_rgba(200,182,255,0.1)] border border-pink-50 flex flex-col justify-center transition-transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-3xl font-black text-[#5C5470]">{{ $proyekWon }}</h3>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wide mt-1">Project Won</p>
                </div>
                <div class="w-10 h-10 rounded-full border-4 border-[#C8B6FF]/30 flex items-center justify-center">
                    <div class="w-6 h-6 rounded-full bg-[#C8B6FF]"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- GRID LAYOUT UTAMA: KIRI (Grafik Panjang) - KANAN (Doughnut & List) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- KOLOM KIRI: Grafik Garis -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_-4px_rgba(178,164,255,0.15)] border border-pink-50 flex flex-col min-w-0">
            <div class="flex justify-between items-center mb-6">
                <!-- JUDUL DIGANTI -->
                <h2 class="text-base font-extrabold text-[#5C5470]">Statistik Proyek Bulanan</h2>
                
                <!-- DROPDOWN FILTER DITAMBAHIN -->
                <select class="text-xs font-semibold text-[#5C5470] bg-[#FAEEF5] border border-[#B2A4FF]/30 rounded-xl px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-[#B2A4FF] cursor-pointer transition-colors hover:bg-pink-50">
                    <option value="6">6 Bulan Terakhir</option>
                    <option value="3">3 Bulan Terakhir</option>
                    <option value="12">1 Tahun Terakhir</option>
                </select>
            </div>
            <div class="flex-grow w-full min-h-[300px] relative">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        <!-- KOLOM KANAN: Doughnut & List Aktivitas -->
        <div class="lg:col-span-1 flex flex-col gap-6 min-w-0">
            
            <!-- Atas: Doughnut Chart -->
            <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_-4px_rgba(255,180,180,0.15)] border border-pink-50 flex flex-col items-center justify-center relative">
                <h2 class="text-sm font-extrabold text-[#5C5470] w-full text-left absolute top-6 left-6">Win Rate Proyek</h2>
                <div class="relative w-36 h-36 mt-8">
                    <canvas id="doughnutChart"></canvas>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none mt-2">
                        <span class="text-2xl font-black text-[#5C5470]">{{ $winRate }}%</span>
                    </div>
                </div>
            </div>

            <!-- Bawah: List Aktivitas -->
            <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_-4px_rgba(178,164,255,0.15)] border border-pink-50 flex-grow">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-sm font-extrabold text-[#5C5470]">Aktivitas Terbaru</h2>
                </div>
                
                <div class="space-y-5">
                    @forelse($historiTerbaru as $histori)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-4 border-l-[3px] pl-3 
                            @if($histori->status_proyek == 'won') border-[#C8B6FF] 
                            @elseif($histori->status_proyek == 'waiting_rab') border-[#FFB4B4] 
                            @else border-gray-200 @endif">
                            
                            <div>
                                <p class="text-sm font-bold text-[#5C5470] truncate max-w-[120px] lg:max-w-[150px]">{{ $histori->nama_pelanggan }}</p>
                                <p class="text-[10px] text-gray-400 font-semibold mt-0.5">
                                    Rp {{ number_format($histori->estimasi_budget, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1.5">
                            @if($histori->status_proyek == 'won')
                                <div class="w-2 h-2 rounded-full bg-[#C8B6FF]"></div>
                                <span class="text-[10px] font-bold text-[#C8B6FF]">WON</span>
                            @elseif($histori->status_proyek == 'waiting_rab')
                                <div class="w-2 h-2 rounded-full bg-[#FFB4B4]"></div>
                                <span class="text-[10px] font-bold text-[#FFB4B4]">WAIT</span>
                            @else
                                <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                                <span class="text-[10px] font-bold text-gray-400">LOG</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6 text-xs text-gray-400 font-medium">Belum ada data.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

<!-- SCRIPT RENDER GRAFIK -->
<script>
    document.addEventListener('livewire:navigated', function() {
        // Line Chart 
        const lineCtx = document.getElementById('lineChart');
        if(lineCtx) {
            const ctx = lineCtx.getContext('2d');
            
            let gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(178, 164, 255, 0.5)'); 
            gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartBulan) !!},
                    datasets: [{
                        label: 'Proyek Baru',
                        data: {!! json_encode($chartDataProyek) !!},
                        borderColor: '#B2A4FF', 
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#B2A4FF',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { family: 'Inter', size: 10 }, color: '#A0AEC0' } },
                        y: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#f3f4f6' }, ticks: { stepSize: 1, font: { family: 'Inter', size: 10 }, color: '#A0AEC0' } }
                    }
                }
            });
        }

        // Doughnut Chart 
        const doughnutCtx = document.getElementById('doughnutChart');
        if(doughnutCtx) {
            new Chart(doughnutCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Won', 'Sisa'],
                    datasets: [{
                        data: [{{ $winRate }}, {{ $sisaRate }}],
                        backgroundColor: ['#B2A4FF', '#FFB4B4'], 
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '80%',
                    plugins: { legend: { display: false }, tooltip: { enabled: false } }
                }
            });
        }
    });
</script>