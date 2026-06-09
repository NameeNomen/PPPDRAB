<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialRequest extends Model
{
    protected $fillable = [
        'nama_material',
        'deskripsi',
        'satuan',
        'status',
        'catatan_purchasing',
        'requested_by'
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}