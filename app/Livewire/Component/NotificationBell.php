<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    // Pake Polling biar otomatis nge-check ke database tiap 30 detik tanpa refresh halaman
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

    // Fungsi pas list notifikasinya di-klik (VERSI TERBARU DENGAN read_at)
    public function bacaNotif($id)
    {
        $notif = Notification::find($id);
        
        if ($notif) {
            // Ubah status jadi sudah dibaca dan catat waktunya
            $notif->update([
                'is_read' => true,
                'read_at' => now() // PENTING: Ini buat patokan hapus otomatis 3 hari
            ]);

            // Tendang user langsung ke halaman tujuan revisi bawaan notif
            return redirect()->to($notif->url_tujuan);
        }
    }
}