<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Connexion</title>
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
            text-decoration: none;
        }
        .logo span { color: white; }
        .left h1 { font-size: 42px; font-weight: 800; line-height: 1.2; margin-bottom: 20px; }
        .left h1 span { color: #00e5a0; }
        .left p { font-size: 16px; color: rgba(255,255,255,0.6); line-height: 1.7; margin-bottom: 40px; }
        .feature { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
        .feature-icon {
            width: 36px; height: 36px;
            background: rgba(0,229,160,0.15);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
        }
        .feature-text { font-size: 14px; color: rgba(255,255,255,0.8); }
        .right {
            background: #0d1f35;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
        }
        .right h2 { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
        .right p { color: rgba(255,255,255,0.5); font-size: 14px; margin-bottom: 32px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 13px; color: rgba(255,255,255,0.7); margin-bottom: 8px; }
        input {
            width: 100%; padding: 12px 16px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 10px; color: white;
            font-size: 15px; outline: none;
            transition: border-color 0.3s;
        }
        input:focus { border-color: #00e5a0; }
        .btn-submit {
            width: 100%; padding: 14px;
            background: #00e5a0; color: #0a1628;
            border: none; border-radius: 10px;
            font-size: 16px; font-weight: 700;
            cursor: pointer; margin-top: 10px;
            transition: transform 0.2s;
        }
        .btn-submit:hover { transform: translateY(-2px); }
        .error { color: #ff6b6b; font-size: 12px; margin-top: 4px; }
        .register-link {
            text-align: center; margin-top: 20px;
            font-size: 14px; color: rgba(255,255,255,0.5);
        }
        .register-link a { color: #00e5a0; text-decoration: none; }
        .remember-row {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 20px;
        }
        .remember-row label { margin-bottom: 0; display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .forgot-link { color: #00e5a0; text-decoration: none; font-size: 13px; }
        @media(max-width: 768px) {
            .container { grid-template-columns: 1fr; }
            .left { display: none; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="left">
        <a href="/" class="logo">Bio<span>Link</span></a>
        <h1>Content de vous <span>revoir !</span></h1>
        <p>Connectez-vous pour accéder à votre espace BioLink et continuer votre parcours scientifique.</p>
        <div class="feature">
            <div class="feature-icon">🔬</div>
            <div class="feature-text">336+ pathologies référencées</div>
        </div>
        <div class="feature">
            <div class="feature-icon">🌿</div>
            <div class="feature-text">Remèdes naturels validés</div>
        </div>
        <div class="feature">
            <div class="feature-icon">🎓</div>
            <div class="feature-text">Système de grades et certifications</div>
        </div>
        <div class="feature">
            <div class="feature-icon">🤖</div>
            <div class="feature-text">Assistant IA intégré</div>
        </div>
    </div>

    <div class="right">
        <h2>Se connecter</h2>
        <p>Accédez à votre compte BioLink</p>

        @if (session('status'))
            <div style="background:rgba(0,229,160,0.15); border:1px solid rgba(0,229,160,0.3); padding:12px; border-radius:10px; margin-bottom:20px; color:#00e5a0; font-size:14px;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Adresse email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="votre@email.com" required autofocus>
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="Votre mot de passe" required>
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember" style="width:auto;">
                    Se souvenir de moi
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
                @endif
            </div>

            <button type="submit" class="btn-submit">🔐 Se connecter</button>
        </form>

        <div class="register-link">
            Pas encore membre ? <a href="{{ route('register') }}">Créer un compte</a>
        </div>
    </div>
</div>
</body>
</html>