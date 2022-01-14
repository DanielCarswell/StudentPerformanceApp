<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * Defining User belongs to many Classes relationship.
     */
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'user_class', 'user_id', 'class_id')->withPivot('grade', 'attendance');
    }
}
