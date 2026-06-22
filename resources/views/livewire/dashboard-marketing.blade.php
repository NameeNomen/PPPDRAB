<div class="p-4 md:p-8 space-y-6 min-h-screen">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   {{-- GREETING CARD (Icon Standard Internet) --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-4">
            {{-- IKON USER PASARAN DARI INTERNET --}}
            <div class="w-14 h-14 md:w-16 md:h-16 bg-[#003057]/10 rounded-2xl flex items-center justify-center border border-[#003057]/20 shrink-0 p-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-[#003057]">
                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg md:text-xl lg:text-2xl font-black text-[#003057] tracking-tight">
                    Selamat Datang, {{ auth()->user()->username ?? 'Marketing' }}
                </h1>
                <p class="text-xs md:text-sm text-[#003057]/70 font-medium mt-0.5">
                    Panel Kendali Data Komersial & Inisiasi Proyek TJT
                </p>
            </div>
        </div>
        <a href="{{ route('marketing.proyek') }}" wire:navigate class="w-full sm:w-auto text-center px-5 py-2.5 bg-[#003057] hover:bg-[#001D36] text-xs font-bold text-white rounded-xl shadow-md transition-all">
            + Tambah Proyek / RFQ
        </a>
    </div>

    {{-- 4 KOTAK METRIK UTAMA (Font Angka Diperbesar Maksi) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- METRIK 1 --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex items-center justify-between transition-transform hover:-translate-y-1">
            <div>
                <p class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-wider">Total RFQ Masuk</p>
                <h3 class="text-3xl md:text-4xl font-black text-[#003057] tracking-tight mt-1">{{ $totalRfq }}</h3>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl text-[#003057] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>

        {{-- METRIK 2 --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex items-center justify-between transition-transform hover:-translate-y-1">
            <div>
                <p class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-wider">Siap Dibuat Bidding</p>
                <h3 class="text-3xl md:text-4xl font-black text-[#003057] tracking-tight mt-1">{{ $siapBidding }}</h3>
            </div>
            <div class="p-3 bg-[#E8BF00]/10 rounded-xl text-[#E8BF00] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        {{-- METRIK 3 --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex items-center justify-between transition-transform hover:-translate-y-1">
            <div>
                <p class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-wider">Approval Direktur</p>
                <h3 class="text-3xl md:text-4xl font-black text-[#003057] tracking-tight mt-1">{{ $menungguApproval }}</h3>
            </div>
            <div class="p-3 bg-blue-50 rounded-xl text-blue-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
        </div>

        {{-- METRIK 4 --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex items-center justify-between transition-transform hover:-translate-y-1">
            <div>
                <p class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-wider">Potensi Penjualan</p>
                <h3 class="text-xl md:text-2xl font-black text-[#003057] tracking-tight mt-1">Rp {{ number_format($potensiPenjualan, 0, ',', '.') }}</h3>
            </div>
            <div class="p-3 bg-green-50 rounded-xl text-green-600 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    {{-- LAYOUT UTAMA: GRAFIK & LIST DATA --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- SEKSI KIRI: GRAFIK --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col min-w-0">
            <div class="mb-4">
                <h2 class="text-sm md:text-base font-bold text-[#003057]">Grafik Performa Bidding (Won vs Lost)</h2>
                <p class="text-xs text-gray-400">Analisis rasio kesuksesan tender komersial 6 bulan terakhir</p>
            </div>
            <div class="flex-grow w-full min-h-[300px] relative">
                <canvas id="biddingChart"></canvas>
            </div>
        </div>

        {{-- SEKSI KANAN: RFQ TERBARU --}}
        <div class="lg:col-span-1 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm flex flex-col">
            <div class="mb-4">
                <h2 class="text-sm md:text-base font-bold text-[#003057]">RFQ / Permintaan Terbaru</h2>
                <p class="text-xs text-gray-400">Daftar dokumen inisiasi proyek masuk</p>
            </div>
            
            <div class="divide-y divide-gray-100 flex-grow">
                @forelse($rfqTerbaru as $rfq)
                    <div class="py-3.5 flex flex-col gap-1.5 first:pt-0 last:pb-0">
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-xs md:text-sm font-bold text-[#003057] block truncate max-w-[150px] lg:max-w-[120px] xl:max-w-[160px]">{{ $rfq->nama_projek }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[9px] md:text-[10px] font-bold uppercase tracking-wider shrink-0
                                @if($rfq->status_proyek === 'pending') bg-[#E8BF00]/10 text-[#003057]
                                @elseif($rfq->status_proyek === 'approved') bg-blue-50 text-blue-700
                                @else bg-gray-100 text-gray-600 @endif">
                                {{ $rfq->status_proyek }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span class="truncate max-w-[120px]">Client: {{ $rfq->nama_pelanggan }}</span>
                            <span class="font-bold text-gray-700">Rp {{ number_format($rfq->estimasi_budget ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-xs text-gray-400">Tidak ada data RFQ masuk.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- SEKSI BAWAH: TABEL PROYEK SIAP DIBIDDING --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <h2 class="text-sm md:text-base font-bold text-[#003057]">Proyek Siap Diproses Bidding</h2>
            <p class="text-xs text-gray-400">Daftar inisiasi proyek dengan status validasi 'Approved' yang memerlukan pembuatan penawaran komersial</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F2F2F2] border-b border-gray-200 text-xs uppercase tracking-wider text-[#003057] font-bold">
                        <th class="p-4">No. Request</th>
                        <th class="p-4">Nama Proyek</th>
                        <th class="p-4">Pelanggan</th>
                        <th class="p-4">Estimasi Budget</th>
                        <th class="p-4 text-center">Status Teknis</th>
                    </tr>
                </thead>
                <tbody class="text-xs md:text-sm divide-y divide-gray-100">
                    @forelse($proyekSiapBidding as $proy)
                        <tr class="hover:bg-[#F2F2F2]/40 transition-colors">
                            <td class="p-4 font-mono font-bold text-[#003057]">{{ $proy->request_no }}</td>
                            <td class="p-4 font-bold text-gray-800">{{ $proy->nama_projek }}</td>
                            <td class="p-4 text-gray-600">{{ $proy->nama_pelanggan }}</td>
                            <td class="p-4 font-semibold text-gray-700">Rp {{ number_format($proy->estimasi_budget ?? 0, 0, ',', '.') }}</td>
                            <td class="p-4 text-center">
                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-md font-bold text-[10px] md:text-xs uppercase">
                                    {{ $proy->status_proyek }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-xs md:text-sm text-gray-400">Tidak ada antrean proyek siap bidding.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SCRIPT GRAPH ENGINE --}}
<script>
    document.addEventListener('livewire:navigated', function() {
        const chartElement = document.getElementById('biddingChart');
        if (chartElement) {
            new Chart(chartElement.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartBulan) !!},
                    datasets: [
                        {
                            label: 'Bidding WON',
                            data: {!! json_encode($chartWon) !!},
                            backgroundColor: '#003057', 
                            borderRadius: 6,
                            borderWidth: 0
                        },
                        {
                            label: 'Bidding LOST',
                            data: {!! json_encode($chartLost) !!},
                            backgroundColor: '#E8BF00', 
                            borderRadius: 6,
                            borderWidth: 0
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: { font: { family: 'Inter', size: 12, weight: 'bold' }, color: '#003057' }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { family: 'Inter', size: 11, weight: '500' }, color: '#4A5568' } },
                        y: { 
                            beginAtZero: true, 
                            grid: { borderDash: [4, 4], color: '#E2E8F0' }, 
                            ticks: { stepSize: 1, font: { family: 'Inter', size: 11 }, color: '#4A5568' } 
                        }
                    }
                }
            });
        }
    });
</script>