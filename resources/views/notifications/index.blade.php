<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Notifications</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; min-height: 100vh; }
        nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 60px; background: rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.1); }
        .logo { font-size: 26px; font-weight: 700; color: #00e5a0; text-decoration: none; }
        .logo span { color: white; }
        .container { max-width: 800px; margin: 0 auto; padding: 40px 20px; }
        h1 { font-size: 28px; font-weight: 800; margin-bottom: 30px; }
        .notif-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px; padding: 20px;
            margin-bottom: 12px; display: flex;
            gap: 16px; align-items: flex-start;
        }
        .notif-card.non-lue { border-color: rgba(0,229,160,0.4); background: rgba(0,229,160,0.05); }
        .notif-icon { font-size: 28px; flex-shrink: 0; }
        .notif-titre { font-size: 15px; font-weight: 700; margin-bottom: 4px; }
        .notif-message { font-size: 13px; color: rgba(255,255,255,0.7); line-height: 1.6; }
        .notif-date { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 6px; }
        .badge-new { background: #00e5a0; color: #0a1628; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 700; margin-left: 8px; }
        .empty { text-align: center; padding: 60px 20px; color: rgba(255,255,255,0.4); }
        .type-success .notif-icon::after { content: ''; }
        .type-info { border-left: 3px solid #378ADD; }
        .type-success { border-left: 3px solid #00e5a0; }
        .type-warning { border-left: 3px solid #ffa500; }
    </style>
</head>
<body>
<nav>
    <a href="/" class="logo">Bio<span>Link</span></a>
    <a href="/dashboard" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px;">← Dashboard</a>
</nav>
<div class="container">
    <h1>🔔 Mes notifications</h1>

    @if($notifications->count() > 0)
        @foreach($notifications as $notif)
        <div class="notif-card type-{{ $notif->type }} {{ !$notif->lue ? 'non-lue' : '' }}">
            <div class="notif-icon">
                @if($notif->type === 'success') ✅
                @elseif($notif->type === 'warning') ⚠️
                @elseif($notif->type === 'grade') 🎓
                @else ℹ️
                @endif
            </div>
            <div style="flex:1">
                <div class="notif-titre">
                    {{ $notif->titre }}
                    @if(!$notif->lue) <span class="badge-new">NEW</span> @endif
                </div>
                <div class="notif-message">{{ $notif->message }}</div>
                <div class="notif-date">{{ $notif->created_at->diffForHumans() }}</div>
            </div>
        </div>
        @endforeach
    @else
        <div class="empty">
            <div style="font-size:64px; margin-bottom:16px;">🔔</div>
            <p style="font-size:18px; color:rgba(255,255,255,0.6);">Aucune notification pour le moment</p>
        </div>
    @endif
</div>
</body>
</html>