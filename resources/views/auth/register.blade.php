<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Créer un compte</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',sans-serif; background:#0a1628; color:white; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px; }
        .container { display:grid; grid-template-columns:1fr 1fr; width:100%; max-width:1000px; min-height:100vh; }
        .left { background:linear-gradient(135deg,#0a1628,#0d2137); display:flex; flex-direction:column; justify-content:center; padding:50px 40px; }
        .logo { font-size:28px; font-weight:700; color:#00e5a0; margin-bottom:30px; text-decoration:none; }
        .logo span { color:white; }
        .left h1 { font-size:36px; font-weight:800; line-height:1.3; margin-bottom:16px; }
        .left h1 span { color:#00e5a0; }
        .left p { font-size:15px; color:rgba(255,255,255,0.6); line-height:1.7; margin-bottom:30px; }
        .feature { display:flex; align-items:center; gap:10px; margin-bottom:12px; }
        .feature-icon { width:32px; height:32px; background:rgba(0,229,160,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; flex-shrink:0; }
        .feature-text { font-size:13px; color:rgba(255,255,255,0.8); }
        .right { background:#0d1f35; display:flex; flex-direction:column; justify-content:center; padding:40px; overflow-y:auto; }
        .right h2 { font-size:24px; font-weight:700; margin-bottom:6px; }
        .right p { color:rgba(255,255,255,0.5); font-size:13px; margin-bottom:24px; }
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .form-group { margin-bottom:0; }
        .form-group.full { grid-column:1/-1; }
        label { display:block; font-size:12px; color:rgba(255,255,255,0.6); margin-bottom:6px; font-weight:500; }
        input, select { width:100%; padding:11px 14px; background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.15); border-radius:10px; color:white; font-size:14px; outline:none; transition:border-color 0.3s; font-family:inherit; }
        input:focus, select:focus { border-color:#00e5a0; }
        select option { background:#0a1628; color:white; }
        select { appearance:none; cursor:pointer; }
        .error { color:#ff6b6b; font-size:11px; margin-top:3px; }
        .btn-submit { width:100%; padding:13px; background:#00e5a0; color:#0a1628; border:none; border-radius:10px; font-size:15px; font-weight:700; cursor:pointer; margin-top:16px; transition:transform 0.2s; }
        .btn-submit:hover { transform:translateY(-2px); }
        .login-link { text-align:center; margin-top:16px; font-size:13px; color:rgba(255,255,255,0.5); }
        .login-link a { color:#00e5a0; text-decoration:none; }
        .section-label { font-size:11px; font-weight:700; color:rgba(0,229,160,0.8); text-transform:uppercase; letter-spacing:1px; margin:16px 0 10px; grid-column:1/-1; border-bottom:1px solid rgba(0,229,160,0.2); padding-bottom:6px; }
        @media(max-width:768px) { .container { grid-template-columns:1fr; } .left { display:none; } .form-grid { grid-template-columns:1fr; } }
    </style>
</head>
<body>
<div class="container">
    <div class="left">
        <a href="/" class="logo">Bio<span>Link</span></a>
        <h1>Rejoignez la communauté <span>scientifique mondiale</span> !</h1>
        <p>Créez votre compte BioLink gratuitement et accédez à des centaines de remèdes naturels validés.</p>
        <div class="feature"><div class="feature-icon">🔬</div><div class="feature-text">336+ pathologies référencées</div></div>
        <div class="feature"><div class="feature-icon">🌿</div><div class="feature-text">Remèdes naturels validés scientifiquement</div></div>
        <div class="feature"><div class="feature-icon">🎓</div><div class="feature-text">Système de grades et certifications</div></div>
        <div class="feature"><div class="feature-icon">👥</div><div class="feature-text">Communauté de chercheurs africains</div></div>
        <div class="feature"><div class="feature-icon">🤖</div><div class="feature-text">Assistant IA intégré 24h/24</div></div>
        <div class="feature"><div class="feature-icon">💯</div><div class="feature-text">100% Gratuit à la base</div></div>
    </div>

    <div class="right">
        <h2>Créer mon compte</h2>
        <p>Rejoignez BioLink gratuitement</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-grid">
                <div class="section-label">👤 Informations personnelles</div>

                <div class="form-group">
                    <label>Prénom et Nom *</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Jean-Marc Dossou" required autofocus>
                    @error('name')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Adresse email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="votre@email.com" required>
                    @error('email')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Mot de passe *</label>
                    <input type="password" name="password" placeholder="Minimum 8 caractères" required>
                    @error('password')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Confirmer le mot de passe *</label>
                    <input type="password" name="password_confirmation" placeholder="Répétez le mot de passe" required>
                </div>

                <div class="form-group">
                    <label>Sexe</label>
                    <select name="sexe">
                        <option value="non_precise">-- Non précisé --</option>
                        <option value="homme">👨 Homme</option>
                        <option value="femme">👩 Femme</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Pays</label>
                    <select name="pays">
                        <option value="Bénin">🇧🇯 Bénin</option>
                        <option value="Togo">🇹🇬 Togo</option>
                        <option value="Côte d'Ivoire">🇨🇮 Côte d'Ivoire</option>
                        <option value="Sénégal">🇸🇳 Sénégal</option>
                        <option value="Mali">🇲🇱 Mali</option>
                        <option value="Burkina Faso">🇧🇫 Burkina Faso</option>
                        <option value="Niger">🇳🇪 Niger</option>
                        <option value="Ghana">🇬🇭 Ghana</option>
                        <option value="Nigeria">🇳🇬 Nigeria</option>
                        <option value="Cameroun">🇨🇲 Cameroun</option>
                        <option value="Congo">🇨🇬 Congo</option>
                        <option value="RDC">🇨🇩 RDC</option>
                        <option value="Madagascar">🇲🇬 Madagascar</option>
                        <option value="France">🇫🇷 France</option>
                        <option value="Belgique">🇧🇪 Belgique</option>
                        <option value="Canada">🇨🇦 Canada</option>
                        <option value="Autre">🌍 Autre</option>
                    </select>
                </div>

                <div class="section-label">🎓 Profil professionnel</div>

                <div class="form-group">
                    <label>Profession *</label>
                    <select name="profession" required>
                        <option value="">-- Sélectionnez --</option>
                        <option value="Médecin">👨‍⚕️ Médecin</option>
                        <option value="Pharmacien">💊 Pharmacien</option>
                        <option value="Infirmier">🏥 Infirmier(ère)</option>
                        <option value="Biologiste">🔬 Biologiste</option>
                        <option value="Phytothérapeute">🌿 Phytothérapeute</option>
                        <option value="Chercheur">🧪 Chercheur</option>
                        <option value="Étudiant">📚 Étudiant(e)</option>
                        <option value="Enseignant">🎓 Enseignant(e)</option>
                        <option value="Tradithérapeute">🌺 Tradithérapeute</option>
                        <option value="Nutritionniste">🥗 Nutritionniste</option>
                        <option value="Sage-femme">👶 Sage-femme</option>
                        <option value="Kinésithérapeute">💪 Kinésithérapeute</option>
                        <option value="Agriculteur">🌱 Agriculteur</option>
                        <option value="Journaliste santé">📰 Journaliste santé</option>
                        <option value="Patient/Particulier">🙋 Patient / Particulier</option>
                        <option value="Autre">🔹 Autre</option>
                    </select>
                    @error('profession')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Domaine d'étude / Spécialité</label>
                    <select name="domaine_etude">
                        <option value="">-- Sélectionnez --</option>
                        <option value="Médecine générale">Médecine générale</option>
                        <option value="Pharmacologie">Pharmacologie</option>
                        <option value="Biologie médicale">Biologie médicale</option>
                        <option value="Biochimie">Biochimie</option>
                        <option value="Microbiologie">Microbiologie</option>
                        <option value="Virologie">Virologie</option>
                        <option value="Parasitologie">Parasitologie</option>
                        <option value="Botanique">Botanique</option>
                        <option value="Phytothérapie">Phytothérapie</option>
                        <option value="Nutrition">Nutrition</option>
                        <option value="Santé publique">Santé publique</option>
                        <option value="Gynécologie">Gynécologie</option>
                        <option value="Pédiatrie">Pédiatrie</option>
                        <option value="Cardiologie">Cardiologie</option>
                        <option value="Neurologie">Neurologie</option>
                        <option value="Dermatologie">Dermatologie</option>
                        <option value="Maladies infectieuses">Maladies infectieuses</option>
                        <option value="Sciences naturelles">Sciences naturelles</option>
                        <option value="Agronomie">Agronomie</option>
                        <option value="Non spécialisé">Non spécialisé</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>

                <div class="form-group full">
                    <label>Numéro WhatsApp (optionnel)</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="+229 XX XX XX XX">
                </div>
            </div>

            <button type="submit" class="btn-submit">🌿 Créer mon compte BioLink</button>
        </form>

        <div class="login-link">
            Déjà membre ? <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </div>
</div>
</body>
</html>