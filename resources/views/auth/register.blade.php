<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Inscription</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0a1628;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
            width: 100%;
        }
        .left {
            background: linear-gradient(135deg, #0a1628, #0d2137);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
        }
        .logo {
            font-size: 32px;
            font-weight: 700;
            color: #00e5a0;
            letter-spacing: 2px;
            margin-bottom: 40px;
        }
        .logo span { color: white; }
        .left h1 {
            font-size: 42px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
        }
        .left h1 span { color: #00e5a0; }
        .left p {
            font-size: 16px;
            color: rgba(255,255,255,0.6);
            line-height: 1.7;
            margin-bottom: 40px;
        }
        .feature {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }
        .feature-icon {
            width: 36px;
            height: 36px;
            background: rgba(0,229,160,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        .feature-text {
            font-size: 14px;
            color: rgba(255,255,255,0.8);
        }
        .right {
            background: #0d1f35;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
        }
        .right h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .right p {
            color: rgba(255,255,255,0.5);
            font-size: 14px;
            margin-bottom: 32px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 13px;
            color: rgba(255,255,255,0.7);
            margin-bottom: 8px;
        }
        input {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 10px;
            color: white;
            font-size: 15px;
            outline: none;
            transition: border-color 0.3s;
        }
        input:focus {
            border-color: #00e5a0;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        select {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 10px;
            color: white;
            font-size: 15px;
            outline: none;
        }
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #00e5a0;
            color: #0a1628;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            transition: transform 0.2s;
        }
        .btn-submit:hover { transform: translateY(-2px); }
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: rgba(255,255,255,0.5);
        }
        .login-link a {
            color: #00e5a0;
            text-decoration: none;
        }
        .error {
            color: #ff6b6b;
            font-size: 12px;
            margin-top: 4px;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Gauche -->
    <div class="left">
        <div class="logo">Bio<span>Link</span></div>
        <h1>Rejoignez la communauté <span>scientifique</span></h1>
        <p>Découvrez des milliers de remèdes naturels validés scientifiquement, partagez vos connaissances et progressez dans vos grades.</p>
        <div class="feature">
            <div class="feature-icon">🔬</div>
            <div class="feature-text">Plus de 1000 pathologies référencées</div>
        </div>
        <div class="feature">
            <div class="feature-icon">✅</div>
            <div class="feature-text">Remèdes validés scientifiquement</div>
        </div>
        <div class="feature">
            <div class="feature-icon">🎓</div>
            <div class="feature-text">Système de grades et certifications</div>
        </div>
        <div class="feature">
            <div class="feature-icon">💚</div>
            <div class="feature-text">100% gratuit à l'usage de base</div>
        </div>
    </div>

    <!-- Droite -->
    <div class="right">
        <h2>Créer mon compte</h2>
        <p>Rejoignez BioLink gratuitement dès aujourd'hui</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label>Nom complet</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Votre nom" required>
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Adresse email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="votre@email.com" required>
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Âge</label>
                    <input type="number" name="age" placeholder="Votre âge" min="1" max="120">
                </div>
                <div class="form-group">
                    <label>Sexe</label>
                    <select name="sexe">
                        <option value="non_precise">Non précisé</option>
                        <option value="homme">Homme</option>
                        <option value="femme">Femme</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Poids (kg)</label>
                    <input type="number" name="poids" placeholder="Ex: 70">
                </div>
                <div class="form-group">
                    <label>Taille (cm)</label>
                    <input type="number" name="taille" placeholder="Ex: 175">
                </div>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="Minimum 8 caractères" required>
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" placeholder="Répétez le mot de passe" required>
            </div>

            <button type="submit" class="btn-submit">🧬 Rejoindre BioLink</button>
        </form>

        <div class="login-link">
            Déjà membre ? <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </div>
</div>
</body>
</html>