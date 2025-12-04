<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory;
    protected $fillable = ['school_id', 
    'name', 
    'sport', 
    'group', 
    'teamsort', 
    'referee',
    'pool',
    'tournament_id'];


    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function fixturesAsTeam1(): HasMany
    {
        return $this->hasMany(Fixture::class, 'team_1_id');
    }

    public function fixturesAsTeam2(): HasMany
    {
        return $this->hasMany(Fixture::class, 'team_2_id');
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }
}
