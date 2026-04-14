<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BioLink – {{ $otherUser->name }}</title>
    <style>
* { margin: 0; padding: 0; box-sizing: border-box; }
html, body {
    height: 100%;
    overflow: hidden;
    font-family: 'Segoe UI', sans-serif;
    background: #0a1628;
    color: white;
}
.page-wrapper {
    display: flex;
    flex-direction: column;
    height: 100vh;
    height: 100dvh;
}
.chat-layout {
    display: flex;
    flex: 1;
    overflow: hidden;
    min-height: 0;
}
.sidebar {
    width: 260px;
    border-right: 1px solid rgba(255,255,255,0.1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    flex-shrink: 0;
}
.sidebar-header { padding: 14px 16px; font-size: 15px; font-weight: 700; flex-shrink: 0; border-bottom: 1px solid rgba(255,255,255,0.1); }
.sidebar-back { display: block; padding: 10px 14px; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); flex-shrink: 0; }
.sidebar-list { overflow-y: auto; flex: 1; }
.conv-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; text-decoration: none; color: white; border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s; }
.conv-item:hover { background: rgba(255,255,255,0.05); }
.conv-item.active { background: rgba(0,229,160,0.1); border-left: 3px solid #00e5a0; }
.conv-avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg,#00e5a0,#378ADD); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #0a1628; overflow: hidden; flex-shrink: 0; }
.conv-avatar img { width: 100%; height: 100%; object-fit: cover; }
.chat-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    min-width: 0;
}
.chat-header-bar {
    padding: 12px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
    background: rgba(255,255,255,0.03);
}
.chat-header-back { display: none; color: #00e5a0; text-decoration: none; font-size: 20px; margin-right: 4px; }
.chat-avatar-hd { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg,#00e5a0,#378ADD); display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 700; color: #0a1628; overflow: hidden; flex-shrink: 0; }
.chat-avatar-hd img { width: 100%; height: 100%; object-fit: cover; }
.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    -webkit-overflow-scrolling: touch;
    min-height: 0;
}
.msg-row { display: flex; gap: 8px; max-width: 75%; }
.msg-row.sent { align-self: flex-end; flex-direction: row-reverse; }
.msg-av { width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg,#00e5a0,#378ADD); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: #0a1628; overflow: hidden; flex-shrink: 0; align-self: flex-end; }
.msg-av img { width: 100%; height: 100%; object-fit: cover; }
.msg-bubble { background: rgba(255,255,255,0.09); border-radius: 18px 18px 18px 4px; padding: 10px 14px; font-size: 14px; line-height: 1.5; word-break: break-word; }
.msg-row.sent .msg-bubble { background: rgba(0,229,160,0.22); border: 1px solid rgba(0,229,160,0.3); border-radius: 18px 18px 4px 18px; }
.msg-time { font-size: 10px; color: rgba(255,255,255,0.35); margin-top: 3px; padding: 0 4px; }
.chat-input-area {
    flex-shrink: 0;
    padding: 10px 14px;
    border-top: 1px solid rgba(255,255,255,0.1);
    display: flex;
    gap: 10px;
    align-items: flex-end;
    background: #0d1f35;
    padding-bottom: max(10px, env(safe-area-inset-bottom));
}
.chat-input {
    flex: 1;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.18);
    border-radius: 22px;
    padding: 10px 16px;
    color: white;
    font-size: 15px;
    outline: none;
    resize: none;
    max-height: 120px;
    overflow-y: auto;
    font-family: inherit;
    line-height: 1.5;
    -webkit-appearance: none;
}
.chat-input:focus { border-color: #00e5a0; }
.chat-input::placeholder { color: rgba(255,255,255,0.4); }
.send-btn {
    width: 44px; height: 44px;
    border-radius: 50%;
    background: #00e5a0;
    border: none;
    color: #0a1628;
    font-size: 18px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
@media (max-width: 700px) {
    .sidebar { display: none !important; }
    .chat-header-back { display: block !important; }
    .msg-row { max-width: 88%; }
}
    </style>
</head>
<body>
<div class="page-wrapper">
    @include('components.navbar')
    <div class="chat-layout">
        <div class="sidebar">
            <div class="sidebar-header">💬 Messages</div>
            <a href="/messages" class="sidebar-back">← Toutes les conversations</a>
            <div class="sidebar-list">
                @foreach($users as $user)
                <a href="/messages/{{ $user->id }}" class="conv-item {{ $user->id == $otherUser->id ? 'active' : '' }}">
                    <div class="conv-avatar">
                        @if($user->photo_profil)
                            <img src="{{ Storage::url($user->photo_profil) }}" alt="">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:600;">{{ $user->name }}</div>
                        <div style="font-size:11px;color:#00e5a0;">{{ $user->nom_grade['emoji'] }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <div class="chat-main">
            <div class="chat-header">
                <div class="chat-header-avatar">
                    @if($otherUser->photo_profil)
                        <img src="{{ Storage::url($otherUser->photo_profil) }}" alt="">
                    @else
                        {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div style="font-size:15px;font-weight:700;">{{ $otherUser->name }}</div>
                    <div style="font-size:12px;color:#00e5a0;">{{ $otherUser->nom_grade['emoji'] }} {{ $otherUser->nom_grade['nom'] }}</div>
                </div>
            </div>

            <div class="chat-messages" id="chatMessages">
                @foreach($messages as $message)
                <div class="msg-row {{ $message->sender_id == Auth::id() ? 'sent' : '' }}">
                    <div class="msg-avatar">
                        @if($message->sender->photo_profil)
                            <img src="{{ Storage::url($message->sender->photo_profil) }}" alt="">
                        @else
                            {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="msg-bubble">{{ $message->contenu }}</div>
                        <div class="msg-time">{{ $message->created_at->format('H:i') }}</div>
                    </div>
                </div>
                @endforeach
            </div>

<div class="chat-input-area">
    <label for="msgPhoto" style="cursor:pointer;font-size:22px;padding:4px 8px;border-radius:8px;transition:all 0.2s;" title="Photo">📷</label>
    <input type="file" id="msgPhoto" accept="image/*" style="display:none" onchange="sendPhoto(this)">
    <button type="button" class="emoji-picker-btn" onclick="toggleMsgEmoji()" style="font-size:20px;">😊</button>
    <textarea class="chat-input" id="msgInput" placeholder="Écrire un message..." rows="1"
        onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendMsg();}"
        oninput="autoResize(this)"></textarea>
    <button class="send-btn" onclick="sendMsg()">➤</button>
</div>
<div id="msgEmojiPanel" class="emoji-panel" style="position:fixed;bottom:70px;right:16px;z-index:100;"></div>
        </div>
    </div>
</div>

<script>
const csrf = document.querySelector('meta[name="csrf-token"]').content;
const msgs = document.getElementById('chatMessages');
msgs.scrollTop = msgs.scrollHeight;

function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 120) + 'px';
}

function sendMsg() {
    const input = document.getElementById('msgInput');
    const text = input.value.trim();
    if (!text) return;

    fetch('/messages/{{ $otherUser->id }}/send', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json' },
        body: JSON.stringify({ contenu: text })
    })
    .then(r => r.json())
    .then(data => {
        const m = data.message;
        msgs.innerHTML += `
            <div class="msg-row sent">
                <div class="msg-avatar">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
                <div>
                    <div class="msg-bubble">${m.contenu}</div>
                    <div class="msg-time">${m.created_at}</div>
                </div>
            </div>`;
        msgs.scrollTop = msgs.scrollHeight;
        input.value = '';
        input.style.height = 'auto';
    });
}
const EMOJIS_MSG = ['😊','😂','❤️','🔥','👍','🙏','😍','🤔','😢','😡','🎉','🌿','💪','✅','🌍','🤖','😮','⭐','👏','🫂'];

function toggleMsgEmoji() {
    const panel = document.getElementById('msgEmojiPanel');
    if (!panel.innerHTML) {
        EMOJIS_MSG.forEach(e => {
            const btn = document.createElement('button');
            btn.textContent = e;
            btn.className = 'emoji-btn';
            btn.style.cssText = 'font-size:22px;cursor:pointer;padding:4px;border:none;background:none;border-radius:6px;';
            btn.onclick = () => {
                const input = document.getElementById('msgInput');
                input.value += e;
                input.focus();
            };
            panel.appendChild(btn);
        });
    }
    panel.classList.toggle('open');
}

function sendPhoto(input) {
    if (!input.files[0]) return;
    const formData = new FormData();
    formData.append('photo', input.files[0]);
    formData.append('_token', csrf);

    fetch('/messages/{{ $otherUser->id }}/send', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf },
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        const m = data.message;
        msgs.innerHTML += `
            <div class="msg-row sent">
                <div class="msg-av">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
                <div>
                    <div class="msg-bubble"><img src="${m.photo}" style="max-width:200px;border-radius:10px;display:block;"></div>
                    <div class="msg-time">${m.created_at}</div>
                </div>
            </div>`;
        msgs.scrollTop = msgs.scrollHeight;
        input.value = '';
    });
}
</script>
</body>
</html>