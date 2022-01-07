<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function students()
    {
        return $this->belongsToMany(User::class, 'user_class_models', 'class_models_id', 'user_id')->withPivot('grade', 'attendance');
    }
}
