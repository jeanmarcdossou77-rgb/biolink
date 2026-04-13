<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Assistant IA</title>
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
    height: 100dvh; /* dynamic viewport height pour mobile */
}
.chat-container {
    display: flex;
    flex-direction: column;
    flex: 1;
    overflow: hidden;
    max-width: 800px;
    width: 100%;
    margin: 0 auto;
    padding: 0 16px;
}
.chat-header {
    text-align: center;
    padding: 20px 0 10px;
    flex-shrink: 0;
}
.chat-header h1 { font-size: 24px; font-weight: 800; }
.chat-header p { font-size: 14px; color: rgba(255,255,255,0.6); }
.quick-suggestions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    padding: 10px 0;
    flex-shrink: 0;
}
.suggestion-btn {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.15);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}
.suggestion-btn:hover { border-color: #00e5a0; color: #00e5a0; }
.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 10px 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
    -webkit-overflow-scrolling: touch;
}
.message-ia, .message-user {
    display: flex;
    gap: 10px;
    max-width: 85%;
}
.message-user { align-self: flex-end; flex-direction: row-reverse; }
.ia-avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00e5a0, #378ADD);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.ia-bubble {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 18px 18px 18px 4px;
    padding: 12px 16px;
    font-size: 14px;
    line-height: 1.7;
    color: rgba(255,255,255,0.9);
    word-break: break-word;
}
.user-bubble {
    background: rgba(0,229,160,0.2);
    border: 1px solid rgba(0,229,160,0.35);
    border-radius: 18px 18px 4px 18px;
    padding: 12px 16px;
    font-size: 14px;
    line-height: 1.6;
    word-break: break-word;
}
.chat-input-area {
    flex-shrink: 0;
    padding: 12px 0 16px;
    display: flex;
    gap: 10px;
    align-items: flex-end;
    background: #0a1628;
    /* Eviter que le clavier cache la barre sur iOS/Android */
    padding-bottom: env(safe-area-inset-bottom, 16px);
}
.chat-input {
    flex: 1;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 24px;
    padding: 12px 18px;
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
    width: 46px; height: 46px;
    border-radius: 50%;
    background: #00e5a0;
    border: none;
    color: #0a1628;
    font-size: 20px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: transform 0.2s;
}
.send-btn:hover { transform: scale(1.08); }
.typing-indicator { display: flex; gap: 5px; align-items: center; padding: 12px 16px; }
.typing-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #00e5a0;
    animation: typingBounce 1.2s infinite;
}
.typing-dot:nth-child(2) { animation-delay: 0.2s; }
.typing-dot:nth-child(3) { animation-delay: 0.4s; }
@keyframes typingBounce {
    0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
    30% { transform: translateY(-8px); opacity: 1; }
}
@media (max-width: 768px) {
    .chat-header h1 { font-size: 20px; }
    .chat-header .ia-icon { width: 60px; height: 60px; font-size: 28px; }
    .chat-container { padding: 0 12px; }
    .message-ia, .message-user { max-width: 92%; }
}
    </style>
</head>
<body>
<div class="page-wrapper">
    @include('components.navbar')

    <div class="chat-container">
        <div class="chat-header">
            <div class="ia-icon" style="width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#00e5a0,#378ADD);display:flex;align-items:center;justify-content:center;font-size:32px;margin:0 auto 12px;">🤖</div>
            <h1>Assistant IA BioLink</h1>
            <p>Posez vos questions sur les pathologies, symptômes et remèdes naturels</p>
        </div>

        <div class="quick-suggestions">
            <button class="suggestion-btn" onclick="askQuestion('Remèdes pour le diabète')">🩸 Diabète</button>
            <button class="suggestion-btn" onclick="askQuestion('Remèdes contre le paludisme')">🦟 Paludisme</button>
            <button class="suggestion-btn" onclick="askQuestion('Remèdes pour la migraine')">🧠 Migraine</button>
            <button class="suggestion-btn" onclick="askQuestion('Remèdes hypertension')">❤️ Hypertension</button>
            <button class="suggestion-btn" onclick="askQuestion('Remèdes COVID-19')">🦠 COVID-19</button>
            <button class="suggestion-btn" onclick="askQuestion('Remèdes contre anémie')">🩸 Anémie</button>
        </div>

        <div class="chat-messages" id="chatMessages">
            <div class="message-ia">
                <div class="ia-avatar">🤖</div>
                <div class="ia-bubble">
                    Bonjour ! Je suis l'assistant IA de BioLink. Je peux vous aider à :<br><br>
                    🔬 Trouver une pathologie par nom ou symptôme<br>
                    🌿 Découvrir des remèdes naturels validés<br>
                    🛡️ Vous informer sur la prévention<br><br>
                    Notre base contient <strong>{{ \App\Models\Pathologie::count() }} pathologies</strong> !<br><br>
                    Posez votre question 👇
                </div>
            </div>
        </div>

        <div class="chat-input-area">
            <textarea
                class="chat-input"
                id="chatInput"
                placeholder="Ex: Quels remèdes pour le diabète ?"
                rows="1"
                onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendMessage();}"
                oninput="autoResize(this)"
            ></textarea>
            <button class="send-btn" onclick="sendMessage()">➤</button>
        </div>
    </div>
</div>

<script>
function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 120) + 'px';
}

function askQuestion(q) {
    document.getElementById('chatInput').value = q;
    sendMessage();
}

function sendMessage() {
    const input = document.getElementById('chatInput');
    const text = input.value.trim();
    if (!text) return;

    const msgs = document.getElementById('chatMessages');

    msgs.innerHTML += `
        <div class="message-user">
            <div class="user-bubble">${text}</div>
        </div>`;

    input.value = '';
    input.style.height = 'auto';
    msgs.scrollTop = msgs.scrollHeight;

    msgs.innerHTML += `
        <div class="message-ia" id="typing">
            <div class="ia-avatar">🤖</div>
            <div class="ia-bubble">
                <div class="typing-indicator">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            </div>
        </div>`;
    msgs.scrollTop = msgs.scrollHeight;

    fetch('/ia/question', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ question: text })
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('typing')?.remove();
        msgs.innerHTML += `
            <div class="message-ia">
                <div class="ia-avatar">🤖</div>
                <div class="ia-bubble">${data.reponse}</div>
            </div>`;
        msgs.scrollTop = msgs.scrollHeight;
    })
    .catch(() => {
        document.getElementById('typing')?.remove();
        msgs.innerHTML += `
            <div class="message-ia">
                <div class="ia-avatar">🤖</div>
                <div class="ia-bubble">❌ Une erreur est survenue. Réessayez.</div>
            </div>`;
    });
}
</script>
</body>
</html>