<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'material';

    protected $fillable = [
        'nama_barang',
        'satuan',
        'harga',
        'supplier',
        'deskripsi',
        'id_user'
    ];

    /**
     * Material diinput oleh user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Material dipakai di banyak item RAB
     */
    public function rabItems()
    {
        return $this->hasMany(RabItem::class, 'id_material', 'id');
    }
}