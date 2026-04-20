<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Assistant IA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; height: 100vh; display: flex; flex-direction: column; }
        nav {
            display: flex; justify-content: space-between; align-items: center;
            padding: 16px 40px; background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.1); flex-shrink: 0;
        }
        .logo { font-size: 24px; font-weight: 700; color: #00e5a0; text-decoration: none; }
        .logo span { color: white; }
        .chat-container { flex: 1; display: flex; flex-direction: column; max-width: 800px; width: 100%; margin: 0 auto; padding: 20px; overflow: hidden; }
        .chat-header { text-align: center; padding: 20px 0; flex-shrink: 0; }
        .chat-header h1 { font-size: 24px; font-weight: 800; margin-bottom: 8px; }
        .chat-header p { color: rgba(255,255,255,0.6); font-size: 14px; }
        .ia-avatar { width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #00e5a0, #378ADD); display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 16px; }
        .messages { flex: 1; overflow-y: auto; padding: 10px 0; display: flex; flex-direction: column; gap: 16px; }
        .message { display: flex; gap: 12px; align-items: flex-start; }
        .message.user { flex-direction: row-reverse; }
        .msg-avatar { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
        .msg-avatar.ia { background: linear-gradient(135deg, #00e5a0, #378ADD); }
        .msg-avatar.user { background: rgba(255,255,255,0.15); }
        .msg-bubble { max-width: 70%; padding: 14px 18px; border-radius: 18px; font-size: 14px; line-height: 1.7; white-space: pre-line; }
        .msg-bubble.ia { background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1); border-top-left-radius: 4px; }
        .msg-bubble.user { background: rgba(0,229,160,0.2); border: 1px solid rgba(0,229,160,0.3); border-top-right-radius: 4px; }
        .typing { display: none; align-items: center; gap: 8px; padding: 8px 0; }
        .typing-dots { display: flex; gap: 4px; }
        .typing-dots span { width: 8px; height: 8px; border-radius: 50%; background: #00e5a0; animation: bounce 1.2s infinite; }
        .typing-dots span:nth-child(2) { animation-delay: 0.2s; }
        .typing-dots span:nth-child(3) { animation-delay: 0.4s; }
        @keyframes bounce { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-8px)} }
        .input-area { display: flex; gap: 12px; padding: 16px 0; flex-shrink: 0; border-top: 1px solid rgba(255,255,255,0.1); }
        .msg-input { flex: 1; padding: 14px 18px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15); border-radius: 25px; color: white; font-size: 15px; outline: none; transition: border-color 0.3s; }
        .msg-input:focus { border-color: #00e5a0; }
        .msg-input::placeholder { color: rgba(255,255,255,0.3); }
        .send-btn { width: 50px; height: 50px; border-radius: 50%; background: #00e5a0; border: none; cursor: pointer; font-size: 20px; display: flex; align-items: center; justify-content: center; transition: transform 0.2s; }
        .send-btn:hover { transform: scale(1.1); }
        .suggestions { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; flex-shrink: 0; }
        .suggestion { background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.8); padding: 6px 14px; border-radius: 20px; font-size: 13px; cursor: pointer; transition: all 0.2s; }
        .suggestion:hover { border-color: #00e5a0; color: #00e5a0; }
        .premium-badge { display: inline-block; background: rgba(255,165,0,0.2); color: #ffa500; padding: 3px 10px; border-radius: 10px; font-size: 11px; margin-left: 8px; }
    </style>
</head>
<body>
<nav>
    <a href="/" class="logo">Bio<span>Link</span></a>
    <div style="display:flex; align-items:center; gap:16px;">
        <span style="font-size:13px; color:rgba(255,255,255,0.6);">🤖 Assistant IA BioLink</span>
        <a href="/dashboard" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:13px;">← Dashboard</a>
    </div>
</nav>

<div class="chat-container">
    <div class="chat-header">
        <div class="ia-avatar">🤖</div>
        <h1>Assistant IA BioLink</h1>
        <p>Posez vos questions sur les pathologies, symptômes et remèdes naturels</p>
    </div>

    <div class="suggestions">
        <span class="suggestion" onclick="envoyer('Quels remèdes pour le diabète ?')">💊 Diabète</span>
        <span class="suggestion" onclick="envoyer('Remèdes contre le paludisme')">🦟 Paludisme</span>
        <span class="suggestion" onclick="envoyer('Comment traiter la migraine naturellement ?')">🧠 Migraine</span>
        <span class="suggestion" onclick="envoyer('Symptômes de l\'hypertension')">❤️ Hypertension</span>
        <span class="suggestion" onclick="envoyer('Remèdes contre le COVID-19')">🦠 COVID-19</span>
        <span class="suggestion" onclick="envoyer('Traitement naturel de l\'anémie')">🩸 Anémie</span>
    </div>

    <div class="messages" id="messages">
        <div class="message">
            <div class="msg-avatar ia">🤖</div>
            <div class="msg-bubble ia">
                👋 Bonjour ! Je suis l'assistant IA de BioLink.

Je peux vous aider à :
🔬 Trouver une pathologie par nom ou symptôme
🌿 Découvrir des remèdes naturels validés
🛡️ Vous informer sur la prévention

Notre base contient <strong><?php echo e(\App\Models\Pathologie::where('approuve', true)->count()); ?></strong> pathologies !

Posez votre question 👇
            </div>
        </div>
    </div>

    <div class="typing" id="typing">
        <div class="msg-avatar ia">🤖</div>
        <div class="typing-dots">
            <span></span><span></span><span></span>
        </div>
    </div>

    <div class="input-area">
        <input type="text" class="msg-input" id="msgInput" placeholder="Ex: Quels remèdes pour le diabète ?" onkeypress="if(event.key==='Enter') envoyer()">
        <button class="send-btn" onclick="envoyer()">➤</button>
    </div>
</div>

<script>
const messagesDiv = document.getElementById('messages');
const typing = document.getElementById('typing');
const input = document.getElementById('msgInput');

function envoyer(texte) {
    const msg = texte || input.value.trim();
    if (!msg) return;

    ajouterMessage(msg, 'user');
    input.value = '';

    typing.style.display = 'flex';
    messagesDiv.scrollTop = messagesDiv.scrollHeight;

    fetch('/ia/repondre', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({ message: msg })
    })
    .then(r => r.json())
    .then(data => {
        typing.style.display = 'none';
        ajouterMessage(data.reponse, 'ia');
    })
    .catch(() => {
        typing.style.display = 'none';
        ajouterMessage('❌ Erreur de connexion. Réessayez.', 'ia');
    });
}

function ajouterMessage(texte, type) {
    const div = document.createElement('div');
    div.className = 'message ' + type;
    div.innerHTML = `
        <div class="msg-avatar ${type}">${type === 'ia' ? '🤖' : '👤'}</div>
        <div class="msg-bubble ${type}">${texte}</div>
    `;
    messagesDiv.appendChild(div);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}
</script>
</body>
</html><?php /**PATH C:\laragon\www\biolink\resources\views/ia/chat.blade.php ENDPATH**/ ?>