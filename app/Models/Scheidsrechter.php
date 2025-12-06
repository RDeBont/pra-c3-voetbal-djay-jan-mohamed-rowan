<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheidsrechter extends Model
{
    /** @use HasFactory<\Database\Factories\ScheidsrechterFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'school_id',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}

