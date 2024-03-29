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
        'username',
        'email',
        'fullname',
        'firstname',
        'lastname'
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
     * Defining Lecturer belongs to many Classes relationship.
     */
    public function teaches()
    {
        return $this->belongsToMany(Classe::class, 'lecturer_class', 'user_id', 'class_id');
    }

    /**
     * Defining Student belongs to many Classes relationship.
     */
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'student_class', 'student_id', 'class_id')->withPivot('grade', 'attendance');
    }
    
    /**
     * Defining User has many Roles relationship.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_role');
    }

    public function hasRole($roles) 
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }
}
