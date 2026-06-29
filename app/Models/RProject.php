<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RProject extends Model
{
    protected $table = 'r_project';

    protected $fillable = [
        'request_no',
        'tanggal_request',
        'requires_site_survey',
        'id_user',
        'nama_projek',
        'nama_pelanggan',
        'pic_pelanggan',
        'no_hp',
        'deskripsi_proyek',
        'target_waktu',
        'estimasi_budget',
        'priority',
        'alamat',
        'status_proyek',
        'category_id'
    ];

    protected $casts = [
        'tanggal_request' => 'datetime',
        'requires_site_survey' => 'boolean',
        'estimasi_budget' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function items()
    {
        return $this->hasMany(RProjectItem::class, 'id_r_project');
    }

    public function biddings()
    {
        return $this->hasMany(Bidding::class, 'id_r_project');
    }

    public function rabs()
    {
        return $this->hasMany(Rab::class, 'id_r_project');
    }

    public function rab()
    {
        return $this->hasOne(Rab::class, 'id_r_project')->latestOfMany();
    }

    public function attachments()
    {
        return $this->hasMany(ProjectAttachment::class, 'id_r_project');
    }
}