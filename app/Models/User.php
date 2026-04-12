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
            1 => ['nom' => 'Débutant', 'couleur' => '#aaaaaa', 'emoji' => '🌱'],
            2 => ['nom' => 'Contributeur', 'couleur' => '#00e5a0', 'emoji' => '🌿'],
            3 => ['nom' => 'Chercheur Actif', 'couleur' => '#378ADD', 'emoji' => '🔬'],
            4 => ['nom' => 'Expert', 'couleur' => '#FFD700', 'emoji' => '⭐'],
            5 => ['nom' => 'Leader Scientifique', 'couleur' => '#FF6B35', 'emoji' => '🏆'],
        ];
        return $grades[$this->grade_id] ?? $grades[1];
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