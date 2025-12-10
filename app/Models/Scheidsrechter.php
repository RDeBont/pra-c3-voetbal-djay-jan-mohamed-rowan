<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Scheidsrechter extends Model
{
    /** @use HasFactory<\Database\Factories\ScheidsrechterFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'school_id',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function fixtures(): HasMany
    {
        return $this->hasMany(Fixture::class, 'scheidsrechter_id');
    }
}

