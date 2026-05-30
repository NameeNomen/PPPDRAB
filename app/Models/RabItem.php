<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RabItem extends Model
{
    protected $table = 'rab_item';

    protected $fillable = [
        'id_rab',
        'parent_id',
        'tipe',
        'id_material',
        'deskripsi_pekerjaan',
        'qty',
        'harga_awal',
        'subtotal'
    ];

    /**
     * Item ini milik satu dokumen RAB
     */
    public function rab()
    {
        return $this->belongsTo(Rab::class, 'id_rab', 'id');
    }

    /**
     * Relasi ke material
     */
    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material', 'id');
    }

    /**
     * Parent item (hirarki WBS)
     */
    public function parent()
    {
        return $this->belongsTo(RabItem::class, 'parent_id', 'id');
    }

    /**
     * Child item (hirarki WBS)
     */
    public function children()
    {
        return $this->hasMany(RabItem::class, 'parent_id', 'id');
    }
}