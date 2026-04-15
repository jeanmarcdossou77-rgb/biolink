<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: white;
            color: #1a1a2e;
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 20mm;
        }
        .border-outer {
            border: 3px solid #00b884;
            border-radius: 8px;
            padding: 12mm 15mm;
            min-height: 267mm;
            position: relative;
        }
        .border-inner {
            border: 1px solid rgba(0,184,132,0.4);
            border-radius: 4px;
            padding: 10mm 12mm;
            min-height: 247mm;
            display: flex;
            flex-direction: column;
        }
        .header { text-align: center; border-bottom: 2px solid #00b884; padding-bottom: 8mm; margin-bottom: 8mm; }
        .logo { font-size: 32pt; font-weight: bold; color: #00b884; letter-spacing: 2px; }
        .logo span { color: #1a1a2e; }
        .tagline { font-size: 10pt; color: #555; margin-top: 3mm; font-style: italic; }
        .attest-title { text-align: center; margin: 6mm 0; }
        .attest-title h1 { font-size: 20pt; font-weight: bold; letter-spacing: 4px; color: #1a1a2e; text-transform: uppercase; }
        .attest-title p { font-size: 11pt; color: #555; margin-top: 3mm; }
        .divider { border: none; border-top: 1px solid rgba(0,184,132,0.4); margin: 5mm 0; }
        .intro-text { text-align: center; font-size: 11pt; color: #444; margin: 4mm 0; }
        .nom-membre { text-align: center; margin: 6mm 0; }
        .nom-membre h2 { font-size: 28pt; font-weight: bold; color: #00b884; }
        .nom-membre .souligne { display: inline-block; border-bottom: 2px dashed #00b884; padding-bottom: 2mm; min-width: 180mm; text-align: center; }
        .nom-membre .profession { font-size: 12pt; color: #666; margin-top: 3mm; font-style: italic; }
        .reconnaissance { text-align: center; font-size: 11pt; color: #444; margin: 4mm 0; line-height: 1.8; }
        .grade-box {
            background: linear-gradient(135deg, rgba(0,184,132,0.08), rgba(55,138,221,0.08));
            border: 1px solid rgba(0,184,132,0.4);
            border-radius: 8px;
            padding: 6mm 10mm;
            text-align: center;
            margin: 6mm auto;
            max-width: 120mm;
        }
        .grade-label { font-size: 9pt; color: #666; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 2mm; }
        .grade-value { font-size: 18pt; font-weight: bold; color: #1a1a2e; }
        .grade-emoji { font-size: 24pt; margin-bottom: 2mm; }
        .stats-section { margin: 5mm 0; }
        .stats-title { font-size: 11pt; font-weight: bold; color: #1a1a2e; margin-bottom: 3mm; border-left: 3px solid #00b884; padding-left: 3mm; }
        .stats-grid { display: table; width: 100%; border-collapse: collapse; }
        .stats-row { display: table-row; }
        .stats-cell { display: table-cell; padding: 3mm 4mm; border: 1px solid rgba(0,184,132,0.2); font-size: 10pt; }
        .stats-cell.label { background: rgba(0,184,132,0.05); font-weight: bold; width: 60mm; color: #333; }
        .stats-cell.value { color: #00b884; font-weight: bold; }
        .pathologies-section { margin: 4mm 0; }
        .path-list { font-size: 10pt; color: #444; line-height: 1.8; }
        .path-item { display: inline-block; background: rgba(0,184,132,0.1); border: 1px solid rgba(0,184,132,0.3); padding: 1mm 4mm; border-radius: 4px; margin: 1mm; font-size: 9pt; }
        .signature-section {
            margin-top: auto;
            padding-top: 6mm;
            border-top: 1px solid rgba(0,184,132,0.3);
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .sig-left { font-size: 9pt; color: #666; }
        .sig-right { text-align: center; }
        .sig-name { font-size: 13pt; font-weight: bold; color: #1a1a2e; }
        .sig-title { font-size: 9pt; color: #666; margin-top: 1mm; }
        .sig-line { border-top: 1px solid #1a1a2e; width: 60mm; margin: 2mm auto; }
        .cachet {
            width: 35mm; height: 35mm;
            border: 2px solid #00b884;
            border-radius: 50%;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            margin: 0 auto 2mm;
            font-size: 7pt; color: #00b884; text-align: center; font-weight: bold;
            line-height: 1.3;
        }
        .date-delivrance { text-align: center; font-size: 9pt; color: #666; margin: 3mm 0; font-style: italic; }
        .numero-cert { text-align: center; font-size: 8pt; color: #aaa; margin-top: 2mm; }
        .corner-tl { position: absolute; top: 5mm; left: 5mm; width: 8mm; height: 8mm; border-top: 2px solid #00b884; border-left: 2px solid #00b884; }
        .corner-tr { position: absolute; top: 5mm; right: 5mm; width: 8mm; height: 8mm; border-top: 2px solid #00b884; border-right: 2px solid #00b884; }
        .corner-bl { position: absolute; bottom: 5mm; left: 5mm; width: 8mm; height: 8mm; border-bottom: 2px solid #00b884; border-left: 2px solid #00b884; }
        .corner-br { position: absolute; bottom: 5mm; right: 5mm; width: 8mm; height: 8mm; border-bottom: 2px solid #00b884; border-right: 2px solid #00b884; }
    </style>
</head>
<body>
<div class="border-outer">
    <!-- Coins décoratifs -->
    <div class="corner-tl"></div>
    <div class="corner-tr"></div>
    <div class="corner-bl"></div>
    <div class="corner-br"></div>

    <div class="border-inner">
        <!-- En-tête -->
        <div class="header">
            <div class="logo">Bio<span>Link</span></div>
            <div class="tagline">La science biologique à votre service – Guérissez, apprenez, partagez.</div>
            <div style="font-size:9pt;color:#888;margin-top:2mm;">Plateforme mondiale de santé naturelle · biolink-production-c2ce.up.railway.app</div>
        </div>

        <!-- Titre -->
        <div class="attest-title">
            <h1>Attestation Officielle</h1>
            <p>de contribution scientifique et de reconnaissance de grade</p>
        </div>

        <hr class="divider">

        <!-- Corps -->
        <div class="intro-text">
            La plateforme scientifique collaborative <strong>BioLink</strong>, représentée par son fondateur,<br>
            certifie officiellement que :
        </div>

        <div class="nom-membre">
            <div class="souligne">
                <h2>{{ $user->name }}</h2>
            </div>
            @if($user->profession)
            <div class="profession">{{ $user->profession }}@if($user->domaine_etude) · {{ $user->domaine_etude }}@endif @if($user->pays) · {{ $user->pays }}@endif</div>
            @endif
        </div>

        <div class="reconnaissance">
            est officiellement reconnu(e) comme membre actif et contributeur(trice) de la communauté BioLink,<br>
            ayant démontré son engagement envers la science biologique et la santé naturelle.
        </div>

        <!-- Grade -->
        <div class="grade-box">
            <div class="grade-emoji">{{ $user->nom_grade['emoji'] }}</div>
            <div class="grade-label">Grade officiel obtenu</div>
            <div class="grade-value">{{ $user->nom_grade['nom'] }}</div>
            <div style="font-size:9pt;color:#666;margin-top:1mm;">Niveau {{ $user->grade_id }} sur 5</div>
        </div>

        <!-- Statistiques -->
        <div class="stats-section">
            <div class="stats-title">📊 Contributions scientifiques</div>
            <div class="stats-grid">
                <div class="stats-row">
                    <div class="stats-cell label">Nombre de publications validées</div>
                    <div class="stats-cell value">{{ $user->publications_validees }} publication(s)</div>
                </div>
                <div class="stats-row">
                    <div class="stats-cell label">Points scientifiques accumulés</div>
                    <div class="stats-cell value">{{ $user->points }} points</div>
                </div>
                <div class="stats-row">
                    <div class="stats-cell label">Membre depuis</div>
                    <div class="stats-cell value">{{ $user->created_at->format('d/m/Y') }}</div>
                </div>
                <div class="stats-row">
                    <div class="stats-cell label">Statut d'abonnement</div>
                    <div class="stats-cell value">{{ $user->is_premium ? '🌟 Membre Premium' : 'Membre Standard' }}</div>
                </div>
            </div>
        </div>

        <!-- Pathologies publiées -->
        @if(isset($pathologiesPubliees) && count($pathologiesPubliees) > 0)
        <div class="pathologies-section">
            <div class="stats-title">🔬 Domaines de contribution (pathologies publiées)</div>
            <div class="path-list">
                @foreach($pathologiesPubliees as $path)
                    <span class="path-item">{{ $path }}</span>
                @endforeach
            </div>
        </div>
        @endif

        <div class="date-delivrance">
            Attestation délivrée le {{ now()->format('d') }} {{ ['','janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'][now()->month] }} {{ now()->year }}
        </div>

        <div class="numero-cert">
            N° de certificat : BL-{{ strtoupper(substr(md5($user->id . $user->created_at), 0, 12)) }}-{{ now()->year }}
        </div>

        <!-- Signature -->
        <div class="signature-section">
            <div class="sig-left">
                <div style="font-size:10pt;color:#444;margin-bottom:1mm;">Cette attestation certifie officiellement</div>
                <div style="font-size:9pt;color:#666;">la contribution de ce membre à BioLink.</div>
                <div style="font-size:9pt;color:#00b884;margin-top:1mm;">biolink-production-c2ce.up.railway.app</div>
            </div>

            <div class="sig-right">
                <div class="cachet">
                    <div>✓</div>
                    <div>BIO</div>
                    <div>LINK</div>
                    <div>OFFICIEL</div>
                </div>
                <div class="sig-line"></div>
                <div class="sig-name">DOSSOU Jean-Marc</div>
                <div class="sig-title">Fondateur & Directeur de BioLink</div>
                <div style="font-size:8pt;color:#888;margin-top:1mm;">📱 +229 62 97 61 86</div>
                <div style="font-size:8pt;color:#888;">📧 jeanmarcdossou77@gmail.com</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>