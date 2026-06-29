<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectAttachment extends Model
{
    protected $table = 'project_request_attachments'; 
    
    protected $fillable = [
        'id_r_project', 'file_name', 'file_path', 'file_type' , 'attachment_category'
    ];

    public function project() {
        return $this->belongsTo(RProject::class, 'id_r_project', 'id');
    }
}