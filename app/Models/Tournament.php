<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    /** @use HasFactory<\Database\Factories\TournamentFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'fields_amount',
        'game_length_minutes',
        'amount_teams_pool',
        'archived',
    ];

    public function fixtures(): HasMany
    {
        return $this->hasMany(Fixture::class, 'tournament_id');
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'tournament_id');
    }


}
