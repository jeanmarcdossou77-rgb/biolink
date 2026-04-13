<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    @include('components.head')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Mon Profil</title>
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
        .container { max-width: 900px; margin: 0 auto; padding: 40px 20px; }
        .profile-header {
            background: linear-gradient(135deg, rgba(0,229,160,0.15), rgba(55,138,221,0.1));
            border: 1px solid rgba(0,229,160,0.3);
            border-radius: 20px; padding: 40px;
            display: flex; gap: 30px; align-items: center;
            margin-bottom: 30px;
        }
        .avatar-large {
            width: 100px; height: 100px; border-radius: 50%;
            background: linear-gradient(135deg, #00e5a0, #378ADD);
            display: flex; align-items: center; justify-content: center;
            font-size: 40px; font-weight: 700; color: #0a1628;
            flex-shrink: 0;
        }
        .profile-info h1 { font-size: 28px; font-weight: 800; margin-bottom: 8px; }
        .profile-info .grade-tag {
            display: inline-block;
            background: rgba(0,229,160,0.2);
            color: #00e5a0; padding: 4px 14px;
            border-radius: 20px; font-size: 13px; margin-bottom: 12px;
        }
        .profile-stats { display: flex; gap: 30px; margin-top: 12px; }
        .profile-stat { text-align: center; }
        .profile-stat-num { font-size: 24px; font-weight: 800; color: #00e5a0; }
        .profile-stat-label { font-size: 12px; color: rgba(255,255,255,0.5); }
        .form-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px; padding: 30px; margin-bottom: 24px;
        }
        .section-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #00e5a0; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; color: rgba(255,255,255,0.7); margin-bottom: 6px; }
        input, select, textarea {
            width: 100%; padding: 12px 16px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 10px; color: white; font-size: 14px;
            outline: none; transition: border-color 0.3s;
        }
        input:focus, select:focus { border-color: #00e5a0; }
        select option { background: #0a1628; }
        .btn-save {
            background: #00e5a0; color: #0a1628;
            border: none; padding: 12px 30px;
            border-radius: 10px; font-size: 15px;
            font-weight: 700; cursor: pointer;
        }
        .success-msg {
            background: rgba(0,229,160,0.15);
            border: 1px solid rgba(0,229,160,0.3);
            padding: 12px 20px; border-radius: 10px;
            margin-bottom: 20px; color: #00e5a0;
        }
        .attestation-card {
            background: rgba(255,215,0,0.1);
            border: 1px solid rgba(255,215,0,0.3);
            border-radius: 16px; padding: 24px;
            text-align: center;
        }
        .attestation-icon { font-size: 48px; margin-bottom: 12px; }
        .attestation-title { font-size: 18px; font-weight: 700; color: #FFD700; margin-bottom: 8px; }
        .attestation-desc { font-size: 14px; color: rgba(255,255,255,0.6); margin-bottom: 16px; }
        .btn-download {
            background: #FFD700; color: #0a1628;
            border: none; padding: 10px 24px;
            border-radius: 10px; font-weight: 700;
            cursor: pointer; text-decoration: none;
            display: inline-block; font-size: 14px;
        }
    </style>
</head>
<body>
<nav>
    <a href="/" class="logo">Bio<span>Link</span></a>
    <a href="/dashboard" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px;">← Dashboard</a>
</nav>

<div class="container">

    @if(session('success'))
        <div class="success-msg">{{ session('success') }}</div>
    @endif

<!-- Avatar avec upload -->
<div style="position:relative; display:inline-block;">
    <div class="avatar-large" id="avatarDisplay">
        @if(Auth::user()->photo_profil)
            <img src="{{ Storage::url(Auth::user()->photo_profil) }}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
        @else
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        @endif
    </div>
    <label for="photoInput" style="position:absolute;bottom:0;right:0;background:#00e5a0;color:#0a1628;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:16px;border:3px solid #0a1628;" title="Changer la photo">📷</label>
</div>

<form method="POST" action="/profil/photo" enctype="multipart/form-data" id="photoForm">
    @csrf
    <input type="file" id="photoInput" name="photo" accept="image/*" style="display:none" onchange="document.getElementById('photoForm').submit()">
</form>

@if(Auth::user()->photo_profil)
<form method="POST" action="/profil/photo" style="margin-top:8px;">
    @csrf @method('DELETE')
    <button type="submit" style="background:rgba(255,80,80,0.2);border:1px solid #ff5050;color:#ff5050;padding:4px 12px;border-radius:10px;font-size:12px;cursor:pointer;">🗑️ Supprimer la photo</button>
</form>
@endif

    <!-- Formulaire profil -->
    <div class="form-card">
        <div class="section-title">✏️ Modifier mon profil</div>
        <form method="POST" action="/profil/update">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label>Nom complet</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}">
                </div>
                <div class="form-group">
                    <label>Âge</label>
                    <input type="number" name="age" value="{{ Auth::user()->age }}" placeholder="Votre âge">
                </div>
                <div class="form-group">
                    <label>Sexe</label>
                    <select name="sexe">
                        <option value="non_precise" {{ Auth::user()->sexe == 'non_precise' ? 'selected' : '' }}>Non précisé</option>
                        <option value="homme" {{ Auth::user()->sexe == 'homme' ? 'selected' : '' }}>Homme</option>
                        <option value="femme" {{ Auth::user()->sexe == 'femme' ? 'selected' : '' }}>Femme</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Poids (kg)</label>
                    <input type="number" name="poids" value="{{ Auth::user()->poids }}" placeholder="Ex: 70">
                </div>
                <div class="form-group">
                    <label>Taille (cm)</label>
                    <input type="number" name="taille" value="{{ Auth::user()->taille }}" placeholder="Ex: 175">
                </div>
            </div>
            <div class="form-group">
                <label>État de santé général</label>
                <textarea name="etat_sante" placeholder="Décrivez votre état de santé général...">{{ Auth::user()->etat_sante }}</textarea>
            </div>
            <button type="submit" class="btn-save">💾 Sauvegarder</button>
        </form>
    </div>

    <!-- Attestations -->
    @if(Auth::user()->grade_id >= 3)
    <div class="attestation-card">
        <div class="attestation-icon">🎓</div>
        <div class="attestation-title">Attestation BioLink disponible !</div>
        <div class="attestation-desc">
            Félicitations ! Votre grade {{ Auth::user()->nom_grade['nom'] }} vous donne droit à une attestation officielle BioLink.
        </div>
        <a href="/attestation/{{ Auth::user()->id }}" class="btn-download">📜 Télécharger mon attestation</a>
    </div>
    @else
    <div class="attestation-card" style="border-color: rgba(255,255,255,0.1); background: rgba(255,255,255,0.03);">
        <div class="attestation-icon">🔒</div>
        <div class="attestation-title" style="color: rgba(255,255,255,0.5);">Attestation non disponible</div>
        <div class="attestation-desc">
            Atteignez le grade <strong>Chercheur Actif</strong> (30 publications validées) pour débloquer votre attestation officielle BioLink.
        </div>
        <div style="background: rgba(255,255,255,0.05); border-radius: 10px; padding: 10px; font-size: 13px; color: rgba(255,255,255,0.5);">
            📝 {{ Auth::user()->publications_validees }} / 30 publications validées
        </div>
    </div>
    @endif

</div>
</body>
</html>