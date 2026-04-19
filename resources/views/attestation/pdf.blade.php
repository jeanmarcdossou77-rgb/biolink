<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: white;
            color: #1a1a2e;
            width: 277mm;
            padding: 8mm 10mm;
        }
        .page {
            border: 3px solid #00b884;
            border-radius: 6px;
            width: 100%;
            padding: 7mm 10mm;
            position: relative;
        }
        .corner { position:absolute; width:6mm; height:6mm; }
        .corner.tl { top:2mm; left:2mm; border-top:2px solid #00b884; border-left:2px solid #00b884; }
        .corner.tr { top:2mm; right:2mm; border-top:2px solid #00b884; border-right:2px solid #00b884; }
        .corner.bl { bottom:2mm; left:2mm; border-bottom:2px solid #00b884; border-left:2px solid #00b884; }
        .corner.br { bottom:2mm; right:2mm; border-bottom:2px solid #00b884; border-right:2px solid #00b884; }

        /* Header */
        .header-table { width:100%; border-bottom:2px solid #00b884; padding-bottom:4mm; margin-bottom:4mm; }
        .logo { font-size:22pt; font-weight:bold; color:#00b884; }
        .logo span { color:#1a1a2e; }
        .header-title { font-size:15pt; font-weight:bold; letter-spacing:3px; text-transform:uppercase; color:#1a1a2e; text-align:center; }
        .header-sub { font-size:8.5pt; color:#666; font-style:italic; text-align:center; margin-top:1mm; }
        .header-date { font-size:7.5pt; color:#888; text-align:right; }

        /* Corps 2 colonnes avec table */
        .body-table { width:100%; margin-top:3mm; }
        .col-left { width:62%; padding-right:6mm; vertical-align:top; }
        .col-right { width:38%; padding-left:6mm; vertical-align:top; border-left:1px solid rgba(0,184,132,0.3); }

        .membre-intro { font-size:8.5pt; color:#555; margin-bottom:1.5mm; }
        .membre-nom { font-size:20pt; font-weight:bold; color:#00b884; margin-bottom:1mm; }
        .membre-souligne { border-bottom:2px dashed #00b884; padding-bottom:0.5mm; }
        .membre-profession { font-size:8.5pt; color:#666; font-style:italic; margin-bottom:2mm; }
        .reconnaissance { font-size:8.5pt; color:#444; line-height:1.7; margin-bottom:3mm; }

        /* Grade */
        .grade-table { width:100%; margin-bottom:3mm; }
        .grade-box { background:rgba(0,184,132,0.06); border:1px solid rgba(0,184,132,0.35); border-radius:5px; padding:3mm; }
        .grade-emoji { font-size:18pt; vertical-align:middle; }
        .grade-label { font-size:7.5pt; color:#666; text-transform:uppercase; letter-spacing:1px; }
        .grade-value { font-size:13pt; font-weight:bold; color:#1a1a2e; }
        .grade-level { font-size:7.5pt; color:#666; margin-top:0.5mm; }

        /* Tableau stats */
        .section-title { font-size:7.5pt; font-weight:bold; color:#1a1a2e; text-transform:uppercase; letter-spacing:1px; margin-bottom:1.5mm; padding-left:2mm; border-left:2px solid #00b884; }
        .stats-table { width:100%; border-collapse:collapse; margin-bottom:3mm; }
        .stats-table th { background:rgba(0,184,132,0.12); color:#1a1a2e; font-size:7.5pt; padding:1.5mm 2mm; text-align:left; border:1px solid rgba(0,184,132,0.25); }
        .stats-table td { font-size:8.5pt; padding:1.5mm 2mm; border:1px solid rgba(0,184,132,0.15); color:#00b884; font-weight:bold; }

        /* Pathologies */
        .path-tag { background:rgba(0,184,132,0.1); border:0.5px solid rgba(0,184,132,0.4); padding:0.5mm 2mm; border-radius:3px; font-size:7pt; color:#1a1a2e; margin:0.5mm; display:inline-block; }

        /* Colonne droite */
        .info-box { background:rgba(0,184,132,0.05); border:1px solid rgba(0,184,132,0.2); border-radius:5px; padding:3mm; margin-bottom:3mm; font-size:7.5pt; color:#444; line-height:1.8; }
        .cert-num-label { font-size:7.5pt; color:#666; text-align:center; margin-bottom:1mm; }
        .cert-num { font-size:8pt; font-weight:bold; color:#00b884; font-family:monospace; text-align:center; margin-bottom:3mm; }

        /* Cachet et signature */
        .sig-table { width:100%; margin-top:3mm; }
        .cachet-cell { width:30mm; text-align:center; vertical-align:middle; }
        .cachet { width:26mm; height:26mm; border:2.5px solid #00b884; border-radius:50%; padding:2mm; text-align:center; display:inline-block; }
        .cachet-text { font-size:6pt; color:#00b884; font-weight:bold; line-height:1.5; }
        .sig-cell { vertical-align:bottom; padding-left:3mm; }
        .sig-line { border-top:1px solid #1a1a2e; width:50mm; margin-bottom:1mm; }
        .sig-name { font-size:10pt; font-weight:bold; color:#1a1a2e; }
        .sig-title { font-size:7.5pt; color:#555; margin-top:0.5mm; }
        .sig-contact { font-size:7pt; color:#888; margin-top:0.5mm; }

        /* Footer */
        .footer-table { width:100%; border-top:1px solid rgba(0,184,132,0.3); padding-top:2mm; margin-top:3mm; }
        .footer-left { font-size:7pt; color:#888; }
        .footer-right { font-size:7pt; color:#aaa; font-style:italic; text-align:right; }
    </style>
</head>
<body>
<div class="page">
    <div class="corner tl"></div>
    <div class="corner tr"></div>
    <div class="corner bl"></div>
    <div class="corner br"></div>

    <!-- Header -->
    <table class="header-table" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width:25%;">
                <div class="logo">Bio<span>Link</span></div>
                <div style="font-size:7pt;color:#888;margin-top:1mm;">La science biologique</div>
            </td>
            <td style="width:50%; text-align:center;">
                <div class="header-title">Attestation Officielle</div>
                <div class="header-sub">de contribution scientifique et de reconnaissance de grade</div>
            </td>
            <td style="width:25%;">
                <div class="header-date">
                    Délivrée le {{ now()->format('d') }}
                    {{ ['','janv.','févr.','mars','avr.','mai','juin','juil.','août','sept.','oct.','nov.','déc.'][now()->month] }}
                    {{ now()->year }}<br>
                    <span style="color:#00b884;font-weight:bold;font-size:8pt;">✓ OFFICIELLE</span>
                </div>
            </td>
        </tr>
    </table>

    <!-- Corps -->
    <table class="body-table" cellpadding="0" cellspacing="0">
        <tr>
            <!-- Colonne gauche -->
            <td class="col-left">
                <div class="membre-intro">La plateforme scientifique <strong>BioLink</strong> certifie que :</div>
                <div class="membre-nom"><span class="membre-souligne">{{ $user->name }}</span></div>

                @if($user->profession || $user->domaine_etude)
                <div class="membre-profession">
                    {{ $user->profession }}
                    @if($user->domaine_etude) · {{ $user->domaine_etude }}@endif
                    @if($user->pays) · {{ $user->pays }}@endif
                </div>
                @endif

                <div class="reconnaissance">
                    est officiellement reconnu(e) comme membre actif et contributeur(trice)
                    de la communauté scientifique mondiale BioLink, ayant démontré son engagement
                    envers la science biologique et la santé naturelle africaine.
                </div>

                <!-- Grade -->
                <table class="grade-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <div class="grade-box">
                                <table cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="width:12mm; vertical-align:middle;">
                                            <span class="grade-emoji">{{ $user->nom_grade['emoji'] }}</span>
                                        </td>
                                        <td style="vertical-align:middle;">
                                            <div class="grade-label">Grade officiel obtenu</div>
                                            <div class="grade-value">{{ $user->nom_grade['nom'] }}</div>
                                            <div class="grade-level">Niveau {{ $user->grade_id }} / 5</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>

                <!-- Stats horizontaux -->
                <div class="section-title">📊 Contributions scientifiques</div>
                <table class="stats-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <th>Publications validées</th>
                        <th>Points scientifiques</th>
                        <th>Membre depuis</th>
                        <th>Statut</th>
                    </tr>
                    <tr>
                        <td>{{ $user->publications_validees }}</td>
                        <td>{{ $user->points }} pts</td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>{{ $user->is_premium ? '🌟 Premium' : 'Standard' }}</td>
                    </tr>
                </table>

                @if(isset($pathologiesPubliees) && count($pathologiesPubliees) > 0)
                <div class="section-title" style="margin-top:2mm;">🔬 Domaines de contribution</div>
                <div style="margin-top:1.5mm;">
                    @foreach($pathologiesPubliees as $path)
                        <span class="path-tag">{{ $path }}</span>
                    @endforeach
                </div>
                @endif
            </td>

            <!-- Colonne droite -->
            <td class="col-right">
                <div class="info-box">
                    ✅ Identité vérifiée<br>
                    ✅ Contributions validées<br>
                    ✅ Grade officiel accordé<br>
                    ✅ Certifié par le fondateur<br>
                    ✅ Document authentique BioLink
                </div>

                <div class="cert-num-label">Numéro de certificat</div>
                <div class="cert-num">
                    BL-{{ strtoupper(substr(md5($user->id . $user->created_at), 0, 8)) }}-{{ now()->year }}
                </div>

                <div style="font-size:7.5pt;color:#444;font-style:italic;text-align:center;margin-bottom:4mm;">
                    Cette attestation est générée<br>et certifiée par BioLink
                </div>

                <!-- Signature -->
                <table class="sig-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="cachet-cell">
                            <div class="cachet">
                                <div class="cachet-text">
                                    <div style="font-size:11pt;">✓</div>
                                    <div>BIO</div>
                                    <div>LINK</div>
                                    <div style="font-size:5pt;">CERTIFIÉ</div>
                                </div>
                            </div>
                        </td>
                        <td class="sig-cell">
                            <div class="sig-line"></div>
                            <div class="sig-name">DOSSOU Jean-Marc</div>
                            <div class="sig-title">Responsable Biologique & Fondateur de BioLink</div>
                            <div class="sig-contact">📱 +229 62 97 61 86</div>
                            <div class="sig-contact">📧 jeanmarcdossou77@gmail.com</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <table class="footer-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="footer-left">🌍 biolink-production-c2ce.up.railway.app · La science biologique à votre service</td>
            <td class="footer-right">Document officiel · © BioLink {{ now()->year }} · Tous droits réservés</td>
        </tr>
    </table>
</div>
</body>
</html>