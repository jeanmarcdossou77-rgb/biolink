<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Créer un groupe</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; min-height: 100vh; }
        .container { max-width: 700px; margin: 0 auto; padding: 40px 20px; }
        h1 { font-size: 28px; font-weight: 800; margin-bottom: 8px; }
        .subtitle { color: rgba(255,255,255,0.6); margin-bottom: 30px; font-size: 15px; }
        .form-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 13px; color: rgba(255,255,255,0.7); margin-bottom: 8px; font-weight: 500; }
        input, select, textarea { width: 100%; padding: 12px 16px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; color: white; font-size: 14px; outline: none; transition: border-color 0.3s; font-family: inherit; }
        input:focus, select:focus, textarea:focus { border-color: #00e5a0; }
        textarea { min-height: 100px; resize: vertical; }
        select option { background: #0a1628; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .btn-submit { width: 100%; padding: 14px; background: #00e5a0; color: #0a1628; border: none; border-radius: 10px; font-size: 16px; font-weight: 700; cursor: pointer; margin-top: 10px; }
        .error { color: #ff6b6b; font-size: 12px; margin-top: 4px; }
        .info-box { background: rgba(0,229,160,0.1); border: 1px solid rgba(0,229,160,0.3); border-radius: 12px; padding: 14px; margin-bottom: 24px; font-size: 14px; color: rgba(255,255,255,0.8); }
    </style>
</head>
<body>

@include('components.navbar')

<div class="container">
    <h1>👨‍👩‍👧 Créer un groupe</h1>
    <p class="subtitle">Créez votre communauté thématique sur la santé naturelle</p>

    @if(Auth::user()->grade_id < 2)
    <div style="background:rgba(255,80,80,0.1); border:1px solid rgba(255,80,80,0.3); border-radius:12px; padding:16px; margin-bottom:20px; color:#ff8080; font-size:14px;">
        ⚠️ Vous devez être au moins <strong>Contributeur</strong> (10 publications validées) pour créer un groupe.
    </div>
    @else
    <div class="info-box">
        ✅ Votre grade {{ Auth::user()->nom_grade['nom'] }} vous permet de créer des groupes !
    </div>
    @endif

    <div class="form-card">
        <form method="POST" action="/groups">
            @csrf

            <div class="form-group">
                <label>Nom du groupe *</label>
                <input type="text" name="nom" placeholder="Ex: Plantes médicinales contre l'hypertension" required value="{{ old('nom') }}">
                @error('nom') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" placeholder="Décrivez l'objectif et les thématiques de votre groupe..." required>{{ old('description') }}</textarea>
                @error('description') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Catégorie</label>
                    <select name="categorie">
                        <option value="Santé">🌿 Santé naturelle</option>
                        <option value="Phytothérapie">🌺 Phytothérapie</option>
                        <option value="Biologie">🔬 Biologie</option>
                        <option value="Nutrition">🥗 Nutrition</option>
                        <option value="Recherche">📚 Recherche</option>
                        <option value="Maladies tropicales">🌍 Maladies tropicales</option>
                        <option value="Pédiatrie">👶 Pédiatrie</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Visibilité</label>
                    <select name="visibilite">
                        <option value="public">🌍 Public — Visible par tous</option>
                        <option value="prive">🔒 Privé — Sur invitation</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-submit" {{ Auth::user()->grade_id < 2 ? 'disabled' : '' }}>
                👨‍👩‍👧 Créer le groupe
            </button>
        </form>
    </div>
</div>

</body>
</html>