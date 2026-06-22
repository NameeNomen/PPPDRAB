<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MaterialRequest extends Model
{
    protected $fillable = [
       'id_r_project', // Nama kolom harus persis sama dengan migrasi
        'nama_material',
        'deskripsi',
        'estimasi_kebutuhan',
        'satuan',
        'target_waktu_dibutuhkan',
        'status',
        'catatan_purchasing',
        'id_material_terdaftar',
        'requested_by'
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
    public function project()
{
    return $this->belongsTo(RProject::class, 'id_r_project');
}
}