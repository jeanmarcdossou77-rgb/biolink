<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BioLink – Fil d'actualité</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; }
        .layout { display: grid; grid-template-columns: 280px 1fr 280px; gap: 20px; max-width: 1200px; margin: 0 auto; padding: 20px; }
        .sidebar { position: sticky; top: 80px; height: fit-content; }
        .sidebar-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 20px; margin-bottom: 16px; }
        .sidebar-title { font-size: 14px; font-weight: 700; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px; }
        .user-mini { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .user-mini:last-child { border-bottom: none; }
        .avatar-sm { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #00e5a0, #378ADD); display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; color: #0a1628; overflow: hidden; flex-shrink: 0; }
        .avatar-sm img { width: 100%; height: 100%; object-fit: cover; }
        .user-mini-name { font-size: 13px; font-weight: 600; }
        .user-mini-grade { font-size: 11px; color: rgba(255,255,255,0.5); }
        .btn-add { background: rgba(0,229,160,0.15); border: 1px solid rgba(0,229,160,0.3); color: #00e5a0; padding: 4px 10px; border-radius: 10px; font-size: 11px; cursor: pointer; text-decoration: none; margin-left: auto; }
        .post-composer { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 20px; margin-bottom: 20px; }
        .composer-header { display: flex; gap: 12px; align-items: flex-start; }
        .composer-avatar { width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #00e5a0, #378ADD); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #0a1628; overflow: hidden; flex-shrink: 0; }
        .composer-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .composer-input { flex: 1; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15); border-radius: 25px; padding: 12px 20px; color: white; font-size: 15px; outline: none; resize: none; transition: all 0.3s; min-height: 50px; font-family: inherit; }
        .composer-input:focus { border-color: #00e5a0; min-height: 100px; }
        .composer-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 12px; }
        .composer-tools { display: flex; gap: 12px; }
        .tool-btn { background: none; border: none; color: rgba(255,255,255,0.6); cursor: pointer; font-size: 20px; padding: 6px; border-radius: 8px; transition: all 0.2s; }
        .tool-btn:hover { background: rgba(255,255,255,0.1); color: white; }
        .btn-post { background: #00e5a0; color: #0a1628; border: none; padding: 10px 24px; border-radius: 20px; font-size: 14px; font-weight: 700; cursor: pointer; }
        .image-preview { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 12px; }
        .preview-item { position: relative; }
        .preview-item img { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; }
        .preview-remove { position: absolute; top: -6px; right: -6px; background: #ff5050; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; display: flex; align-items: center; justify-content: center; }
        .post-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; margin-bottom: 16px; overflow: hidden; transition: border-color 0.3s; }
        .post-card:hover { border-color: rgba(255,255,255,0.2); }
        .post-header { display: flex; align-items: center; gap: 12px; padding: 16px; }
        .post-avatar { width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #00e5a0, #378ADD); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #0a1628; overflow: hidden; flex-shrink: 0; }
        .post-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .post-user-name { font-size: 15px; font-weight: 700; }
        .post-user-grade { font-size: 12px; color: #00e5a0; }
        .post-time { font-size: 12px; color: rgba(255,255,255,0.4); margin-left: auto; }
        .post-content { padding: 0 16px 16px; font-size: 15px; line-height: 1.7; color: rgba(255,255,255,0.9); }
        .post-images { display: grid; gap: 2px; margin-bottom: 12px; }
        .post-images.one img { width: 100%; max-height: 400px; object-fit: cover; }
        .post-images.two { grid-template-columns: 1fr 1fr; }
        .post-images.two img { height: 200px; object-fit: cover; width: 100%; }
        .post-images.three { grid-template-columns: 2fr 1fr; grid-template-rows: 1fr 1fr; }
        .post-images.three img:first-child { grid-row: 1 / 3; height: 300px; object-fit: cover; width: 100%; }
        .post-images.three img { height: 150px; object-fit: cover; width: 100%; }
        .post-actions { display: flex; gap: 4px; padding: 8px 12px; border-top: 1px solid rgba(255,255,255,0.07); }
        .action-btn { display: flex; align-items: center; gap: 6px; background: none; border: none; color: rgba(255,255,255,0.6); cursor: pointer; padding: 8px 16px; border-radius: 8px; font-size: 14px; transition: all 0.2s; flex: 1; justify-content: center; }
        .action-btn:hover { background: rgba(255,255,255,0.08); color: white; }
        .action-btn.liked { color: #ff5050; }
        .comments-section { padding: 12px 16px; border-top: 1px solid rgba(255,255,255,0.07); display: none; }
        .comments-section.active { display: block; }
        .comment-item { display: flex; gap: 10px; margin-bottom: 12px; }
        .comment-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #00e5a0, #378ADD); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #0a1628; overflow: hidden; flex-shrink: 0; }
        .comment-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .comment-bubble { background: rgba(255,255,255,0.07); border-radius: 12px; padding: 10px 14px; flex: 1; }
        .comment-user { font-size: 13px; font-weight: 700; margin-bottom: 4px; }
        .comment-text { font-size: 14px; color: rgba(255,255,255,0.8); }
        .comment-time { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 4px; }
        .comment-input-row { display: flex; gap: 8px; margin-top: 12px; }
        .comment-input { flex: 1; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15); border-radius: 20px; padding: 8px 16px; color: white; font-size: 14px; outline: none; }
        .comment-input:focus { border-color: #00e5a0; }
        .comment-send { background: #00e5a0; border: none; color: #0a1628; padding: 8px 16px; border-radius: 20px; cursor: pointer; font-weight: 700; font-size: 13px; }
        .success-msg { background: rgba(0,229,160,0.15); border: 1px solid rgba(0,229,160,0.3); padding: 12px 20px; border-radius: 10px; margin-bottom: 16px; color: #00e5a0; font-size: 14px; }
        .empty-feed { text-align: center; padding: 60px 20px; color: rgba(255,255,255,0.4); }
        .nav-link-side { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; color: rgba(255,255,255,0.8); text-decoration: none; font-size: 14px; transition: all 0.2s; margin-bottom: 4px; }
        .nav-link-side:hover { background: rgba(255,255,255,0.08); color: white; }
        .nav-link-side.active { background: rgba(0,229,160,0.15); color: #00e5a0; }
        .badge-count { background: #ff5050; color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px; margin-left: auto; }
        @media(max-width: 900px) { .layout { grid-template-columns: 1fr; } .sidebar { display: none; } }
    </style>
</head>
<body>

@include('components.navbar')

<div class="layout">

    <!-- Sidebar gauche -->
    <div class="sidebar">
        <div class="sidebar-card">
            <div style="text-align:center; margin-bottom:16px;">
                <div class="composer-avatar" style="margin:0 auto 10px; width:60px; height:60px; font-size:24px;">
                    @if(Auth::user()->photo_profil)
                        <img src="{{ Storage::url(Auth::user()->photo_profil) }}" alt="">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <div style="font-size:15px; font-weight:700;">{{ Auth::user()->name }}</div>
                <div style="font-size:12px; color:#00e5a0;">{{ Auth::user()->nom_grade['emoji'] }} {{ Auth::user()->nom_grade['nom'] }}</div>
                <div style="font-size:12px; color:rgba(255,255,255,0.5); margin-top:4px;">{{ Auth::user()->points }} points</div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; text-align:center; border-top:1px solid rgba(255,255,255,0.1); padding-top:12px;">
                <div>
                    <div style="font-size:20px; font-weight:700; color:#00e5a0;">{{ Auth::user()->amis_count }}</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.5);">Amis</div>
                </div>
                <div>
                    <div style="font-size:20px; font-weight:700; color:#00e5a0;">{{ Auth::user()->posts()->count() }}</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.5);">Publications</div>
                </div>
            </div>
        </div>

        <div class="sidebar-card">
            <div class="sidebar-title">Navigation</div>
            <a href="/feed" class="nav-link-side active">🏠 Fil d'actualité</a>
            <a href="/friends/requests" class="nav-link-side">👥 Demandes d'amis</a>
            <a href="/messages" class="nav-link-side">💬 Messages</a>
            <a href="/groups" class="nav-link-side">👨‍👩‍👧 Groupes</a>
            <a href="/recherche" class="nav-link-side">🔬 Pathologies</a>
            <a href="/ia" class="nav-link-side">🤖 Assistant IA</a>
            <a href="/jobs" class="nav-link-side">💼 Emplois</a>
            <a href="/aide" class="nav-link-side">❓ Aide</a>
        </div>
    </div>

    <!-- Contenu principal -->
    <div>
        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        <!-- Compositeur de publication -->
        <div class="post-composer">
            <form method="POST" action="/posts" enctype="multipart/form-data" id="postForm">
                @csrf
                <div class="composer-header">
                    <div class="composer-avatar">
                        @if(Auth::user()->photo_profil)
                            <img src="{{ Storage::url(Auth::user()->photo_profil) }}" alt="">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <textarea name="contenu" class="composer-input" placeholder="Que se passe-t-il aujourd'hui ? Partagez vos connaissances sur la santé naturelle..."></textarea>
                </div>

                <div id="imagePreview" class="image-preview"></div>
                <input type="file" name="images[]" id="imageInput" multiple accept="image/*" style="display:none" onchange="previewImages(this)">

                <div class="composer-actions">
                    <div class="composer-tools">
                        <button type="button" class="tool-btn" onclick="document.getElementById('imageInput').click()" title="Ajouter des photos">📷</button>
                        <select name="visibilite" style="background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.15); color:white; padding:6px 12px; border-radius:10px; font-size:13px; outline:none;">
                            <option value="public">🌍 Public</option>
                            <option value="amis">👥 Amis seulement</option>
                            <option value="prive">🔒 Privé</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-post">📝 Publier</button>
                </div>
            </form>
        </div>

        <!-- Publications -->
        @if($posts->count() > 0)
            @foreach($posts as $post)
            <div class="post-card" id="post-{{ $post->id }}">
                <div class="post-header">
                    <div class="post-avatar">
                        @if($post->user->photo_profil)
                            <img src="{{ Storage::url($post->user->photo_profil) }}" alt="">
                        @else
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="post-user-name">{{ $post->user->name }}</div>
                        <div class="post-user-grade">{{ $post->user->nom_grade['emoji'] }} {{ $post->user->nom_grade['nom'] }}</div>
                    </div>
                    <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                    @if($post->user_id == Auth::id() || Auth::user()->is_admin)
                        <form method="POST" action="/posts/{{ $post->id }}" style="margin-left:8px;">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:rgba(255,255,255,0.4); cursor:pointer; font-size:16px;" onclick="return confirm('Supprimer ?')">🗑️</button>
                        </form>
                    @endif
                </div>

                @if($post->contenu)
                    <div class="post-content">{{ $post->contenu }}</div>
                @endif

                @if($post->images->count() > 0)
                    <div class="post-images {{ ['','one','two','three','three'][$post->images->count()] ?? 'three' }}">
                        @foreach($post->images->take(3) as $image)
                            <img src="{{ Storage::url($image->image_path) }}" alt="">
                        @endforeach
                    </div>
                @endif

                <div class="post-actions">
                    <button class="action-btn {{ $post->isLikedBy(Auth::id()) ? 'liked' : '' }}"
                            onclick="likePost({{ $post->id }}, this)"
                            id="like-btn-{{ $post->id }}">
                        ❤️ <span id="like-count-{{ $post->id }}">{{ $post->likes_count }}</span>
                    </button>
                    <button class="action-btn" onclick="toggleComments({{ $post->id }})">
                        💬 <span id="comment-count-{{ $post->id }}">{{ $post->comments_count }}</span>
                    </button>
                    <button class="action-btn" onclick="sharePost('{{ $post->id }}')">
                        🔗 Partager
                    </button>
                </div>

                <!-- Section commentaires -->
                <div class="comments-section" id="comments-{{ $post->id }}">
                    @foreach($post->comments as $comment)
                    <div class="comment-item">
                        <div class="comment-avatar">
                            @if($comment->user->photo_profil)
                                <img src="{{ Storage::url($comment->user->photo_profil) }}" alt="">
                            @else
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="comment-bubble">
                            <div class="comment-user">{{ $comment->user->name }} {{ $comment->user->nom_grade['emoji'] }}</div>
                            <div class="comment-text">{{ $comment->contenu }}</div>
                            <div class="comment-time">{{ $comment->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @endforeach

                    <div class="comment-input-row" id="comment-form-{{ $post->id }}">
                        <div class="comment-avatar">
                            @if(Auth::user()->photo_profil)
                                <img src="{{ Storage::url(Auth::user()->photo_profil) }}" alt="">
                            @else
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            @endif
                        </div>
                        <input type="text" class="comment-input" placeholder="Écrire un commentaire..." id="comment-input-{{ $post->id }}">
                        <button class="comment-send" onclick="sendComment({{ $post->id }})">Envoyer</button>
                    </div>
                </div>
            </div>
            @endforeach

            <div style="text-align:center; padding:20px;">
                {{ $posts->links() }}
            </div>
        @else
            <div class="empty-feed">
                <div style="font-size:64px; margin-bottom:16px;">🌿</div>
                <h3 style="font-size:22px; color:rgba(255,255,255,0.7); margin-bottom:10px;">Aucune publication</h3>
                <p>Soyez le premier à partager vos connaissances sur la santé naturelle !</p>
            </div>
        @endif
    </div>

    <!-- Sidebar droite -->
    <div class="sidebar">
        <div class="sidebar-card">
            <div class="sidebar-title">Personnes à connaître</div>
            @foreach($users as $user)
            <div class="user-mini">
                <div class="avatar-sm">
                    @if($user->photo_profil)
                        <img src="{{ Storage::url($user->photo_profil) }}" alt="">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="user-mini-name">{{ $user->name }}</div>
                    <div class="user-mini-grade">{{ $user->nom_grade['emoji'] }} {{ $user->nom_grade['nom'] }}</div>
                </div>
                @if(!Auth::user()->isFriendWith($user->id) && !Auth::user()->hasPendingRequestWith($user->id))
                    <form method="POST" action="/friends/request/{{ $user->id }}">
                        @csrf
                        <button type="submit" class="btn-add">+ Ajouter</button>
                    </form>
                @endif
            </div>
            @endforeach
        </div>

        <div class="sidebar-card">
            <div class="sidebar-title">Groupes populaires</div>
            <a href="/groups" style="display:block; text-align:center; background:rgba(0,229,160,0.15); border:1px solid rgba(0,229,160,0.3); color:#00e5a0; padding:10px; border-radius:10px; text-decoration:none; font-size:14px; font-weight:600;">
                👨‍👩‍👧 Voir tous les groupes
            </a>
            <a href="/groups/create" style="display:block; text-align:center; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:rgba(255,255,255,0.7); padding:10px; border-radius:10px; text-decoration:none; font-size:14px; margin-top:8px;">
                + Créer un groupe
            </a>
        </div>

        <div class="sidebar-card" style="background:rgba(255,80,80,0.1); border-color:rgba(255,80,80,0.3);">
            <div class="sidebar-title" style="color:#ff8080;">🆘 Urgence</div>
            <div style="font-size:13px; color:rgba(255,255,255,0.8); margin-bottom:12px;">
                Contactez le responsable BioLink :
            </div>
            <a href="https://wa.me/22962976186" target="_blank" style="display:flex; align-items:center; gap:8px; color:#25D366; text-decoration:none; font-size:14px; font-weight:600; margin-bottom:8px;">
                📱 WhatsApp
            </a>
            <a href="mailto:jeanmarcdossou77@gmail.com" style="display:flex; align-items:center; gap:8px; color:#00e5a0; text-decoration:none; font-size:13px;">
                📧 jeanmarcdossou77@gmail.com
            </a>
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

function previewImages(input) {
    const preview = document.getElementById('imagePreview');
    const files = Array.from(input.files).slice(0, 10);
    preview.innerHTML = '';
    files.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            preview.innerHTML += `
                <div class="preview-item">
                    <img src="${e.target.result}" alt="">
                    <button class="preview-remove" onclick="removeImage(${i})">×</button>
                </div>`;
        };
        reader.readAsDataURL(file);
    });
}

function removeImage(index) {
    const input = document.getElementById('imageInput');
    const dt = new DataTransfer();
    Array.from(input.files).forEach((file, i) => {
        if (i !== index) dt.items.add(file);
    });
    input.files = dt.files;
    previewImages(input);
}

function likePost(postId, btn) {
    fetch(`/posts/${postId}/like`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        btn.classList.toggle('liked', data.liked);
        document.getElementById(`like-count-${postId}`).textContent = data.count;
    });
}

function toggleComments(postId) {
    const section = document.getElementById(`comments-${postId}`);
    section.classList.toggle('active');
}

function sendComment(postId) {
    const input = document.getElementById(`comment-input-${postId}`);
    const contenu = input.value.trim();
    if (!contenu) return;

    fetch(`/posts/${postId}/comment`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
        body: JSON.stringify({ contenu })
    })
    .then(r => r.json())
    .then(data => {
        const comment = data.comment;
        const avatar = comment.user.photo
            ? `<img src="/storage/${comment.user.photo}" alt="">`
            : comment.user.name.charAt(0).toUpperCase();

        const html = `
            <div class="comment-item">
                <div class="comment-avatar">${avatar}</div>
                <div class="comment-bubble">
                    <div class="comment-user">${comment.user.name} ${comment.user.grade}</div>
                    <div class="comment-text">${comment.contenu}</div>
                    <div class="comment-time">${comment.created_at}</div>
                </div>
            </div>`;

        document.getElementById(`comment-form-${postId}`).insertAdjacentHTML('beforebegin', html);
        document.getElementById(`comment-count-${postId}`).textContent = data.count;
        input.value = '';
    });
}

function sharePost(postId) {
    navigator.clipboard.writeText(window.location.origin + '/feed#post-' + postId);
    alert('Lien copié !');
}
</script>

</body>
</html>