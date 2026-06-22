<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public function render()
    {
        $idUser = Auth::id();

        // Ambil 5 notifikasi terbaru milik user yang sedang login
        $notifikasi = Notification::where('id_user', $idUser)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Hitung berapa yang belum dibaca buat angka di badge merah
        $jumlahUnread = Notification::where('id_user', $idUser)
            ->where('is_read', false)
            ->count();

        return view('livewire.component.notification-bell', compact('notifikasi', 'jumlahUnread'));
    }

    public function bacaNotif($id)
    {
        $notif = Notification::where('id_user', Auth::id())->find($id);
        
        if ($notif) {
            $notif->update([
                'is_read' => true,
                'read_at' => now() 
            ]);

            // DI LIVEWIRE 3, CARA REDIRECT YANG BENAR ITU BEGINI:
            // Pakai navigate: true biar transisinya mulus ala Single Page Application (SPA)
            $this->redirect($notif->url_tujuan, navigate: true);
        }
    }
}