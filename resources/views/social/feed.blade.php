<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BioLink – Fil d'actualité</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        html,body { font-family:'Segoe UI',sans-serif; background:#0a1628; color:white; min-height:100vh; }
        .layout { display:grid; grid-template-columns:260px 1fr 260px; gap:16px; max-width:1100px; margin:0 auto; padding:16px; }
        .sidebar { position:sticky; top:10px; height:fit-content; }
        .sidebar-card { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:14px; padding:16px; margin-bottom:12px; }
        .sidebar-title { font-size:11px; font-weight:700; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:1px; margin-bottom:12px; }
        .nav-link-side { display:flex; align-items:center; gap:10px; padding:9px 10px; border-radius:10px; color:rgba(255,255,255,0.8); text-decoration:none; font-size:13px; transition:all 0.2s; margin-bottom:2px; }
        .nav-link-side:hover,.nav-link-side.active { background:rgba(0,229,160,0.12); color:#00e5a0; }
        .user-card { display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid rgba(255,255,255,0.05); }
        .user-card:last-child { border-bottom:none; }
        .av { width:38px; height:38px; border-radius:50%; background:linear-gradient(135deg,#00e5a0,#378ADD); display:flex; align-items:center; justify-content:center; font-size:15px; font-weight:700; color:#0a1628; overflow:hidden; flex-shrink:0; }
        .av img { width:100%; height:100%; object-fit:cover; }
        .av-sm { width:32px; height:32px; font-size:12px; border-radius:50%; background:linear-gradient(135deg,#00e5a0,#378ADD); display:flex; align-items:center; justify-content:center; font-weight:700; color:#0a1628; overflow:hidden; flex-shrink:0; }
        .av-sm img { width:100%; height:100%; object-fit:cover; }
        .av-lg { width:44px; height:44px; font-size:18px; border-radius:50%; background:linear-gradient(135deg,#00e5a0,#378ADD); display:flex; align-items:center; justify-content:center; font-weight:700; color:#0a1628; overflow:hidden; flex-shrink:0; }
        .av-lg img { width:100%; height:100%; object-fit:cover; }
        .btn-add { background:rgba(0,229,160,0.15); border:1px solid rgba(0,229,160,0.3); color:#00e5a0; padding:4px 10px; border-radius:10px; font-size:11px; cursor:pointer; text-decoration:none; }
        /* Composer */
        .composer { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:16px; padding:16px; margin-bottom:14px; }
        .composer-row { display:flex; gap:10px; align-items:flex-start; }
        .composer-input { flex:1; background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.15); border-radius:22px; padding:10px 18px; color:white; font-size:14px; outline:none; resize:none; min-height:44px; max-height:200px; font-family:inherit; line-height:1.6; overflow-y:auto; }
        .composer-input:focus { border-color:#00e5a0; }
        .composer-input::placeholder { color:rgba(255,255,255,0.4); }
        .composer-footer { display:flex; justify-content:space-between; align-items:center; margin-top:10px; flex-wrap:wrap; gap:8px; }
        .composer-tools { display:flex; gap:6px; align-items:center; flex-wrap:wrap; }
        .tool-btn { background:none; border:none; color:rgba(255,255,255,0.6); cursor:pointer; font-size:18px; padding:6px 8px; border-radius:8px; transition:all 0.2s; }
        .tool-btn:hover { background:rgba(255,255,255,0.1); color:white; }
        .emoji-picker-btn { font-size:18px; cursor:pointer; padding:6px 8px; border-radius:8px; background:none; border:none; transition:all 0.2s; }
        .emoji-picker-btn:hover { background:rgba(255,255,255,0.1); }
        .emoji-panel { display:none; background:#0d1f35; border:1px solid rgba(255,255,255,0.15); border-radius:12px; padding:10px; flex-wrap:wrap; gap:4px; max-width:280px; }
        .emoji-panel.open { display:flex; }
        .emoji-btn { font-size:20px; cursor:pointer; padding:4px; border-radius:6px; border:none; background:none; transition:all 0.2s; }
        .emoji-btn:hover { background:rgba(255,255,255,0.1); transform:scale(1.2); }
        .btn-post { background:#00e5a0; color:#0a1628; border:none; padding:10px 22px; border-radius:20px; font-size:14px; font-weight:700; cursor:pointer; transition:transform 0.2s; }
        .btn-post:hover { transform:translateY(-2px); }
        .preview-grid { display:flex; flex-wrap:wrap; gap:8px; margin-top:10px; }
        .preview-item { position:relative; }
        .preview-item img { width:72px; height:72px; object-fit:cover; border-radius:10px; border:2px solid rgba(0,229,160,0.3); }
        .preview-remove { position:absolute; top:-6px; right:-6px; background:#ff5050; color:white; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer; font-size:12px; display:flex; align-items:center; justify-content:center; }
        .visib-select { background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.15); color:white; padding:6px 12px; border-radius:10px; font-size:12px; outline:none; }
        .visib-select option { background:#0a1628; }
        /* Post card */
        .post-card { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:16px; margin-bottom:14px; overflow:hidden; transition:border-color 0.3s; }
        .post-card:hover { border-color:rgba(255,255,255,0.2); }
        .post-head { display:flex; align-items:center; gap:10px; padding:14px 16px 0; }
        .post-name { font-size:14px; font-weight:700; }
        .post-grade { font-size:11px; color:#00e5a0; }
        .post-time { font-size:11px; color:rgba(255,255,255,0.4); margin-left:auto; }
        .post-body { padding:10px 16px 14px; font-size:14px; line-height:1.8; color:rgba(255,255,255,0.9); white-space:pre-wrap; word-break:break-word; }
        .post-body-truncated { overflow:hidden; }
        .post-body-truncated.collapsed { max-height: 120px; -webkit-mask-image: linear-gradient(to bottom, black 60%, transparent 100%); mask-image: linear-gradient(to bottom, black 60%, transparent 100%); }
        .voir-plus-btn { background:none; border:none; color:#00e5a0; font-size:13px; font-weight:600; cursor:pointer; padding:4px 0 8px 16px; display:block; }
        .voir-plus-btn:hover { text-decoration:underline; }
        .post-body a { color: #378ADD; text-decoration: none; }
        .post-body a:hover { text-decoration: underline; }
        /* Images grille */
        .post-imgs { overflow:hidden; margin-bottom:2px; }
        .post-imgs.c1 img { width:100%; max-height:380px; object-fit:cover; display:block; }
        .post-imgs.c2 { display:grid; grid-template-columns:1fr 1fr; gap:2px; }
        .post-imgs.c2 img { height:200px; width:100%; object-fit:cover; display:block; }
        .post-imgs.c3 { display:grid; grid-template-columns:2fr 1fr; gap:2px; }
        .post-imgs.c3 img:first-child { height:300px; object-fit:cover; display:block; width:100%; }
        .post-imgs.c3 img { height:150px; object-fit:cover; display:block; width:100%; }
        .post-imgs.c4 { display:grid; grid-template-columns:1fr 1fr; gap:2px; }
        .post-imgs.c4 img { height:160px; object-fit:cover; display:block; width:100%; }
        /* Réactions */
        .post-actions { display:flex; gap:2px; padding:4px 10px 4px; border-top:1px solid rgba(255,255,255,0.07); }
        .act-btn { display:flex; align-items:center; gap:5px; background:none; border:none; color:rgba(255,255,255,0.6); cursor:pointer; padding:8px 12px; border-radius:8px; font-size:13px; transition:all 0.2s; flex:1; justify-content:center; position:relative; }
        .act-btn:hover { background:rgba(255,255,255,0.08); color:white; }
        .act-btn.liked { color:#ff5050; }
        .reaction-popup { display:none; position:absolute; bottom:44px; left:50%; transform:translateX(-50%); background:#0d1f35; border:1px solid rgba(255,255,255,0.15); border-radius:30px; padding:6px 10px; flex-direction:row; gap:4px; z-index:100; white-space:nowrap; box-shadow:0 4px 20px rgba(0,0,0,0.5); }
        .act-btn:hover .reaction-popup { display:flex; }
        .react-emoji { font-size:22px; cursor:pointer; padding:4px; border-radius:50%; transition:all 0.2s; border:none; background:none; }
        .react-emoji:hover { transform:scale(1.4) translateY(-4px); }
        /* Commentaires */
        .comments-wrap { display:none; padding:12px 16px; border-top:1px solid rgba(255,255,255,0.07); }
        .comments-wrap.open { display:block; }
        .comment-item { display:flex; gap:8px; margin-bottom:10px; }
        .comment-bubble { background:rgba(255,255,255,0.07); border-radius:14px; padding:8px 12px; flex:1; }
        .comment-user { font-size:12px; font-weight:700; margin-bottom:3px; }
        .comment-text { font-size:13px; color:rgba(255,255,255,0.85); white-space:pre-wrap; word-break:break-word; }
        .comment-actions { display:flex; gap:12px; margin-top:5px; }
        .comment-act { font-size:11px; color:rgba(255,255,255,0.45); cursor:pointer; transition:color 0.2s; border:none; background:none; padding:0; }
        .comment-act:hover,.comment-act.liked { color:#00e5a0; }
        .comment-time { font-size:10px; color:rgba(255,255,255,0.35); }
        .reply-item { display:flex; gap:8px; margin-top:8px; margin-left:20px; }
        .comment-input-row { display:flex; gap:8px; align-items:flex-end; margin-top:10px; }
        .c-input { flex:1; background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.15); border-radius:20px; padding:8px 14px; color:white; font-size:13px; outline:none; resize:none; max-height:100px; font-family:inherit; }
        .c-input:focus { border-color:#00e5a0; }
        .c-send { background:#00e5a0; border:none; color:#0a1628; padding:8px 14px; border-radius:20px; cursor:pointer; font-weight:700; font-size:12px; flex-shrink:0; }
        .success-msg { background:rgba(0,229,160,0.15); border:1px solid rgba(0,229,160,0.3); padding:10px 16px; border-radius:10px; margin-bottom:12px; color:#00e5a0; font-size:13px; }
        .reactions-count { font-size:12px; color:rgba(255,255,255,0.5); padding:2px 12px 6px; display:flex; gap:6px; }
        @media(max-width:900px) { .layout { grid-template-columns:1fr; } .sidebar { display:none; } }
        @media(max-width:480px) { .layout { padding:8px; } .post-body { font-size:13px; } }
    </style>
</head>
<body>
@include('components.navbar')

<div class="layout">
    <!-- Sidebar gauche -->
    <div class="sidebar">
        <div class="sidebar-card">
            <div style="text-align:center;margin-bottom:14px;">
                <div class="av-lg" style="margin:0 auto 8px;">
                    @if(Auth::user()->photo_profil)
                        <img src="{{ Storage::url(Auth::user()->photo_profil) }}" alt="">
                    @else
                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                    @endif
                </div>
                <div style="font-size:14px;font-weight:700;">{{ Auth::user()->name }}</div>
                <div style="font-size:11px;color:#00e5a0;">{{ Auth::user()->nom_grade['emoji'] }} {{ Auth::user()->nom_grade['nom'] }}</div>
                <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-top:3px;">⭐ {{ Auth::user()->points }} pts</div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;text-align:center;border-top:1px solid rgba(255,255,255,0.1);padding-top:10px;">
                <div><div style="font-size:18px;font-weight:700;color:#00e5a0;">{{ Auth::user()->amis_count }}</div><div style="font-size:10px;color:rgba(255,255,255,0.5);">Amis</div></div>
                <div><div style="font-size:18px;font-weight:700;color:#00e5a0;">{{ Auth::user()->posts()->count() }}</div><div style="font-size:10px;color:rgba(255,255,255,0.5);">Posts</div></div>
            </div>
        </div>
        <div class="sidebar-card">
            <div class="sidebar-title">Menu</div>
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

    <!-- Centre -->
    <div>
        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        <!-- Compositeur -->
        <div class="composer">
            <form method="POST" action="/posts" enctype="multipart/form-data" id="postForm">
                @csrf
                <div class="composer-row">
                    <div class="av-lg">
                        @if(Auth::user()->photo_profil)
                            <img src="{{ Storage::url(Auth::user()->photo_profil) }}" alt="">
                        @else
                            {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                        @endif
                    </div>
                    <textarea
                        name="contenu"
                        class="composer-input"
                        id="postInput"
                        placeholder="Que se passe-t-il aujourd'hui ? Partagez vos connaissances..."
                        onkeydown="handlePostEnter(event)"
                        oninput="autoResize(this)"
                        rows="2"
                    ></textarea>
                </div>

                <div id="previewGrid" class="preview-grid"></div>
                <input type="file" name="images[]" id="imgInput" multiple accept="image/*" style="display:none" onchange="previewImgs(this)">

                <div class="composer-footer">
                    <div class="composer-tools">
                        <button type="button" class="tool-btn" onclick="document.getElementById('imgInput').click()" title="Photos">📷</button>
                        <button type="button" class="tool-btn" onclick="document.getElementById('videoInput').click()" title="Vidéo">🎥</button>
                        <input type="file" name="video" id="videoInput" accept="video/mp4,video/webm" style="display:none" onchange="previewVideo(this)">
                        <button type="button" class="emoji-picker-btn" onclick="toggleEmojiPicker('postEmoji','postInput')" title="Emojis">😊</button>
                        <select name="visibilite" class="visib-select">
                            <option value="public">🌍 Public</option>
                            <option value="amis">👥 Amis</option>
                            <option value="prive">🔒 Privé</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-post">📝 Publier</button>
                </div>
                <div id="postEmoji" class="emoji-panel" style="margin-top:8px;"></div>
            </form>
        </div>

        <!-- Publications -->
        @forelse($posts as $post)
        <div class="post-card" id="post-{{ $post->id }}">
            <div class="post-head">
                <div class="av-lg">
                    @if($post->user->photo_profil)
                        <img src="{{ Storage::url($post->user->photo_profil) }}" alt="">
                    @else
                        {{ strtoupper(substr($post->user->name,0,1)) }}
                    @endif
                </div>
                <div>
                    <div class="post-name">{{ $post->user->name }}</div>
                    <div class="post-grade">{{ $post->user->nom_grade['emoji'] }} {{ $post->user->nom_grade['nom'] }}</div>
                </div>
                <span class="post-time">{{ $post->created_at->diffForHumans() }}</span>
                @if($post->user_id==Auth::id()||Auth::user()->is_admin)
                <form method="POST" action="/posts/{{ $post->id }}" style="margin-left:6px;">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none;border:none;color:rgba(255,80,80,0.7);cursor:pointer;font-size:16px;" onclick="return confirm('Supprimer ?')">🗑️</button>
                </form>
                @endif
            </div>

            @if($post->contenu)
@php $isLong = strlen($post->contenu) > 300 || substr_count($post->contenu, "\n") > 4; @endphp
<div class="post-body post-body-truncated {{ $isLong ? 'collapsed' : '' }}"
     id="post-body-{{ $post->id }}">
    {!! nl2br(preg_replace(
        '/(https?:\/\/[^\s<>"]+[^\s<>".,:;!?)\'"]+)/i',
        '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>',
        e($post->contenu)
    )) !!}
</div>
@if($isLong)
<button class="voir-plus-btn" id="vp-btn-{{ $post->id }}"
    onclick="toggleVoirPlus({{ $post->id }})">
    ... Voir plus
</button>
@endif
@endif

           @if($post->images->count() > 0)
@php
    $imgCount = min($post->images->count(), 4);
    $gridClass = ['','c1','c2','c3','c4'][$imgCount];
@endphp
<div class="post-imgs {{ $gridClass }}">
    @foreach($post->images->take(4) as $img)
    @php
        $imgSrc = '';
        if ($img->image_path) {
            if (str_starts_with($img->image_path, 'http')) {
                $imgSrc = $img->image_path;
            } elseif (str_starts_with($img->image_path, '/')) {
                $imgSrc = $img->image_path;
            } else {
                $imgSrc = config('app.url') . '/storage/' . ltrim($img->image_path, '/');
            }
        }
    @endphp
    @if($imgSrc)
    <img src="{{ $imgSrc }}"
         alt="Photo"
         loading="lazy"
         style="cursor:zoom-in;"
         onclick="openImg(this.src)"
         onerror="this.closest('.post-imgs')?.childElementCount === 1 ? this.closest('.post-imgs').style.display='none' : this.style.display='none'">
    @endif
    @endforeach
</div>
@endif

@if($post->video_path)
@php
    $videoSrc = str_starts_with($post->video_path, 'http')
        ? $post->video_path
        : config('app.url') . '/storage/' . ltrim($post->video_path, '/');
@endphp
<div style="background:#000;line-height:0;">
    <video src="{{ $videoSrc }}" controls preload="metadata"
        style="width:100%;max-height:420px;display:block;">
    </video>
</div>
@endif

            <!-- Compteurs réactions -->
            @if($post->likes_count>0||$post->comments_count>0)
            <div class="reactions-count">
                @if($post->likes_count>0)<span>❤️ {{ $post->likes_count }}</span>@endif
                @if($post->comments_count>0)<span>💬 {{ $post->comments_count }} commentaires</span>@endif
            </div>
            @endif

            <!-- Actions -->
            <div class="post-actions">
                <!-- Like avec réactions -->
                <button class="act-btn {{ $post->isLikedBy(Auth::id()) ? 'liked' : '' }}"
                    id="like-btn-{{ $post->id }}"
                    onclick="likePost({{ $post->id }},this)">
                    <span id="like-emoji-{{ $post->id }}">{{ $post->isLikedBy(Auth::id()) ? '❤️' : '🤍' }}</span>
                    <span id="like-count-{{ $post->id }}">{{ $post->likes_count }}</span>
                    <div class="reaction-popup">
                        <button class="react-emoji" onclick="event.stopPropagation();reactPost({{ $post->id }},'❤️')">❤️</button>
                        <button class="react-emoji" onclick="event.stopPropagation();reactPost({{ $post->id }},'😂')">😂</button>
                        <button class="react-emoji" onclick="event.stopPropagation();reactPost({{ $post->id }},'😮')">😮</button>
                        <button class="react-emoji" onclick="event.stopPropagation();reactPost({{ $post->id }},'😢')">😢</button>
                        <button class="react-emoji" onclick="event.stopPropagation();reactPost({{ $post->id }},'😡')">😡</button>
                        <button class="react-emoji" onclick="event.stopPropagation();reactPost({{ $post->id }},'👍')">👍</button>
                    </div>
                </button>
                <button class="act-btn" onclick="toggleComments({{ $post->id }})">
                    💬 <span id="cmt-count-{{ $post->id }}">{{ $post->comments_count }}</span>
                </button>
                <button class="act-btn" onclick="sharePost({{ $post->id }})">🔗 Partager</button>
                <button class="act-btn" onclick="signalerPost({{ $post->id }})">🚩</button>
            </div>

            <!-- Commentaires -->
            <div class="comments-wrap" id="comments-{{ $post->id }}">
                <div id="comments-list-{{ $post->id }}">
                    @foreach($post->comments->take(5) as $comment)
                    <div class="comment-item" id="comment-{{ $comment->id }}">
                        <div class="av-sm">
                            @if($comment->user->photo_profil)
                                <img src="{{ Storage::url($comment->user->photo_profil) }}" alt="">
                            @else
                                {{ strtoupper(substr($comment->user->name,0,1)) }}
                            @endif
                        </div>
                        <div style="flex:1">
                            <div class="comment-bubble">
                                <div class="comment-user">{{ $comment->user->name }} <span style="color:rgba(255,255,255,0.3);font-weight:400;">{{ $comment->created_at->diffForHumans() }}</span></div>
                                <div class="comment-text">{!! nl2br(preg_replace(
    '/(https?:\/\/[^\s<>"]+[^\s<>".,:;!?)\'"]+)/i',
    '<a href="$1" target="_blank" rel="noopener noreferrer" style="color:#378ADD;">$1</a>',
    e($comment->contenu)
)) !!}</div>
                                <div class="comment-actions">
                                    <button class="comment-act" onclick="likeComment({{ $comment->id }},this)">❤️ <span>{{ $comment->likes_count }}</span></button>
                                    <button class="comment-act" onclick="showReply({{ $post->id }},{{ $comment->id }},'{{ addslashes($comment->user->name) }}')">💬 Répondre</button>
                                </div>
                            </div>
                            <!-- Réponses -->
                            <div id="replies-{{ $comment->id }}"></div>
                            <div id="reply-form-{{ $comment->id }}" style="display:none;margin-top:6px;margin-left:10px;">
                                <div class="comment-input-row">
                                    <div class="av-sm">
                                        @if(Auth::user()->photo_profil)
                                            <img src="{{ Storage::url(Auth::user()->photo_profil) }}" alt="">
                                        @else
                                            {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                                        @endif
                                    </div>
                                    <textarea class="c-input" id="reply-input-{{ $comment->id }}" placeholder="Répondre à {{ $comment->user->name }}..." rows="1" oninput="autoResize(this)"></textarea>
                                    <button class="c-send" onclick="sendReply({{ $post->id }},{{ $comment->id }})">↩</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="comment-input-row" style="margin-top:8px;">
                    <div class="av-sm">
                        @if(Auth::user()->photo_profil)
                            <img src="{{ Storage::url(Auth::user()->photo_profil) }}" alt="">
                        @else
                            {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                        @endif
                    </div>
                    <div style="flex:1;position:relative;">
                        <textarea class="c-input" id="cmt-input-{{ $post->id }}" placeholder="Écrire un commentaire..." rows="1" oninput="autoResize(this)" onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendComment({{ $post->id }});}"></textarea>
                    </div>
                    <button class="emoji-picker-btn" onclick="toggleEmojiPicker('cmt-emoji-{{ $post->id }}','cmt-input-{{ $post->id }}')">😊</button>
                    <button class="c-send" onclick="sendComment({{ $post->id }})">Envoyer</button>
                </div>
                <div id="cmt-emoji-{{ $post->id }}" class="emoji-panel" style="margin-top:6px;"></div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:60px 20px;color:rgba(255,255,255,0.4);">
            <div style="font-size:56px;margin-bottom:14px;">🌿</div>
            <h3 style="font-size:20px;margin-bottom:8px;color:rgba(255,255,255,0.7);">Aucune publication</h3>
            <p style="font-size:13px;">Soyez le premier à partager !</p>
        </div>
        @endforelse

        <div style="text-align:center;padding:16px;">{{ $posts->links() }}</div>
    </div>

    <!-- Sidebar droite -->
    <div class="sidebar">
        <div class="sidebar-card">
            <div class="sidebar-title">Membres à connaître</div>
            @foreach($users as $user)
            <div class="user-card">
                <div class="av-sm">
                    @if($user->photo_profil)
                        <img src="{{ Storage::url($user->photo_profil) }}" alt="">
                    @else
                        {{ strtoupper(substr($user->name,0,1)) }}
                    @endif
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:12px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $user->name }}</div>
                    <div style="font-size:10px;color:#00e5a0;">{{ $user->nom_grade['emoji'] }}</div>
                </div>
                @if(!Auth::user()->isFriendWith($user->id)&&!Auth::user()->hasPendingRequestWith($user->id))
                <form method="POST" action="/friends/request/{{ $user->id }}">
                    @csrf
                    <button type="submit" class="btn-add">+ Ami</button>
                </form>
                @endif
            </div>
            @endforeach
        </div>
        <div class="sidebar-card" style="margin-bottom:12px;">
    <div class="sidebar-title">🔥 Tendances cette semaine</div>
    @foreach($tendances as $t)
    <a href="/pathologies/{{ $t->id }}" style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.05);text-decoration:none;color:white;">
        <div>
            <div style="font-size:13px;font-weight:600;">{{ Str::limit($t->nom,25) }}</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.4);">{{ $t->categorie }}</div>
        </div>
        <span style="font-size:11px;color:#00e5a0;">👁️ {{ $t->vues }}</span>
    </a>
    @endforeach
    <a href="/recherche" style="display:block;text-align:center;margin-top:10px;font-size:12px;color:#00e5a0;text-decoration:none;">Voir toutes →</a>
</div>
        <div class="sidebar-card" style="background:rgba(255,80,80,0.08);border-color:rgba(255,80,80,0.2);">
            <div class="sidebar-title" style="color:#ff8080;">🆘 Urgence</div>
            <a href="https://wa.me/22962976186" target="_blank" style="display:flex;align-items:center;gap:8px;color:#25D366;text-decoration:none;font-size:13px;font-weight:600;margin-bottom:8px;">📱 WhatsApp</a>
            <a href="mailto:jeanmarcdossou77@gmail.com" style="display:flex;align-items:center;gap:8px;color:#00e5a0;text-decoration:none;font-size:12px;">📧 Email</a>
        </div>
    </div>
</div>

<script>
const csrf = document.querySelector('meta[name="csrf-token"]').content;

// Emojis disponibles
const EMOJIS = ['😊','😂','❤️','🔥','👍','🙏','😍','🤔','😢','😡','🎉','🌿','💪','✅','🌍','🤖','🧬','💊','🌺','⭐','😮','🏆','🎓','💡','🌱','🔬','🦠','💉','🧪','🌸'];

function buildEmojiPanel(panelId, inputId) {
    const panel = document.getElementById(panelId);
    if (panel.innerHTML) return;
    EMOJIS.forEach(e => {
        const btn = document.createElement('button');
        btn.className = 'emoji-btn';
        btn.textContent = e;
        btn.onclick = () => insertEmoji(inputId, e);
        panel.appendChild(btn);
    });
}

function toggleEmojiPicker(panelId, inputId) {
    buildEmojiPanel(panelId, inputId);
    const panel = document.getElementById(panelId);
    panel.classList.toggle('open');
}

function insertEmoji(inputId, emoji) {
    const el = document.getElementById(inputId);
    if (!el) return;
    const start = el.selectionStart;
    const end = el.selectionEnd;
    el.value = el.value.substring(0, start) + emoji + el.value.substring(end);
    el.selectionStart = el.selectionEnd = start + emoji.length;
    el.focus();
    autoResize(el);
}

function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 200) + 'px';
}

function handlePostEnter(e) {
    // Shift+Enter = nouvelle ligne, Enter seul = rien de spécial (laisser par défaut)
}

// Prévisualisation images
function previewImgs(input) {
    const grid = document.getElementById('previewGrid');
    grid.innerHTML = '';
    const files = Array.from(input.files).slice(0, 10);
    files.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            grid.innerHTML += `
                <div class="preview-item">
                    <img src="${e.target.result}" alt="">
                    <button class="preview-remove" onclick="removeImg(${i})" type="button">×</button>
                </div>`;
        };
        reader.readAsDataURL(file);
    });
}

function removeImg(idx) {
    const input = document.getElementById('imgInput');
    const dt = new DataTransfer();
    Array.from(input.files).forEach((f, i) => { if (i !== idx) dt.items.add(f); });
    input.files = dt.files;
    previewImgs(input);
}

// Like post
function likePost(postId, btn) {
    fetch(`/posts/${postId}/like`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf }
    })
    .then(r => r.json())
    .then(data => {
        btn.classList.toggle('liked', data.liked);
        document.getElementById(`like-emoji-${postId}`).textContent = data.liked ? '❤️' : '🤍';
        document.getElementById(`like-count-${postId}`).textContent = data.count;
    });
}

// Réaction spécifique
function reactPost(postId, emoji) {
    fetch(`/posts/${postId}/like`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf }
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById(`like-emoji-${postId}`).textContent = emoji;
        document.getElementById(`like-count-${postId}`).textContent = data.count;
        document.getElementById(`like-btn-${postId}`).classList.add('liked');
    });
}

// Toggle commentaires
function toggleComments(postId) {
    const w = document.getElementById(`comments-${postId}`);
    w.classList.toggle('open');
    if (w.classList.contains('open')) {
        document.getElementById(`cmt-input-${postId}`)?.focus();
    }
}

// Envoyer commentaire
function sendComment(postId) {
    const input = document.getElementById(`cmt-input-${postId}`);
    const text = input.value.trim();
    if (!text) return;

    fetch(`/posts/${postId}/comment`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json' },
        body: JSON.stringify({ contenu: text })
    })
    .then(r => r.json())
    .then(data => {
        const c = data.comment;
        const av = c.user.photo
            ? `<img src="/storage/${c.user.photo}" alt="">`
            : c.user.name.charAt(0).toUpperCase();

        document.getElementById(`comments-list-${postId}`).innerHTML += `
            <div class="comment-item" id="comment-${c.id}">
                <div class="av-sm">${av}</div>
                <div style="flex:1">
                    <div class="comment-bubble">
                        <div class="comment-user">${c.user.name} <span style="color:rgba(255,255,255,0.3);font-weight:400;">${c.created_at}</span></div>
                        <div class="comment-text">${c.contenu}</div>
                        <div class="comment-actions">
                            <button class="comment-act" onclick="likeComment(${c.id},this)">❤️ <span>0</span></button>
                            <button class="comment-act" onclick="showReply(${postId},${c.id},'${c.user.name}')">💬 Répondre</button>
                        </div>
                    </div>
                    <div id="replies-${c.id}"></div>
                    <div id="reply-form-${c.id}" style="display:none;margin-top:6px;margin-left:10px;"></div>
                </div>
            </div>`;

        document.getElementById(`cmt-count-${postId}`).textContent = data.count;
        input.value = '';
        input.style.height = 'auto';

        // Fermer emoji panel
        const ep = document.getElementById(`cmt-emoji-${postId}`);
        if (ep) ep.classList.remove('open');
    });
}

// Like commentaire
function likeComment(commentId, btn) {
    fetch(`/comments/${commentId}/like`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf }
    })
    .then(r => r.json())
    .then(data => {
        btn.classList.toggle('liked', data.liked);
        btn.querySelector('span').textContent = data.count;
    });
}

// Afficher formulaire réponse
function showReply(postId, commentId, userName) {
    const formDiv = document.getElementById('reply-form-' + commentId);
    if (!formDiv) return;

    if (formDiv.style.display === 'none' || formDiv.style.display === '') {
        formDiv.style.display = 'block';
        // Créer le formulaire si vide
        if (!formDiv.innerHTML.trim()) {
            const authAvatar = '{{ strtoupper(substr(Auth::user()->name,0,1)) }}';
            formDiv.innerHTML = `
                <div style="display:flex;gap:8px;align-items:flex-end;margin-top:6px;margin-left:20px;">
                    <div class="av-sm">${authAvatar}</div>
                    <textarea
                        class="c-input"
                        id="ri-${commentId}"
                        placeholder="Répondre à ${escapeHtml(userName)}..."
                        rows="1"
                        oninput="autoResize(this)"
                        onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendReply(${postId},${commentId});}"
                        style="flex:1;"
                    ></textarea>
                    <button class="emoji-picker-btn" onclick="toggleEmojiPicker('re-emoji-${commentId}','ri-${commentId}')">😊</button>
                    <button class="c-send" onclick="sendReply(${postId},${commentId})">↩ Envoyer</button>
                </div>
                <div id="re-emoji-${commentId}" class="emoji-panel" style="margin-top:4px;margin-left:20px;"></div>`;
        }
        const textarea = document.getElementById('ri-' + commentId);
        if (textarea) textarea.focus();
    } else {
        formDiv.style.display = 'none';
    }
}

// Envoyer réponse
function sendReply(postId, commentId) {
    const input = document.getElementById('ri-' + commentId);
    if (!input) return;
    const text = input.value.trim();
    if (!text) return;

    const btn = input.nextElementSibling?.nextElementSibling || input.parentElement.querySelector('button');

    fetch('/posts/' + postId + '/comment', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ contenu: text, parent_id: commentId })
    })
    .then(function(r) {
        if (!r.ok) throw new Error('Erreur ' + r.status);
        return r.json();
    })
    .then(function(data) {
        const c = data.comment;
        const repliesDiv = document.getElementById('replies-' + commentId);
        if (repliesDiv) {
            const avatarHtml = c.user.photo
                ? '<img src="/storage/' + c.user.photo + '" alt="" style="width:100%;height:100%;object-fit:cover;">'
                : c.user.name.charAt(0).toUpperCase();

            repliesDiv.innerHTML += `
                <div class="reply-item" style="display:flex;gap:8px;margin-top:8px;margin-left:20px;">
                    <div class="av-sm">${avatarHtml}</div>
                    <div class="comment-bubble">
                        <div class="comment-user">${c.user.name}</div>
                        <div class="comment-text">${escapeHtml(c.contenu)}</div>
                        <div class="comment-time">${c.created_at}</div>
                    </div>
                </div>`;
        }
        input.value = '';
        input.style.height = 'auto';

        // Masquer le formulaire de réponse
        const replyForm = document.getElementById('reply-form-' + commentId);
        if (replyForm) replyForm.style.display = 'none';
    })
    .catch(function(err) {
        console.error('Erreur envoi réponse:', err);
        alert('Erreur lors de l\'envoi. Réessayez.');
    });
}

// Partager
function sharePost(postId) {
    const url = window.location.origin + '/feed#post-' + postId;
    if (navigator.share) {
        navigator.share({ title: 'BioLink', url });
    } else {
        navigator.clipboard.writeText(url);
        alert('Lien copié !');
    }
}

function signalerPost(postId) {
    const raisons = ['Contenu inapproprié','Spam','Fausse information','Harcèlement','Contenu dangereux'];
    const raison = prompt('Raison du signalement:\n' + raisons.map((r,i)=>`${i+1}. ${r}`).join('\n') + '\n\nEntrez le numéro (1-5):');
    if (!raison) return;
    const idx = parseInt(raison) - 1;
    const raisonText = raisons[idx] || 'Contenu inapproprié';

    fetch(`/signaler/post/${postId}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json' },
        body: JSON.stringify({ raison: raisonText })
    })
    .then(() => alert('✅ Signalement envoyé. Merci !'));
}

function previewVideo(input) {
    const file = input.files[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    document.getElementById('previewGrid').innerHTML += `
        <div style="margin-top:8px;">
            <video src="${url}" controls style="max-width:100%;border-radius:10px;max-height:200px;"></video>
            <div style="font-size:11px;color:#00e5a0;margin-top:4px;">🎥 ${file.name} (${(file.size/1024/1024).toFixed(1)} Mo)</div>
        </div>`;
}

// Ouvrir image en grand
function openImg(url) {
    const overlay = document.createElement('div');
    overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.9);z-index:9999;display:flex;align-items:center;justify-content:center;cursor:pointer;';
    overlay.innerHTML = `<img src="${url}" style="max-width:95vw;max-height:95vh;object-fit:contain;border-radius:8px;">`;
    overlay.onclick = () => overlay.remove();
    document.body.appendChild(overlay);
}

function toggleVoirPlus(postId) {
    const body = document.getElementById('post-body-' + postId);
    const btn = document.getElementById('vp-btn-' + postId);
    if (!body || !btn) return;

    if (body.classList.contains('collapsed')) {
        body.classList.remove('collapsed');
        btn.textContent = 'Voir moins';
    } else {
        body.classList.add('collapsed');
        btn.textContent = '... Voir plus';
    }
}
</script>
</body>
</html>