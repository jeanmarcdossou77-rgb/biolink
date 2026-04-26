<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    @include('components.head')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Recherche de pathologies</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0a1628;
            color: white;
            min-height: 100vh;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 60px;
            background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .logo {
            font-size: 28px;
            font-weight: 700;
            color: #00e5a0;
            letter-spacing: 2px;
            text-decoration: none;
        }
        .logo span { color: white; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 14px;
        }
        .nav-links a:hover { color: #00e5a0; }
        .btn-nav {
            background: #00e5a0;
            color: #0a1628 !important;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600 !important;
        }
        .hero {
            text-align: center;
            padding: 60px 20px 40px;
        }
        .hero h1 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 16px;
        }
        .hero h1 span { color: #00e5a0; }
        .hero p {
            color: rgba(255,255,255,0.6);
            font-size: 16px;
            margin-bottom: 40px;
        }
        .search-box {
            max-width: 700px;
            margin: 0 auto;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 20px;
            padding: 30px;
        }
        .search-row {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }
        .search-input {
            flex: 1;
            padding: 14px 20px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px;
            color: white;
            font-size: 15px;
            outline: none;
        }
        .search-input:focus {
            border-color: #00e5a0;
        }
        .search-input::placeholder {
            color: rgba(255,255,255,0.4);
        }
        .search-select {
            padding: 14px 20px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px;
            color: white;
            font-size: 15px;
            outline: none;
            min-width: 180px;
        }
        .search-btn {
            width: 100%;
            padding: 14px;
            background: #00e5a0;
            color: #0a1628;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .search-btn:hover { transform: translateY(-2px); }
        .content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 50px 40px;
        }
        .section-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        .pathologie-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 24px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: white;
            display: block;
        }
        .pathologie-card:hover {
            border-color: #00e5a0;
            transform: translateY(-4px);
            background: rgba(0,229,160,0.07);
        }
        .card-categorie {
            display: inline-block;
            background: rgba(0,229,160,0.15);
            color: #00e5a0;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-bottom: 12px;
        }
        .card-nom {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .card-description {
            font-size: 13px;
            color: rgba(255,255,255,0.6);
            line-height: 1.6;
            margin-bottom: 16px;
        }
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: rgba(255,255,255,0.4);
        }
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: rgba(255,255,255,0.4);
        }
        .empty-state .icon { font-size: 64px; margin-bottom: 20px; }
        .empty-state h3 { font-size: 22px; margin-bottom: 10px; color: rgba(255,255,255,0.7); }
        .result-count {
            background: rgba(0,229,160,0.15);
            border: 1px solid rgba(0,229,160,0.3);
            border-radius: 12px;
            padding: 16px 24px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .result-count span { color: #00e5a0; font-weight: 700; font-size: 18px; }

        select {
    background: #0d1f35 !important;
    color: white !important;
    border: 1px solid rgba(255,255,255,0.2);
    padding: 10px 16px;
    border-radius: 10px;
    font-size: 14px;
    outline: none;
    appearance: none;
    -webkit-appearance: none;
    cursor: pointer;
}
select option {
    background: #0d1f35 !important;
    color: white !important;
}
    </style>
</head>
<body>

<nav>
    <a href="/" class="logo">Bio<span>Link</span></a>
    <div class="nav-links">
        <a href="/recherche">🔬 Pathologies</a>
        <a href="#">📝 Publier</a>
        <a href="#">👥 Communauté</a>
        @auth
            <a href="/dashboard" class="btn-nav">Mon espace</a>
        @else
            <a href="/register" class="btn-nav">Rejoindre</a>
        @endauth
    </div>
</nav>

<section class="hero">
    <h1>Recherchez votre <span>pathologie</span></h1>
    <p>Trouvez instantanément les remèdes naturels adaptés à votre situation</p>

    <div class="search-box">
<form method="GET" action="/recherche" id="searchForm">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
        <div>
            <label style="font-size:12px;color:rgba(255,255,255,0.6);margin-bottom:6px;display:block;">🔍 Recherche</label>
            <input type="text" name="query" value="{{ request('query') }}"
                placeholder="Ex: diabète, paludisme, fièvre..."
                style="width:100%;padding:12px 16px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.15);border-radius:12px;color:white;font-size:14px;outline:none;">
        </div>
        <div>
            <label style="font-size:12px;color:rgba(255,255,255,0.6);margin-bottom:6px;display:block;">📂 Catégorie</label>
            <select name="categorie" style="width:100%;padding:12px 16px;background:#0d1f35;border:1px solid rgba(255,255,255,0.15);border-radius:12px;color:white;font-size:14px;outline:none;">
                <option value="">Toutes catégories</option>
                @foreach(\App\Models\Pathologie::distinct()->pluck('categorie')->sort() as $cat)
                    <option value="{{ $cat }}" {{ request('categorie')==$cat?'selected':'' }} style="background:#0a1628;color:white;">{{ $cat }}</option>
                @endforeach
                <option value="autre">✏️ Autre...</option>
            </select>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:12px;">
        <div>
            <label style="font-size:12px;color:rgba(255,255,255,0.6);margin-bottom:6px;display:block;">⚠️ Gravité</label>
            <select name="gravite" style="width:100%;padding:10px 14px;background:#0d1f35;border:1px solid rgba(255,255,255,0.15);border-radius:12px;color:white;font-size:13px;outline:none;">
                <option value="">Toutes</option>
                <option value="legere" {{ request('gravite')=='legere'?'selected':'' }} style="background:#0a1628;">🟢 Légère</option>
                <option value="moderee" {{ request('gravite')=='moderee'?'selected':'' }} style="background:#0a1628;">🟡 Modérée</option>
                <option value="grave" {{ request('gravite')=='grave'?'selected':'' }} style="background:#0a1628;">🔴 Grave</option>
                <option value="critique" {{ request('gravite')=='critique'?'selected':'' }} style="background:#0a1628;">⚫ Critique</option>
            </select>
        </div>
        <div>
            <label style="font-size:12px;color:rgba(255,255,255,0.6);margin-bottom:6px;display:block;">🌿 Type traitement</label>
            <select name="type_traitement" style="width:100%;padding:10px 14px;background:#0d1f35;border:1px solid rgba(255,255,255,0.15);border-radius:12px;color:white;font-size:13px;outline:none;">
                <option value="">Tous types</option>
                <option value="phytotherapie" style="background:#0a1628;">🌺 Phytothérapie</option>
                <option value="aromatherapie" style="background:#0a1628;">🌸 Aromathérapie</option>
                <option value="alimentation" style="background:#0a1628;">🥗 Alimentation</option>
                <option value="naturel" style="background:#0a1628;">🍃 Naturel</option>
                <option value="traditionnel" style="background:#0a1628;">🏺 Traditionnel</option>
            </select>
        </div>
        <div>
            <label style="font-size:12px;color:rgba(255,255,255,0.6);margin-bottom:6px;display:block;">🔗 Contagieux</label>
            <select name="contagieux" style="width:100%;padding:10px 14px;background:#0d1f35;border:1px solid rgba(255,255,255,0.15);border-radius:12px;color:white;font-size:13px;outline:none;">
                <option value="">Tous</option>
                <option value="1" style="background:#0a1628;">⚠️ Contagieux</option>
                <option value="0" style="background:#0a1628;">✅ Non contagieux</option>
            </select>
        </div>
    </div>

    <!-- Pathologie libre -->
    <div id="autreDiv" style="display:{{ request('categorie')=='autre'?'block':'none' }};margin-bottom:12px;">
        <input type="text" name="query_libre" value="{{ request('query_libre') }}"
            placeholder="Tapez le nom de la pathologie..."
            style="width:100%;padding:12px 16px;background:rgba(0,229,160,0.1);border:1px solid rgba(0,229,160,0.3);border-radius:12px;color:white;font-size:14px;outline:none;">
    </div>

    <div style="display:flex;gap:10px;">
        <button type="submit"
            style="flex:1;padding:13px;background:#00e5a0;color:#0a1628;border:none;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;">
            🔬 Rechercher un remède naturel
        </button>
        <a href="/recherche"
            style="padding:13px 18px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.2);border-radius:12px;color:rgba(255,255,255,0.7);text-decoration:none;font-size:14px;display:flex;align-items:center;">
            ✕
        </a>
    </div>
</form>

<script>
document.querySelector('select[name="categorie"]').addEventListener('change', function() {
    document.getElementById('autreDiv').style.display = this.value === 'autre' ? 'block' : 'none';
});
</script>
    </div>
</section>

<!-- Résultats -->
<div style="max-width:1100px;margin:30px auto;padding:0 20px;">

    @if($pathologies->count() > 0)
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h2 style="font-size:20px;font-weight:700;">
                🔬 {{ $pathologies->total() }} pathologie{{ $pathologies->total()>1?'s':'' }} trouvée{{ $pathologies->total()>1?'s':'' }}
            </h2>
            <span style="font-size:13px;color:rgba(255,255,255,0.5);">Page {{ $pathologies->currentPage() }} / {{ $pathologies->lastPage() }}</span>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:16px;margin-bottom:30px;">
            @foreach($pathologies as $pathologie)
            <a href="/pathologies/{{ $pathologie->id }}" style="text-decoration:none;">
                <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:20px;transition:all 0.3s;height:100%;" onmouseover="this.style.borderColor='#00e5a0';this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.1)';this.style.transform='translateY(0)'">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
                        <span style="background:rgba(0,229,160,0.15);color:#00e5a0;padding:3px 10px;border-radius:10px;font-size:11px;font-weight:600;">{{ $pathologie->categorie }}</span>
                        @if($pathologie->gravite)
                        <span style="font-size:11px;color:rgba(255,255,255,0.4);">
                            @if($pathologie->gravite=='legere')🟢@elseif($pathologie->gravite=='moderee')🟡@elseif($pathologie->gravite=='grave')🔴@else⚫@endif
                            {{ ucfirst($pathologie->gravite) }}
                        </span>
                        @endif
                    </div>
                    <h3 style="font-size:16px;font-weight:700;color:white;margin-bottom:8px;">{{ $pathologie->nom }}</h3>
                    @if($pathologie->description)
                    <p style="font-size:13px;color:rgba(255,255,255,0.6);line-height:1.6;margin-bottom:10px;">{{ Str::limit($pathologie->description, 100) }}</p>
                    @endif
                    @if($pathologie->symptomes)
                    <p style="font-size:12px;color:rgba(255,255,255,0.4);">🩺 {{ Str::limit($pathologie->symptomes, 80) }}</p>
                    @endif
                    <div style="margin-top:12px;display:flex;gap:10px;align-items:center;">
                        @if($pathologie->contagieux)
                        <span style="font-size:11px;background:rgba(255,80,80,0.15);color:#ff8080;padding:2px 8px;border-radius:8px;">⚠️ Contagieux</span>
                        @endif
                        <span style="font-size:11px;color:rgba(255,255,255,0.3);margin-left:auto;">👁️ {{ $pathologie->vues ?? 0 }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div style="display:flex;justify-content:center;">
            @if($pathologies->hasPages())
<div style="display:flex;justify-content:center;align-items:center;gap:6px;padding:20px 0;flex-wrap:wrap;">

    {{-- Précédent --}}
    @if($pathologies->onFirstPage())
        <span style="padding:8px 16px;border-radius:10px;background:rgba(255,255,255,0.04);color:rgba(255,255,255,0.25);font-size:13px;cursor:not-allowed;">← Précédent</span>
    @else
        <a href="{{ $pathologies->previousPageUrl() }}"
            style="padding:8px 16px;border-radius:10px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.15);color:rgba(255,255,255,0.8);font-size:13px;text-decoration:none;transition:all 0.2s;"
            onmouseover="this.style.borderColor='#00e5a0';this.style.color='#00e5a0'"
            onmouseout="this.style.borderColor='rgba(255,255,255,0.15)';this.style.color='rgba(255,255,255,0.8)'">
            ← Précédent
        </a>
    @endif

    {{-- Pages --}}
    @php
        $current = $pathologies->currentPage();
        $last = $pathologies->lastPage();
        $start = max(1, $current - 2);
        $end = min($last, $current + 2);
    @endphp

    @if($start > 1)
        <a href="{{ $pathologies->url(1) }}"
            style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.15);color:rgba(255,255,255,0.8);font-size:13px;text-decoration:none;"
            onmouseover="this.style.borderColor='#00e5a0';this.style.color='#00e5a0'"
            onmouseout="this.style.borderColor='rgba(255,255,255,0.15)';this.style.color='rgba(255,255,255,0.8)'">1</a>
        @if($start > 2)
            <span style="color:rgba(255,255,255,0.4);padding:0 4px;">···</span>
        @endif
    @endif

    @for($i = $start; $i <= $end; $i++)
        @if($i == $current)
            <span style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:#00e5a0;color:#0a1628;font-size:13px;font-weight:700;">{{ $i }}</span>
        @else
            <a href="{{ $pathologies->url($i) }}"
                style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.15);color:rgba(255,255,255,0.8);font-size:13px;text-decoration:none;"
                onmouseover="this.style.background='rgba(0,229,160,0.15)';this.style.borderColor='#00e5a0';this.style.color='#00e5a0'"
                onmouseout="this.style.background='rgba(255,255,255,0.07)';this.style.borderColor='rgba(255,255,255,0.15)';this.style.color='rgba(255,255,255,0.8)'">{{ $i }}</a>
        @endif
    @endfor

    @if($end < $last)
        @if($end < $last - 1)
            <span style="color:rgba(255,255,255,0.4);padding:0 4px;">···</span>
        @endif
        <a href="{{ $pathologies->url($last) }}"
            style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.15);color:rgba(255,255,255,0.8);font-size:13px;text-decoration:none;"
            onmouseover="this.style.borderColor='#00e5a0';this.style.color='#00e5a0'"
            onmouseout="this.style.borderColor='rgba(255,255,255,0.15)';this.style.color='rgba(255,255,255,0.8)'">{{ $last }}</a>
    @endif

    {{-- Suivant --}}
    @if($pathologies->hasMorePages())
        <a href="{{ $pathologies->nextPageUrl() }}"
            style="padding:8px 16px;border-radius:10px;background:rgba(0,229,160,0.15);border:1px solid rgba(0,229,160,0.4);color:#00e5a0;font-size:13px;text-decoration:none;font-weight:600;transition:all 0.2s;"
            onmouseover="this.style.background='rgba(0,229,160,0.25)'"
            onmouseout="this.style.background='rgba(0,229,160,0.15)'">
            Suivant →
        </a>
    @else
        <span style="padding:8px 16px;border-radius:10px;background:rgba(255,255,255,0.04);color:rgba(255,255,255,0.25);font-size:13px;cursor:not-allowed;">Suivant →</span>
    @endif

    {{-- Info total --}}
    <div style="width:100%;text-align:center;margin-top:8px;font-size:12px;color:rgba(255,255,255,0.4);">
        Page {{ $current }} sur {{ $last }} · {{ $pathologies->total() }} pathologies au total
    </div>
