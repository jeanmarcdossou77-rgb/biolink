<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink – Messages</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0a1628; color: white; height: 100vh; display: flex; flex-direction: column; }
        .messages-layout { display: grid; grid-template-columns: 320px 1fr; flex: 1; overflow: hidden; max-height: calc(100vh - 64px); }
        .conversations-list { border-right: 1px solid rgba(255,255,255,0.1); overflow-y: auto; background: rgba(255,255,255,0.02); }
        .conv-header { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); font-size: 18px; font-weight: 700; }
        .conv-item { display: flex; gap: 12px; padding: 14px 16px; cursor: pointer; transition: background 0.2s; border-bottom: 1px solid rgba(255,255,255,0.05); text-decoration: none; color: white; }
        .conv-item:hover { background: rgba(255,255,255,0.05); }
        .conv-avatar { width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #00e5a0, #378ADD); display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; color: #0a1628; overflow: hidden; flex-shrink: 0; }
        .conv-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .conv-name { font-size: 14px; font-weight: 700; margin-bottom: 4px; }
        .conv-preview { font-size: 13px; color: rgba(255,255,255,0.5); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px; }
        .empty-messages { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: rgba(255,255,255,0.4); text-align: center; padding: 40px; }
        .new-conv { padding: 16px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .new-conv select { width: 100%; padding: 10px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; color: white; outline: none; font-size: 14px; }
        .new-conv select option { background: #0a1628; }
    </style>
</head>
<body>

@include('components.navbar')

<div class="messages-layout">
    <div class="conversations-list">
        <div class="conv-header">💬 Messages</div>

        <div class="new-conv">
            <select onchange="if(this.value) window.location='/messages/'+this.value">
                <option value="">Nouvelle conversation...</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        @if($conversations->count() > 0)
            @foreach($conversations as $userId => $msgs)
                @php
                    $lastMsg = $msgs->last();
                    $otherUser = $lastMsg->sender_id == Auth::id() ? $lastMsg->receiver : $lastMsg->sender;
                @endphp
                <a href="/messages/{{ $otherUser->id }}" class="conv-item">
                    <div class="conv-avatar">
                        @if($otherUser->photo_profil)
                            <img src="{{ Storage::url($otherUser->photo_profil) }}" alt="">
                        @else
                            {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="conv-name">{{ $otherUser->name }}</div>
                        <div class="conv-preview">{{ $lastMsg->contenu }}</div>
                    </div>
                </a>
            @endforeach
        @else
            <div style="padding:30px; text-align:center; color:rgba(255,255,255,0.4); font-size:14px;">
                Aucune conversation.<br>Commencez à discuter !
            </div>
        @endif
    </div>

    <div class="empty-messages">
        <div style="font-size:64px; margin-bottom:16px;">💬</div>
        <h3 style="font-size:20px; color:rgba(255,255,255,0.7); margin-bottom:8px;">Vos messages</h3>
        <p style="font-size:14px;">Sélectionnez une conversation ou commencez-en une nouvelle</p>
    </div>
</div>

</body>
</html>