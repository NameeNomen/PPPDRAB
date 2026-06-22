<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;

class HasilReviewMaterial extends Notification
{
    public $status, $catatan;

    public function __construct($status, $catatan)
    {
        $this->status = $status;
        $this->catatan = $catatan;
    }

    public function via($notifiable) { return ['database']; }

    public function toArray($notifiable)
    {
        return [
            'pesan' => "Request material lu di-{$this->status} Purchasing. Catatan: {$this->catatan}",
            'url' => '/dashboard', // Arahkan ke dashboard engineering
        ];
    }
}