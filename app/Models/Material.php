<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'material';

    protected $fillable = [
        'nama_barang',
        'deskripsi',
        'satuan',
        'harga',
        'supplier',
        'id_user'
    ];

    public function projectItemMaterials()
    {
        return $this->hasMany(ProjectItemMaterial::class, 'material_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}