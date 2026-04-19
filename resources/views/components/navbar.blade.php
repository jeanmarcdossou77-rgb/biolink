<link rel="stylesheet" href="/css/mobile.css">
<link rel="icon" type="image/svg+xml" href="/favicon.svg">
<meta name="theme-color" content="#0a1628">

<style>
.bio-header {
    background: rgba(10,22,40,0.97);
    border-bottom: 1px solid rgba(255,255,255,0.1);
    backdrop-filter: blur(12px);
    position: sticky;
    top: 0;
    z-index: 1000;
    padding: 0;
}
.bio-nav {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    padding: 0 16px;
    height: 56px;
    gap: 8px;
}
.nav-logo {
    font-size: 22px;
    font-weight: 800;
    color: #00e5a0;
    text-decoration: none;
    letter-spacing: 1px;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
    margin-right: 8px;
}
.nav-logo span { color: white; }
.nav-logo svg { flex-shrink: 0; }
.nav-links {
    display: flex;
    align-items: center;
    gap: 2px;
    flex: 1;
    flex-wrap: nowrap;
    overflow: hidden;
}
.nav-link {
    color: rgba(255,255,255,0.75);
    text-decoration: none;
    padding: 6px 10px;
    border-radius: 10px;
    font-size: 13px;
    transition: all 0.2s;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 4px;
}
.nav-link:hover { background: rgba(255,255,255,0.08); color: white; }
.nav-btn {
    background: #00e5a0;
    color: #0a1628;
    padding: 7px 16px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 13px;
    text-decoration: none;
    white-space: nowrap;
    transition: transform 0.2s;
}
.nav-btn:hover { transform: translateY(-1px); }
.notif-btn {
    position: relative;
    color: rgba(255,255,255,0.7);
    text-decoration: none;
    padding: 6px 8px;
    border-radius: 10px;
    font-size: 18px;
    transition: all 0.2s;
}
.notif-btn:hover { background: rgba(255,255,255,0.08); }
.notif-badge {
    position: absolute;
    top: 0;
    right: 0;
    background: #ff5050;
    color: white;
    font-size: 9px;
    font-weight: 700;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.premium-badge-nav {
    background: linear-gradient(135deg, #ffa500, #ff6b35);
    color: white;
    font-size: 9px;
    padding: 2px 5px;
    border-radius: 6px;
    font-weight: 700;
}
.nav-avatar {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00e5a0, #378ADD);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700; color: #0a1628;
    overflow: hidden; flex-shrink: 0;
}
.nav-avatar img { width: 100%; height: 100%; object-fit: cover; }
/* Dropdown */
.dropdown { position: relative; display: inline-block; }
.dropdown-trigger {
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    padding: 6px 10px;
    border-radius: 10px;
    font-size: 13px;
    color: rgba(255,255,255,0.8);
    transition: background 0.2s;
    white-space: nowrap;
    user-select: none;
}
.dropdown-trigger:hover { background: rgba(255,255,255,0.08); }
.dropdown-menu {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    background: #0d1f35;
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 14px;
    padding: 8px;
    min-width: 210px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.6);
    z-index: 99999;
    display: none;
}
.dropdown-menu.show { display: block !important; }
.dropdown-item {
    display: block;
    padding: 10px 14px;
    color: rgba(255,255,255,0.85);
    text-decoration: none;
    font-size: 13px;
    border-radius: 10px;
    transition: all 0.2s;
    width: 100%;
    text-align: left;
    background: none;
    border: none;
    cursor: pointer;
    font-family: inherit;
}
.dropdown-item:hover { background: rgba(255,255,255,0.1); color: white; }
.dropdown-divider { border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 6px 0; }
/* Mobile hamburger */
.hamburger {
    display: none;
    flex-direction: column;
    gap: 4px;
    cursor: pointer;
    padding: 6px;
    border-radius: 8px;
    background: none;
    border: none;
    margin-left: auto;
}
.hamburger span {
    display: block;
    width: 22px;
    height: 2px;
    background: white;
    border-radius: 2px;
    transition: all 0.3s;
}
.mobile-menu {
    display: none;
    background: #0d1f35;
    border-top: 1px solid rgba(255,255,255,0.1);
    padding: 12px 16px;
}
.mobile-menu.open { display: block; }
.mobile-nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 8px;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    font-size: 15px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    border-radius: 0;
    transition: background 0.2s;
}
.mobile-nav-link:hover { background: rgba(255,255,255,0.05); border-radius: 10px; }
.mobile-user-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 8px 14px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    margin-bottom: 8px;
}
@media (max-width: 900px) {
    .nav-links { display: none; }
    .hamburger { display: flex; }
}
</style>

