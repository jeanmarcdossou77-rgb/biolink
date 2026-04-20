<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; }
    .dashboard {
        min-height: 100vh;
        background: #0a1628;
        color: white;
        padding: 30px 40px;
    }
    .top-bar {
        display: flex; justify-content: space-between;
        align-items: center; margin-bottom: 30px;
    }
    .logo { font-size: 26px; font-weight: 700; color: #00e5a0; }
    .logo span { color: white; }
    .user-info { display: flex; align-items: center; gap: 16px; }
    .avatar {
        width: 44px; height: 44px; border-radius: 50%;
        background: linear-gradient(135deg, #00e5a0, #378ADD);
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; font-weight: 700; color: #0a1628;
    }
    .user-name { font-size: 15px; font-weight: 600; }
    .user-grade { font-size: 12px; color: rgba(255,255,255,0.6); }
    .btn-logout {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: white; padding: 8px 18px;
        border-radius: 20px; cursor: pointer;
        font-size: 13px; text-decoration: none;
    }
    .welcome-card {
        background: linear-gradient(135deg, rgba(0,229,160,0.15), rgba(55,138,221,0.1));
        border: 1px solid rgba(0,229,160,0.3);
        border-radius: 20px; padding: 30px;
        margin-bottom: 30px;
        display: flex; justify-content: space-between; align-items: center;
    }
    .welcome-left h1 { font-size: 26px; font-weight: 800; margin-bottom: 8px; }
    .welcome-left h1 span { color: #00e5a0; }
    .welcome-left p { color: rgba(255,255,255,0.6); font-size: 14px; }
    .grade-display {
        text-align: center;
        background: rgba(0,0,0,0.2);
        border-radius: 16px; padding: 20px 30px;
    }
    .grade-emoji { font-size: 40px; margin-bottom: 8px; }
    .grade-nom { font-size: 16px; font-weight: 700; }
    .grade-niveau { font-size: 12px; color: rgba(255,255,255,0.5); margin-top: 4px; }
    .progress-bar {
        margin-top: 10px;
        background: rgba(255,255,255,0.1);
        border-radius: 10px; height: 6px; width: 120px;
    }
    .progress-fill {
        height: 100%; border-radius: 10px;
        background: #00e5a0;
    }
    .stats-grid {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 16px; margin-bottom: 30px;
    }
    .stat-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px; padding: 20px; text-align: center;
        transition: border-color 0.3s;
    }
    .stat-card:hover { border-color: #00e5a0; }
    .stat-number { font-size: 32px; font-weight: 800; color: #00e5a0; }
    .stat-label { font-size: 12px; color: rgba(255,255,255,0.6); margin-top: 6px; }
    .main-grid {
        display: grid; grid-template-columns: 2fr 1fr;
        gap: 24px; margin-bottom: 30px;
    }
    .section-title {
        font-size: 18px; font-weight: 700;
        margin-bottom: 16px; display: flex;
        align-items: center; gap: 8px;
    }
    .actions-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .action-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 14px; padding: 20px;
        text-decoration: none; color: white;
        transition: all 0.3s; display: block;
    }
    .action-card:hover {
        border-color: #00e5a0;
        transform: translateY(-3px);
        background: rgba(0,229,160,0.07);
    }
    .action-icon { font-size: 28px; margin-bottom: 10px; }
    .action-title { font-size: 14px; font-weight: 600; margin-bottom: 4px; }
    .action-desc { font-size: 12px; color: rgba(255,255,255,0.5); }
    .grades-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px; padding: 24px;
    }
    .grade-item {
        display: flex; align-items: center;
        gap: 12px; padding: 10px 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .grade-item:last-child { border-bottom: none; }
    .grade-badge-small {
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center;
        justify-content: center; font-size: 16px;
    }
    .grade-info-name { font-size: 13px; font-weight: 600; }
    .grade-info-req { font-size: 11px; color: rgba(255,255,255,0.4); }
    .grade-actuel { color: #00e5a0; font-size: 11px; font-weight: 600; }
    .success-msg {
        background: rgba(0,229,160,0.15);
        border: 1px solid rgba(0,229,160,0.3);
        padding: 12px 20px; border-radius: 10px;
        margin-bottom: 20px; color: #00e5a0; font-size: 14px;
    }
    @media(max-width: 768px) {
        .dashboard { padding: 20px; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .main-grid { grid-template-columns: 1fr; }
        .actions-grid { grid-template-columns: 1fr; }
        .welcome-card { flex-direction: column; gap: 20px; }
    }
</style>

<div class="dashboard">

    <?php if(session('success')): ?>
        <div class="success-msg"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <!-- Top bar -->
    <div class="top-bar">
        <div class="logo">Bio<span>Link</span></div>
        <div class="user-info">
            <div class="avatar"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?></div>
            <div>
                <div class="user-name"><?php echo e(Auth::user()->name); ?></div>
                <div class="user-grade"><?php echo e(Auth::user()->nom_grade['emoji']); ?> <?php echo e(Auth::user()->nom_grade['nom']); ?></div>
            </div>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-logout">Déconnexion</button>
            </form>
            <?php if(Auth::user()->is_admin): ?>
                <a href="/admin" style="background:#ffa500; color:#0a1628; padding:8px 18px; border-radius:20px; text-decoration:none; font-size:13px; font-weight:700;">👑 Admin</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Welcome -->
    <div class="welcome-card">
        <div class="welcome-left">
            <h1>Bienvenue, <span><?php echo e(explode(' ', Auth::user()->name)[0]); ?></span> ! 👋</h1>
            <p>La science biologique à votre service – Guérissez, apprenez, partagez.</p>
            <p style="margin-top:8px; font-size:13px; color:rgba(255,255,255,0.5);">
                Membre depuis <?php echo e(Auth::user()->created_at->format('d/m/Y')); ?>

            </p>
        </div>
        <div class="grade-display">
            <div class="grade-emoji"><?php echo e(Auth::user()->nom_grade['emoji']); ?></div>
            <div class="grade-nom"><?php echo e(Auth::user()->nom_grade['nom']); ?></div>
            <div class="grade-niveau">Niveau <?php echo e(Auth::user()->grade_id); ?> / 5</div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo e((Auth::user()->grade_id / 5) * 100); ?>%"></div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo e(Auth::user()->publications_validees); ?></div>
            <div class="stat-label">📝 Publications</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo e(Auth::user()->points); ?></div>
            <div class="stat-label">⭐ Points</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo e(Auth::user()->grade_id); ?></div>
            <div class="stat-label">🎓 Niveau actuel</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo e(Auth::user()->is_premium ? '✅' : '🔓'); ?></div>
            <div class="stat-label"><?php echo e(Auth::user()->is_premium ? 'Premium' : 'Compte gratuit'); ?></div>
        </div>
    </div>

    <!-- Main grid -->
    <div class="main-grid">
        <!-- Actions -->
        <div>
            <div class="section-title">⚡ Actions rapides</div>
            <div class="actions-grid">
                <a href="/recherche" class="action-card">
                    <div class="action-icon">🔬</div>
                    <div class="action-title">Rechercher un remède</div>
                    <div class="action-desc">Trouvez le soin naturel adapté</div>
                </a>
                <a href="/remedes/create" class="action-card">
                    <div class="action-icon">🌿</div>
                    <div class="action-title">Publier un remède</div>
                    <div class="action-desc">Partagez vos connaissances</div>
                </a>
                <a href="/recherche" class="action-card">
                    <div class="action-icon">🦠</div>
                    <div class="action-title">Explorer les pathologies</div>
                    <div class="action-desc"><?php echo e(\App\Models\Pathologie::count()); ?> pathologies disponibles</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">👥</div>
                    <div class="action-title">Communauté</div>
                    <div class="action-desc"><?php echo e(\App\Models\User::count()); ?> membres actifs</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">💼</div>
                    <div class="action-title">Offres d'emploi</div>
                    <div class="action-desc">Biologie & Santé naturelle</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">🤖</div>
                    <div class="action-title">Assistant IA</div>
                    <div class="action-desc">Posez vos questions santé</div>
                </a>
            </div>
        </div>

        <!-- Grades -->
        <div>
            <div class="section-title">🎓 Système de grades</div>
            <div class="grades-card">
                <?php
                    $grades = [
                        1 => ['emoji' => '🌱', 'nom' => 'Débutant', 'req' => 'Compte créé', 'bg' => 'rgba(170,170,170,0.2)'],
                        2 => ['emoji' => '🌿', 'nom' => 'Contributeur', 'req' => '10 publications', 'bg' => 'rgba(0,229,160,0.2)'],
                        3 => ['emoji' => '🔬', 'nom' => 'Chercheur Actif', 'req' => '30 publications', 'bg' => 'rgba(55,138,221,0.2)'],
                        4 => ['emoji' => '⭐', 'nom' => 'Expert', 'req' => '60 publications', 'bg' => 'rgba(255,215,0,0.2)'],
                        5 => ['emoji' => '🏆', 'nom' => 'Leader Scientifique', 'req' => 'Reconnu par Admin', 'bg' => 'rgba(255,107,53,0.2)'],
                    ];
                ?>
                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $niveau => $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="grade-item">
                    <div class="grade-badge-small" style="background: <?php echo e($grade['bg']); ?>">
                        <?php echo e($grade['emoji']); ?>

                    </div>
                    <div style="flex:1">
                        <div class="grade-info-name"><?php echo e($grade['nom']); ?></div>
                        <div class="grade-info-req"><?php echo e($grade['req']); ?></div>
                    </div>
                    <?php if(Auth::user()->grade_id == $niveau): ?>
                        <span class="grade-actuel">← Vous</span>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\biolink\resources\views/dashboard.blade.php ENDPATH**/ ?>