<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Centre d'aide</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; min-height: 100vh; }
        .hero { text-align: center; padding: 60px 20px 40px; background: radial-gradient(ellipse at top, rgba(0,229,160,0.1), transparent 60%); }
        .hero h1 { font-size: 38px; font-weight: 800; margin-bottom: 12px; }
        .hero h1 span { color: #00e5a0; }
        .hero p { color: rgba(255,255,255,0.6); font-size: 16px; margin-bottom: 30px; }
        .search-box { max-width: 500px; margin: 0 auto; display: flex; gap: 10px; }
        .search-input { flex: 1; padding: 14px 20px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15); border-radius: 25px; color: white; font-size: 15px; outline: none; }
        .search-input:focus { border-color: #00e5a0; }
        .container { max-width: 900px; margin: 0 auto; padding: 40px 20px; }
        .faq-section { margin-bottom: 40px; }
        .faq-title { font-size: 22px; font-weight: 700; margin-bottom: 20px; color: #00e5a0; }
        .faq-item { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; margin-bottom: 10px; overflow: hidden; }
        .faq-question { padding: 16px 20px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-size: 15px; font-weight: 600; transition: background 0.2s; }
        .faq-question:hover { background: rgba(255,255,255,0.05); }
        .faq-answer { padding: 0 20px 16px; font-size: 14px; color: rgba(255,255,255,0.7); line-height: 1.7; display: none; }
        .faq-answer.active { display: block; }
        .faq-arrow { transition: transform 0.3s; }
        .faq-arrow.open { transform: rotate(180deg); }
        .guides-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 40px; }
        .guide-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 24px; text-align: center; transition: all 0.3s; cursor: pointer; }
        .guide-card:hover { border-color: #00e5a0; transform: translateY(-3px); }
        .guide-icon { font-size: 36px; margin-bottom: 12px; }
        .guide-title { font-size: 15px; font-weight: 700; margin-bottom: 8px; }
        .guide-desc { font-size: 13px; color: rgba(255,255,255,0.6); }
        .contact-card { background: linear-gradient(135deg, rgba(0,229,160,0.15), rgba(55,138,221,0.1)); border: 1px solid rgba(0,229,160,0.3); border-radius: 20px; padding: 40px; text-align: center; }
        .contact-card h2 { font-size: 24px; font-weight: 800; margin-bottom: 12px; }
        .contact-card p { color: rgba(255,255,255,0.6); margin-bottom: 24px; }
        .contact-buttons { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
        .btn-whatsapp { background: #25D366; color: white; padding: 12px 28px; border-radius: 25px; font-weight: 700; text-decoration: none; font-size: 15px; }
        .btn-email { background: rgba(255,255,255,0.1); color: white; padding: 12px 28px; border-radius: 25px; font-weight: 600; text-decoration: none; font-size: 15px; border: 1px solid rgba(255,255,255,0.2); }
        @media(max-width: 768px) { .guides-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

@include('components.navbar')

<div class="hero">
    <h1>Centre d'<span>Aide</span> BioLink</h1>
    <p>Trouvez rapidement les réponses à vos questions</p>
    <div class="search-box">
        <input type="text" class="search-input" placeholder="🔍 Rechercher dans l'aide..." id="searchHelp" onkeyup="filterFAQ()">
    </div>
</div>

<div class="container">

    <!-- Guides rapides -->
    <div class="faq-title">🚀 Guides rapides</div>
    <div class="guides-grid">
        <div class="guide-card" onclick="window.location='/register'">
            <div class="guide-icon">👤</div>
            <div class="guide-title">Créer un compte</div>
            <div class="guide-desc">Rejoignez BioLink gratuitement en quelques secondes</div>
        </div>
        <div class="guide-card" onclick="window.location='/recherche'">
            <div class="guide-icon">🔬</div>
            <div class="guide-title">Chercher un remède</div>
            <div class="guide-desc">Trouvez le soin naturel adapté à votre pathologie</div>
        </div>
        <div class="guide-card" onclick="window.location='/remedes/create'">
            <div class="guide-icon">🌿</div>
            <div class="guide-title">Publier un remède</div>
            <div class="guide-desc">Partagez vos connaissances avec la communauté</div>
        </div>
        <div class="guide-card" onclick="window.location='/feed'">
            <div class="guide-icon">📱</div>
            <div class="guide-title">Fil d'actualité</div>
            <div class="guide-desc">Interagissez avec la communauté scientifique</div>
        </div>
        <div class="guide-card" onclick="window.location='/profil'">
            <div class="guide-icon">🎓</div>
            <div class="guide-title">Système de grades</div>
            <div class="guide-desc">Progressez et obtenez des attestations officielles</div>
        </div>
        <div class="guide-card" onclick="window.location='/premium'">
            <div class="guide-icon">🌟</div>
            <div class="guide-title">Passer Premium</div>
            <div class="guide-desc">Accédez à toutes les fonctionnalités avancées</div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="faq-section">
        <div class="faq-title">❓ Questions fréquentes</div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                BioLink est-il vraiment gratuit ?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                Oui ! BioLink est 100% gratuit à l'usage de base. Vous pouvez accéder à toutes les pathologies, rechercher des remèdes, publier des contenus et interagir avec la communauté sans payer. Le plan Premium offre des fonctionnalités avancées supplémentaires.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Comment publier un remède naturel ?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                1. Connectez-vous à votre compte<br>
                2. Cliquez sur "Publier un remède" dans le menu ou le dashboard<br>
                3. Remplissez le formulaire avec le titre, la description, les ingrédients et la préparation<br>
                4. Sélectionnez la pathologie concernée<br>
                5. Soumettez — notre équipe validera votre remède sous 24-48h
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Comment fonctionne le système de grades ?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                BioLink dispose de 5 grades :<br>
                🌱 Débutant — À l'inscription<br>
                🌿 Contributeur — 10 publications validées<br>
                🔬 Chercheur Actif — 30 publications validées<br>
                ⭐ Expert — 60 publications validées<br>
                🏆 Leader Scientifique — Reconnu par l'Admin<br><br>
                À partir du grade Chercheur Actif, vous pouvez télécharger votre attestation officielle BioLink !
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Comment créer un groupe ou une page ?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                La création de groupes est disponible à partir du grade Contributeur (10 publications). Cliquez sur "Groupes" dans le menu, puis "Créer un groupe". Donnez un nom, une description et choisissez la visibilité (public ou privé).
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Mes données personnelles sont-elles sécurisées ?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                Oui ! BioLink utilise HTTPS pour chiffrer toutes les communications. Vos données ne sont jamais vendues à des tiers. Seules les informations que vous choisissez de partager publiquement sont visibles des autres membres.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Comment signaler un contenu inapproprié ?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                Contactez directement notre équipe via WhatsApp ou email. Nous examinons tous les signalements sous 24h et prenons les mesures nécessaires pour maintenir la qualité et la sécurité de la plateforme.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                Comment télécharger mon attestation ?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                Atteignez le grade Chercheur Actif (30 publications validées), puis allez dans votre profil. Le bouton "Télécharger mon attestation" sera disponible et vous pourrez obtenir votre certificat officiel BioLink en PDF.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                L'assistant IA est-il fiable pour la santé ?
                <span class="faq-arrow">▼</span>
            </div>
            <div class="faq-answer">
                L'assistant IA de BioLink est un outil d'orientation basé sur notre base de données de remèdes naturels validés. Il ne remplace pas un avis médical professionnel. Pour toute condition grave, consultez toujours un médecin qualifié.
            </div>
        </div>
    </div>

    <!-- Contact -->
    <div class="contact-card">
        <h2>🆘 Besoin d'aide urgente ?</h2>
        <p>Notre équipe est disponible pour vous aider. Contactez-nous directement !</p>
        <div style="margin-bottom:20px;">
            <div style="font-size:16px; font-weight:700; margin-bottom:4px;">DOSSOU Jean-Marc</div>
            <div style="font-size:14px; color:rgba(255,255,255,0.6);">Responsable & Fondateur de BioLink</div>
        </div>
        <div class="contact-buttons">
            <a href="https://wa.me/22900000000" target="_blank" class="btn-whatsapp">📱 WhatsApp</a>
            <a href="mailto:jeanmarcdossou77@gmail.com" class="btn-email">📧 Email</a>
        </div>
    </div>

</div>

<script>
function toggleFAQ(element) {
    const answer = element.nextElementSibling;
    const arrow = element.querySelector('.faq-arrow');
    answer.classList.toggle('active');
    arrow.classList.toggle('open');
}

function filterFAQ() {
    const search = document.getElementById('searchHelp').value.toLowerCase();
    document.querySelectorAll('.faq-item').forEach(item => {
        const question = item.querySelector('.faq-question').textContent.toLowerCase();
        const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
        item.style.display = (question.includes(search) || answer.includes(search)) ? 'block' : 'none';
    });
}
</script>

</body>
</html>