<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – La science biologique à votre service</title>
    <meta name="description" content="Découvrez les soins naturels personnalisés selon votre pathologie. BioLink — plateforme collaborative de santé naturelle.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; }
        .hero {
            text-align: center; padding: 100px 20px 80px;
            background: radial-gradient(ellipse at top, rgba(0,229,160,0.1) 0%, transparent 60%);
        }
        .hero-badge {
            display: inline-block;
            background: rgba(0,229,160,0.15);
            border: 1px solid rgba(0,229,160,0.3);
            color: #00e5a0; padding: 6px 20px;
            border-radius: 25px; font-size: 13px; margin-bottom: 30px;
        }
        .hero h1 { font-size: 58px; font-weight: 800; line-height: 1.2; margin-bottom: 20px; }
        .hero h1 span { color: #00e5a0; }
        .hero p { font-size: 19px; color: rgba(255,255,255,0.7); max-width: 620px; margin: 0 auto 40px; line-height: 1.7; }
        .hero-btns { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; margin-bottom: 60px; }
        .btn-primary { background: #00e5a0; color: #0a1628; padding: 15px 36px; border-radius: 30px; font-weight: 700; font-size: 16px; text-decoration: none; transition: transform 0.2s; }
        .btn-primary:hover { transform: translateY(-3px); }
        .btn-secondary { border: 1px solid rgba(255,255,255,0.3); color: white; padding: 15px 36px; border-radius: 30px; font-size: 16px; text-decoration: none; transition: border-color 0.3s; }
        .btn-secondary:hover { border-color: #00e5a0; color: #00e5a0; }
        .stats { display: flex; justify-content: center; gap: 50px; flex-wrap: wrap; padding: 50px 20px; border-top: 1px solid rgba(255,255,255,0.08); border-bottom: 1px solid rgba(255,255,255,0.08); }
        .stat { text-align: center; }
        .stat-num { font-size: 44px; font-weight: 800; color: #00e5a0; }
        .stat-label { font-size: 14px; color: rgba(255,255,255,0.5); margin-top: 4px; }
        .section { padding: 80px 20px; max-width: 1200px; margin: 0 auto; }
        .section-title { text-align: center; font-size: 36px; font-weight: 800; margin-bottom: 12px; }
        .section-sub { text-align: center; color: rgba(255,255,255,0.6); font-size: 16px; margin-bottom: 50px; }
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .feature-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 18px; padding: 30px;
            transition: all 0.3s;
        }
        .feature-card:hover { border-color: #00e5a0; transform: translateY(-4px); }
        .feature-icon { font-size: 38px; margin-bottom: 16px; }
        .feature-titre { font-size: 18px; font-weight: 700; margin-bottom: 10px; }
        .feature-desc { font-size: 14px; color: rgba(255,255,255,0.6); line-height: 1.7; }
        .pathologies-preview { padding: 80px 20px; background: rgba(255,255,255,0.02); }
        .pathologies-preview h2 { text-align: center; font-size: 32px; font-weight: 800; margin-bottom: 12px; }
        .pathologies-preview p { text-align: center; color: rgba(255,255,255,0.6); margin-bottom: 40px; }
        .categories-grid { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; max-width: 900px; margin: 0 auto 40px; }
        .cat-badge {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.15);
            padding: 8px 18px; border-radius: 25px;
            font-size: 14px; color: rgba(255,255,255,0.8);
            text-decoration: none; transition: all 0.2s;
        }
        .cat-badge:hover { border-color: #00e5a0; color: #00e5a0; }
        .grades-section { padding: 80px 20px; max-width: 900px; margin: 0 auto; }
        .grades-timeline { display: flex; justify-content: space-between; align-items: center; position: relative; margin-top: 50px; }
        .grades-timeline::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 2px; background: rgba(255,255,255,0.1); z-index: 0; }
        .grade-step { text-align: center; position: relative; z-index: 1; flex: 1; }
        .grade-circle {
            width: 70px; height: 70px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; margin: 0 auto 12px;
            border: 2px solid rgba(255,255,255,0.2);
            background: #0a1628;
        }
        .grade-circle.active { border-color: #00e5a0; background: rgba(0,229,160,0.1); }
        .grade-name { font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.7); }
        .grade-req { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 4px; }
        .cta-section {
            padding: 80px 20px; text-align: center;
            background: radial-gradient(ellipse at center, rgba(0,229,160,0.1) 0%, transparent 70%);
        }
        .cta-section h2 { font-size: 40px; font-weight: 800; margin-bottom: 16px; }
        .cta-section p { font-size: 17px; color: rgba(255,255,255,0.7); margin-bottom: 36px; }
        .testimonials { padding: 80px 20px; max-width: 1000px; margin: 0 auto; }
        .testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .testimonial-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; padding: 24px;
        }
        .testimonial-text { font-size: 14px; color: rgba(255,255,255,0.8); line-height: 1.7; margin-bottom: 16px; font-style: italic; }
        .testimonial-author { display: flex; align-items: center; gap: 10px; }
        .testimonial-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #00e5a0, #378ADD); display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; color: #0a1628; }
        .testimonial-name { font-size: 13px; font-weight: 600; }
        .testimonial-grade { font-size: 11px; color: #00e5a0; }
        footer {
            background: rgba(255,255,255,0.03);
            border-top: 1px solid rgba(255,255,255,0.1);
            padding: 50px 60px 30px;
        }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 40px; }
        .footer-logo { font-size: 28px; font-weight: 700; color: #00e5a0; margin-bottom: 12px; }
        .footer-logo span { color: white; }
        .footer-desc { font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7; }
        .footer-title { font-size: 13px; font-weight: 700; color: white; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 1px; }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a { color: rgba(255,255,255,0.5); text-decoration: none; font-size: 13px; transition: color 0.2s; }
        .footer-links a:hover { color: #00e5a0; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); padding-top: 24px; display: flex; justify-content: space-between; align-items: center; }
        .footer-bottom p { font-size: 12px; color: rgba(255,255,255,0.4); }
        @media(max-width:768px) {
            .hero h1 { font-size: 36px; }
            .features-grid { grid-template-columns: 1fr; }
            .testimonials-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .grades-timeline { flex-direction: column; gap: 20px; }
            .grades-timeline::before { display: none; }
        }
    </style>
</head>
<body>

<?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Hero -->
<section class="hero">
    <div class="hero-badge">🧬 Plateforme scientifique collaborative mondiale</div>
    <h1>La science biologique<br><span>à votre service</span></h1>
    <p>Découvrez les soins naturels personnalisés selon votre pathologie, votre âge, votre poids et votre état de santé. Gratuit, scientifique et communautaire.</p>
    <div class="hero-btns">
        <a href="/register" class="btn-primary">🌿 Rejoindre gratuitement</a>
        <a href="/recherche" class="btn-secondary">🔬 Explorer les pathologies</a>
    </div>
</section>

<!-- Stats -->
<div class="stats">
    <div class="stat">
        <div class="stat-num"><?php echo e(\App\Models\Pathologie::where('approuve', true)->count()); ?>+</div>
        <div class="stat-label">Pathologies référencées</div>
    </div>
    <div class="stat">
        <div class="stat-num"><?php echo e(\App\Models\User::count()); ?></div>
        <div class="stat-label">Membres actifs</div>
    </div>
    <div class="stat">
        <div class="stat-num">100%</div>
        <div class="stat-label">Gratuit à la base</div>
    </div>
    <div class="stat">
        <div class="stat-num">5</div>
        <div class="stat-label">Niveaux de grades</div>
    </div>
    <div class="stat">
        <div class="stat-num">∞</div>
        <div class="stat-label">Remèdes naturels</div>
    </div>
</div>

<!-- Features -->
<div class="section">
    <div class="section-title">Pourquoi choisir BioLink ?</div>
    <div class="section-sub">Une plateforme complète pour votre santé naturelle</div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🔬</div>
            <div class="feature-titre">Recherche personnalisée</div>
            <div class="feature-desc">Trouvez les remèdes adaptés à votre pathologie, poids, âge, sexe et état de santé général en quelques secondes.</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">✅</div>
            <div class="feature-titre">Validé scientifiquement</div>
            <div class="feature-desc">Tous les remèdes sont soumis à validation par notre équipe. Chaque contenu porte la mention "Approuvé par BioLink".</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🤖</div>
            <div class="feature-titre">Assistant IA intégré</div>
            <div class="feature-desc">Posez vos questions santé à notre assistant IA disponible 24h/24 pour vous orienter vers les bons remèdes naturels.</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">👥</div>
            <div class="feature-titre">Communauté scientifique</div>
            <div class="feature-desc">Rejoignez des milliers de chercheurs, biologistes et phytothérapeutes qui partagent leurs connaissances.</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🎓</div>
            <div class="feature-titre">Grades et attestations</div>
            <div class="feature-desc">Progressez de Débutant à Leader Scientifique et obtenez des attestations officielles téléchargeables en PDF.</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">💼</div>
            <div class="feature-titre">Job Board spécialisé</div>
            <div class="feature-desc">Trouvez ou publiez des offres d'emploi dans la biologie, phytothérapie et santé naturelle en Afrique et dans le monde.</div>
        </div>
    </div>
</div>

<!-- Catégories -->
<div class="pathologies-preview">
    <h2>🦠 336+ Pathologies référencées</h2>
    <p>Toutes les spécialités médicales couvertes — de la cardiologie aux maladies tropicales africaines</p>
    <div class="categories-grid">
        <?php
        $categories = ['Cardiologie','Neurologie','Pneumologie','Gastroentérologie','Endocrinologie','Dermatologie','Rhumatologie','Ophtalmologie','ORL','Urologie','Gynécologie','Pédiatrie','Oncologie','Psychiatrie','Infectiologie','Hématologie','Virologie','Bactériologie','Parasitologie','Maladies tropicales','Nutrition','Orthopédie','Allergologie','Métabolisme','Maladies génétiques','Maladies auto-immunes'];
        ?>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="/recherche?categorie=<?php echo e($cat); ?>" class="cat-badge"><?php echo e($cat); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div style="text-align:center;">
        <a href="/recherche" class="btn-primary">🔬 Explorer toutes les pathologies</a>
    </div>
</div>

<!-- Grades -->
<div class="grades-section">
    <div class="section-title">🎓 Système de grades BioLink</div>
    <div class="section-sub">Progressez et faites reconnaître votre expertise scientifique</div>
    <div class="grades-timeline">
        <div class="grade-step">
            <div class="grade-circle active">🌱</div>
            <div class="grade-name">Débutant</div>
            <div class="grade-req">Inscription</div>
        </div>
        <div class="grade-step">
            <div class="grade-circle">🌿</div>
            <div class="grade-name">Contributeur</div>
            <div class="grade-req">10 publications</div>
        </div>
        <div class="grade-step">
            <div class="grade-circle">🔬</div>
            <div class="grade-name">Chercheur</div>
            <div class="grade-req">30 publications</div>
        </div>
        <div class="grade-step">
            <div class="grade-circle">⭐</div>
            <div class="grade-name">Expert</div>
            <div class="grade-req">60 publications</div>
        </div>
        <div class="grade-step">
            <div class="grade-circle">🏆</div>
            <div class="grade-name">Leader</div>
            <div class="grade-req">Reconnu Admin</div>
        </div>
    </div>
</div>

<!-- Témoignages -->
<div class="testimonials">
    <div class="section-title" style="text-align:center; margin-bottom:12px;">💬 Ce que disent nos membres</div>
    <div class="section-sub">Des milliers de personnes font confiance à BioLink</div>
    <div class="testimonials-grid">
        <div class="testimonial-card">
            <div class="testimonial-text">"BioLink m'a aidé à trouver un remède naturel contre mon diabète de type 2. Les informations sont claires et scientifiquement validées."</div>
            <div class="testimonial-author">
                <div class="testimonial-avatar">K</div>
                <div>
                    <div class="testimonial-name">Kofi Mensah</div>
                    <div class="testimonial-grade">🔬 Chercheur Actif — Ghana</div>
                </div>
            </div>
        </div>
        <div class="testimonial-card">
            <div class="testimonial-text">"En tant que phytothérapeute, BioLink est devenu mon outil principal. La base de données est impressionnante avec toutes les plantes africaines."</div>
            <div class="testimonial-author">
                <div class="testimonial-avatar">A</div>
                <div>
                    <div class="testimonial-name">Aminata Diallo</div>
                    <div class="testimonial-grade">⭐ Expert — Sénégal</div>
                </div>
            </div>
        </div>
        <div class="testimonial-card">
            <div class="testimonial-text">"L'assistant IA de BioLink est remarquable. Il m'a orienté vers les bons remèdes pour le paludisme en quelques secondes. Révolutionnaire !"</div>
            <div class="testimonial-author">
                <div class="testimonial-avatar">J</div>
                <div>
                    <div class="testimonial-name">Jean-Marc Dossou</div>
                    <div class="testimonial-grade">👑 Leader Scientifique — Bénin</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Final -->
<div class="cta-section">
    <h2>Prêt à rejoindre BioLink ? 🌍</h2>
    <p>Rejoignez la communauté mondiale de la santé naturelle. Gratuit pour toujours à la base.</p>
    <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
        <a href="/register" class="btn-primary" style="font-size:17px; padding:16px 40px;">🌿 Créer mon compte gratuit</a>
        <a href="/premium" class="btn-secondary" style="font-size:17px; padding:16px 40px; border-color:#ffa500; color:#ffa500;">🌟 Découvrir Premium</a>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="footer-grid">
        <div>
            <div class="footer-logo">Bio<span>Link</span></div>
            <div class="footer-desc">La plateforme mondiale de science biologique et santé naturelle. Guérissez, apprenez, partagez.</div>
        </div>
        <div>
            <div class="footer-title">Plateforme</div>
            <ul class="footer-links">
                <li><a href="/recherche">🔬 Pathologies</a></li>
                <li><a href="/ia">🤖 Assistant IA</a></li>
                <li><a href="/jobs">💼 Emplois</a></li>
                <li><a href="/premium">🌟 Premium</a></li>
            </ul>
        </div>
        <div>
            <div class="footer-title">Communauté</div>
            <ul class="footer-links">
                <li><a href="/register">Rejoindre</a></li>
                <li><a href="/login">Se connecter</a></li>
                <li><a href="/dashboard">Dashboard</a></li>
                <li><a href="/profil">Mon profil</a></li>
            </ul>
        </div>
        <div>
            <div class="footer-title">Contact</div>
            <ul class="footer-links">
                <li><a href="#">📧 contact@biolink.com</a></li>
                <li><a href="#">📱 WhatsApp</a></li>
                <li><a href="#">🌍 Partenariats</a></li>
                <li><a href="#">📜 À propos</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2026 BioLink — Guérissez, apprenez, partagez. Tous droits réservés.</p>
        <p style="color:#00e5a0;">🌍 Plateforme mondiale de santé naturelle</p>
    </div>
</footer>

</body>
</html><?php /**PATH C:\laragon\www\biolink\resources\views/welcome.blade.php ENDPATH**/ ?>