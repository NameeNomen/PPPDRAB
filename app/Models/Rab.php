<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rab extends Model
{
    protected $table = 'rabs';

    protected $fillable = [
        'id_r_project',
        'id_user',
        'no_boq',
        'tgl_boq',
        'overhead_cost',
        'grand_total',
        'status_rab',
    ];

    // Relasi ke Project
    public function project()
    {
        return $this->belongsTo(RProject::class, 'id_r_project', 'id');
    }

    // Relasi ke User (Engineering)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Di dalam class Rab extends Model
public function getGrandTotalRealAttribute()
{
    // Total pekerjaan + overhead
    return $this->items->sum('subtotal') + $this->overhead_cost;
}
    // Relasi ke Item RAB
    public function items()
    {
        return $this->hasMany(RabItem::class, 'id_rab', 'id');
    }

    // Relasi ke Histori Revisi / Commit
    public function documentCommits()
    {
        return $this->hasMany(DocumentCommit::class, 'id_rab', 'id');
    }
}