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

<div class="content">
    @isset($pathologies)
        @if(isset($query) || isset($categorie))
            <div class="result-count">
                🔬 <span>{{ $pathologies->count() }}</span> pathologie(s) trouvée(s)
                @if(isset($query)) pour "<strong>{{ $query }}</strong>" @endif
            </div>
        @else
            <div class="section-title">🌟 Pathologies récentes</div>
        @endif

        @if($pathologies->count() > 0)
            <div class="results-grid">
                @foreach($pathologies as $pathologie)
                    <a href="/pathologies/{{ $pathologie->id }}" class="pathologie-card">
                        <div class="card-categorie">{{ $pathologie->categorie }}</div>
                        <div class="card-nom">{{ $pathologie->nom }}</div>
                        <div class="card-description">
                            {{ Str::limit($pathologie->description, 100) }}
                        </div>
                        <div class="card-footer">
                            <span>{{ $pathologie->remedes->count() }} remède(s)</span>
                            <span>✅ Validé</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="icon">🔬</div>
                <h3>Aucune pathologie trouvée</h3>
                <p>Essayez avec d'autres mots clés ou soyez le premier à publier !</p>
            </div>
        @endif
    @else
        <div class="empty-state">
            <div class="icon">🧬</div>
            <h3>Aucune pathologie encore publiée</h3>
            <p>Soyez le premier contributeur de BioLink !</p>
        </div>
    @endisset
</div>

</body>
</html>