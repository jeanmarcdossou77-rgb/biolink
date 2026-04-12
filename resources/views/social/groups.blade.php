<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Groupes</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; min-height: 100vh; }
        .container { max-width: 1100px; margin: 0 auto; padding: 30px 20px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        h1 { font-size: 28px; font-weight: 800; }
        .btn-create { background: #00e5a0; color: #0a1628; padding: 12px 24px; border-radius: 25px; font-weight: 700; text-decoration: none; font-size: 14px; }
        .groups-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .group-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; overflow: hidden; transition: all 0.3s; }
        .group-card:hover { border-color: #00e5a0; transform: translateY(-4px); }
        .group-cover { height: 100px; background: linear-gradient(135deg, rgba(0,229,160,0.3), rgba(55,138,221,0.3)); display: flex; align-items: center; justify-content: center; font-size: 40px; }
        .group-body { padding: 16px; }
        .group-name { font-size: 16px; font-weight: 700; margin-bottom: 6px; }
        .group-desc { font-size: 13px; color: rgba(255,255,255,0.6); line-height: 1.5; margin-bottom: 12px; }
        .group-meta { display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: rgba(255,255,255,0.5); margin-bottom: 12px; }
        .group-cat { background: rgba(0,229,160,0.15); color: #00e5a0; padding: 3px 10px; border-radius: 10px; font-size: 11px; }
        .btn-join { width: 100%; padding: 10px; background: rgba(0,229,160,0.2); border: 1px solid #00e5a0; color: #00e5a0; border-radius: 10px; cursor: pointer; font-weight: 700; font-size: 14px; text-decoration: none; display: block; text-align: center; }
        .btn-view { width: 100%; padding: 10px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.2); color: white; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 14px; text-decoration: none; display: block; text-align: center; }
    </style>
</head>
<body>

@include('components.navbar')

<div class="container">
    <div class="page-header">
        <h1>👨‍👩‍👧 Groupes BioLink</h1>
        <a href="/groups/create" class="btn-create">+ Créer un groupe</a>
    </div>

    @if($groups->count() > 0)
        <div class="groups-grid">
            @foreach($groups as $group)
            <div class="group-card">
                <div class="group-cover">🌿</div>
                <div class="group-body">
                    <div class="group-name">{{ $group->nom }}</div>
                    <div class="group-desc">{{ Str::limit($group->description, 80) }}</div>
                    <div class="group-meta">
                        <span>👥 {{ $group->membres_count }} membres</span>
                        <span class="group-cat">{{ $group->categorie }}</span>
                    </div>
                    <a href="/groups/{{ $group->id }}" class="btn-view">👁️ Voir le groupe</a>
                </div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:30px; text-align:center;">{{ $groups->links() }}</div>
    @else
        <div style="text-align:center; padding:80px 20px; color:rgba(255,255,255,0.4);">
            <div style="font-size:64px; margin-bottom:16px;">👨‍👩‍👧</div>
            <h3 style="font-size:22px; color:rgba(255,255,255,0.7); margin-bottom:10px;">Aucun groupe disponible</h3>
            <p>Soyez le premier à créer un groupe sur BioLink !</p>
            <a href="/groups/create" style="display:inline-block; margin-top:20px; background:#00e5a0; color:#0a1628; padding:12px 28px; border-radius:25px; font-weight:700; text-decoration:none;">+ Créer le premier groupe</a>
        </div>
    @endif
</div>

</body>
</html>