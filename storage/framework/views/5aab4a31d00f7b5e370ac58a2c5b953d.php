<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: #fff;
            color: #1a1a2e;
        }
        .page {
            width: 100%;
            min-height: 550px;
            padding: 40px;
            border: 12px solid #00c48c;
            position: relative;
        }
        .corner {
            position: absolute;
            width: 60px;
            height: 60px;
            border-color: #00c48c;
            border-style: solid;
        }
        .corner-tl { top: 10px; left: 10px; border-width: 4px 0 0 4px; }
        .corner-tr { top: 10px; right: 10px; border-width: 4px 4px 0 0; }
        .corner-bl { bottom: 10px; left: 10px; border-width: 0 0 4px 4px; }
        .corner-br { bottom: 10px; right: 10px; border-width: 0 4px 4px 0; }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #00c48c;
        }
        .logo-text {
            font-size: 42px;
            font-weight: bold;
            color: #00c48c;
            letter-spacing: 4px;
        }
        .logo-text span { color: #1a1a2e; }
        .slogan {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
            font-style: italic;
        }
        .title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #1a1a2e;
            margin: 20px 0 10px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        .subtitle {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }
        .body {
            text-align: center;
            padding: 20px 60px;
        }
        .certifie {
            font-size: 15px;
            color: #444;
            margin-bottom: 16px;
        }
        .nom {
            font-size: 36px;
            font-weight: bold;
            color: #00c48c;
            margin: 10px 0;
            border-bottom: 2px dotted #00c48c;
            padding-bottom: 8px;
            display: inline-block;
        }
        .grade-section {
            margin: 20px 0;
            padding: 16px 40px;
            background: #f0faf6;
            border-radius: 10px;
            border: 1px solid #00c48c;
            display: inline-block;
        }
        .grade-titre { font-size: 13px; color: #666; margin-bottom: 4px; }
        .grade-nom { font-size: 24px; font-weight: bold; color: #1a1a2e; }
        .stats-row {
            display: table;
            width: 100%;
            margin: 20px 0;
        }
        .stat-box {
            display: table-cell;
            width: 33%;
            text-align: center;
            padding: 10px;
            border-right: 1px solid #ddd;
        }
        .stat-box:last-child { border-right: none; }
        .stat-num { font-size: 28px; font-weight: bold; color: #00c48c; }
        .stat-label { font-size: 11px; color: #888; margin-top: 2px; }
        .footer {
            margin-top: 30px;
            display: table;
            width: 100%;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .footer-left {
            display: table-cell;
            width: 50%;
            text-align: left;
            vertical-align: bottom;
        }
        .footer-right {
            display: table-cell;
            width: 50%;
            text-align: right;
            vertical-align: bottom;
        }
        .signature-line {
            border-top: 2px solid #1a1a2e;
            width: 180px;
            margin-bottom: 6px;
        }
        .signature-name { font-size: 13px; font-weight: bold; color: #1a1a2e; }
        .signature-title { font-size: 11px; color: #888; }
        .date-box {
            background: #f0faf6;
            border: 1px solid #00c48c;
            border-radius: 8px;
            padding: 8px 16px;
            display: inline-block;
            font-size: 13px;
            color: #444;
        }
        .numero {
            font-size: 10px;
            color: #aaa;
            text-align: center;
            margin-top: 10px;
        }
        .dna-decor {
            font-size: 60px;
            position: absolute;
            opacity: 0.05;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
<div class="page">
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>
    <div class="dna-decor">🧬</div>

    <div class="header">
        <div class="logo-text">Bio<span>Link</span></div>
        <div class="slogan">La science biologique à votre service – Guérissez, apprenez, partagez.</div>
    </div>

    <div class="title">Attestation officielle</div>
    <div class="subtitle">de contribution scientifique</div>

    <div class="body">
        <div class="certifie">La plateforme scientifique BioLink certifie que</div>
        <div class="nom"><?php echo e($user->name); ?></div>

        <div style="font-size:14px; color:#444; margin: 16px 0;">
            est reconnu(e) membre actif de la communauté BioLink avec le grade de
        </div>

        <div class="grade-section">
            <div class="grade-titre">Grade obtenu</div>
            <div class="grade-nom"><?php echo e($grade['nom']); ?></div>
        </div>

        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-num"><?php echo e($user->publications_validees); ?></div>
                <div class="stat-label">Publications validées</div>
            </div>
            <div class="stat-box">
                <div class="stat-num"><?php echo e($user->points); ?></div>
                <div class="stat-label">Points obtenus</div>
            </div>
            <div class="stat-box">
                <div class="stat-num"><?php echo e($user->grade_id); ?>/5</div>
                <div class="stat-label">Niveau atteint</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="footer-left">
            <div class="signature-line"></div>
            <div class="signature-name">Responsable BioLink</div>
            <div class="signature-title">Direction scientifique</div>
        </div>
        <div class="footer-right">
            <div class="date-box">📅 Délivré le <?php echo e($date); ?></div>
        </div>
    </div>

    <div class="numero">
        N° BioLink-<?php echo e(str_pad($user->id, 6, '0', STR_PAD_LEFT)); ?>-<?php echo e(now()->format('Y')); ?> |
        www.biolink.com | Attestation vérifiable en ligne
    </div>
</div>
</body>
</html><?php /**PATH C:\laragon\www\biolink\resources\views/attestation/pdf.blade.php ENDPATH**/ ?>