</div>
@endif
        </div>

    @elseif(request()->hasAny(['query','categorie','gravite','contagieux']))
        <div style="text-align:center;padding:60px 20px;">
            <div style="font-size:56px;margin-bottom:16px;">🔍</div>
            <h3 style="font-size:20px;color:rgba(255,255,255,0.7);margin-bottom:10px;">Aucun résultat trouvé</h3>
            <p style="color:rgba(255,255,255,0.5);margin-bottom:20px;">Essayez avec d'autres mots-clés ou catégories</p>
            <a href="/recherche" style="background:#00e5a0;color:#0a1628;padding:10px 24px;border-radius:20px;text-decoration:none;font-weight:700;">Réinitialiser la recherche</a>
        </div>

    @else
        <!-- Affichage par défaut — toutes les pathologies récentes -->
        <h2 style="font-size:20px;font-weight:700;margin-bottom:20px;">🌟 Pathologies récentes</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:16px;margin-bottom:30px;">
            @foreach($recentes as $pathologie)
            <a href="/pathologies/{{ $pathologie->id }}" style="text-decoration:none;">
                <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:20px;transition:all 0.3s;" onmouseover="this.style.borderColor='#00e5a0'" onmouseout="this.style.borderColor='rgba(255,255,255,0.1)'">
                    <span style="background:rgba(0,229,160,0.15);color:#00e5a0;padding:3px 10px;border-radius:10px;font-size:11px;font-weight:600;">{{ $pathologie->categorie }}</span>
                    <h3 style="font-size:16px;font-weight:700;color:white;margin:10px 0 8px;">{{ $pathologie->nom }}</h3>
                    <p style="font-size:13px;color:rgba(255,255,255,0.6);line-height:1.6;">{{ Str::limit($pathologie->description, 100) }}</p>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Toutes les pathologies paginées -->
        <h2 style="font-size:20px;font-weight:700;margin-bottom:20px;">📋 Toutes les pathologies ({{ \App\Models\Pathologie::where('approuve',true)->count() }})</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:16px;">
            @foreach(\App\Models\Pathologie::where('approuve',true)->orderBy('nom')->take(24)->get() as $p)
            <a href="/pathologies/{{ $p->id }}" style="text-decoration:none;">
                <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:14px;padding:16px;transition:all 0.3s;" onmouseover="this.style.borderColor='#00e5a0'" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)'">
                    <span style="background:rgba(55,138,221,0.15);color:#378ADD;padding:2px 8px;border-radius:8px;font-size:10px;">{{ $p->categorie }}</span>
                    <h3 style="font-size:14px;font-weight:700;color:white;margin:8px 0 4px;">{{ $p->nom }}</h3>
                    <p style="font-size:12px;color:rgba(255,255,255,0.5);">{{ Str::limit($p->description, 70) }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:24px;">
            <a href="/recherche?query=a" style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.2);color:white;padding:10px 24px;border-radius:20px;text-decoration:none;font-size:14px;">Voir toutes les pathologies →</a>
        </div>
    @endif
</div>

</body>
</html>