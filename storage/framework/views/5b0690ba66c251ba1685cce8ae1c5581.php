<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – <?php echo e($pathologie->nom); ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; }
        nav {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 60px; background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .logo { font-size: 26px; font-weight: 700; color: #00e5a0; text-decoration: none; }
        .logo span { color: white; }
        .back-btn {
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
            color: white; padding: 8px 20px; border-radius: 20px;
            text-decoration: none; font-size: 14px;
        }
        .container { max-width: 1000px; margin: 0 auto; padding: 40px 20px; }
        .badge-categorie {
            display: inline-block; background: rgba(0,229,160,0.15);
            color: #00e5a0; padding: 6px 16px; border-radius: 20px;
            font-size: 13px; margin-bottom: 16px;
        }
        .badge-gravite-grave { background: rgba(255,80,80,0.15); color: #ff5050; padding: 6px 16px; border-radius: 20px; font-size: 13px; margin-left: 8px; }
        .badge-gravite-modérée { background: rgba(255,165,0,0.15); color: #ffa500; padding: 6px 16px; border-radius: 20px; font-size: 13px; margin-left: 8px; }
        .badge-gravite-légère { background: rgba(0,229,160,0.15); color: #00e5a0; padding: 6px 16px; border-radius: 20px; font-size: 13px; margin-left: 8px; }
        .badge-contagieux { background: rgba(255,80,80,0.15); color: #ff5050; padding: 6px 16px; border-radius: 20px; font-size: 13px; margin-left: 8px; }
        h1 { font-size: 38px; font-weight: 800; margin-bottom: 16px; }
        .description { color: rgba(255,255,255,0.7); font-size: 16px; line-height: 1.8; margin-bottom: 40px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px; }
        .info-card {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; padding: 24px;
        }
        .info-card h3 { font-size: 15px; color: #00e5a0; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
        .info-card p { font-size: 14px; color: rgba(255,255,255,0.7); line-height: 1.7; }
        .remedes-section { margin-top: 40px; }
        .remedes-section h2 { font-size: 24px; font-weight: 700; margin-bottom: 24px; }
        .remede-card {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; padding: 24px; margin-bottom: 16px;
            transition: border-color 0.3s;
        }
        .remede-card:hover { border-color: #00e5a0; }
        .remede-titre { font-size: 18px; font-weight: 700; margin-bottom: 12px; color: #00e5a0; }
        .remede-label { font-size: 12px; color: rgba(255,255,255,0.5); text-transform: uppercase; margin-bottom: 6px; }
        .remede-content { font-size: 14px; color: rgba(255,255,255,0.8); line-height: 1.7; margin-bottom: 16px; }
        .empty-remedes { text-align: center; padding: 40px; color: rgba(255,255,255,0.4); }
        .btn-publier {
            display: inline-block; background: #00e5a0; color: #0a1628;
            padding: 12px 28px; border-radius: 25px; font-weight: 700;
            text-decoration: none; margin-top: 20px;
        }
        .symptomes-list { display: flex; flex-wrap: wrap; gap: 8px; }
        .symptome-tag {
            background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15);
            padding: 4px 12px; border-radius: 20px; font-size: 13px;
            color: rgba(255,255,255,0.8);
        }
    </style>
</head>
<body>
<nav>
    <a href="/" class="logo">Bio<span>Link</span></a>
    <a href="/recherche" class="back-btn">← Retour à la recherche</a>
</nav>

<div class="container">
    <div class="badge-categorie"><?php echo e($pathologie->categorie); ?></div>
    <?php if($pathologie->gravite): ?>
        <span class="badge-gravite-<?php echo e($pathologie->gravite); ?>">⚠️ Gravité : <?php echo e($pathologie->gravite); ?></span>
    <?php endif; ?>
    <?php if($pathologie->contagieux === 'oui'): ?>
        <span class="badge-contagieux">🦠 Contagieux</span>
    <?php endif; ?>

    <h1><?php echo e($pathologie->nom); ?></h1>
    <p class="description"><?php echo e($pathologie->description); ?></p>

    <div class="info-grid">
        <div class="info-card">
            <h3>🩺 Symptômes</h3>
            <div class="symptomes-list">
                <?php $__currentLoopData = explode(',', $pathologie->symptomes); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $symptome): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="symptome-tag"><?php echo e(trim($symptome)); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <?php if($pathologie->cause): ?>
        <div class="info-card">
            <h3>🔍 Causes</h3>
            <p><?php echo e($pathologie->cause); ?></p>
        </div>
        <?php endif; ?>

        <?php if($pathologie->prevention): ?>
        <div class="info-card">
            <h3>🛡️ Prévention</h3>
            <p><?php echo e($pathologie->prevention); ?></p>
        </div>
        <?php endif; ?>

        <?php if($pathologie->traitement_naturel): ?>
        <div class="info-card" style="border-color: rgba(0,229,160,0.3);">
            <h3>🌿 Traitement naturel de base</h3>
            <p><?php echo e($pathologie->traitement_naturel); ?></p>
        </div>
        <?php endif; ?>
    </div>

    <div class="remedes-section">
        <h2>💊 Remèdes naturels validés (<?php echo e(count($remedes)); ?>)</h2>

        <?php if(count($remedes) > 0): ?>
            <?php $__currentLoopData = $remedes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remede): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="remede-card">
                <div class="remede-titre">🌿 <?php echo e($remede->titre); ?></div>
                <div class="remede-label">Description</div>
                <div class="remede-content"><?php echo e($remede->description); ?></div>
                <div class="remede-label">Ingrédients</div>
                <div class="remede-content"><?php echo e($remede->ingredients); ?></div>
                <div class="remede-label">Préparation</div>
                <div class="remede-content"><?php echo e($remede->preparation); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="empty-remedes">
                <div style="font-size:48px; margin-bottom:16px;">🌿</div>
                <p>Aucun remède validé pour cette pathologie encore.</p>
                <p>Soyez le premier à en publier un !</p>
                <?php if(auth()->guard()->check()): ?>
                    <a href="/remedes/create?pathologie=<?php echo e($pathologie->id); ?>" class="btn-publier">+ Publier un remède</a>
                <?php else: ?>
                    <a href="/register" class="btn-publier">Rejoindre BioLink pour publier</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html><?php /**PATH C:\laragon\www\biolink\resources\views/pathologie/show.blade.php ENDPATH**/ ?>