<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Groupes</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',sans-serif; background:var(--bg, #0a1628); color:var(--text, white); min-height:100vh; }
        .container { max-width:1100px; margin:0 auto; padding:24px 20px; }
        .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
        h1 { font-size:26px; font-weight:800; }
        .btn-create { background:#00e5a0; color:#0a1628; padding:10px 22px; border-radius:20px; font-weight:700; text-decoration:none; font-size:14px; transition:transform 0.2s; }
        .btn-create:hover { transform:translateY(-2px); }
        /* Barre de recherche */
        .search-bar { display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap; }
        .search-input { flex:1; min-width:200px; padding:11px 16px; background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.15); border-radius:12px; color:white; font-size:14px; outline:none; transition:border-color 0.3s; }
        .search-input:focus { border-color:#00e5a0; }
        .search-input::placeholder { color:rgba(255,255,255,0.4); }
        .filter-select { padding:11px 16px; background:#0d1f35; border:1px solid rgba(255,255,255,0.15); border-radius:12px; color:white; font-size:14px; outline:none; cursor:pointer; }
        .filter-select option { background:#0a1628; }
        .btn-search { background:#00e5a0; color:#0a1628; border:none; padding:11px 20px; border-radius:12px; font-weight:700; cursor:pointer; font-size:14px; }
        /* Catégories rapides */
        .cats { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px; }
        .cat-btn { padding:6px 14px; border-radius:20px; font-size:12px; cursor:pointer; border:1px solid rgba(255,255,255,0.15); background:rgba(255,255,255,0.05); color:rgba(255,255,255,0.7); transition:all 0.2s; text-decoration:none; }
        .cat-btn:hover, .cat-btn.active { background:rgba(0,229,160,0.15); border-color:#00e5a0; color:#00e5a0; }
        /* Grille groupes */
        .groups-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:16px; }
        .group-card { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:16px; overflow:hidden; transition:all 0.3s; text-decoration:none; color:white; display:block; }
        .group-card:hover { border-color:#00e5a0; transform:translateY(-4px); box-shadow:0 8px 24px rgba(0,229,160,0.15); }
        .group-cover { height:90px; display:flex; align-items:center; justify-content:center; font-size:36px; }
        .group-body { padding:14px 16px; }
        .group-name { font-size:15px; font-weight:700; margin-bottom:5px; }
        .group-desc { font-size:12px; color:rgba(255,255,255,0.55); line-height:1.5; margin-bottom:10px; }
        .group-footer { display:flex; justify-content:space-between; align-items:center; }
        .group-meta { font-size:11px; color:rgba(255,255,255,0.4); }
        .group-cat { background:rgba(0,229,160,0.12); color:#00e5a0; padding:2px 9px; border-radius:8px; font-size:10px; font-weight:600; }
        .btn-join { padding:6px 14px; background:rgba(0,229,160,0.15); border:1px solid rgba(0,229,160,0.4); color:#00e5a0; border-radius:10px; font-size:12px; font-weight:600; text-decoration:none; display:inline-block; margin-top:10px; width:100%; text-align:center; transition:all 0.2s; }
        .btn-join:hover { background:rgba(0,229,160,0.25); }
        .empty { text-align:center; padding:60px 20px; color:rgba(255,255,255,0.4); }
        .results-info { font-size:13px; color:rgba(255,255,255,0.5); margin-bottom:16px; }
        @media(max-width:600px) { .groups-grid { grid-template-columns:1fr; } .search-bar { flex-direction:column; } }
    </style>
</head>
<body>
@include('components.navbar')

<div class="container">
    <div class="page-header">
        <h1>👨‍👩‍👧 Groupes BioLink</h1>
        @auth
        <a href="/groups/create" class="btn-create">+ Créer un groupe</a>
        @endauth
    </div>

    <!-- Barre de recherche -->
    <form method="GET" action="/groups">
        <div class="search-bar">
            <input type="text" name="q" value="{{ request('q') }}"
                class="search-input" placeholder="🔍 Rechercher un groupe...">
            <select name="categorie" class="filter-select">
                <option value="">Toutes catégories</option>
                @foreach(['Santé','Phytothérapie','Biologie','Nutrition','Recherche','Maladies tropicales','Pédiatrie'] as $cat)
                <option value="{{ $cat }}" {{ request('categorie')==$cat?'selected':'' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <select name="visibilite" class="filter-select">
                <option value="">Tous</option>
                <option value="public" {{ request('visibilite')=='public'?'selected':'' }}>🌍 Publics</option>
                <option value="prive" {{ request('visibilite')=='prive'?'selected':'' }}>🔒 Privés</option>
            </select>
            <button type="submit" class="btn-search">Rechercher</button>
        </div>
    </form>

    <!-- Filtres rapides par catégorie -->
    <div class="cats">
        <a href="/groups" class="cat-btn {{ !request('categorie')?'active':'' }}">Tous</a>
        @foreach(['Santé','Phytothérapie','Biologie','Nutrition','Recherche','Maladies tropicales'] as $cat)
        <a href="/groups?categorie={{ $cat }}" class="cat-btn {{ request('categorie')==$cat?'active':'' }}">{{ $cat }}</a>
        @endforeach
    </div>

    @if($groups->count() > 0)
    <div class="results-info">{{ $groups->total() }} groupe(s) trouvé(s)</div>
    <div class="groups-grid">
        @foreach($groups as $group)
        <div class="group-card">
            <div class="group-cover" style="background:linear-gradient(135deg,rgba(0,229,160,0.2),rgba(55,138,221,0.2));">🌿</div>
            <div class="group-body">
                <div class="group-name">{{ $group->nom }}</div>
                <div class="group-desc">{{ Str::limit($group->description, 80) }}</div>
                <div class="group-footer">
                    <span class="group-meta">👥 {{ $group->membres_count }} membres</span>
                    <span class="group-cat">{{ $group->categorie }}</span>
                </div>
                <a href="/groups/{{ $group->id }}" class="btn-join">👁️ Voir le groupe</a>
            </div>
        </div>
        @endforeach
    </div>
    <div style="margin-top:24px;text-align:center;">{{ $groups->links() }}</div>
    @else
    <div class="empty">
        <div style="font-size:56px;margin-bottom:14px;">👨‍👩‍👧</div>
        <h3 style="color:rgba(255,255,255,0.7);margin-bottom:8px;">Aucun groupe trouvé</h3>
        <p style="margin-bottom:16px;">Essayez d'autres critères ou créez le premier groupe !</p>
        @auth
        <a href="/groups/create" style="background:#00e5a0;color:#0a1628;padding:10px 24px;border-radius:20px;text-decoration:none;font-weight:700;">+ Créer un groupe</a>
        @endauth
    </div>
    @endif
</div>
</body>
</html>