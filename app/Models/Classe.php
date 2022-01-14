<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'credits'
    ];

    public function students()
    {
        return $this->belongsToMany(User::class, 'user_class', 'class_id', 'user_id')->withPivot('grade', 'attendance');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'courses', 'course_id', 'course_id');
    }
}
