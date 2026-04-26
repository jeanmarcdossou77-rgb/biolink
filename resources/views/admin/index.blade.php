<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Administration</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; min-height: 100vh; }
        nav {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 40px; background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .logo { font-size: 24px; font-weight: 700; color: #00e5a0; }
        .logo span { color: white; }
        .admin-badge {
            background: rgba(255,165,0,0.2); color: #ffa500;
            padding: 4px 12px; border-radius: 20px; font-size: 12px; margin-left: 10px;
        }
        .container { padding: 30px 40px; }
        h1 { font-size: 28px; font-weight: 800; margin-bottom: 30px; }
        .stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; margin-bottom: 40px; }
        .stat-card {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; padding: 20px; text-align: center;
        }
        .stat-number { font-size: 36px; font-weight: 800; color: #00e5a0; }
        .stat-label { font-size: 12px; color: rgba(255,255,255,0.6); margin-top: 6px; }
        .stat-card.alert { border-color: rgba(255,80,80,0.4); }
        .stat-card.alert .stat-number { color: #ff5050; }
        .section { margin-bottom: 40px; }
        .section h2 { font-size: 20px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert-badge { background: #ff5050; color: white; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
        .item-card {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px; padding: 20px; margin-bottom: 12px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .item-info h3 { font-size: 16px; font-weight: 600; margin-bottom: 4px; }
        .item-info p { font-size: 13px; color: rgba(255,255,255,0.6); }
        .item-actions { display: flex; gap: 10px; }
        .btn-approve {
            background: rgba(0,229,160,0.2); border: 1px solid #00e5a0;
            color: #00e5a0; padding: 8px 16px; border-radius: 8px;
            cursor: pointer; font-size: 13px; font-weight: 600;
        }
        .btn-reject {
            background: rgba(255,80,80,0.2); border: 1px solid #ff5050;
            color: #ff5050; padding: 8px 16px; border-radius: 8px;
            cursor: pointer; font-size: 13px; font-weight: 600;
        }
        .success-msg {
            background: rgba(0,229,160,0.15); border: 1px solid rgba(0,229,160,0.3);
            padding: 12px 20px; border-radius: 10px; margin-bottom: 20px;
            color: #00e5a0; font-size: 14px;
        }
        .users-table { width: 100%; border-collapse: collapse; }
        .users-table th { text-align: left; padding: 12px; font-size: 13px; color: rgba(255,255,255,0.5); border-bottom: 1px solid rgba(255,255,255,0.1); }
        .users-table td { padding: 12px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .grade-badge { background: rgba(0,229,160,0.15); color: #00e5a0; padding: 2px 10px; border-radius: 10px; font-size: 12px; }
        .empty { text-align: center; padding: 30px; color: rgba(255,255,255,0.4); font-size: 14px; }
        form { display: inline; }
    </style>
</head>
<body>
<nav>
    <div>
        <span class="logo">Bio<span>Link</span></span>
        <span class="admin-badge">👑 Administration</span>
    </div>
    <div style="display:flex; gap:16px; align-items:center;">
        <a href="/dashboard" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px;">← Dashboard</a>
        <a href="/recherche" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px;">🔬 Recherche</a>
    </div>
</nav>

<div class="container">
    <h1>👑 Tableau de bord Administrateur</h1>

    @if(session('success'))
        <div class="success-msg">{{ session('success') }}</div>
    @endif

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $stats['users'] }}</div>
            <div class="stat-label">👥 Utilisateurs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['pathologies'] }}</div>
            <div class="stat-label">🦠 Pathologies</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['remedes'] }}</div>
            <div class="stat-label">🌿 Remèdes</div>
        </div>
        <div class="stat-card alert">
            <div class="stat-number">{{ $stats['remedes_en_attente'] }}</div>
            <div class="stat-label">⏳ Remèdes en attente</div>
        </div>
        <div class="stat-card alert">
            <div class="stat-number">{{ $stats['pathologies_en_attente'] }}</div>
            <div class="stat-label">⏳ Pathologies en attente</div>
        </div>
    </div>

    <!-- Graphiques -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:24px;">

    <!-- Membres par jour -->
    <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:20px;">
        <div style="font-size:15px;font-weight:700;margin-bottom:16px;">📈 Nouveaux membres (7 derniers jours)</div>
        <canvas id="membresChart" height="150"></canvas>
    </div>

    <!-- Pathologies les plus consultées -->
    <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:20px;">
        <div style="font-size:15px;font-weight:700;margin-bottom:16px;">🔥 Top 5 pathologies consultées</div>
        @php
            $topPathologies = \App\Models\Pathologie::where('approuve', true)
                ->orderBy('vues', 'desc')->take(5)->get();
            $maxVues = $topPathologies->max('vues') ?: 1;
        @endphp
        @foreach($topPathologies as $p)
        <div style="margin-bottom:10px;">
            <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:3px;">
                <span>{{ Str::limit($p->nom, 30) }}</span>
                <span style="color:#00e5a0;">{{ $p->vues }} vues</span>
            </div>
            <div style="background:rgba(255,255,255,0.08);border-radius:6px;height:8px;">
                <div style="width:{{ ($p->vues / $maxVues) * 100 }}%;height:100%;background:linear-gradient(90deg,#00e5a0,#378ADD);border-radius:6px;"></div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Publications par semaine -->
    <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:20px;">
        <div style="font-size:15px;font-weight:700;margin-bottom:16px;">📝 Publications (7 derniers jours)</div>
        <canvas id="postsChart" height="150"></canvas>
    </div>

    <!-- Répartition grades -->
    <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:20px;">
        <div style="font-size:15px;font-weight:700;margin-bottom:16px;">🎓 Répartition des grades</div>
        @php
            $gradesStats = \App\Models\User::selectRaw('grade_id, count(*) as total')
                ->groupBy('grade_id')->orderBy('grade_id')->get();
            $gradeNames = ['','🌱 Débutant','🌿 Contributeur','🔬 Chercheur','⭐ Expert','🏆 Leader'];
            $gradeColors = ['','rgba(170,170,170,0.6)','rgba(0,229,160,0.6)','rgba(55,138,221,0.6)','rgba(255,215,0,0.6)','rgba(255,107,53,0.6)'];
        @endphp
        @foreach($gradesStats as $g)
        @php $pct = \App\Models\User::count() > 0 ? round(($g->total / \App\Models\User::count()) * 100) : 0; @endphp
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
            <div style="width:120px;font-size:12px;color:rgba(255,255,255,0.7);">{{ $gradeNames[$g->grade_id] ?? 'Grade '.$g->grade_id }}</div>
            <div style="flex:1;background:rgba(255,255,255,0.08);border-radius:6px;height:8px;">
                <div style="width:{{ $pct }}%;height:100%;background:{{ $gradeColors[$g->grade_id] ?? '#00e5a0' }};border-radius:6px;"></div>
            </div>
            <div style="width:40px;font-size:12px;color:#00e5a0;text-align:right;">{{ $g->total }}</div>
        </div>
        @endforeach
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script>
// Données membres par jour
@php
$membresParJour = collect(range(6, 0))->map(function($i) {
    return [
        'date' => now()->subDays($i)->format('d/m'),
        'count' => \App\Models\User::whereDate('created_at', now()->subDays($i))->count()
    ];
});
$postsParJour = collect(range(6, 0))->map(function($i) {
    return [
        'date' => now()->subDays($i)->format('d/m'),
        'count' => \App\Models\Post::whereDate('created_at', now()->subDays($i))->count()
    ];
});
@endphp

const chartOptions = {
    responsive: true,
    plugins: { legend: { display: false } },
    scales: {
        y: { grid: { color: 'rgba(255,255,255,0.07)' }, ticks: { color: 'rgba(255,255,255,0.5)', stepSize: 1 } },
        x: { grid: { display: false }, ticks: { color: 'rgba(255,255,255,0.5)' } }
    }
};

new Chart(document.getElementById('membresChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($membresParJour->pluck('date')) !!},
        datasets: [{
            data: {!! json_encode($membresParJour->pluck('count')) !!},
            backgroundColor: 'rgba(0,229,160,0.5)',
            borderColor: '#00e5a0',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: chartOptions
});

new Chart(document.getElementById('postsChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($postsParJour->pluck('date')) !!},
        datasets: [{
            data: {!! json_encode($postsParJour->pluck('count')) !!},
            borderColor: '#378ADD',
            backgroundColor: 'rgba(55,138,221,0.15)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#378ADD',
        }]
    },
    options: chartOptions
});
</script>

    <!-- Remèdes en attente -->
    <div class="section">
        <h2>
            🌿 Remèdes en attente de validation
            @if($stats['remedes_en_attente'] > 0)
                <span class="alert-badge">{{ $stats['remedes_en_attente'] }}</span>
            @endif
        </h2>

        @if($remedes_en_attente->count() > 0)
            @foreach($remedes_en_attente as $remede)
            <div class="item-card">
                <div class="item-info">
                    <h3>🌿 {{ $remede->titre }}</h3>
                    <p>Par {{ $remede->user->name }} — Pour : {{ $remede->pathologie->nom ?? 'N/A' }}</p>
                    <p style="margin-top:4px;">{{ Str::limit($remede->description, 120) }}</p>
                </div>
                <div class="item-actions">
                    <form method="POST" action="/admin/remedes/{{ $remede->id }}/approuver">
                        @csrf
                        <button type="submit" class="btn-approve">✅ Approuver</button>
                    </form>
                    <form method="POST" action="/admin/remedes/{{ $remede->id }}/rejeter">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-reject">❌ Rejeter</button>
                    </form>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty">✅ Aucun remède en attente de validation !</div>
        @endif
    </div>

    <!-- Pathologies en attente -->
    <div class="section">
        <h2>
            🦠 Pathologies en attente
            @if($stats['pathologies_en_attente'] > 0)
                <span class="alert-badge">{{ $stats['pathologies_en_attente'] }}</span>
            @endif
        </h2>

        @if($pathologies_en_attente->count() > 0)
            @foreach($pathologies_en_attente as $pathologie)
            <div class="item-card">
                <div class="item-info">
                    <h3>🦠 {{ $pathologie->nom }}</h3>
                    <p>Par {{ $pathologie->user->name }} — Catégorie : {{ $pathologie->categorie }}</p>
                </div>
                <div class="item-actions">
                    <form method="POST" action="/admin/pathologies/{{ $pathologie->id }}/approuver">
                        @csrf
                        <button type="submit" class="btn-approve">✅ Approuver</button>
                    </form>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty">✅ Aucune pathologie en attente !</div>
        @endif
    </div>

    <!-- Derniers utilisateurs -->
    <div class="section">
        <h2>👥 Derniers membres inscrits</h2>
        <table class="users-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Points</th>
                    <th>Grade</th>
                    <th>Inscrit le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($derniers_users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>⭐ {{ $user->points }}</td>
                    <td><span class="grade-badge">Niveau {{ $user->grade_id }}</span></td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
@if(Auth::id() === 1)
    @if(!$user->is_admin)
    <form method="POST" action="/admin/users/{{ $user->id }}/make-admin">
        @csrf
        <button type="submit" class="btn-approve" style="font-size:11px;padding:4px 10px;">👑 Rendre Admin</button>
    </form>
    @elseif($user->id !== 1)
    <form method="POST" action="/admin/users/{{ $user->id }}/remove-admin">
        @csrf
        <button type="submit" class="btn-reject" style="font-size:11px;padding:4px 10px;">❌ Retirer Admin</button>
    </form>
    @else
        <span style="color:#ffa500;font-size:12px;">👑 Fondateur</span>
    @endif
@else
    @if($user->is_admin)
        <span style="color:#ffa500;font-size:12px;">👑 Admin</span>
    @endif
@endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>