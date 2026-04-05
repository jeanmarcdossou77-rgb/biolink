<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Publier une offre</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; min-height: 100vh; }
        nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 60px; background: rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.1); }
        .logo { font-size: 26px; font-weight: 700; color: #00e5a0; text-decoration: none; }
        .logo span { color: white; }
        .container { max-width: 800px; margin: 0 auto; padding: 40px 20px; }
        h1 { font-size: 32px; font-weight: 800; margin-bottom: 8px; }
        .subtitle { color: rgba(255,255,255,0.6); margin-bottom: 40px; font-size: 15px; }
        .form-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 40px; }
        .form-group { margin-bottom: 20px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        label { display: block; font-size: 13px; color: rgba(255,255,255,0.7); margin-bottom: 8px; }
        input, select, textarea { width: 100%; padding: 12px 16px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; color: white; font-size: 14px; outline: none; transition: border-color 0.3s; font-family: 'Segoe UI', sans-serif; }
        input:focus, select:focus, textarea:focus { border-color: #00e5a0; }
        textarea { min-height: 120px; resize: vertical; }
        select option { background: #0a1628; }
        .btn-submit { width: 100%; padding: 14px; background: #00e5a0; color: #0a1628; border: none; border-radius: 10px; font-size: 16px; font-weight: 700; cursor: pointer; margin-top: 10px; }
        .section-title { font-size: 15px; font-weight: 600; color: #00e5a0; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .info-box { background: rgba(255,165,0,0.1); border: 1px solid rgba(255,165,0,0.3); border-radius: 12px; padding: 14px; margin-bottom: 24px; font-size: 13px; color: rgba(255,255,255,0.8); }
    </style>
</head>
<body>
<nav>
    <a href="/" class="logo">Bio<span>Link</span></a>
    <a href="/jobs" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px;">← Retour aux offres</a>
</nav>
<div class="container">
    <h1>💼 Publier une offre d'emploi</h1>
    <p class="subtitle">Trouvez les meilleurs talents en biologie et santé naturelle</p>
    <div class="info-box">⚠️ Les offres sont publiées après validation par notre équipe. Délai : 24-48h.</div>
    <div class="form-card">
        <form method="POST" action="/jobs">
            @csrf
            <div class="section-title">📋 Informations du poste</div>
            <div class="form-group">
                <label>Titre du poste *</label>
                <input type="text" name="titre" placeholder="Ex: Biologiste chercheur en phytothérapie" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Entreprise / Organisation *</label>
                    <input type="text" name="entreprise" placeholder="Nom de l'entreprise" required>
                </div>
                <div class="form-group">
                    <label>Lieu *</label>
                    <input type="text" name="lieu" placeholder="Ex: Cotonou, Bénin" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Type de contrat</label>
                    <select name="type">
                        <option value="CDI">CDI</option>
                        <option value="CDD">CDD</option>
                        <option value="Stage">Stage</option>
                        <option value="Freelance">Freelance</option>
                        <option value="Bénévolat">Bénévolat</option>
                        <option value="Temps partiel">Temps partiel</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Catégorie</label>
                    <select name="categorie">
                        <option value="Biologie">Biologie</option>
                        <option value="Phytothérapie">Phytothérapie</option>
                        <option value="Médecine naturelle">Médecine naturelle</option>
                        <option value="Recherche">Recherche</option>
                        <option value="Pharmacie">Pharmacie</option>
                        <option value="Nutrition">Nutrition</option>
                        <option value="Santé publique">Santé publique</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Description du poste *</label>
                <textarea name="description" placeholder="Décrivez le poste, les missions et l'environnement de travail..." required></textarea>
            </div>
            <div class="form-group">
                <label>Compétences requises *</label>
                <textarea name="competences" placeholder="Ex: Licence en biologie, 2 ans d'expérience en phytothérapie..." required></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Salaire (optionnel)</label>
                    <input type="text" name="salaire" placeholder="Ex: 300 000 FCFA / mois">
                </div>
                <div class="form-group">
                    <label>Email de contact *</label>
                    <input type="email" name="email_contact" placeholder="recrutement@entreprise.com" required>
                </div>
            </div>
            <button type="submit" class="btn-submit">💼 Soumettre l'offre d'emploi</button>
        </form>
    </div>
</div>
</body>
</html>