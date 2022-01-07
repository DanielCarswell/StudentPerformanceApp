<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [

    ];

    public function users() {
        return $this->belongsToMany(Role::class, 'user_permission', 'permission_id', 'user_id');
    }

    public function roles() {
        return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'role_id');
    }
    
}
