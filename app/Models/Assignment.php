<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'class_worth',
        'is_exam',
        'class_id'
    ];

    public function class()
    {
        return $this->belongsTo(Classe::class, 'classes', 'class_id', 'class_id');
    }
}
