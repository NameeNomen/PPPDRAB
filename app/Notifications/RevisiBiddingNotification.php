<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RevisiBiddingNotification extends Notification
{
    use Queueable;

    public $bidding; // Variabel buat nampung data dokumen yang direvisi

    // Constructor ini buat nerima paket data dari halaman KelolaBidding
    public function __construct($biddingData)
    {
        $this->bidding = $biddingData;
    }

    // Ini ngasih tau Laravel: "Kirim notifnya lewat database aja ya, gak usah via email"
    public function via($notifiable)
    {
        return ['database'];
    }

    // Ini template isi pesannya yang bakal masuk ke database
    public function toArray($notifiable)
    {
        return [
            'id_bidding' => $this->bidding->id,
            'no_penawaran' => $this->bidding->no_penawaran,
            'nama_klien' => $this->bidding->nama_perusahaan,
            'pesan' => 'Dokumen penawaran ' . $this->bidding->no_penawaran . ' telah direvisi dan butuh direview ulang.',
            'url' => '/marketing/bidding/' . $this->bidding->id // Opsional: URL kalau notifnya diklik mau lari ke mana
        ];
    }
}