<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Demandes d'amis</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; min-height: 100vh; }
        .container { max-width: 900px; margin: 0 auto; padding: 30px 20px; }
        h1 { font-size: 28px; font-weight: 800; margin-bottom: 30px; }
        .tabs { display: flex; gap: 10px; margin-bottom: 30px; }
        .tab { padding: 10px 20px; border-radius: 20px; font-size: 14px; font-weight: 600; cursor: pointer; border: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.7); background: none; transition: all 0.2s; text-decoration: none; }
        .tab.active { background: #00e5a0; color: #0a1628; border-color: #00e5a0; }
        .section-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; color: rgba(255,255,255,0.8); }
        .members-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 40px; }
        .member-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 20px; text-align: center; transition: all 0.3s; }
        .member-card:hover { border-color: #00e5a0; transform: translateY(-3px); }
        .member-avatar { width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #00e5a0, #378ADD); display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 700; color: #0a1628; margin: 0 auto 12px; overflow: hidden; }
        .member-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .member-name { font-size: 14px; font-weight: 700; margin-bottom: 4px; }
        .member-grade { font-size: 12px; color: #00e5a0; margin-bottom: 12px; }
        .member-points { font-size: 11px; color: rgba(255,255,255,0.5); margin-bottom: 12px; }
        .btn-add { width: 100%; padding: 8px; background: rgba(0,229,160,0.2); border: 1px solid #00e5a0; color: #00e5a0; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13px; }
        .btn-msg { width: 100%; padding: 8px; background: rgba(55,138,221,0.2); border: 1px solid #378ADD; color: #378ADD; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13px; text-decoration: none; display: block; margin-top: 6px; }
        .btn-pending { width: 100%; padding: 8px; background: rgba(255,165,0,0.2); border: 1px solid #ffa500; color: #ffa500; border-radius: 10px; font-size: 13px; cursor: default; }
        .btn-friends { width: 100%; padding: 8px; background: rgba(0,229,160,0.1); border: 1px solid rgba(0,229,160,0.3); color: rgba(255,255,255,0.6); border-radius: 10px; font-size: 13px; cursor: default; }
        .request-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 16px; display: flex; align-items: center; gap: 14px; margin-bottom: 12px; }
        .request-actions { display: flex; gap: 8px; margin-left: auto; }
        .btn-accept { background: rgba(0,229,160,0.2); border: 1px solid #00e5a0; color: #00e5a0; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; }
        .btn-reject { background: rgba(255,80,80,0.2); border: 1px solid #ff5050; color: #ff5050; padding: 8px 16px; border-radius: 10px; font-size: 13px; cursor: pointer; }
        .empty { text-align: center; padding: 40px; color: rgba(255,255,255,0.4); font-size: 14px; }
        .success-msg { background: rgba(0,229,160,0.15); border: 1px solid rgba(0,229,160,0.3); padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; color: #00e5a0; font-size: 14px; }
    </style>
</head>
<body>

@include('components.navbar')

<div class="container">
    <h1>👥 Communauté BioLink</h1>

    @if(session('success'))
        <div class="success-msg">{{ session('success') }}</div>
    @endif

    <div class="tabs">
        <a href="#demandes" class="tab active">📩 Demandes reçues ({{ $requests->count() }})</a>
        <a href="#membres" class="tab">🌍 Tous les membres</a>
    </div>

    <!-- Demandes reçues -->
    <div id="demandes">
        <div class="section-title">📩 Demandes d'amis en attente</div>
        @if($requests->count() > 0)
            @foreach($requests as $request)
            <div class="request-card">
                <div class="member-avatar" style="width:48px;height:48px;font-size:18px;margin:0;flex-shrink:0;">
                    @if($request->user->photo_profil)
                        <img src="{{ Storage::url($request->user->photo_profil) }}" alt="">
                    @else
                        {{ strtoupper(substr($request->user->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div style="font-size:15px; font-weight:700;">{{ $request->user->name }}</div>
                    <div style="font-size:12px; color:#00e5a0;">{{ $request->user->nom_grade['emoji'] }} {{ $request->user->nom_grade['nom'] }}</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.5);">⭐ {{ $request->user->points }} points</div>
                </div>
                <div class="request-actions">
                    <form method="POST" action="/friends/accept/{{ $request->id }}">
                        @csrf
                        <button type="submit" class="btn-accept">✅ Accepter</button>
                    </form>
                    <form method="POST" action="/friends/reject/{{ $request->id }}">
                        @csrf
                        <button type="submit" class="btn-reject">❌ Refuser</button>
                    </form>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty">Aucune demande d'ami en attente.</div>
        @endif
    </div>

    <!-- Tous les membres -->
    <div id="membres" style="margin-top:40px;">
        <div class="section-title">🌍 Tous les membres BioLink</div>
        <div class="members-grid">
            @foreach($allUsers as $user)
            <div class="member-card">
                <div class="member-avatar">
                    @if($user->photo_profil)
                        <img src="{{ Storage::url($user->photo_profil) }}" alt="">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div class="member-name">{{ $user->name }}</div>
                <div class="member-grade">{{ $user->nom_grade['emoji'] }} {{ $user->nom_grade['nom'] }}</div>
                <div class="member-points">⭐ {{ $user->points }} points</div>

                @if(Auth::user()->isFriendWith($user->id))
                    <div class="btn-friends">✅ Amis</div>
                    <a href="/messages/{{ $user->id }}" class="btn-msg">💬 Message</a>
                @elseif(Auth::user()->hasPendingRequestWith($user->id))
                    <div class="btn-pending">⏳ En attente</div>
                @else
                    <form method="POST" action="/friends/request/{{ $user->id }}">
                        @csrf
                        <button type="submit" class="btn-add">+ Ajouter en ami</button>
                    </form>
                    <a href="/messages/{{ $user->id }}" class="btn-msg">💬 Message</a>
                @endif
            </div>
            @endforeach
        </div>
    </div>

</div>

</body>
</html>