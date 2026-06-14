<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'email',
        'telepon',
        'npwp',
        'website',
        'direktur',
        'jabatan_penandatangan',
        'logo',
        'stempel'
    ];
}