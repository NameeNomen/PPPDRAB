<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RProject extends Model
{
    protected $table = 'r_project';
    
    // Jangan masukin 'id' ke sini!
    protected $fillable = [
        'request_no', 'id_user', 'nama_pelanggan', 'pic_pelanggan', 
        'no_hp', 'deskripsi_proyek', 'target_waktu', 'estimasi_budget', 
        'priority', 'alamat', 'status_proyek'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    // Buka app/Models/RProject.php
    
    public function biddings()
    {
        // Pastikan 'id_r_project' adalah nama kolom foreign key di tabel biddings lu
        return $this->hasMany(Bidding::class, 'id_r_project');
    }
/**
     * Relasi: Satu Proyek memiliki banyak dokumen RAB
     */
    public function rabs()
    {
        return $this->hasMany(Rab::class, 'id_r_project', 'id');
    }
    /**
     * Relasi: Mengambil 1 dokumen RAB spesifik (terbaru/aktif) untuk keperluan Dashboard
     */
    public function rab()
    {
        // Menggunakan hasOne untuk langsung mengembalikan object, bukan collection
        // latestOfMany() memastikan yang ditarik adalah data RAB yang paling akhir dibuat
        return $this->hasOne(Rab::class, 'id_r_project', 'id')->latestOfMany();
    }
    // Ini relasi One-to-Many buat narik banyak gambar/file
    public function attachments() {
        return $this->hasMany(ProjectAttachment::class, 'r_project_id', 'id');
    }
    public function category() {
    return $this->belongsTo(ProjectCategory::class, 'category_id', 'id');
}
}