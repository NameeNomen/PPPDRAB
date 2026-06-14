<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    protected $table = 'biddings';
protected $fillable = [
        'id_r_project',
        'id_user',
        'nama_pelanggan_snapshot',
        'pic_pelanggan_snapshot',
        'no_penawaran',
        'tgl_penawaran',
        'perihal',
        'surat_pengantar',
        'catatan',
        'term_of_payment',
        'masa_berlaku',
        'waktu_pengerjaan',
        'garansi',
        'harga_dasar',
        'total_penawaran',
        'status_bidding',
    ];
    protected $casts = [
        'tgl_penawaran' => 'date',
        'harga_dasar' => 'decimal:2',      // Ubah jadi decimal
        'total_penawaran' => 'decimal:2',  // Ubah jadi decimal
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