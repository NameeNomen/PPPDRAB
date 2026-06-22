<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialSupplier extends Model
{
    protected $table = 'material_suppliers';

    protected $fillable = [
        'material_id',
        'supplier_id',
        'harga',
        'lead_time_hari',
        'is_preferred',
        'catatan',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}