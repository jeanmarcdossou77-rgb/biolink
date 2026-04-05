<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink Premium</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; min-height: 100vh; }
        nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 60px; background: rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.1); }
        .logo { font-size: 26px; font-weight: 700; color: #00e5a0; text-decoration: none; }
        .logo span { color: white; }
        .hero { text-align: center; padding: 60px 20px 40px; }
        .hero h1 { font-size: 44px; font-weight: 800; margin-bottom: 16px; }
        .hero h1 span { color: #ffa500; }
        .hero p { font-size: 18px; color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto 40px; }
        .plans { display: flex; gap: 24px; justify-content: center; flex-wrap: wrap; padding: 0 20px 60px; max-width: 1000px; margin: 0 auto; }
        .plan-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px; padding: 36px 30px;
            width: 280px; text-align: center;
            transition: transform 0.3s;
        }
        .plan-card:hover { transform: translateY(-6px); }
        .plan-card.popular {
            border-color: #ffa500;
            background: rgba(255,165,0,0.08);
            position: relative;
        }
        .popular-badge {
            position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
            background: #ffa500; color: #0a1628; padding: 4px 16px;
            border-radius: 20px; font-size: 12px; font-weight: 700;
        }
        .plan-icon { font-size: 48px; margin-bottom: 16px; }
        .plan-nom { font-size: 22px; font-weight: 700; margin-bottom: 8px; }
        .plan-prix { font-size: 38px; font-weight: 800; color: #ffa500; margin-bottom: 4px; }
        .plan-periode { font-size: 13px; color: rgba(255,255,255,0.5); margin-bottom: 24px; }
        .plan-features { list-style: none; margin-bottom: 28px; text-align: left; }
        .plan-features li { padding: 8px 0; font-size: 14px; color: rgba(255,255,255,0.8); border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 8px; }
        .plan-features li:last-child { border-bottom: none; }
        .btn-plan {
            display: block; width: 100%; padding: 14px;
            background: #00e5a0; color: #0a1628;
            border: none; border-radius: 12px;
            font-size: 16px; font-weight: 700;
            cursor: pointer; text-decoration: none;
            transition: transform 0.2s;
        }
        .btn-plan:hover { transform: translateY(-2px); }
        .btn-plan.gold { background: #ffa500; }
        .btn-plan.free { background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2); }
        .garantie { text-align: center; padding: 20px; color: rgba(255,255,255,0.5); font-size: 14px; }
        .features-section { max-width: 900px; margin: 0 auto; padding: 0 20px 60px; }
        .features-section h2 { text-align: center; font-size: 28px; margin-bottom: 30px; }
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .feature-item { background: rgba(255,255,255,0.05); border-radius: 14px; padding: 24px; text-align: center; }
        .feature-icon { font-size: 32px; margin-bottom: 12px; }
        .feature-titre { font-size: 15px; font-weight: 600; margin-bottom: 8px; }
        .feature-desc { font-size: 13px; color: rgba(255,255,255,0.6); line-height: 1.6; }
        @media(max-width:768px) { .features-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<nav>
    <a href="/" class="logo">Bio<span>Link</span></a>
    <a href="/dashboard" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px;">← Dashboard</a>
</nav>

<div class="hero">
    <h1>BioLink <span>Premium</span> 🌟</h1>
    <p>Accédez à toutes les fonctionnalités avancées pour une expérience scientifique complète</p>
</div>

<div class="plans">

    <!-- Gratuit -->
    <div class="plan-card">
        <div class="plan-icon">🌱</div>
        <div class="plan-nom">Gratuit</div>
        <div class="plan-prix">0 FCFA</div>
        <div class="plan-periode">pour toujours</div>
        <ul class="plan-features">
            <li>✅ Accès aux 336+ pathologies</li>
            <li>✅ Recherche de remèdes</li>
            <li>✅ Publication de remèdes</li>
            <li>✅ Assistant IA de base</li>
            <li>✅ Profil et grades</li>
            <li>❌ Export PDF avancé</li>
            <li>❌ IA avancée illimitée</li>
            <li>❌ Badge Premium</li>
        </ul>
        <a href="/dashboard" class="btn-plan free">Continuer gratuitement</a>
    </div>

    <!-- Premium Mensuel -->
    <div class="plan-card popular">
        <div class="popular-badge">⭐ Plus populaire</div>
        <div class="plan-icon">🌟</div>
        <div class="plan-nom">Premium</div>
        <div class="plan-prix">2 500 FCFA</div>
        <div class="plan-periode">par mois</div>
        <ul class="plan-features">
            <li>✅ Tout du plan gratuit</li>
            <li>✅ Badge Premium visible</li>
            <li>✅ IA avancée illimitée</li>
            <li>✅ Export PDF des remèdes</li>
            <li>✅ Validation prioritaire</li>
            <li>✅ Attestations officielles</li>
            <li>✅ Sans publicités</li>
            <li>✅ Support prioritaire</li>
        </ul>
        <form method="POST" action="/premium/activer">
            @csrf
            <button type="submit" class="btn-plan gold">🌟 Devenir Premium</button>
        </form>
    </div>

    <!-- Premium Annuel -->
    <div class="plan-card">
        <div class="plan-icon">🏆</div>
        <div class="plan-nom">Premium Annuel</div>
        <div class="plan-prix">20 000 FCFA</div>
        <div class="plan-periode">par an — économisez 33%</div>
        <ul class="plan-features">
            <li>✅ Tout du Premium mensuel</li>
            <li>✅ Certificat officiel annuel</li>
            <li>✅ Profil mis en avant</li>
            <li>✅ Accès aux cours complets</li>
            <li>✅ Co-modération possible</li>
            <li>✅ Accès aux partenariats</li>
            <li>✅ Newsletter exclusive</li>
            <li>✅ Événements virtuels VIP</li>
        </ul>
        <form method="POST" action="/premium/activer">
            @csrf
            <button type="submit" class="btn-plan gold">🏆 Premium Annuel</button>
        </form>
    </div>

</div>

<div class="garantie">🔒 Paiement sécurisé · Annulation à tout moment · Support 24/7</div>

<div class="features-section">
    <h2>🌟 Pourquoi choisir Premium ?</h2>
    <div class="features-grid">
        <div class="feature-item">
            <div class="feature-icon">🤖</div>
            <div class="feature-titre">IA Avancée</div>
            <div class="feature-desc">Accédez à une IA médicale puissante pour des réponses personnalisées selon votre profil santé.</div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">📜</div>
            <div class="feature-titre">Attestations PDF</div>
            <div class="feature-desc">Téléchargez vos attestations officielles BioLink pour valoriser votre expertise scientifique.</div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">⚡</div>
            <div class="feature-titre">Validation prioritaire</div>
            <div class="feature-desc">Vos remèdes et publications sont validés en priorité par notre équipe scientifique.</div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">🚫</div>
            <div class="feature-titre">Sans publicités</div>
            <div class="feature-desc">Profitez d'une expérience pure et fluide sans aucune interruption publicitaire.</div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">👑</div>
            <div class="feature-titre">Badge Premium</div>
            <div class="feature-desc">Affichez votre badge Premium sur votre profil et gagnez en crédibilité dans la communauté.</div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">🌍</div>
            <div class="feature-titre">Impact mondial</div>
            <div class="feature-desc">Contribuez au développement de la plus grande base de remèdes naturels au monde.</div>
        </div>
    </div>
</div>

</body>
</html>