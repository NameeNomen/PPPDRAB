<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RProjectItem extends Model
{
    protected $table = 'r_project_items';

    protected $fillable = [
        'r_project_id',
        'nama_item',
        'qty',
        'satuan',
        'spesifikasi_klien',
        'is_calculated',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'r_project_id');
    }

    public function materials()
    {
        return $this->hasMany(ProjectItemMaterial::class, 'project_item_id');
    }
}