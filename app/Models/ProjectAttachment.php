<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectAttachment extends Model
{
    // INI YANG GW MAKSUD, SESUAIIN SAMA GAMBAR LU!
    protected $table = 'project_request_attachments'; 
    
    protected $fillable = [
        'r_project_id', 'file_name', 'file_path', 'file_type' , 'attachment_category'
    ];

    public function project() {
        return $this->belongsTo(RProject::class, 'r_project_id', 'id');
    }
}