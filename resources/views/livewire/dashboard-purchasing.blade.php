<div class="min-h-screen pb-12 font-sans transition-colors duration-500 bg-[#F2F7F5]">
    <div class="max-w-7xl mx-auto space-y-8 p-4 md:p-8">

        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 md:p-8 rounded-[1.5rem] border border-[#02462E]/10 shadow-sm">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-3 py-1 bg-[#02462E]/10 text-[#02462E] text-[10px] font-bold uppercase tracking-widest rounded-lg">Modul Pembelian</span>
                    <span class="px-3 py-1 bg-[#FEC700]/20 text-[#02462E] text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 rounded-lg">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#FEC700] animate-pulse"></span> Sistem Aktif
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl font-black text-[#02462E] tracking-tight">Dashboard Purchasing</h1>
            </div>
            <div class="text-left md:text-right">
                <p class="text-[10px] font-bold text-[#02462E]/60 uppercase tracking-widest">Pembaruan Terakhir</p>
                <p class="font-mono text-sm font-bold text-[#02462E] mt-1">{{ now()->format('d M Y - H:i') }} WIB</p>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-[#02462E]/10 shadow-sm hover:shadow-md transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-[#02462E]/60 uppercase tracking-widest">Master Material</p>
                    <div class="p-2 bg-[#02462E]/5 rounded-xl text-[#02462E] group-hover:bg-[#FEC700]/20 group-hover:scale-110 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-[#02462E] font-mono">{{ number_format($kpiMaterial, 0, ',', '.') }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-[#02462E]/10 shadow-sm hover:shadow-md transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-[#02462E]/60 uppercase tracking-widest">Supplier Aktif</p>
                    <div class="p-2 bg-[#02462E]/5 rounded-xl text-[#02462E] group-hover:bg-[#FEC700]/20 group-hover:scale-110 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.25 8.25h-10.5m10.5 0c.621 0 1.125.504 1.125 1.125v10.5c0 .621-.504 1.125-1.125 1.125h-10.5c-.621 0-1.125-.504-1.125-1.125v-10.5c0-.621.504-1.125 1.125-1.125h10.5z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-[#02462E] font-mono">{{ number_format($kpiSupplier, 0, ',', '.') }}</p>
            </div>

            <div class="bg-gradient-to-br from-red-50 to-orange-50 p-6 rounded-2xl border border-red-100 shadow-sm hover:shadow-md transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[10px] font-bold text-red-600/70 uppercase tracking-widest">Menunggu Review</p>
                    <div class="p-2 bg-red-100 rounded-xl text-red-600 group-hover:scale-110 transition-all animate-pulse">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-black text-red-600 font-mono">{{ number_format($kpiRequestPending, 0, ',', '.') }}</p>
            </div>

            <div class="bg-gradient-to-br from-[#02462E] to-[#03593B] p-6 rounded-2xl shadow-md relative overflow-hidden group">
                <div class="absolute right-0 bottom-0 opacity-10 group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <p class="text-[10px] font-bold text-[#FEC700] uppercase tracking-widest mb-4">Request Disetujui</p>
                    <p class="text-3xl font-black text-white font-mono">{{ number_format($kpiRequestApproved, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[1.5rem] border border-[#02462E]/10 shadow-sm p-6 md:p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xs font-bold uppercase tracking-widest text-[#02462E]">Grafik Request Material ({{ date('Y') }})</h2>
            </div>
            <div class="relative w-full h-72">
                <canvas id="requestChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-[1.5rem] border border-[#02462E]/10 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-[#02462E]/5 flex justify-between items-center bg-[#F2F7F5]/50">
                <h3 class="text-xs font-bold uppercase tracking-widest text-[#02462E]">Request Material Pending (Urgent)</h3>
                <a href="{{ route('purchasing.material-review') }}" class="text-[10px] px-4 py-2 bg-white text-[#02462E] font-bold rounded-lg border border-[#02462E]/20 hover:bg-[#02462E] hover:text-[#FEC700] transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-white text-[#02462E]/60 uppercase tracking-widest text-[10px] border-b border-[#02462E]/10">
                        <tr>
                            <th class="px-6 py-4 font-bold">Nama Material</th>
                            <th class="px-6 py-4 text-center font-bold">Kuantitas</th>
                            <th class="px-6 py-4 font-bold">Target Waktu</th>
                            <th class="px-6 py-4 text-center font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#02462E]/5">
                        @forelse($requestPending as $req)
                            @php $isOverdue = \Carbon\Carbon::parse($req->target_waktu_dibutuhkan)->isPast(); @endphp
                            <tr class="hover:bg-[#F2F7F5]/50 transition-colors {{ $isOverdue ? 'bg-red-50/30' : '' }}">
                                <td class="px-6 py-4 font-bold text-[#02462E]">{{ $req->nama_material }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-lg border border-blue-100">
                                        {{ rtrim(rtrim(number_format($req->estimasi_kebutuhan, 2, ',', '.'), '0'), ',') }} {{ $req->satuan }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold {{ $isOverdue ? 'text-red-600' : 'text-[#02462E]' }}">
                                    {{ \Carbon\Carbon::parse($req->target_waktu_dibutuhkan)->format('d M Y') }}
                                    @if($isOverdue) <span class="ml-2 px-2 py-0.5 bg-red-100 text-red-700 text-[9px] rounded uppercase">Overdue</span> @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('purchasing.material-review') }}" class="text-[10px] font-bold uppercase tracking-wider text-[#02462E] hover:text-[#FEC700] underline">Review</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-10 text-center text-[#02462E]/50 font-bold text-sm">Tidak ada request pending. Tim engineering sedang tidur.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-[1.5rem] border border-[#02462E]/10 shadow-sm overflow-hidden flex flex-col">
                <div class="p-6 border-b border-[#02462E]/5">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-[#02462E]">Supplier Teratas</h3>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-[#F2F7F5] text-[#02462E]/60 uppercase tracking-widest text-[10px] border-b border-[#02462E]/10">
                            <tr>
                                <th class="px-6 py-4 font-bold">Nama Supplier</th>
                                <th class="px-6 py-4 text-center font-bold">Item Disuplai</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#02462E]/5">
                            @forelse($supplierTeratas as $sup)
                                <tr class="hover:bg-[#F2F7F5]/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-[#02462E]">{{ $sup->nama_supplier }}</td>
                                    <td class="px-6 py-4 text-center font-mono font-bold text-[#02462E]">{{ $sup->materials_count }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="px-6 py-8 text-center text-xs text-[#02462E]/50">Belum ada data supplier.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-[1.5rem] border border-[#02462E]/10 shadow-sm overflow-hidden flex flex-col">
                <div class="p-6 border-b border-[#02462E]/5">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-[#02462E]">Material Terpopuler (Sering Direquest)</h3>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-[#F2F7F5] text-[#02462E]/60 uppercase tracking-widest text-[10px] border-b border-[#02462E]/10">
                            <tr>
                                <th class="px-6 py-4 font-bold">Nama Material</th>
                                <th class="px-6 py-4 text-center font-bold">Total Request</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#02462E]/5">
                            @forelse($materialTerpopuler as $mat)
                                <tr class="hover:bg-[#F2F7F5]/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-[#02462E]">{{ $mat->nama_material }}</td>
                                    <td class="px-6 py-4 text-center font-mono font-bold text-[#02462E]">
                                        <span class="px-2 py-1 bg-[#FEC700]/20 rounded-lg">{{ $mat->total_request }}x</span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="px-6 py-8 text-center text-xs text-[#02462E]/50">Belum ada riwayat material.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[1.5rem] border border-[#02462E]/10 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-[#02462E]/5">
                <h3 class="text-xs font-bold uppercase tracking-widest text-[#02462E]">Aktivitas Terbaru</h3>
            </div>
            <div class="p-6">
                <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-[#02462E]/10 before:to-transparent">
                    @forelse($aktivitasTerbaru as $index => $aktivitas)
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white {{ $aktivitas->status === 'approved' ? 'bg-[#02462E] text-[#FEC700]' : ($aktivitas->status === 'rejected' ? 'bg-red-500 text-white' : 'bg-[#FEC700] text-[#02462E]') }} shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                                @if($aktivitas->status === 'approved')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                @elseif($aktivitas->status === 'rejected')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </div>
                            
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-[#02462E]/10 bg-[#F2F7F5]/50 shadow-sm">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] font-bold text-[#02462E]/50 uppercase tracking-wider">{{ $aktivitas->updated_at->diffForHumans() }}</span>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase border {{ $aktivitas->status === 'approved' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($aktivitas->status === 'rejected' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-yellow-50 text-yellow-700 border-yellow-200') }}">
                                        {{ $aktivitas->status }}
                                    </span>
                                </div>
                                <p class="text-sm font-bold text-[#02462E]">Request: {{ $aktivitas->nama_material }}</p>
                                <p class="text-xs text-[#02462E]/70 mt-1">Status material diupdate ke {{ strtoupper($aktivitas->status) }}.</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-sm font-bold text-[#02462E]/50 py-4">Belum ada aktivitas terekam.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        const ctx = document.getElementById('requestChart');
        const dataBulan = @json($grafikRequest); // Narik data array 12 bulan dari PHP

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Request',
                    data: dataBulan,
                    borderColor: '#02462E',
                    backgroundColor: 'rgba(2, 70, 46, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#FEC700',
                    pointBorderColor: '#02462E',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { stepSize: 1, color: '#02462E80', font: { family: 'sans-serif', size: 10, weight: 'bold' } },
                        grid: { color: 'rgba(2, 70, 46, 0.05)' }
                    },
                    x: {
                        ticks: { color: '#02462E80', font: { family: 'sans-serif', size: 11, weight: 'bold' } },
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>