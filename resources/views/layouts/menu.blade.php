<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
<link rel="stylesheet" href="{{url('assets/css/menu.css')}}">

<div class="leftBar">
    <div id="logo"><a href="../home/home.html"><img src="{{url('assets//img/logo.png')}}" alt=""></a></div>
    <div class="user-profile" id="profile-left">
        {{-- Vamos adicionar informacoes do perfil aqui com JS --}}
    </div>
    <div id="left-menu">
        <div class="left-menu-item" id="home">
            <a href="/home">
                <span class="material-symbols-outlined material-style">home</span>
                <p>Página Inicial</p>
            </a>
        </div>
        <div class="left-menu-item" id="message">
            <a href="/chat">
                <span class="material-symbols-outlined material-style">message</span>
                <p>Chat</p>
            </a>
        </div>
        <div class="left-menu-item" id="friends">
            <a href="/friends">
                <span class="material-symbols-outlined material-style">sports_martial_arts</span>
                <p>Amizades</p>
            </a>
        </div>

        <div class="left-menu-item" id="notifications">
            <a href="../notificacao/notificacoes.html">
                <span class="material-symbols-outlined material-style">notifications</span>
                <p>Notificações</p>
            </a>
        </div>
        <div class="left-menu-item" id="settings">
            <a href="../definicoes/definicoes.html">
                <span class="material-symbols-outlined material-style">settings</span>
                <p>Definições</p>
            </a>
        </div>
        <div class="left-menu-item" id="more">
            <a href="#">
                <span class="material-symbols-outlined material-style">more_horiz</span>
                <p>Mais</p>
            </a>
        </div>
    </div>
</div>
