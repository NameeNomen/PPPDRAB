<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MaterialRequest;
use App\Models\User;
use App\Notifications\AlarmPurchasing;
use Carbon\Carbon;

class CekDeadlineRequest extends Command
{
    protected $signature = 'app:cek-deadline-request';
    protected $description = 'Mengecek request yang hampir telat atau sudah telat untuk Purchasing';

    public function handle()
    {
        $sekarang = Carbon::now();

        // 1. Cari yang deadlinenya persis di antara sekarang sampai 15 menit ke depan
        $hampirTelat = MaterialRequest::where('status', 'pending')
            ->whereBetween('target_waktu_dibutuhkan', [$sekarang, $sekarang->copy()->addMinutes(15)])
            ->get();

        // 2. Cari yang deadlinenya udah lewat (masa lalu) dan masih pending
        $sudahTelat = MaterialRequest::where('status', 'pending')
            ->where('target_waktu_dibutuhkan', '<', $sekarang)
            ->get();

        // Asumsi lu punya user Purchasing (misal ID-nya 2, sesuaikan sama data lu)
        // Kalau lu punya role 'purchasing', query usernya di sini.
        $userPurchasing = User::find(2); 

        if ($userPurchasing) {
            foreach ($hampirTelat as $req) {
                $userPurchasing->notify(new AlarmPurchasing('hampir_telat', $req));
            }

            foreach ($sudahTelat as $req) {
                $userPurchasing->notify(new AlarmPurchasing('sudah_telat', $req));
            }
        }

        $this->info('Pengecekan deadline selesai dijalankan.');
    }
}