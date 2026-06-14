<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    protected $table = 'biddings';

     protected $fillable = [
        // Relasi
        'id_r_project',
        'id_user',

        // Identitas Dokumen
        'no_penawaran',
        'tgl_penawaran',
        'perihal',

        // Tujuan Penawaran
        'kepada',
        'up',

        // Isi Penawaran
        'surat_pengantar',
        'catatan',

        // Ketentuan Komersial
        'term_of_payment',
        'masa_berlaku',
        'waktu_pengerjaan',
        'garansi',

        // Harga
        'harga_dasar',
        'total_penawaran',

        // Status
        'status_bidding',
    ];

    protected $casts = [
        'tgl_penawaran' => 'date',
        'harga_dasar' => 'integer',
        'total_penawaran' => 'integer',
        'masa_berlaku' => 'integer',
        'waktu_pengerjaan' => 'integer',
    ];

    // Relasi ke Project
    public function project()
    {
        return $this->belongsTo(RProject::class, 'id_r_project', 'id');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Relasi ke Document Commit
    public function documentCommits()
    {
        return $this->hasMany(DocumentCommit::class, 'id_bidding', 'id');
    }
    
}