<header class="bio-header">
    <nav class="bio-nav">
        <!-- Logo DJM -->
        <a href="/" class="nav-logo">
            <svg width="36" height="36" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="djmG" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#00e5a0"/>
                        <stop offset="100%" style="stop-color:#378ADD"/>
                    </linearGradient>
                </defs>
                <circle cx="18" cy="18" r="17" fill="rgba(0,229,160,0.12)" stroke="url(#djmG)" stroke-width="1.5"/>
                <!-- D -->
                <text x="3" y="25" font-family="Georgia,serif" font-size="15" font-weight="bold" fill="#00e5a0">D</text>
                <!-- J -->
                <text x="13" y="23" font-family="Georgia,serif" font-size="13" font-weight="bold" fill="url(#djmG)">J</text>
                <!-- M -->
                <text x="21" y="26" font-family="Georgia,serif" font-size="14" font-weight="bold" fill="#378ADD">M</text>
                <!-- Ligne décorative -->
                <path d="M5 28 Q18 20 31 28" stroke="url(#djmG)" stroke-width="1" fill="none" opacity="0.4"/>
            </svg>
            Bio<span>Link</span>
        </a>

        <!-- Liens desktop -->
        <div class="nav-links">
            <a href="/recherche" class="nav-link">🔬 Pathologies</a>
            <a href="/feed" class="nav-link">📱 Fil</a>
            <a href="/groups" class="nav-link">👥 Groupes</a>
            <a href="/ia" class="nav-link">🤖 IA</a>
            <a href="/jobs" class="nav-link">💼 Emplois</a>
            <a href="/aide" class="nav-link">❓ Aide</a>

            @auth
<a href="/messages" class="notif-btn" title="Messages">
    💬
    <span class="notif-badge" id="msg-badge" style="display:none">0</span>
</a>
<a href="/notifications" class="notif-btn" title="Notifications">
    🔔
    <span class="notif-badge" id="notif-badge" style="display:none">0</span>
</a>

                @if(Auth::user()->is_admin)
                    <a href="/admin" class="nav-link" style="color:#ffa500;">👑 Admin</a>
                @endif

<div class="dropdown" id="mainDropdown">
    <div class="dropdown-trigger" id="dropdownTrigger">
        <div class="nav-avatar">
            @if(Auth::user()->photo_profil)
                <img src="{{ Storage::url(Auth::user()->photo_profil) }}" alt="">
            @else
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            @endif
        </div>
        {{ explode(' ', Auth::user()->name)[0] }}
        @if(Auth::user()->is_premium)
            <span class="premium-badge-nav">★ PRO</span>
        @endif
        <span style="font-size:10px;opacity:0.6;">▾</span>
    </div>
    <div class="dropdown-menu" id="mainDropdownMenu">
        <a href="/dashboard" class="dropdown-item">🏠 Dashboard</a>
        <a href="/feed" class="dropdown-item">📱 Fil d'actualité</a>
        <a href="/profil" class="dropdown-item">👤 Mon profil</a>
        <a href="/friends/requests" class="dropdown-item">👥 Demandes d'amis</a>
        <a href="/messages" class="dropdown-item">💬 Messages</a>
        <a href="/remedes/create" class="dropdown-item">🌿 Publier un remède</a>
        <a href="/notifications" class="dropdown-item">🔔 Notifications</a>
        @if(!Auth::user()->is_premium)
            <a href="/premium" class="dropdown-item" style="color:#ffa500;">🌟 Passer Premium</a>
        @endif
        <div class="dropdown-divider"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item" style="color:rgba(255,80,80,0.9);">🚪 Déconnexion</button>
        </form>
    </div>
