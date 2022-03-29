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

    public function lecturers()
    {
        return $this->belongsToMany(User::class, 'lecturer_class', 'class_id', 'lecturer_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_class', 'class_id', 'student_id')->withPivot('grade', 'attendance');
    }

    public function assignments() 
    {
        return $this->belongsToMany(Assignment::class, 'assignments', 'class_id', 'id');
    }
}
