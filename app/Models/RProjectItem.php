<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RProjectItem extends Model
{
    protected $table = 'r_project_items';

    protected $fillable = [
        'id_r_project',
        'nama_item',
        'qty',
        'satuan',
        'dskripsi',
        'is_calculated',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_r_project');
    }

    public function materials()
    {
        return $this->hasMany(ProjectItemMaterial::class, 'project_item_id');
    }
}