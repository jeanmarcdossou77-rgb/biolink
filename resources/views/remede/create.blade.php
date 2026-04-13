<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Publier un remède</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; min-height: 100vh; }
        nav {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 60px; background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .logo { font-size: 26px; font-weight: 700; color: #00e5a0; text-decoration: none; }
        .logo span { color: white; }
        .container { max-width: 800px; margin: 0 auto; padding: 40px 20px; }
        h1 { font-size: 32px; font-weight: 800; margin-bottom: 8px; }
        .subtitle { color: rgba(255,255,255,0.6); margin-bottom: 40px; }
        .form-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px; padding: 40px;
        }
        .form-group { margin-bottom: 24px; }
        label { display: block; font-size: 14px; color: rgba(255,255,255,0.8); margin-bottom: 8px; font-weight: 500; }
        .required { color: #00e5a0; }
        input, select, textarea {
            width: 100%; padding: 12px 16px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 10px; color: white; font-size: 15px;
            outline: none; transition: border-color 0.3s;
            font-family: 'Segoe UI', sans-serif;
        }
        input:focus, select:focus, textarea:focus { border-color: #00e5a0; }
        input::placeholder, textarea::placeholder { color: rgba(255,255,255,0.3); }
        textarea { resize: vertical; min-height: 120px; }
        select option { background: #0a1628; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
        .btn-submit {
            width: 100%; padding: 16px;
            background: #00e5a0; color: #0a1628;
            border: none; border-radius: 12px;
            font-size: 17px; font-weight: 700;
            cursor: pointer; transition: transform 0.2s;
            margin-top: 10px;
        }
        .btn-submit:hover { transform: translateY(-2px); }
        .error { color: #ff6b6b; font-size: 12px; margin-top: 4px; }
        .info-box {
            background: rgba(0,229,160,0.1);
            border: 1px solid rgba(0,229,160,0.3);
            border-radius: 12px; padding: 16px;
            margin-bottom: 30px; font-size: 14px;
            color: rgba(255,255,255,0.8);
        }
        .section-title {
            font-size: 16px; font-weight: 600;
            color: #00e5a0; margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>
<nav>
    <a href="/" class="logo">Bio<span>Link</span></a>
    <a href="/recherche" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px;">← Retour</a>
</nav>

<div class="container">
    <h1>🌿 Publier un remède</h1>
    <p class="subtitle">Partagez vos connaissances avec la communauté BioLink — votre contribution sera validée par notre équipe.</p>

    <div class="info-box">
        ℹ️ Votre remède sera soumis à validation avant publication. Une fois approuvé, il sera visible par tous les membres et vous gagnerez des points !
    </div>

    <div class="form-card">
        <form method="POST" action="/remedes">
            @csrf

            <div class="section-title">📋 Informations générales</div>

            <div class="form-group">
                <label>Titre du remède <span class="required">*</span></label>
                <input type="text" name="titre" placeholder="Ex: Décoction de feuilles de moringa contre l'anémie" value="{{ old('titre') }}" required>
                @error('titre') <div class="error">{{ $message }}</div> @enderror
            </div>

        <div class="form-group">
    <label>Pathologie concernée <span class="required">*</span></label>
    <select name="pathologie_id" id="pathologieSelect" onchange="checkAutre(this)">
        <option value="">Sélectionnez une pathologie</option>
        @foreach($pathologies as $pathologie)
            <option value="{{ $pathologie->id }}">{{ $pathologie->nom }} ({{ $pathologie->categorie }})</option>
        @endforeach
        <option value="autre">✏️ Autre — Je ne trouve pas ma pathologie</option>
    </select>
</div>

<div class="form-group" id="autrePathologieDiv" style="display:none;">
    <label>Nom de votre pathologie <span class="required">*</span></label>
    <input type="text" name="pathologie_libre" id="pathologieLibre" placeholder="Écrivez le nom exact de votre pathologie...">
    <div style="font-size:12px; color:#00e5a0; margin-top:6px;">✅ Votre pathologie sera ajoutée à notre base après validation.</div>
</div>

            <div class="form-group">
                <label>Description du remède <span class="required">*</span></label>
                <textarea name="description" placeholder="Décrivez ce remède, son origine, son efficacité et pourquoi vous le recommandez..." required>{{ old('description') }}</textarea>
                @error('description') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="section-title">🌱 Composition et préparation</div>

            <div class="form-group">
                <label>Ingrédients <span class="required">*</span></label>
                <textarea name="ingredients" placeholder="Ex: 50g de feuilles de moringa fraîches, 1L d'eau, 2 cuillères de miel naturel..." required>{{ old('ingredients') }}</textarea>
                @error('ingredients') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Mode de préparation <span class="required">*</span></label>
                <textarea name="preparation" placeholder="Ex: 1. Laver les feuilles... 2. Faire bouillir 10 minutes... 3. Filtrer et ajouter le miel..." required>{{ old('preparation') }}</textarea>
                @error('preparation') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="section-title">👤 Adapté pour qui ?</div>

            <div class="form-row-3">
                <div class="form-group">
                    <label>Type de remède</label>
                    <select name="type">
                        <option value="naturel">🌿 Naturel</option>
                        <option value="phytotherapie">🌺 Phytothérapie</option>
                        <option value="alimentation">🥗 Alimentaire</option>
                        <option value="aromatherapie">🌸 Aromathérapie</option>
                        <option value="traditionnel">🏺 Traditionnel</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Sexe concerné</label>
                    <select name="sexe">
                        <option value="tous">Tous</option>
                        <option value="homme">Homme uniquement</option>
                        <option value="femme">Femme uniquement</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select name="type">
                        <option value="naturel">Naturel</option>
                        <option value="traditionnel">Traditionnel</option>
                        <option value="moderne">Moderne</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Âge minimum (années)</label>
                    <input type="number" name="age_min" placeholder="Ex: 5" min="0" max="120" value="{{ old('age_min') }}">
                </div>
                <div class="form-group">
                    <label>Âge maximum (années)</label>
                    <input type="number" name="age_max" placeholder="Ex: 80" min="0" max="120" value="{{ old('age_max') }}">
                </div>
            </div>

            <button type="submit" class="btn-submit">🌿 Soumettre mon remède pour validation</button>
        </form>
    </div>
</div>

<script>
function checkAutre(select) {
    const div = document.getElementById('autrePathologieDiv');
    const input = document.getElementById('pathologieLibre');
    if (select.value === 'autre') {
        div.style.display = 'block';
        input.required = true;
    } else {
        div.style.display = 'none';
        input.required = false;
    }
}
</script>
</body>
</html>