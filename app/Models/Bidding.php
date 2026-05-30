<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    protected $table = 'biddings';

    protected $fillable = [
        'id_r_project',
        'id_user',
        'nama_perusahaan',
        'term_of_payment',
        'masa_berlaku',
        'no_penawaran',
        'tgl_penawaran',
        'surat_pengantar',
        'alamat_perusahaan',
        'total_penawaran',
        'status_bidding',
        'email_perusahaan',
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