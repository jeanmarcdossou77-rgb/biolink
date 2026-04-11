<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Dashboard</title>
</head>
<body>
@include('components.navbar')
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; min-height: 100vh; }
.dashboard { padding: 30px 40px; }
.welcome-card {
    background: linear-gradient(135deg, rgba(0,229,160,0.15), rgba(55,138,221,0.1));
    border: 1px solid rgba(0,229,160,0.3);
    border-radius: 20px; padding: 30px;
    margin-bottom: 30px;
    display: flex; justify-content: space-between; align-items: center;
}
.welcome-left h1 { font-size: 26px; font-weight: 800; margin-bottom: 8px; }
.welcome-left h1 span { color: #00e5a0; }
.welcome-left p { color: rgba(255,255,255,0.6); font-size: 14px; }
.grade-display {
    text-align: center; background: rgba(0,0,0,0.2);
    border-radius: 16px; padding: 20px 30px;
}
.grade-emoji { font-size: 40px; margin-bottom: 8px; }
.grade-nom { font-size: 16px; font-weight: 700; }
.grade-niveau { font-size: 12px; color: rgba(255,255,255,0.5); margin-top: 4px; }
.progress-bar { margin-top: 10px; background: rgba(255,255,255,0.1); border-radius: 10px; height: 6px; width: 120px; }
.progress-fill { height: 100%; border-radius: 10px; background: #00e5a0; }
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 30px; }
.stat-card {
    background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
    border-radius: 16px; padding: 20px; text-align: center;
}
.stat-number { font-size: 32px; font-weight: 800; color: #00e5a0; }
.stat-label { font-size: 12px; color: rgba(255,255,255,0.6); margin-top: 6px; }
.section-title { font-size: 18px; font-weight: 700; margin-bottom: 16px; }
.actions-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 30px; }
.action-card {
    background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
    border-radius: 14px; padding: 20px; text-decoration: none; color: white;
    transition: all 0.3s; display: block;
}
.action-card:hover { border-color: #00e5a0; transform: translateY(-3px); }
.action-icon { font-size: 28px; margin-bottom: 10px; }
.action-title { font-size: 14px; font-weight: 600; margin-bottom: 4px; }
.action-desc { font-size: 12px; color: rgba(255,255,255,0.5); }
.grades-card {
    background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
    border-radius: 16px; padding: 24px;
}
.grade-item {
    display: flex; align-items: center; gap: 12px; padding: 10px 0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}
.grade-item:last-child { border-bottom: none; }
.grade-badge-small {
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center; font-size: 16px;
}
.grade-info-name { font-size: 13px; font-weight: 600; }
.grade-info-req { font-size: 11px; color: rgba(255,255,255,0.4); }
.grade-actuel { color: #00e5a0; font-size: 11px; font-weight: 600; }
.main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 30px; }
.success-msg {
    background: rgba(0,229,160,0.15); border: 1px solid rgba(0,229,160,0.3);
    padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; color: #00e5a0;
}
@media(max-width: 768px) {
    .dashboard { padding: 20px; }
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .main-grid { grid-template-columns: 1fr; }
    .actions-grid { grid-template-columns: 1fr; }
    .welcome-card { flex-direction: column; gap: 20px; }
}
</style>

<div class="dashboard">

    @if(session('success'))
        <div class="success-msg">{{ session('success') }}</div>
    @endif

    <div class="welcome-card">
        <div class="welcome-left">
            <h1>Bienvenue, <span>{{ explode(' ', Auth::user()->name)[0] }}</span> ! 👋</h1>
            <p>La science biologique à votre service – Guérissez, apprenez, partagez.</p>
            <p style="margin-top:8px; font-size:13px; color:rgba(255,255,255,0.5);">
                Membre depuis {{ Auth::user()->created_at->format('d/m/Y') }}
            </p>
        </div>
        <div class="grade-display">
            <div class="grade-emoji">{{ Auth::user()->nom_grade['emoji'] }}</div>
            <div class="grade-nom">{{ Auth::user()->nom_grade['nom'] }}</div>
            <div class="grade-niveau">Niveau {{ Auth::user()->grade_id }} / 5</div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ (Auth::user()->grade_id / 5) * 100 }}%"></div>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ Auth::user()->publications_validees }}</div>
            <div class="stat-label">📝 Publications</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ Auth::user()->points }}</div>
            <div class="stat-label">⭐ Points</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ Auth::user()->grade_id }}</div>
            <div class="stat-label">🎓 Niveau actuel</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ Auth::user()->is_premium ? '✅' : '🔓' }}</div>
            <div class="stat-label">{{ Auth::user()->is_premium ? 'Premium' : 'Compte gratuit' }}</div>
        </div>
    </div>

    <div class="main-grid">
        <div>
            <div class="section-title">⚡ Actions rapides</div>
            <div class="actions-grid">
                <a href="/recherche" class="action-card">
                    <div class="action-icon">🔬</div>
                    <div class="action-title">Rechercher un remède</div>
                    <div class="action-desc">Trouvez le soin naturel adapté</div>
                </a>
                <a href="/remedes/create" class="action-card">
                    <div class="action-icon">🌿</div>
                    <div class="action-title">Publier un remède</div>
                    <div class="action-desc">Partagez vos connaissances</div>
                </a>
                <a href="/recherche" class="action-card">
                    <div class="action-icon">🦠</div>
                    <div class="action-title">Explorer les pathologies</div>
                    <div class="action-desc">{{ \App\Models\Pathologie::count() }} pathologies disponibles</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">👥</div>
                    <div class="action-title">Communauté</div>
                    <div class="action-desc">{{ \App\Models\User::count() }} membres actifs</div>
                </a>
                <a href="/jobs" class="action-card">
                    <div class="action-icon">💼</div>
                    <div class="action-title">Offres d'emploi</div>
                    <div class="action-desc">Biologie & Santé naturelle</div>
                </a>
                <a href="/ia" class="action-card">
                    <div class="action-icon">🤖</div>
                    <div class="action-title">Assistant IA</div>
                    <div class="action-desc">Posez vos questions santé</div>
                </a>
            </div>
        </div>

        <div>
            <div class="section-title">🎓 Système de grades</div>
            <div class="grades-card">
                @php
                    $grades = [
                        1 => ['emoji' => '🌱', 'nom' => 'Débutant', 'req' => 'Compte créé', 'bg' => 'rgba(170,170,170,0.2)'],
                        2 => ['emoji' => '🌿', 'nom' => 'Contributeur', 'req' => '10 publications', 'bg' => 'rgba(0,229,160,0.2)'],
                        3 => ['emoji' => '🔬', 'nom' => 'Chercheur Actif', 'req' => '30 publications', 'bg' => 'rgba(55,138,221,0.2)'],
                        4 => ['emoji' => '⭐', 'nom' => 'Expert', 'req' => '60 publications', 'bg' => 'rgba(255,215,0,0.2)'],
                        5 => ['emoji' => '🏆', 'nom' => 'Leader Scientifique', 'req' => 'Reconnu par Admin', 'bg' => 'rgba(255,107,53,0.2)'],
                    ];
                @endphp
                @foreach($grades as $niveau => $grade)
                <div class="grade-item">
                    <div class="grade-badge-small" style="background: {{ $grade['bg'] }}">
                        {{ $grade['emoji'] }}
                    </div>
                    <div style="flex:1">
                        <div class="grade-info-name">{{ $grade['nom'] }}</div>
                        <div class="grade-info-req">{{ $grade['req'] }}</div>
                    </div>
                    @if(Auth::user()->grade_id == $niveau)
                        <span class="grade-actuel">← Vous</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
</body>
</html>