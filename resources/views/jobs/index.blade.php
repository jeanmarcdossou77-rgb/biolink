<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    @include('components.head')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Offres d'emploi</title>
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
        .hero { text-align: center; padding: 50px 20px 30px; }
        .hero h1 { font-size: 38px; font-weight: 800; margin-bottom: 12px; }
        .hero h1 span { color: #00e5a0; }
        .hero p { color: rgba(255,255,255,0.6); font-size: 16px; margin-bottom: 30px; }
        .btn-publier {
            background: #00e5a0; color: #0a1628;
            padding: 12px 28px; border-radius: 25px;
            font-weight: 700; text-decoration: none; font-size: 15px;
        }
        .container { max-width: 1100px; margin: 0 auto; padding: 30px 20px; }
        .filters { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 30px; }
        .filter-btn {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.8); padding: 6px 16px;
            border-radius: 20px; font-size: 13px; cursor: pointer;
            transition: all 0.2s; text-decoration: none;
        }
        .filter-btn:hover, .filter-btn.active { border-color: #00e5a0; color: #00e5a0; }
        .jobs-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }
        .job-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; padding: 24px;
            transition: all 0.3s;
        }
        .job-card:hover { border-color: #00e5a0; transform: translateY(-4px); }
        .job-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
        .job-categorie { background: rgba(0,229,160,0.15); color: #00e5a0; padding: 3px 10px; border-radius: 10px; font-size: 12px; }
        .job-type { background: rgba(55,138,221,0.15); color: #378ADD; padding: 3px 10px; border-radius: 10px; font-size: 12px; }
        .job-titre { font-size: 17px; font-weight: 700; margin-bottom: 6px; }
        .job-entreprise { font-size: 14px; color: #00e5a0; margin-bottom: 8px; }
        .job-lieu { font-size: 13px; color: rgba(255,255,255,0.5); margin-bottom: 12px; }
        .job-desc { font-size: 13px; color: rgba(255,255,255,0.7); line-height: 1.6; margin-bottom: 16px; }
        .job-footer { display: flex; justify-content: space-between; align-items: center; }
        .job-salaire { font-size: 13px; color: #ffa500; font-weight: 600; }
        .btn-postuler {
            background: rgba(0,229,160,0.2); border: 1px solid #00e5a0;
            color: #00e5a0; padding: 7px 16px; border-radius: 8px;
            font-size: 13px; font-weight: 600; text-decoration: none;
        }
        .empty { text-align: center; padding: 80px 20px; color: rgba(255,255,255,0.4); }
        .success-msg {
            background: rgba(0,229,160,0.15); border: 1px solid rgba(0,229,160,0.3);
            padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; color: #00e5a0;
        }
    </style>
</head>
<body>
<nav>
    <a href="/" class="logo">Bio<span>Link</span></a>
    <div style="display:flex; gap:20px; align-items:center;">
        <a href="/recherche" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px;">🔬 Pathologies</a>
        <a href="/ia" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px;">🤖 IA</a>
        <a href="/dashboard" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px;">← Dashboard</a>
    </div>
</nav>

<div class="hero">
    <h1>💼 Offres d'<span>emploi</span></h1>
    <p>Biologie, Phytothérapie, Santé naturelle — Trouvez votre prochain poste</p>
    <a href="/jobs/create" class="btn-publier">+ Publier une offre</a>
</div>

<div class="container">

    @if(session('success'))
        <div class="success-msg">{{ session('success') }}</div>
    @endif

    <div class="filters">
        <span class="filter-btn active">Tous</span>
        @foreach($categories as $cat)
            <span class="filter-btn">{{ $cat }}</span>
        @endforeach
    </div>

    @if($jobs->count() > 0)
        <div class="jobs-grid">
            @foreach($jobs as $job)
            <div class="job-card">
                <div class="job-header">
                    <span class="job-categorie">{{ $job->categorie }}</span>
                    <span class="job-type">{{ $job->type }}</span>
                </div>
                <div class="job-titre">{{ $job->titre }}</div>
                <div class="job-entreprise">🏢 {{ $job->entreprise }}</div>
                <div class="job-lieu">📍 {{ $job->lieu }}</div>
                <div class="job-desc">{{ Str::limit($job->description, 120) }}</div>
                <div class="job-footer">
                    <span class="job-salaire">
                        {{ $job->salaire ? '💰 '.$job->salaire : '💰 Selon profil' }}
                    </span>
                    <a href="mailto:{{ $job->email_contact }}" class="btn-postuler">📩 Postuler</a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="empty">
            <div style="font-size:64px; margin-bottom:20px;">💼</div>
            <h3 style="font-size:22px; color:rgba(255,255,255,0.7); margin-bottom:10px;">Aucune offre disponible</h3>
            <p>Soyez le premier à publier une offre d'emploi sur BioLink !</p>
            <a href="/jobs/create" style="display:inline-block; margin-top:20px; background:#00e5a0; color:#0a1628; padding:12px 28px; border-radius:25px; font-weight:700; text-decoration:none;">+ Publier une offre</a>
        </div>
    @endif

</div>
</body>
</html>