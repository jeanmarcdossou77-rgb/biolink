<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
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

    <?php if(session('success')): ?>
        <div class="success-msg"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <!-- Header profil -->
    <div class="profile-header">
        <div class="avatar-large"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?></div>
        <div class="profile-info">
            <h1><?php echo e(Auth::user()->name); ?></h1>
            <div class="grade-tag">
                <?php echo e(Auth::user()->nom_grade['emoji']); ?> <?php echo e(Auth::user()->nom_grade['nom']); ?> — Niveau <?php echo e(Auth::user()->grade_id); ?>

            </div>
            <div style="font-size:13px; color:rgba(255,255,255,0.5);">
                📧 <?php echo e(Auth::user()->email); ?> · Membre depuis <?php echo e(Auth::user()->created_at->format('d/m/Y')); ?>

            </div>
            <div class="profile-stats">
                <div class="profile-stat">
                    <div class="profile-stat-num"><?php echo e(Auth::user()->publications_validees); ?></div>
                    <div class="profile-stat-label">Publications</div>
                </div>
                <div class="profile-stat">
                    <div class="profile-stat-num"><?php echo e(Auth::user()->points); ?></div>
                    <div class="profile-stat-label">Points</div>
                </div>
                <div class="profile-stat">
                    <div class="profile-stat-num"><?php echo e(Auth::user()->grade_id); ?>/5</div>
                    <div class="profile-stat-label">Grade</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire profil -->
    <div class="form-card">
        <div class="section-title">✏️ Modifier mon profil</div>
        <form method="POST" action="/profil/update">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="form-grid">
                <div class="form-group">
                    <label>Nom complet</label>
                    <input type="text" name="name" value="<?php echo e(Auth::user()->name); ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo e(Auth::user()->email); ?>">
                </div>
                <div class="form-group">
                    <label>Âge</label>
                    <input type="number" name="age" value="<?php echo e(Auth::user()->age); ?>" placeholder="Votre âge">
                </div>
                <div class="form-group">
                    <label>Sexe</label>
                    <select name="sexe">
                        <option value="non_precise" <?php echo e(Auth::user()->sexe == 'non_precise' ? 'selected' : ''); ?>>Non précisé</option>
                        <option value="homme" <?php echo e(Auth::user()->sexe == 'homme' ? 'selected' : ''); ?>>Homme</option>
                        <option value="femme" <?php echo e(Auth::user()->sexe == 'femme' ? 'selected' : ''); ?>>Femme</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Poids (kg)</label>
                    <input type="number" name="poids" value="<?php echo e(Auth::user()->poids); ?>" placeholder="Ex: 70">
                </div>
                <div class="form-group">
                    <label>Taille (cm)</label>
                    <input type="number" name="taille" value="<?php echo e(Auth::user()->taille); ?>" placeholder="Ex: 175">
                </div>
            </div>
            <div class="form-group">
                <label>État de santé général</label>
                <textarea name="etat_sante" placeholder="Décrivez votre état de santé général..."><?php echo e(Auth::user()->etat_sante); ?></textarea>
            </div>
            <button type="submit" class="btn-save">💾 Sauvegarder</button>
        </form>
    </div>

    <!-- Attestations -->
    <?php if(Auth::user()->grade_id >= 3): ?>
    <div class="attestation-card">
        <div class="attestation-icon">🎓</div>
        <div class="attestation-title">Attestation BioLink disponible !</div>
        <div class="attestation-desc">
            Félicitations ! Votre grade <?php echo e(Auth::user()->nom_grade['nom']); ?> vous donne droit à une attestation officielle BioLink.
        </div>
        <a href="/attestation/<?php echo e(Auth::user()->id); ?>" class="btn-download">📜 Télécharger mon attestation</a>
    </div>
    <?php else: ?>
    <div class="attestation-card" style="border-color: rgba(255,255,255,0.1); background: rgba(255,255,255,0.03);">
        <div class="attestation-icon">🔒</div>
        <div class="attestation-title" style="color: rgba(255,255,255,0.5);">Attestation non disponible</div>
        <div class="attestation-desc">
            Atteignez le grade <strong>Chercheur Actif</strong> (30 publications validées) pour débloquer votre attestation officielle BioLink.
        </div>
        <div style="background: rgba(255,255,255,0.05); border-radius: 10px; padding: 10px; font-size: 13px; color: rgba(255,255,255,0.5);">
            📝 <?php echo e(Auth::user()->publications_validees); ?> / 30 publications validées
        </div>
    </div>
    <?php endif; ?>

</div>
</body>
</html><?php /**PATH C:\laragon\www\biolink\resources\views/profil.blade.php ENDPATH**/ ?>