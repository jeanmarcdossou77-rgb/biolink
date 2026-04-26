<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Page introuvable</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',sans-serif; background:#0a1628; color:white; min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:20px; }
        .logo { font-size:32px; font-weight:800; color:#00e5a0; margin-bottom:30px; text-decoration:none; }
        .logo span { color:white; }
        .code { font-size:100px; font-weight:900; color:rgba(0,229,160,0.2); line-height:1; margin-bottom:10px; }
        h1 { font-size:28px; font-weight:800; margin-bottom:12px; }
        p { font-size:16px; color:rgba(255,255,255,0.6); margin-bottom:30px; max-width:400px; }
        .btns { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; }
        .btn-home { background:#00e5a0; color:#0a1628; padding:12px 28px; border-radius:20px; text-decoration:none; font-weight:700; font-size:15px; transition:transform 0.2s; }
        .btn-home:hover { transform:translateY(-2px); }
        .btn-back { background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.2); color:white; padding:12px 28px; border-radius:20px; text-decoration:none; font-size:15px; }
        .dna { font-size:60px; margin-bottom:20px; animation:float 3s ease-in-out infinite; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-15px)} }
        .suggestions { margin-top:40px; display:flex; gap:10px; flex-wrap:wrap; justify-content:center; }
        .sug-link { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:8px 16px; border-radius:20px; text-decoration:none; color:rgba(255,255,255,0.7); font-size:13px; transition:all 0.2s; }
        .sug-link:hover { border-color:#00e5a0; color:#00e5a0; }
    </style>
</head>
<body>
    <a href="/" class="logo">Bio<span>Link</span></a>
    <div class="dna">🧬</div>
    <div class="code">404</div>
    <h1>Page introuvable</h1>
    <p>La page que vous cherchez n'existe pas ou a été déplacée. Retournez à l'accueil !</p>
    <div class="btns">
        <a href="/" class="btn-home">🏠 Retour à l'accueil</a>
        <a href="javascript:history.back()" class="btn-back">← Retour</a>
    </div>
    <div class="suggestions">
        <a href="/recherche" class="sug-link">🔬 Pathologies</a>
        <a href="/feed" class="sug-link">📱 Fil d'actualité</a>
        <a href="/ia" class="sug-link">🤖 Assistant IA</a>
        <a href="/jobs" class="sug-link">💼 Emplois</a>
        <a href="/aide" class="sug-link">❓ Aide</a>
    </div>
</body>
</html>