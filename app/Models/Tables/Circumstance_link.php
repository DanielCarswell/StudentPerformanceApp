<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Circumstance;

class Circumstance_link extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'link'
    ];

    public function links() {
        return $this->belongsTo(Circumstance::class);
    }
}
