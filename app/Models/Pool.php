<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pool extends Model
{
    /** @use HasFactory<\Database\Factories\PoolFactory> */
    use HasFactory;
    protected $fillable = [
        'tournament_id',
        'name',
    ];

    public function teams(): HasMany {
        return $this->hasMany(Team::class, 'pool_id');
    }

    public function tournament(): BelongsTo {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }


    
}
