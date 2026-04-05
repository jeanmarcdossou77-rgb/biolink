<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remede extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'ingredients',
        'preparation',
        'type',
        'age_min',
        'age_max',
        'sexe',
        'approuve',
        'votes',
        'pathologie_id',
        'user_id'
    ];

    public function pathologie()
    {
        return $this->belongsTo(Pathologie::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}