<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Kita pakai guarded biar lu nggak usah capek-capek nulis fillable satu-satu.
    // Artinya: "semua kolom boleh diisi otomatis, KECUALI id".
    protected $guarded = ['id'];

    /* * Kalau lu tipe yang paranoid dan rajin, pakai fillable aja kayak gini:
     * protected $fillable = ['id_user', 'judul', 'pesan', 'url_tujuan', 'is_read'];
     */

    // Ini relasi baliknya ke tabel users. 
    // Biar sistem tahu notif ini punya siapa kalau sewaktu-waktu lu butuh manggil data usernya.
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}