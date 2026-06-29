<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentCommit extends Model
{
    protected $table = 'document_commits';

    /**
     * Nonaktifkan timestamps otomatis Laravel
     */
    public $timestamps = false;

    protected $fillable = [
    'id_r_project',
    'id_rab',
    'id_bidding',
    'id_user',
    'jenis_aksi',
    'komentar_commit',
    'user_name',
    'total_penawaran',
    'grand_total',
    'created_at',
    'snapshot_data'
];
protected $casts = [
        'snapshot_data' => 'array', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function rab()
    {
        return $this->belongsTo(Rab::class, 'id_rab', 'id');
    }
public function project()
    {
        return $this->belongsTo(\App\Models\RProject::class, 'id_r_project', 'id');
    }
   
   public function bidding()
    {
        return $this->belongsTo(\App\Models\Bidding::class, 'id_bidding', 'id');
    }
}