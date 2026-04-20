<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Administration</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; min-height: 100vh; }
        nav {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 40px; background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .logo { font-size: 24px; font-weight: 700; color: #00e5a0; }
        .logo span { color: white; }
        .admin-badge {
            background: rgba(255,165,0,0.2); color: #ffa500;
            padding: 4px 12px; border-radius: 20px; font-size: 12px; margin-left: 10px;
        }
        .container { padding: 30px 40px; }
        h1 { font-size: 28px; font-weight: 800; margin-bottom: 30px; }
        .stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; margin-bottom: 40px; }
        .stat-card {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; padding: 20px; text-align: center;
        }
        .stat-number { font-size: 36px; font-weight: 800; color: #00e5a0; }
        .stat-label { font-size: 12px; color: rgba(255,255,255,0.6); margin-top: 6px; }
        .stat-card.alert { border-color: rgba(255,80,80,0.4); }
        .stat-card.alert .stat-number { color: #ff5050; }
        .section { margin-bottom: 40px; }
        .section h2 { font-size: 20px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert-badge { background: #ff5050; color: white; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
        .item-card {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px; padding: 20px; margin-bottom: 12px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .item-info h3 { font-size: 16px; font-weight: 600; margin-bottom: 4px; }
        .item-info p { font-size: 13px; color: rgba(255,255,255,0.6); }
        .item-actions { display: flex; gap: 10px; }
        .btn-approve {
            background: rgba(0,229,160,0.2); border: 1px solid #00e5a0;
            color: #00e5a0; padding: 8px 16px; border-radius: 8px;
            cursor: pointer; font-size: 13px; font-weight: 600;
        }
        .btn-reject {
            background: rgba(255,80,80,0.2); border: 1px solid #ff5050;
            color: #ff5050; padding: 8px 16px; border-radius: 8px;
            cursor: pointer; font-size: 13px; font-weight: 600;
        }
        .success-msg {
            background: rgba(0,229,160,0.15); border: 1px solid rgba(0,229,160,0.3);
            padding: 12px 20px; border-radius: 10px; margin-bottom: 20px;
            color: #00e5a0; font-size: 14px;
        }
        .users-table { width: 100%; border-collapse: collapse; }
        .users-table th { text-align: left; padding: 12px; font-size: 13px; color: rgba(255,255,255,0.5); border-bottom: 1px solid rgba(255,255,255,0.1); }
        .users-table td { padding: 12px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .grade-badge { background: rgba(0,229,160,0.15); color: #00e5a0; padding: 2px 10px; border-radius: 10px; font-size: 12px; }
        .empty { text-align: center; padding: 30px; color: rgba(255,255,255,0.4); font-size: 14px; }
        form { display: inline; }
    </style>
</head>
<body>
<nav>
    <div>
        <span class="logo">Bio<span>Link</span></span>
        <span class="admin-badge">👑 Administration</span>
    </div>
    <div style="display:flex; gap:16px; align-items:center;">
        <a href="/dashboard" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px;">← Dashboard</a>
        <a href="/recherche" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px;">🔬 Recherche</a>
    </div>
</nav>

<div class="container">
    <h1>👑 Tableau de bord Administrateur</h1>

    <?php if(session('success')): ?>
        <div class="success-msg"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo e($stats['users']); ?></div>
            <div class="stat-label">👥 Utilisateurs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo e($stats['pathologies']); ?></div>
            <div class="stat-label">🦠 Pathologies</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo e($stats['remedes']); ?></div>
            <div class="stat-label">🌿 Remèdes</div>
        </div>
        <div class="stat-card alert">
            <div class="stat-number"><?php echo e($stats['remedes_en_attente']); ?></div>
            <div class="stat-label">⏳ Remèdes en attente</div>
        </div>
        <div class="stat-card alert">
            <div class="stat-number"><?php echo e($stats['pathologies_en_attente']); ?></div>
            <div class="stat-label">⏳ Pathologies en attente</div>
        </div>
    </div>

    <!-- Remèdes en attente -->
    <div class="section">
        <h2>
            🌿 Remèdes en attente de validation
            <?php if($stats['remedes_en_attente'] > 0): ?>
                <span class="alert-badge"><?php echo e($stats['remedes_en_attente']); ?></span>
            <?php endif; ?>
        </h2>

        <?php if($remedes_en_attente->count() > 0): ?>
            <?php $__currentLoopData = $remedes_en_attente; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remede): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="item-card">
                <div class="item-info">
                    <h3>🌿 <?php echo e($remede->titre); ?></h3>
                    <p>Par <?php echo e($remede->user->name); ?> — Pour : <?php echo e($remede->pathologie->nom ?? 'N/A'); ?></p>
                    <p style="margin-top:4px;"><?php echo e(Str::limit($remede->description, 120)); ?></p>
                </div>
                <div class="item-actions">
                    <form method="POST" action="/admin/remedes/<?php echo e($remede->id); ?>/approuver">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-approve">✅ Approuver</button>
                    </form>
                    <form method="POST" action="/admin/remedes/<?php echo e($remede->id); ?>/rejeter">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn-reject">❌ Rejeter</button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="empty">✅ Aucun remède en attente de validation !</div>
        <?php endif; ?>
    </div>

    <!-- Pathologies en attente -->
    <div class="section">
        <h2>
            🦠 Pathologies en attente
            <?php if($stats['pathologies_en_attente'] > 0): ?>
                <span class="alert-badge"><?php echo e($stats['pathologies_en_attente']); ?></span>
            <?php endif; ?>
        </h2>

        <?php if($pathologies_en_attente->count() > 0): ?>
            <?php $__currentLoopData = $pathologies_en_attente; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pathologie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="item-card">
                <div class="item-info">
                    <h3>🦠 <?php echo e($pathologie->nom); ?></h3>
                    <p>Par <?php echo e($pathologie->user->name); ?> — Catégorie : <?php echo e($pathologie->categorie); ?></p>
                </div>
                <div class="item-actions">
                    <form method="POST" action="/admin/pathologies/<?php echo e($pathologie->id); ?>/approuver">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-approve">✅ Approuver</button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="empty">✅ Aucune pathologie en attente !</div>
        <?php endif; ?>
    </div>

    <!-- Derniers utilisateurs -->
    <div class="section">
        <h2>👥 Derniers membres inscrits</h2>
        <table class="users-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Points</th>
                    <th>Grade</th>
                    <th>Inscrit le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $derniers_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td>⭐ <?php echo e($user->points); ?></td>
                    <td><span class="grade-badge">Niveau <?php echo e($user->grade_id); ?></span></td>
                    <td><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                    <td>
                        <?php if(!$user->is_admin): ?>
                        <form method="POST" action="/admin/users/<?php echo e($user->id); ?>/make-admin">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn-approve" style="font-size:11px; padding:4px 10px;">👑 Admin</button>
                        </form>
                        <?php else: ?>
                            <span style="color:#ffa500; font-size:12px;">👑 Admin</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html><?php /**PATH C:\laragon\www\biolink\resources\views/admin/index.blade.php ENDPATH**/ ?>