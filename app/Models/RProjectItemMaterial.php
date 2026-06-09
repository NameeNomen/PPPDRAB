<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RProjectItemMaterial extends Model
{
    protected $table = 'r_project_item_materials';

    protected $fillable = [
        'project_item_id',
        'material_id',
        'qty',
        'satuan',
        'status_kesesuaian',
        'catatan_engineering',
    ];

    public function projectItem()
    {
        return $this->belongsTo(ProjectItem::class, 'project_item_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}