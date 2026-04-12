<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BioLink – {{ $otherUser->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; height: 100vh; display: flex; flex-direction: column; }
        .chat-layout { display: grid; grid-template-columns: 320px 1fr; flex: 1; overflow: hidden; max-height: calc(100vh - 64px); }
        .conversations-list { border-right: 1px solid rgba(255,255,255,0.1); overflow-y: auto; }
        .conv-header { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); font-size: 18px; font-weight: 700; }
        .chat-area { display: flex; flex-direction: column; height: 100%; }
        .chat-header { display: flex; align-items: center; gap: 12px; padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.03); }
        .chat-avatar { width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #00e5a0, #378ADD); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #0a1628; overflow: hidden; }
        .chat-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .chat-messages { flex: 1; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 12px; }
        .message-bubble { display: flex; gap: 8px; max-width: 70%; }
        .message-bubble.sent { align-self: flex-end; flex-direction: row-reverse; }
        .msg-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #00e5a0, #378ADD); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #0a1628; flex-shrink: 0; overflow: hidden; }
        .msg-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .msg-content { background: rgba(255,255,255,0.08); border-radius: 16px; padding: 10px 14px; font-size: 14px; line-height: 1.6; }
        .message-bubble.sent .msg-content { background: rgba(0,229,160,0.2); border: 1px solid rgba(0,229,160,0.3); }
        .msg-time { font-size: 10px; color: rgba(255,255,255,0.4); margin-top: 4px; }
        .chat-input-area { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; gap: 12px; }
        .chat-input { flex: 1; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15); border-radius: 25px; padding: 12px 20px; color: white; font-size: 15px; outline: none; }
        .chat-input:focus { border-color: #00e5a0; }
        .send-btn { background: #00e5a0; border: none; color: #0a1628; width: 46px; height: 46px; border-radius: 50%; cursor: pointer; font-size: 20px; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>

@include('components.navbar')

<div class="chat-layout">
    <div class="conversations-list">
        <div class="conv-header">💬 Messages</div>
        <a href="/messages" style="display:block; padding:14px 16px; color:rgba(255,255,255,0.7); text-decoration:none; font-size:14px; border-bottom:1px solid rgba(255,255,255,0.05);">← Retour aux conversations</a>
    </div>

    <div class="chat-area">
        <div class="chat-header">
            <div class="chat-avatar">
                @if($otherUser->photo_profil)
                    <img src="{{ Storage::url($otherUser->photo_profil) }}" alt="">
                @else
                    {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                @endif
            </div>
            <div>
                <div style="font-size:15px; font-weight:700;">{{ $otherUser->name }}</div>
                <div style="font-size:12px; color:#00e5a0;">{{ $otherUser->nom_grade['emoji'] }} {{ $otherUser->nom_grade['nom'] }}</div>
            </div>
        </div>

        <div class="chat-messages" id="chatMessages">
            @foreach($messages as $message)
            <div class="message-bubble {{ $message->sender_id == Auth::id() ? 'sent' : '' }}">
                <div class="msg-avatar">
                    @if($message->sender->photo_profil)
                        <img src="{{ Storage::url($message->sender->photo_profil) }}" alt="">
                    @else
                        {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="msg-content">{{ $message->contenu }}</div>
                    <div class="msg-time">{{ $message->created_at->format('H:i') }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="chat-input-area">
            <input type="text" class="chat-input" id="messageInput" placeholder="Écrivez un message..." onkeypress="if(event.key==='Enter') sendMessage()">
            <button class="send-btn" onclick="sendMessage()">➤</button>
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
const chatMessages = document.getElementById('chatMessages');
chatMessages.scrollTop = chatMessages.scrollHeight;

function sendMessage() {
    const input = document.getElementById('messageInput');
    const contenu = input.value.trim();
    if (!contenu) return;

    fetch('/messages/{{ $otherUser->id }}/send', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
        body: JSON.stringify({ contenu })
    })
    .then(r => r.json())
    .then(data => {
        const msg = data.message;
        chatMessages.innerHTML += `
            <div class="message-bubble sent">
                <div class="msg-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div>
                    <div class="msg-content">${msg.contenu}</div>
                    <div class="msg-time">${msg.created_at}</div>
                </div>
            </div>`;
        chatMessages.scrollTop = chatMessages.scrollHeight;
        input.value = '';
    });
}
</script>

</body>
</html>