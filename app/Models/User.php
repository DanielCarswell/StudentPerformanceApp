<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Defining User belongs to many Classes relationship.
     */
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'user_class_models', 'user_id', 'class_models_id')->withPivot('grade', 'attendance');
    }

    /**
     * Defining User has many Permissions relationship.
     */
    public function permissions(){

        return $this->belongsToMany(Permission::class, 'user_permission', 'user_id', 'permission_id');

    }

    /**
     * Defining User has many Roles relationship.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }
}
