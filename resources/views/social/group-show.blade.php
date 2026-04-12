<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BioLink – {{ $group->nom }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; min-height: 100vh; }
        .cover { height: 200px; background: linear-gradient(135deg, rgba(0,229,160,0.4), rgba(55,138,221,0.4)); display: flex; align-items: center; justify-content: center; font-size: 80px; }
        .group-header { max-width: 900px; margin: 0 auto; padding: 20px; }
        .group-title { font-size: 28px; font-weight: 800; margin-bottom: 8px; }
        .group-meta { display: flex; gap: 20px; align-items: center; margin-bottom: 16px; }
        .meta-item { font-size: 14px; color: rgba(255,255,255,0.6); }
        .group-desc { font-size: 15px; color: rgba(255,255,255,0.7); line-height: 1.7; margin-bottom: 20px; }
        .group-actions { display: flex; gap: 12px; margin-bottom: 30px; }
        .btn-join { background: #00e5a0; color: #0a1628; padding: 10px 24px; border-radius: 20px; font-weight: 700; border: none; cursor: pointer; font-size: 14px; }
        .btn-leave { background: rgba(255,80,80,0.2); border: 1px solid #ff5050; color: #ff5050; padding: 10px 24px; border-radius: 20px; font-weight: 600; cursor: pointer; font-size: 14px; }
        .layout { display: grid; grid-template-columns: 1fr 280px; gap: 20px; max-width: 900px; margin: 0 auto; padding: 0 20px 30px; }
        .post-composer { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 20px; margin-bottom: 20px; }
        .post-input { width: 100%; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 12px; color: white; font-size: 14px; outline: none; resize: none; min-height: 80px; font-family: inherit; }
        .post-input:focus { border-color: #00e5a0; }
        .btn-post { background: #00e5a0; color: #0a1628; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 700; cursor: pointer; margin-top: 10px; }
        .post-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 18px; margin-bottom: 14px; }
        .post-header { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .post-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #00e5a0, #378ADD); display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 700; color: #0a1628; overflow: hidden; }
        .post-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .member-card { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .member-card:last-child { border-bottom: none; }
        .sidebar-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 18px; }
        .sidebar-title { font-size: 13px; font-weight: 700; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px; }
        .empty { text-align: center; padding: 30px; color: rgba(255,255,255,0.4); font-size: 14px; }
    </style>
</head>
<body>

@include('components.navbar')

<div class="cover">🌿</div>

<div class="group-header">
    <div class="group-title">{{ $group->nom }}</div>
    <div class="group-meta">
        <span class="meta-item">👥 {{ $group->membres_count }} membres</span>
        <span class="meta-item">📂 {{ $group->categorie }}</span>
        <span class="meta-item">🔓 {{ ucfirst($group->visibilite) }}</span>
        <span class="meta-item">Créé par {{ $group->creator->name }}</span>
    </div>
    <div class="group-desc">{{ $group->description }}</div>
    <div class="group-actions">
        @if($group->isMember(Auth::id()))
            <form method="POST" action="/groups/{{ $group->id }}/leave">
                @csrf
                <button type="submit" class="btn-leave">👋 Quitter le groupe</button>
            </form>
        @else
            <form method="POST" action="/groups/{{ $group->id }}/join">
                @csrf
                <button type="submit" class="btn-join">+ Rejoindre le groupe</button>
            </form>
        @endif
        <a href="/feed" style="background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.2); color:white; padding:10px 20px; border-radius:20px; text-decoration:none; font-size:14px;">← Retour</a>
    </div>
</div>

<div class="layout">
    <div>
        @if($group->isMember(Auth::id()))
        <div class="post-composer">
            <form method="POST" action="/posts">
                @csrf
                <input type="hidden" name="group_id" value="{{ $group->id }}">
                <textarea name="contenu" class="post-input" placeholder="Partagez quelque chose avec le groupe..."></textarea>
                <button type="submit" class="btn-post">📝 Publier dans le groupe</button>
            </form>
        </div>
        @endif

        @if($group->posts->count() > 0)
            @foreach($group->posts->sortByDesc('created_at') as $post)
            <div class="post-card">
                <div class="post-header">
                    <div class="post-avatar">
                        @if($post->user->photo_profil)
                            <img src="{{ Storage::url($post->user->photo_profil) }}" alt="">
                        @else
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div style="font-size:14px; font-weight:700;">{{ $post->user->name }}</div>
                        <div style="font-size:11px; color:rgba(255,255,255,0.5);">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <div style="font-size:14px; line-height:1.7; color:rgba(255,255,255,0.9);">{{ $post->contenu }}</div>
            </div>
            @endforeach
        @else
            <div class="empty">Aucune publication dans ce groupe. Soyez le premier !</div>
        @endif
    </div>

    <div>
        <div class="sidebar-card">
            <div class="sidebar-title">Membres ({{ $group->membres_count }})</div>
            @foreach($group->members->take(10) as $member)
            <div class="member-card">
                <div class="post-avatar" style="width:36px;height:36px;font-size:14px;">
                    @if($member->user->photo_profil)
                        <img src="{{ Storage::url($member->user->photo_profil) }}" alt="">
                    @else
                        {{ strtoupper(substr($member->user->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div style="font-size:13px; font-weight:600;">{{ $member->user->name }}</div>
                    <div style="font-size:11px; color:#00e5a0;">{{ $member->role }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

</body>
</html>