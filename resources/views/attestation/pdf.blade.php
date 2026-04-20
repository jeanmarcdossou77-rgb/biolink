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
            width: 297mm;
            height: 210mm;
            padding: 10mm 14mm;
        }
        .page {
            border: 3px solid #00b884;
            border-radius: 8px;
            width: 100%;
            height: 190mm;
            padding: 8mm 12mm;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        /* Coins décoratifs */
        .c { position:absolute; width:7mm; height:7mm; }
        .c.tl { top:3mm; left:3mm; border-top:2px solid #00b884; border-left:2px solid #00b884; }
        .c.tr { top:3mm; right:3mm; border-top:2px solid #00b884; border-right:2px solid #00b884; }
        .c.bl { bottom:3mm; left:3mm; border-bottom:2px solid #00b884; border-left:2px solid #00b884; }
        .c.br { bottom:3mm; right:3mm; border-bottom:2px solid #00b884; border-right:2px solid #00b884; }
        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #00b884;
            padding-bottom: 4mm;
            margin-bottom: 4mm;
        }
        .logo { font-size: 26pt; font-weight: bold; color: #00b884; }
        .logo span { color: #1a1a2e; }
        .header-center { text-align: center; flex: 1; }
        .header-center h1 { font-size: 16pt; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; color: #1a1a2e; }
        .header-center p { font-size: 9pt; color: #666; margin-top: 1mm; font-style: italic; }
        .header-right { text-align: right; font-size: 8pt; color: #888; }
        /* Corps — 2 colonnes */
        .body { display: flex; gap: 8mm; flex: 1; }
        .col-left { flex: 1.2; }
        .col-right { flex: 0.8; border-left: 1px solid rgba(0,184,132,0.3); padding-left: 8mm; display: flex; flex-direction: column; }
        /* Membre */
        .membre-intro { font-size: 9pt; color: #555; margin-bottom: 2mm; }
        .membre-nom { font-size: 22pt; font-weight: bold; color: #00b884; margin: 2mm 0; }
        .membre-souligne { border-bottom: 2px dashed #00b884; padding-bottom: 1mm; display: inline-block; }
        .membre-profession { font-size: 9pt; color: #666; font-style: italic; margin-bottom: 2mm; }
        .reconnaissance { font-size: 9pt; color: #444; line-height: 1.7; margin-bottom: 3mm; }
        /* Grade */
        .grade-box {
            background: linear-gradient(135deg, rgba(0,184,132,0.08), rgba(55,138,221,0.06));
            border: 1px solid rgba(0,184,132,0.4);
            border-radius: 6px;
            padding: 3mm 5mm;
            margin-bottom: 3mm;
            display: flex;
            align-items: center;
            gap: 4mm;
        }
        .grade-emoji { font-size: 20pt; }
        .grade-label { font-size: 8pt; color: #666; text-transform: uppercase; letter-spacing: 1px; }
        .grade-value { font-size: 14pt; font-weight: bold; color: #1a1a2e; }
        /* Tableau stats horizontal */
        .stats-table { width: 100%; border-collapse: collapse; margin-bottom: 3mm; }
        .stats-table th {
            background: rgba(0,184,132,0.12);
            color: #1a1a2e;
            font-size: 8pt;
            padding: 2mm 3mm;
            text-align: left;
            border: 1px solid rgba(0,184,132,0.25);
        }
        .stats-table td {
            font-size: 9pt;
            padding: 2mm 3mm;
            border: 1px solid rgba(0,184,132,0.15);
            color: #00b884;
            font-weight: bold;
        }
        .stats-table tr:nth-child(even) td { background: rgba(0,184,132,0.03); }
        /* Pathologies */
        .section-title { font-size: 8pt; font-weight: bold; color: #1a1a2e; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2mm; border-left: 2px solid #00b884; padding-left: 2mm; }
        .path-tags { display: flex; flex-wrap: wrap; gap: 1.5mm; }
        .path-tag { background: rgba(0,184,132,0.1); border: 0.5px solid rgba(0,184,132,0.4); padding: 0.8mm 2.5mm; border-radius: 3px; font-size: 7.5pt; color: #1a1a2e; }
        /* Signature */
        .signature-area { margin-top: auto; }
        .cachet-sig { display: flex; align-items: center; gap: 5mm; margin-top: 3mm; }
        .cachet {
            width: 28mm; height: 28mm;
            border: 2px solid #00b884;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 6.5pt;
            color: #00b884;
            font-weight: bold;
            text-align: center;
            line-height: 1.4;
            flex-shrink: 0;
        }
        .sig-block { text-align: center; }
        .sig-line { border-top: 1px solid #1a1a2e; width: 50mm; margin: 1.5mm auto; }
        .sig-name { font-size: 10pt; font-weight: bold; color: #1a1a2e; }
        .sig-title { font-size: 7.5pt; color: #666; margin-top: 0.5mm; }
        .sig-contact { font-size: 7pt; color: #888; margin-top: 0.5mm; }
        /* Footer */
        .footer {
            border-top: 1px solid rgba(0,184,132,0.3);
            padding-top: 2mm;
            margin-top: 2mm;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer-left { font-size: 7.5pt; color: #888; }
        .footer-right { font-size: 7.5pt; color: #aaa; font-style: italic; }
        .num-cert { font-size: 7pt; color: #aaa; text-align: center; margin-top: 1mm; }
    </style>
</head>
<body>
<div class="page">
    <!-- Coins -->
    <div class="c tl"></div>
    <div class="c tr"></div>
    <div class="c bl"></div>
    <div class="c br"></div>

    <!-- Header -->
    <div class="header">
        <div class="logo">Bio<span>Link</span></div>
        <div class="header-center">
            <h1>Attestation Officielle</h1>
            <p>de contribution scientifique et de reconnaissance de grade</p>
        </div>
        <div class="header-right">
            Délivrée le {{ now()->format('d') }}<br>
            {{ ['','janv.','févr.','mars','avr.','mai','juin','juil.','août','sept.','oct.','nov.','déc.'][now()->month] }} {{ now()->year }}<br>
            <span style="color:#00b884;font-weight:bold;">OFFICIELLE</span>
        </div>
    </div>

    <!-- Corps en 2 colonnes -->
    <div class="body">

        <!-- Colonne gauche -->
        <div class="col-left">
            <div class="membre-intro">La plateforme scientifique <strong>BioLink</strong> certifie que :</div>

            <div class="membre-nom">
                <span class="membre-souligne">{{ $user->name }}</span>
            </div>

            @if($user->profession || $user->domaine_etude)
            <div class="membre-profession">
                {{ $user->profession }}@if($user->domaine_etude) · {{ $user->domaine_etude }}@endif
                @if($user->pays) · 🌍 {{ $user->pays }}@endif
            </div>
            @endif

            <div class="reconnaissance">
                est officiellement reconnu(e) comme membre actif et contributeur(trice)
                de la communauté scientifique mondiale BioLink, ayant démontré son
                engagement envers la science biologique et la santé naturelle africaine.
            </div>

            <!-- Grade -->
            <div class="grade-box">
                <div class="grade-emoji">{{ $user->nom_grade['emoji'] }}</div>
                <div>
                    <div class="grade-label">Grade officiel obtenu</div>
                    <div class="grade-value">{{ $user->nom_grade['nom'] }}</div>
                    <div style="font-size:7.5pt;color:#666;">Niveau {{ $user->grade_id }} / 5</div>
                </div>
            </div>

            <!-- Tableau contributions HORIZONTAL -->
            <div class="section-title" style="margin-bottom:2mm;">📊 Contributions scientifiques</div>
            <table class="stats-table">
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
            <div class="path-tags">
                @foreach($pathologiesPubliees as $path)
                <span class="path-tag">{{ $path }}</span>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Colonne droite -->
        <div class="col-right">
            <div style="font-size:8pt;color:#666;margin-bottom:3mm;text-align:center;font-style:italic;">
                Cette attestation est générée et certifiée<br>par la plateforme BioLink
            </div>

            <div style="background:rgba(0,184,132,0.06);border:1px solid rgba(0,184,132,0.2);border-radius:6px;padding:3mm;margin-bottom:4mm;font-size:8pt;color:#444;line-height:1.7;">
                ✅ Identité vérifiée<br>
                ✅ Contributions validées<br>
                ✅ Grade officiel accordé<br>
                ✅ Certifié par le fondateur<br>
                ✅ Document authentique BioLink
            </div>

            <div style="text-align:center;margin-bottom:3mm;">
                <div style="font-size:8pt;color:#666;margin-bottom:2mm;">Numéro de certificat</div>
                <div style="font-size:8pt;font-weight:bold;color:#00b884;font-family:monospace;">
                    BL-{{ strtoupper(substr(md5($user->id . $user->created_at), 0, 8)) }}-{{ now()->year }}
                </div>
            </div>

            <!-- Signature -->
            <div class="signature-area">
                <div class="cachet-sig">
                    <div class="cachet">
                        <div style="font-size:10pt;">✓</div>
                        <div>BIO</div>
                        <div>LINK</div>
                        <div style="font-size:5.5pt;">CERTIFIÉ</div>
                    </div>
                    <div class="sig-block">
                        <div class="sig-line"></div>
                        <div class="sig-name">DOSSOU Jean-Marc</div>
                        <div class="sig-title">Responsable Biologique & Fondateur de BioLink</div>
                        <div class="sig-contact">📱 +229 62 97 61 86</div>
                        <div class="sig-contact">📧 jeanmarcdossou77@gmail.com</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-left">
            🌍 biolink-production-c2ce.up.railway.app · La science biologique à votre service
        </div>
        <div class="footer-right">
            Document officiel · © BioLink {{ now()->year }} · Tous droits réservés
        </div>
    </div>
</div>
</body>
</html>