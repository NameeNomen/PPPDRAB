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
        'jumlah',
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

    // Relasi ke pivot
    public function materialSuppliers()
    {
        return $this->hasMany(MaterialSupplier::class, 'material_id');
    }

    // Relasi many-to-many ke supplier
    public function suppliers()
    {
        return $this->belongsToMany(
            Supplier::class,
            'material_suppliers',
            'material_id',
            'supplier_id'
        )->withPivot([
            'harga',
            'lead_time_hari',
            'is_preferred',
            'catatan'
        ])->withTimestamps();
    }
}