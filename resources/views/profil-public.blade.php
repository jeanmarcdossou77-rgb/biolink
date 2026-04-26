<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – {{ $membre->name }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',sans-serif; background:#0a1628; color:white; min-height:100vh; }
        .container { max-width:900px; margin:0 auto; padding:24px 20px; }
        .profile-card { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:20px; overflow:hidden; margin-bottom:24px; }
        .banner { height:160px; background:linear-gradient(135deg,rgba(0,229,160,0.3),rgba(55,138,221,0.3)); position:relative; }
        .profile-info { padding:0 24px 24px; }
        .avatar-wrap { margin-top:-50px; margin-bottom:12px; }
        .avatar { width:100px; height:100px; border-radius:50%; border:4px solid #0a1628; background:linear-gradient(135deg,#00e5a0,#378ADD); display:flex; align-items:center; justify-content:center; font-size:40px; font-weight:700; color:#0a1628; overflow:hidden; }
        .avatar img { width:100%; height:100%; object-fit:cover; }
        .member-name { font-size:24px; font-weight:800; margin-bottom:4px; }
        .member-grade { font-size:14px; color:#00e5a0; margin-bottom:6px; }
        .member-bio { font-size:14px; color:rgba(255,255,255,0.6); line-height:1.7; margin-bottom:16px; }
        .member-meta { display:flex; gap:16px; flex-wrap:wrap; font-size:13px; color:rgba(255,255,255,0.5); margin-bottom:16px; }
        .stats-row { display:flex; gap:20px; margin-bottom:16px; }
        .stat-item { text-align:center; }
        .stat-num { font-size:22px; font-weight:800; color:#00e5a0; }
        .stat-label { font-size:11px; color:rgba(255,255,255,0.5); }
        .actions { display:flex; gap:10px; flex-wrap:wrap; }
        .btn-action { padding:9px 20px; border-radius:20px; font-size:14px; font-weight:600; cursor:pointer; border:none; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s; }
        .btn-follow { background:#00e5a0; color:#0a1628; }
        .btn-message { background:rgba(55,138,221,0.2); border:1px solid #378ADD; color:#378ADD; }
        .btn-friend { background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.2); color:white; }
        .btn-following { background:rgba(0,229,160,0.1); border:1px solid rgba(0,229,160,0.3); color:#00e5a0; }
        .tabs { display:flex; gap:4px; margin-bottom:20px; background:rgba(255,255,255,0.05); border-radius:12px; padding:4px; }
        .tab { flex:1; padding:10px; text-align:center; border-radius:10px; cursor:pointer; font-size:14px; font-weight:600; color:rgba(255,255,255,0.6); transition:all 0.2s; border:none; background:none; }
        .tab.active { background:rgba(0,229,160,0.15); color:#00e5a0; }
        .tab-content { display:none; }
        .tab-content.active { display:block; }
        .post-card { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:14px; padding:16px; margin-bottom:12px; }
        .remede-card { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:14px; padding:16px; margin-bottom:12px; text-decoration:none; color:white; display:block; transition:all 0.3s; }
        .remede-card:hover { border-color:#00e5a0; }
        .empty-tab { text-align:center; padding:40px; color:rgba(255,255,255,0.4); font-size:14px; }
    </style>
</head>
<body>
@include('components.navbar')

<div class="container">
    <div class="profile-card">
        <div class="banner"></div>
        <div class="profile-info">
            <div class="avatar-wrap">
                <div class="avatar">
                    @if($membre->photo_profil)
                        <img src="{{ $membre->photo_profil }}" alt="">
                    @else
                        {{ strtoupper(substr($membre->name, 0, 1)) }}
                    @endif
                </div>
            </div>

            <div class="member-name">{{ $membre->name }}</div>
            <div class="member-grade">{{ $membre->nom_grade['emoji'] }} {{ $membre->nom_grade['nom'] }}</div>

            @if($membre->bio)
            <div class="member-bio">{{ $membre->bio }}</div>
            @endif

            <div class="member-meta">
                @if($membre->profession)<span>💼 {{ $membre->profession }}</span>@endif
                @if($membre->domaine_etude)<span>🎓 {{ $membre->domaine_etude }}</span>@endif
                @if($membre->pays)<span>🌍 {{ $membre->pays }}</span>@endif
                <span>📅 Membre depuis {{ $membre->created_at->format('M Y') }}</span>
            </div>

            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-num">{{ $membre->publications_validees }}</div>
                    <div class="stat-label">Publications</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">{{ $membre->points }}</div>
                    <div class="stat-label">Points</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">{{ $membre->amis_count }}</div>
                    <div class="stat-label">Amis</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">{{ $membre->abonnes_count ?? 0 }}</div>
                    <div class="stat-label">Abonnés</div>
                </div>
            </div>

            @auth
            @if(Auth::id() !== $membre->id)
            <div class="actions">
                <!-- Suivi -->
                @if($estSuivi)
                <form method="POST" action="/suivre/{{ $membre->id }}">
                    @csrf
                    <button type="submit" class="btn-action btn-following">✅ Suivi</button>
                </form>
                @else
                <form method="POST" action="/suivre/{{ $membre->id }}">
                    @csrf
                    <button type="submit" class="btn-action btn-follow">➕ Suivre</button>
                </form>
                @endif

                <!-- Message -->
                <a href="/messages/{{ $membre->id }}" class="btn-action btn-message">💬 Message</a>

                <!-- Ami -->
                @if(Auth::user()->isFriendWith($membre->id))
                    <span class="btn-action btn-friend">👥 Amis</span>
                @elseif(!Auth::user()->hasPendingRequestWith($membre->id))
                <form method="POST" action="/friends/request/{{ $membre->id }}">
                    @csrf
                    <button type="submit" class="btn-action btn-friend">👤 Ajouter</button>
                </form>
                @else
                    <span class="btn-action btn-friend" style="opacity:0.6;">⏳ En attente</span>
                @endif

                @if($membre->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $membre->whatsapp) }}"
                   target="_blank" class="btn-action" style="background:rgba(37,211,102,0.15);border:1px solid #25D366;color:#25D366;">
                    📱 WhatsApp
                </a>
                @endif
            </div>
            @endif
            @endauth
        </div>
    </div>

    <!-- Onglets -->
    <div class="tabs">
        <button class="tab active" onclick="showTab('posts')">📝 Publications ({{ $posts->count() }})</button>
        <button class="tab" onclick="showTab('remedes')">🌿 Remèdes ({{ $remedes->count() }})</button>
    </div>

    <!-- Publications -->
    <div class="tab-content active" id="tab-posts">
        @forelse($posts as $post)
        <div class="post-card">
            <div style="font-size:12px;color:rgba(255,255,255,0.4);margin-bottom:8px;">{{ $post->created_at->diffForHumans() }}</div>
            <div style="font-size:14px;line-height:1.7;color:rgba(255,255,255,0.9);">{{ Str::limit($post->contenu, 200) }}</div>
            @if($post->images->count() > 0)
            <div style="margin-top:10px;display:flex;gap:6px;flex-wrap:wrap;">
                @foreach($post->images->take(3) as $img)
                <img src="{{ $img->image_path }}" style="width:80px;height:80px;object-fit:cover;border-radius:8px;">
                @endforeach
            </div>
            @endif
            <div style="display:flex;gap:16px;margin-top:10px;font-size:12px;color:rgba(255,255,255,0.4);">
                <span>❤️ {{ $post->likes_count }}</span>
                <span>💬 {{ $post->comments_count }}</span>
            </div>
        </div>
        @empty
        <div class="empty-tab">Aucune publication publique.</div>
        @endforelse
    </div>

    <!-- Remèdes -->
    <div class="tab-content" id="tab-remedes">
        @forelse($remedes as $remede)
        <a href="/pathologies/{{ $remede->pathologie_id }}" class="remede-card">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px;">
                <span style="background:rgba(0,229,160,0.15);color:#00e5a0;padding:2px 10px;border-radius:8px;font-size:11px;">{{ $remede->type }}</span>
                @if($remede->approuve)
                    <span style="font-size:11px;color:#00e5a0;">✅ Validé</span>
                @else
                    <span style="font-size:11px;color:#ffa500;">⏳ En attente</span>
                @endif
            </div>
            <div style="font-size:15px;font-weight:700;margin-bottom:6px;">{{ $remede->titre }}</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.6);">{{ Str::limit($remede->description, 100) }}</div>
        </a>
        @empty
        <div class="empty-tab">Aucun remède publié.</div>
        @endforelse
    </div>
</div>

<script>
function showTab(name) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    event.target.classList.add('active');
}
</script>
</body>
</html>