<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Perfil do Usuário</title>

    <link rel="stylesheet" href="{{url('assets/css/profile.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/profile_edit.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+DE+Grund:wght@100..400&display=swap" rel="stylesheet">
</head>
<body>

    @extends('layouts.menu')

    <div class="profile-page">
        <div class="profile-card">

            <div class="profile-photo">
                <div class="profile-pic">
                    {{--            A imagem do perfil será adicionado aqui--}}
                </div>
            </div>

            <div class="edit-icon">
                <i class="fas fa-camera"></i>
            </div>
            <div class= "edit-btn">
                <button class="edit-button">Editar perfil</button>
            </div>

            <div class="profile-info">
                {{--            As informações do perfil serão adicionadas aqui--}}
            </div>

            <div class="profile-tabs">
                <div class="tab active" onclick="showTab('publicacoes')"><i class="fas fa-edit"></i> Publicações</div>
                <div class="tab" onclick="showTab('fotos')"><i class="fas fa-image"></i> Fotos</div>
                <div class="tab" onclick="showTab('videos')"><i class="fas fa-video"></i> Vídeos</div>
            </div>

        </div>

        <div class="profile-right">
            <p>For a while</p>
        </div>
    </div>

    <div class="edit-profile">
        <div class="edit-photo">
            <div class="profile-photo">
                <div class="profile-pic">
                    {{--            A imagem do perfil será adicionado aqui--}}
                </div>
                <input type="file" id="profile-photo-input" name="photo">
                <div class="edit-profile-photo">
                    <button id="upload-photo-btn"><i class="fas fa-camera"></i></button>
                </div>
            </div>
        </div>
        <form class="edit-field simple">
            <div class="simple-left">
                <div class="item simple-item">
                    <label for="name">Nome</label>
                    <input type="text" name="name" id="edit-name">
                </div>
                <div class="item simple-item">
                    <label for="gender">Gênero</label>
                    <select name="gender" id="edit-gender">
{{--                        Os gêneros serão adicionados dinamicamente--}}
                    </select>
                </div>
                <div class="item simple-item">
                    <label for="location">Localização</label>
                    <input type="text" name="edit-location" id="edit-location">
                </div>

            </div>
            <div class="simple-right">
                <div class="item simple-item">
                    <label for="biography">Biografia</label>
                    <textarea name="edit-biography" id="edit-biography" cols="30" rows="7"></textarea>
                </div>
                <button class="edit-btn" id="simple-edit-btn" type="submit">Salvar</button>
            </div>
        </form>

        <div class="edit-field lists">
            <div class="item list-item">
                <ul id="hobbies">
                    <li>
                        <input type="text" value="Xadrez" readonly>
                        <button class="edit-btn" id="editar">Editar</button>
                        <button class="edit-btn" id="excluir">Excluir</button>
                    </li>
                    <li>
                        <input type="text" value="Xadrez" readonly>
                        <button class="edit-btn" id="editar">Editar</button>
                        <button class="edit-btn" id="excluir">Excluir</button>
                    </li>
                    <li>
                        <input type="text" value="Xadrez" readonly>
                        <button class="edit-btn" id="editar">Editar</button>
                        <button class="edit-btn" id="excluir">Excluir</button>
                    </li>
                </ul>
                <button class="edit-btn" id="add-item-btn">Adicionar</button>
            </div>
            <div class="item list-item">
                <ul id="interests">
                    <li>
                        <input type="text" value="Xadrez" readonly>
                        <button class="edit-btn" id="editar">Editar</button>
                        <button class="edit-btn" id="excluir">Excluir</button>
                    </li>
                    <li>
                        <input type="text" value="Xadrez" readonly>
                        <button class="edit-btn" id="editar">Editar</button>
                        <button class="edit-btn" id="excluir">Excluir</button>
                    </li>
                    <li>
                        <input type="text" value="Xadrez" readonly>
                        <button class="edit-btn" id="editar">Editar</button>
                        <button class="edit-btn" id="excluir">Excluir</button>
                    </li>
                </ul>
                <button class="edit-btn" id="add-item-btn">Adicionar</button>
            </div>
        </div>
        <div class="edit-field big-items">

        </div>
    </div>

    <script src="{{url('assets/js/profile.js')}}"></script>
    <script src="{{url('assets/js/profile-edit.js')}}"></script>
</body>
</html>
