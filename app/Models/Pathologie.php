<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pathologie extends Model
{
    protected $fillable = [
        'nom',
        'categorie',
        'description',
        'symptomes',
        'cause',
        'prevention',
        'traitement_naturel',
        'gravite',
        'contagieux',
        'image',
        'approuve',
        'user_id'
    ];

    public function remedes()
    {
        return $this->hasMany(Remede::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}