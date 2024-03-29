<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Tables\Circumstance_link;

class Circumstance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'information'
    ];

    public function circumstance_links() {
        return $this->hasMany(Circumstance_link::class);
    }
}
