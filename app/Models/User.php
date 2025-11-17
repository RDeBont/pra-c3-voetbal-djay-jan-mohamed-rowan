<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'phonenumber',
    ];

    public function school(): HasOne
    {
        return $this->hasOne(School::class, 'creator_id');
    }

   


}
