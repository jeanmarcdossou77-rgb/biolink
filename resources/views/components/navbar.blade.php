@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
.biolink-nav {
    display: flex; justify-content: space-between; align-items: center;
    padding: 16px 40px; background: rgba(10,22,40,0.98);
    border-bottom: 1px solid rgba(255,255,255,0.1);
    position: sticky; top: 0; z-index: 1000;
    backdrop-filter: blur(10px);
}
.nav-logo { font-size: 26px; font-weight: 700; color: #00e5a0; text-decoration: none; letter-spacing: 1px; }
.nav-logo span { color: white; }
.nav-links { display: flex; align-items: center; gap: 6px; }
.nav-link {
    color: rgba(255,255,255,0.7); text-decoration: none;
    padding: 7px 14px; border-radius: 20px; font-size: 14px;
    transition: all 0.2s; display: flex; align-items: center; gap: 6px;
}
.nav-link:hover { color: #00e5a0; background: rgba(0,229,160,0.08); }
.nav-link.active { color: #00e5a0; background: rgba(0,229,160,0.1); }
.nav-btn {
    background: #00e5a0; color: #0a1628 !important;
    padding: 8px 18px; border-radius: 20px;
    font-weight: 700; font-size: 14px;
}
.nav-btn:hover { background: #00c48c; }
.nav-btn.gold { background: #ffa500; }
.notif-btn {
    position: relative; padding: 7px 12px;
    color: rgba(255,255,255,0.7); text-decoration: none;
    border-radius: 20px; transition: all 0.2s;
    font-size: 18px;
}
.notif-btn:hover { background: rgba(255,255,255,0.08); }
.notif-count {
    position: absolute; top: 2px; right: 4px;
    background: #ff5050; color: white;
    font-size: 9px; font-weight: 700;
    width: 16px; height: 16px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}
.premium-badge-nav {
    background: rgba(255,165,0,0.2); color: #ffa500;
    padding: 2px 8px; border-radius: 10px; font-size: 10px;
    font-weight: 700; margin-left: 4px;
}
.avatar-nav {
    width: 32px; height: 32px; border-radius: 50%;
    background: linear-gradient(135deg, #00e5a0, #378ADD);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; color: #0a1628;
}
.dropdown { position: relative; }
.dropdown-menu {
    display: none; position: absolute; right: 0; top: 44px;
    background: #0d1f35; border: 1px solid rgba(255,255,255,0.15);
    border-radius: 14px; padding: 8px; min-width: 200px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5); z-index: 100;
}
.dropdown:hover .dropdown-menu { display: block; }
.dropdown-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px; border-radius: 10px;
    color: rgba(255,255,255,0.8); text-decoration: none;
    font-size: 14px; transition: background 0.2s;
}
.dropdown-item:hover { background: rgba(255,255,255,0.07); color: white; }
.dropdown-divider { border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 6px 0; }
</style>

<nav class="biolink-nav">
    <a href="/" class="nav-logo">Bio<span>Link</span></a>

    <div class="nav-links">
        <a href="/recherche" class="nav-link">🔬 Pathologies</a>
        <a href="/ia" class="nav-link">🤖 IA</a>
        <a href="/jobs" class="nav-link">💼 Emplois</a>

        @auth
            <a href="/notifications" class="notif-btn" title="Notifications">
                🔔
                <span class="notif-count" id="notifCount" style="display:none">0</span>
            </a>

            @if(Auth::user()->is_admin)
                <a href="/admin" class="nav-link" style="color:#ffa500;">👑 Admin</a>
            @endif

            <div class="dropdown">
                <div class="nav-link" style="cursor:pointer; gap:8px;">
                    <div class="avatar-nav">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    {{ explode(' ', Auth::user()->name)[0] }}
                    @if(Auth::user()->is_premium)
                        <span class="premium-badge-nav">★ PRO</span>
                    @endif
                    ▾
                </div>
                <div class="dropdown-menu">
                    <a href="/dashboard" class="dropdown-item">🏠 Dashboard</a>
                    <a href="/profil" class="dropdown-item">👤 Mon profil</a>
                    <a href="/remedes/create" class="dropdown-item">🌿 Publier un remède</a>
                    <a href="/notifications" class="dropdown-item">🔔 Notifications</a>
                    @if(!Auth::user()->is_premium)
                        <a href="/premium" class="dropdown-item" style="color:#ffa500;">🌟 Passer Premium</a>
                    @endif
                    <hr class="dropdown-divider">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item" style="width:100%; background:none; border:none; cursor:pointer; text-align:left;">
                            🚪 Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="/login" class="nav-link">Se connecter</a>
            <a href="/register" class="nav-btn">Rejoindre BioLink</a>
        @endauth
    </div>
</nav>

@auth
<script>
fetch('/notifications/count')
    .then(r => r.json())
    .then(data => {
        if (data.count > 0) {
            const badge = document.getElementById('notifCount');
            badge.textContent = data.count;
            badge.style.display = 'flex';
        }
    });
</script>
@endauth