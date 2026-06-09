<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RProject extends Model
{
    protected $table = 'r_project';

    protected $fillable = [
        'request_no',
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
        // 'latitude',
        // 'longitude',
        'status_proyek',
        'category_id'
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
        return $this->hasMany(RProjectItem::class, 'r_project_id');
    }

    public function biddings()
    {
        return $this->hasMany(Bidding::class, 'r_project_id');
    }

  // app/Models/RProject.php

    public function rabs()
    {
        // Ganti 'r_project_id' jadi 'id_r_project'
        return $this->hasMany(Rab::class, 'id_r_project');
    }

    public function rab()
    {
        // Ganti juga di sini
        return $this->hasOne(Rab::class, 'id_r_project')->latestOfMany();
    }

    public function attachments()
    {
        return $this->hasMany(ProjectAttachment::class, 'r_project_id');
    }
}