</div>
            @else
                <a href="/login" class="nav-link">Se connecter</a>
                <a href="/register" class="nav-btn">Rejoindre BioLink</a>
            @endauth
        </div>

        <!-- Hamburger mobile -->
        <button class="hamburger" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </nav>

    <!-- Menu mobile -->
    <div class="mobile-menu" id="mobileMenu">
        @auth
        <div class="mobile-user-card">
            <div class="nav-avatar" style="width:44px;height:44px;font-size:18px;">
                @if(Auth::user()->photo_profil)
                    <img src="{{ Storage::url(Auth::user()->photo_profil) }}" alt="">
                @else
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                @endif
            </div>
            <div>
                <div style="font-weight:700;font-size:15px;">{{ Auth::user()->name }}</div>
                <div style="font-size:12px;color:#00e5a0;">{{ Auth::user()->nom_grade['emoji'] }} {{ Auth::user()->nom_grade['nom'] }} · ⭐ {{ Auth::user()->points }} pts</div>
            </div>
        </div>
        @endauth

        <a href="/recherche" class="mobile-nav-link">🔬 Pathologies</a>
        <a href="/feed" class="mobile-nav-link">📱 Fil d'actualité</a>
        <a href="/groups" class="mobile-nav-link">👥 Groupes</a>
        <a href="/ia" class="mobile-nav-link">🤖 Assistant IA</a>
        <a href="/jobs" class="mobile-nav-link">💼 Emplois</a>
        <a href="/aide" class="mobile-nav-link">❓ Aide</a>
        <a href="/messages" class="mobile-nav-link">💬 Messages</a>
        <a href="/notifications" class="mobile-nav-link">🔔 Notifications</a>

        @auth
            <a href="/dashboard" class="mobile-nav-link">🏠 Dashboard</a>
            <a href="/profil" class="mobile-nav-link">👤 Mon profil</a>
            <a href="/friends/requests" class="mobile-nav-link">👥 Demandes d'amis</a>
            <a href="/remedes/create" class="mobile-nav-link">🌿 Publier un remède</a>
            @if(!Auth::user()->is_premium)
                <a href="/premium" class="mobile-nav-link" style="color:#ffa500;">🌟 Passer Premium</a>
            @endif
            @if(Auth::user()->is_admin)
                <a href="/admin" class="mobile-nav-link" style="color:#ffa500;">👑 Admin</a>
            @endif
            <div class="dropdown-divider" style="margin:8px 0;"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mobile-nav-link" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;font-family:inherit;color:rgba(255,80,80,0.8);">🚪 Déconnexion</button>
            </form>
        @else
            <a href="/login" class="mobile-nav-link">🔐 Se connecter</a>
            <a href="/register" class="mobile-nav-link" style="color:#00e5a0;font-weight:700;">🌿 Rejoindre BioLink</a>
        @endauth
    </div>
</header>

<!-- Bouton retour en haut -->
<button id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})"
    style="display:none;position:fixed;bottom:80px;right:16px;width:44px;height:44px;border-radius:50%;background:#00e5a0;color:#0a1628;border:none;font-size:20px;cursor:pointer;box-shadow:0 4px 16px rgba(0,229,160,0.4);z-index:999;transition:all 0.3s;align-items:center;justify-content:center;">
    ↑
</button>

<script>
(function() {
    // Dropdown
    var trigger = document.getElementById('dropdownTrigger');
    var menu = document.getElementById('mainDropdownMenu');

    if (trigger && menu) {
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            var isOpen = menu.classList.contains('show');
            // Fermer tous les dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(function(m) {
                m.classList.remove('show');
            });
            if (!isOpen) {
                menu.classList.add('show');
            }
        });
    }

    // Menu hamburger mobile
    var hamburger = document.querySelector('.hamburger');
    var mobileMenu = document.getElementById('mobileMenu');

    if (hamburger && mobileMenu) {
        hamburger.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileMenu.classList.toggle('open');
        });
    }

    // Fermer en cliquant ailleurs
    document.addEventListener('click', function(e) {
        if (menu && trigger && !trigger.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove('show');
        }
        if (mobileMenu && hamburger && !mobileMenu.contains(e.target) && !hamburger.contains(e.target)) {
            mobileMenu.classList.remove('open');
        }
    });

    // Notifications temps réel
    @auth
    function checkNotifications() {
        fetch('/api/notifications/count', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var msgBadge = document.getElementById('msg-badge');
            var notifBadge = document.getElementById('notif-badge');
            if (msgBadge) {
                msgBadge.textContent = data.messages;
                msgBadge.style.display = data.messages > 0 ? 'flex' : 'none';
            }
            if (notifBadge) {
                notifBadge.textContent = data.notifications;
                notifBadge.style.display = data.notifications > 0 ? 'flex' : 'none';
            }
        })
        .catch(function() {});
    }
    setInterval(checkNotifications, 15000);
    checkNotifications();
    @endauth

    // Bouton retour en haut
    var backBtn = document.getElementById('backToTop');
    if (backBtn) {
        window.addEventListener('scroll', function() {
            backBtn.style.display = window.scrollY > 400 ? 'flex' : 'none';
        });
    }
})();
</script>