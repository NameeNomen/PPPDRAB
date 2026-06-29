<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    
    protected $fillable = ['username', 'password', 'role'];
    protected $hidden = ['password'];
    public function projects() {
        return $this->hasMany(RProject::class, 'id_user', 'id');
    }
    public function materials() {
        return $this->hasMany(Material::class, 'id_user', 'id');
    }
    public function rabs() {
        return $this->hasMany(Rab::class, 'id_user', 'id');
    }

    public function biddings() {
        return $this->hasMany(Bidding::class, 'id_user', 'id');
    }
    public function documentCommits() {
        return $this->hasMany(DocumentCommit::class, 'id_document_commit', 'id');
    }
}