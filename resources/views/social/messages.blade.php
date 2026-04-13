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
        .conv-header { padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); font-size: 18px; font-weight: 700; }
        .new-conv { padding: 12px 16px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .search-input { width: 100%; padding: 10px 14px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15); border-radius: 20px; color: white; font-size: 14px; outline: none; }
        .search-input:focus { border-color: #00e5a0; }
        .search-input::placeholder { color: rgba(255,255,255,0.4); }
        .users-dropdown { background: #0d1f35; border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; margin-top: 8px; max-height: 200px; overflow-y: auto; display: none; }
        .user-option { display: flex; align-items: center; gap: 10px; padding: 10px 14px; cursor: pointer; transition: background 0.2s; text-decoration: none; color: white; }
        .user-option:hover { background: rgba(255,255,255,0.07); }
        .option-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #00e5a0, #378ADD); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #0a1628; overflow: hidden; flex-shrink: 0; }
        .option-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .option-name { font-size: 13px; font-weight: 600; }
        .option-grade { font-size: 11px; color: #00e5a0; }
        .conv-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; cursor: pointer; transition: background 0.2s; border-bottom: 1px solid rgba(255,255,255,0.05); text-decoration: none; color: white; }
        .conv-item:hover { background: rgba(255,255,255,0.05); }
        .conv-item.active { background: rgba(0,229,160,0.1); border-left: 3px solid #00e5a0; }
        .conv-avatar { width: 46px; height: 46px; border-radius: 50%; background: linear-gradient(135deg, #00e5a0, #378ADD); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; color: #0a1628; overflow: hidden; flex-shrink: 0; position: relative; }
        .conv-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .conv-info { flex: 1; min-width: 0; }
        .conv-name { font-size: 14px; font-weight: 700; margin-bottom: 3px; }
        .conv-preview { font-size: 12px; color: rgba(255,255,255,0.5); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .unread-badge { background: #00e5a0; color: #0a1628; font-size: 10px; font-weight: 700; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .empty-chat { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: rgba(255,255,255,0.4); text-align: center; padding: 40px; }
        .section-label { padding: 8px 16px; font-size: 11px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; background: rgba(255,255,255,0.02); }
    </style>
</head>
<body>

@include('components.navbar')

<div class="messages-layout">
    <div class="conversations-list">
        <div class="conv-header">💬 Messages</div>

        <div class="new-conv">
            <input type="text" class="search-input" placeholder="🔍 Rechercher un membre..." id="searchUser" onkeyup="filterUsers(this.value)" onfocus="showDropdown()" onblur="setTimeout(hideDropdown, 200)">
            <div class="users-dropdown" id="usersDropdown">
                @foreach($users as $user)
                <a href="/messages/{{ $user->id }}" class="user-option" data-name="{{ strtolower($user->name) }}">
                    <div class="option-avatar">
                        @if($user->photo_profil)
                            <img src="{{ Storage::url($user->photo_profil) }}" alt="">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="option-name">{{ $user->name }}</div>
                        <div class="option-grade">{{ $user->nom_grade['emoji'] }} {{ $user->nom_grade['nom'] }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        @if(count($conversations) > 0)
            <div class="section-label">Conversations récentes</div>
            @foreach($conversations as $conv)
            <a href="/messages/{{ $conv['user']->id }}" class="conv-item">
                <div class="conv-avatar">
                    @if($conv['user']->photo_profil)
                        <img src="{{ Storage::url($conv['user']->photo_profil) }}" alt="">
                    @else
                        {{ strtoupper(substr($conv['user']->name, 0, 1)) }}
                    @endif
                </div>
                <div class="conv-info">
                    <div class="conv-name">{{ $conv['user']->name }}</div>
                    <div class="conv-preview">
                        {{ $conv['lastMsg']->sender_id == Auth::id() ? 'Vous : ' : '' }}{{ Str::limit($conv['lastMsg']->contenu, 35) }}
                    </div>
                </div>
                @if($conv['unread'] > 0)
                    <div class="unread-badge">{{ $conv['unread'] }}</div>
                @endif
            </a>
            @endforeach
        @else
            <div style="padding:24px 16px; text-align:center; color:rgba(255,255,255,0.4); font-size:13px;">
                Aucune conversation.<br>Recherchez un membre ci-dessus !
            </div>
        @endif

        <div class="section-label">Tous les membres</div>
        @foreach($users->take(20) as $user)
        <a href="/messages/{{ $user->id }}" class="conv-item">
            <div class="conv-avatar">
                @if($user->photo_profil)
                    <img src="{{ Storage::url($user->photo_profil) }}" alt="">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>
            <div class="conv-info">
                <div class="conv-name">{{ $user->name }}</div>
                <div class="conv-preview">{{ $user->nom_grade['emoji'] }} {{ $user->nom_grade['nom'] }} · ⭐ {{ $user->points }} pts</div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="empty-chat">
        <div style="font-size:64px; margin-bottom:16px;">💬</div>
        <h3 style="font-size:20px; color:rgba(255,255,255,0.7); margin-bottom:8px;">Vos messages</h3>
        <p style="font-size:14px; margin-bottom:20px;">Sélectionnez une conversation ou écrivez à un membre</p>
        <p style="font-size:13px; color:rgba(255,255,255,0.3);">Recherchez n'importe quel membre dans la barre ci-dessus</p>
    </div>
</div>

<script>
function showDropdown() {
    document.getElementById('usersDropdown').style.display = 'block';
}
function hideDropdown() {
    document.getElementById('usersDropdown').style.display = 'none';
}
function filterUsers(value) {
    const dropdown = document.getElementById('usersDropdown');
    dropdown.style.display = 'block';
    const search = value.toLowerCase();
    document.querySelectorAll('.user-option').forEach(option => {
        const name = option.getAttribute('data-name');
        option.style.display = name.includes(search) ? 'flex' : 'none';
    });
}
</script>

</body>
</html>