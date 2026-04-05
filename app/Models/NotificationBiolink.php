<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationBiolink extends Model
{
    protected $table = 'notifications_biolink';

    protected $fillable = [
        'user_id', 'titre', 'message', 'type', 'lien', 'lue'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function envoyer($userId, $titre, $message, $type = 'info', $lien = null)
    {
        return self::create([
            'user_id' => $userId,
            'titre' => $titre,
            'message' => $message,
            'type' => $type,
            'lien' => $lien,
        ]);
    }
}