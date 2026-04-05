<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobBoard extends Model
{
    protected $table = 'jobs_board';

    protected $fillable = [
        'titre', 'entreprise', 'lieu', 'type',
        'description', 'competences', 'salaire',
        'email_contact', 'categorie', 'approuve', 'date_expiration'
    ];
}