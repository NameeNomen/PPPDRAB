<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    
    protected $fillable = ['username', 'password', 'role'];
    protected $hidden = ['password'];

    // User bisa membuat banyak proyek (khusus Marketing)
    public function projects() {
        // 'id_user' = nama kolom di tabel r_projects
        // 'id' = primary key di tabel users
        return $this->hasMany(RProject::class, 'id_user', 'id');
    }

    // User bisa mengelola banyak material (khusus Purchasing)
    public function materials() {
        return $this->hasMany(Material::class, 'id_user', 'id');
    }

    // User bisa membuat banyak RAB (khusus Engineering)
    public function rabs() {
        return $this->hasMany(Rab::class, 'id_user', 'id');
    }

    // User bisa membuat banyak Bidding (khusus Marketing)
    public function biddings() {
        return $this->hasMany(Bidding::class, 'id_user', 'id');
    }

    // User bisa memberikan banyak revisi/commit
    public function documentCommits() {
        return $this->hasMany(DocumentCommit::class, 'id_document_commit', 'id');
    }
}