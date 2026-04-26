<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'sexe', 'age', 'poids',
        'taille', 'etat_sante', 'grade_id', 'publications_validees',
        'points', 'is_premium', 'is_admin', 'avatar',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_premium' => 'boolean',
        'is_admin' => 'boolean',
    ];

    public function remedes()
    {
        return $this->hasMany(Remede::class);
    }

    public function posts()
{
    return $this->hasMany(Post::class);
}

public function comments()
{
    return $this->hasMany(Comment::class);
}

public function sentMessages()
{
    return $this->hasMany(Message::class, 'sender_id');
}

public function receivedMessages()
{
    return $this->hasMany(Message::class, 'receiver_id');
}

public function friendships()
{
    return $this->hasMany(Friendship::class);
}

public function friends()
{
    return $this->friendships()->where('status', 'accepted');
}

public function groupMemberships()
{
    return $this->hasMany(GroupMember::class);
}

public function isFriendWith($userId)
{
    return Friendship::where(function($q) use ($userId) {
        $q->where('user_id', auth()->id())->where('friend_id', $userId);
    })->orWhere(function($q) use ($userId) {
        $q->where('user_id', $userId)->where('friend_id', auth()->id());
    })->where('status', 'accepted')->exists();
}

public function hasPendingRequestWith($userId)
{
    return Friendship::where('user_id', auth()->id())
        ->where('friend_id', $userId)
        ->where('status', 'pending')
        ->exists();
}

    public function pathologies()
    {
        return $this->hasMany(Pathologie::class);
    }

public function getNomGradeAttribute()
{
    $grades = [
        1 => ['nom' => 'Débutant', 'emoji' => '🌱'],
        2 => ['nom' => 'Contributeur', 'emoji' => '🌿'],
        3 => ['nom' => 'Chercheur Actif', 'emoji' => '🔬'],
        4 => ['nom' => 'Expert', 'emoji' => '⭐'],
        5 => ['nom' => 'Leader Scientifique', 'emoji' => '🏆'],
    ];
    return $grades[$this->grade_id] ?? $grades[1];
}

public function verifierEtMettreAJourGrade()
{
    $pubs = $this->publications_validees;
    $nouveauGrade = 1;

    if ($pubs >= 20) {
        $nouveauGrade = 4; // Expert
    } elseif ($pubs >= 12) {
        $nouveauGrade = 3; // Chercheur Actif
    } elseif ($pubs >= 6) {
        $nouveauGrade = 2; // Contributeur
    } else {
        $nouveauGrade = 1; // Débutant
    }

    if ($nouveauGrade > $this->grade_id && $this->grade_id < 5) {
        $this->update(['grade_id' => $nouveauGrade]);

        // Notifier l'utilisateur
        \App\Models\NotificationBiolink::envoyer(
            $this->id,
            '🎉 Nouveau grade obtenu !',
            'Félicitations ! Vous avez atteint le grade ' . $this->fresh()->nom_grade['emoji'] . ' ' . $this->fresh()->nom_grade['nom'] . ' !',
            'success',
            '/dashboard'
        );
    }
}

public function peutCreerGroupe()
{
    return $this->grade_id >= 2; // Contributeur et plus
}

public function peutPublierPlusPhotos()
{
    return $this->grade_id >= 3; // Chercheur et plus
}

public function peutAccederIAAvancee()
{
    return $this->grade_id >= 4; // Expert et plus
}

    public function getPhotoUrlAttribute()
{
    if (!$this->photo_profil) return null;
    return $this->photo_profil;
}

    public function mettreAJourGrade()
    {
        $publications = $this->publications_validees;
        if ($publications >= 60) {
            $this->update(['grade_id' => 4]);
        } elseif ($publications >= 30) {
            $this->update(['grade_id' => 3]);
        } elseif ($publications >= 10) {
            $this->update(['grade_id' => 2]);
        }
    }
}