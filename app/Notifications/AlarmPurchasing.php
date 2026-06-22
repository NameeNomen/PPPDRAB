<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AlarmPurchasing extends Notification
{
    use Queueable;

    public $tipeAlarm;
    public $materialRequest;

    public function __construct($tipeAlarm, $materialRequest)
    {
        $this->tipeAlarm = $tipeAlarm; // 'hampir_telat' atau 'sudah_telat'
        $this->materialRequest = $materialRequest;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Kita simpan ke database aja, gausah kirim email ribet
    }

    public function toArray(object $notifiable): array
    {
        $pesan = '';
        if ($this->tipeAlarm === 'hampir_telat') {
            $pesan = "Bro lu kemana aja, ini ada request material {$this->materialRequest->nama_material} belum lu cek! 15 menit lagi deadline nih.";
        } else {
            $pesan = "Bro telat ah. Minta maaf gih ke Engineering, gw tahu lu sibuk tapi request {$this->materialRequest->nama_material} udah lewat batas waktu!";
        }

        return [
            'request_id' => $this->materialRequest->id,
            'pesan' => $pesan,
            'tipe' => $this->tipeAlarm
        ];
    }
}