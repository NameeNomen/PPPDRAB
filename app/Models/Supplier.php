<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'nama_supplier',
        'telepon',
        'email',
        'alamat',
        'pic',
        'is_active',
        'catatan'
    ];

    public function materialSuppliers()
    {
        return $this->hasMany(MaterialSupplier::class, 'supplier_id');
    }

    public function materials()
    {
        return $this->belongsToMany(
            Material::class,
            'material_suppliers',
            'supplier_id',
            'material_id'
        )->withPivot([
            'harga',
            'lead_time_hari',
            'is_preferred',
            'catatan'
        ])->withTimestamps();
    }
}