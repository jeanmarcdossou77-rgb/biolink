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

        .form-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px; 
            padding: 30px; 
            margin-top: 24px;           /* Ajouté pour espacer après la bannière */
            margin-bottom: 24px;
        }
        /* Le reste de tes styles reste identique... */
        .success-msg {
            background: rgba(0,229,160,0.15);
            border: 1px solid rgba(0,229,160,0.3);
            padding: 12px 20px; border-radius: 10px;
            margin-bottom: 20px; color: #00e5a0;
        }
        .section-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #00e5a0; }
        /* ... tous tes autres styles ... */
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

    <!-- Bannière profil -->
    <div style="position:relative;height:180px;background:linear-gradient(135deg,rgba(0,229,160,0.3),rgba(55,138,221,0.3));border-radius:16px 16px 0 0;overflow:hidden;">
        <div style="position:absolute;inset:0;background:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22><circle cx=%2220%22 cy=%2220%22 r=%2240%22 fill=%22rgba(0,229,160,0.1)%22/><circle cx=%2280%22 cy=%2270%22 r=%2260%22 fill=%22rgba(55,138,221,0.1)%22/></svg>');"></div>
        
        <!-- Infos bannière -->
        <div style="position:absolute;bottom:16px;left:20px;right:20px;display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <div style="display:flex;align-items:flex-end;gap:14px;">
                <!-- Avatar -->
                <div style="position:relative;">
                    <div style="width:90px;height:90px;border-radius:50%;border:4px solid #0a1628;background:linear-gradient(135deg,#00e5a0,#378ADD);display:flex;align-items:center;justify-content:center;font-size:36px;font-weight:700;color:#0a1628;overflow:hidden;">
                        @if(Auth::user()->photo_profil)
                            <img src="{{ Storage::url(Auth::user()->photo_profil) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <label for="photoInput" style="position:absolute;bottom:0;right:0;background:#00e5a0;color:#0a1628;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:13px;border:2px solid #0a1628;" title="Changer la photo">📷</label>
                </div>

                <div style="padding-bottom:4px;">
                    <div style="font-size:20px;font-weight:800;text-shadow:0 2px 8px rgba(0,0,0,0.5);">{{ Auth::user()->name }}</div>
                    <div style="font-size:13px;color:#00e5a0;">
                        {{ Auth::user()->nom_grade['emoji'] ?? '🔬' }} {{ Auth::user()->nom_grade['nom'] ?? 'Membre' }}
                    </div>
                    @if(Auth::user()->profession)
                        <div style="font-size:12px;color:rgba(255,255,255,0.7);">
                            {{ Auth::user()->profession }} 
                            @if(Auth::user()->pays)· 🌍 {{ Auth::user()->pays }}@endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistiques -->
            <div style="display:flex;gap:16px;text-align:center;padding-bottom:4px;">
                <div>
                    <div style="font-size:20px;font-weight:700;color:#00e5a0;">{{ Auth::user()->publications_validees ?? 0 }}</div>
                    <div style="font-size:11px;color:rgba(255,255,255,0.6);">Publications</div>
                </div>
                <div>
                    <div style="font-size:20px;font-weight:700;color:#00e5a0;">{{ Auth::user()->points ?? 0 }}</div>
                    <div style="font-size:11px;color:rgba(255,255,255,0.6);">Points</div>
                </div>
                <div>
                    <div style="font-size:20px;font-weight:700;color:#00e5a0;">{{ Auth::user()->amis_count ?? 0 }}</div>
                    <div style="font-size:11px;color:rgba(255,255,255,0.6);">Amis</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire upload photo -->
    <form method="POST" action="/profil/photo" enctype="multipart/form-data" id="photoForm">
        @csrf
        <input type="file" id="photoInput" name="photo" accept="image/*" style="display:none" onchange="document.getElementById('photoForm').submit()">
    </form>

    <!-- Option Supprimer la photo (recommandé) -->
    @if(Auth::user()->photo_profil)
    <form method="POST" action="/profil/photo" style="margin-top:8px; margin-bottom:20px;">
        @csrf 
        @method('DELETE')
        <button type="submit" style="background:rgba(255,80,80,0.2);border:1px solid #ff5050;color:#ff5050;padding:6px 14px;border-radius:10px;font-size:13px;cursor:pointer;">
            🗑️ Supprimer la photo
        </button>
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
                <textarea name="etat_sante" placeholder="Décrivez votre état de santé général...">{{ Auth::user()->etat_sante ?? '' }}</textarea>
            </div>
            <button type="submit" class="btn-save">💾 Sauvegarder</button>
        </form>
    </div>

    <!-- Attestations (inchangé) -->
    @if(Auth::user()->grade_id >= 3)
    <div class="attestation-card">
        <div class="attestation-icon">🎓</div>
        <div class="attestation-title">Attestation BioLink disponible !</div>
        <div class="attestation-desc">
            Félicitations ! Votre grade {{ Auth::user()->nom_grade['nom'] ?? '' }} vous donne droit à une attestation officielle BioLink.
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
            📝 {{ Auth::user()->publications_validees ?? 0 }} / 30 publications validées
        </div>
    </div>
    @endif

</div>
</body>
</html>