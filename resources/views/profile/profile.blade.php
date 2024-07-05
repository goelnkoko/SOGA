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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
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
                <button class="edit-button" id="edit-profile">Editar perfil</button>
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
            <div class="edit-field lists">
                <div class="item list-item">
                    <h3>Hobbies</h3>
                    <ul id="hobbies">
                        {{--Aqui virá a lista de hobbies--}}
                    </ul>
                </div>
                <div class="item list-item">
                    <h3>Interesses</h3>
                    <ul id="interests">
                        {{--Aqui virá a lista dos interesses--}}
                    </ul>
                </div>
            </div>

            <div class="edit-field big-items">
                <div class="edit-education">
                    <h3>Educação</h3>
                    <div class="education-items" id="educations">
                        {{--Aqui serão inseridos os itens da educação--}}
                    </div>
                </div>
                <div class="edit-education">
                    <h3>Trabalho</h3>
                    <div class="education-items" id="works">
                        {{--Aqui serão inseridos os itens da educação--}}
                    </div>
                </div>
                <div class="edit-education">
                    <h3>Contactos</h3>
                    <div class="education-items" id="contacts">
                        {{--Aqui serão inseridos os itens da educação--}}
                    </div>
                </div>
            </div>



        </div>
        </div>
    </div>


    {{-- Código para edição do perfil --}}
    <div class="edit-profile">
        <div class="edit-photo">
            <div class= "edit-btn">
                <button class="edit-button" id="back-profile">Voltar ao perfil</button>
            </div>

            <div class="profile-photo">
                <div class="profile-pic" id="edit-profile-pic">
                    <!-- A imagem do perfil será adicionada aqui -->
                </div>
                <input type="file" id="profile-photo-input" name="photo" style="display: none;">
                <div class="edit-profile-photo">
                    <button id="upload-photo-btn"><i class="fas fa-camera"></i></button>
                </div>
            </div>
        </div>

        <!-- Modal para confirmar o envio da foto-->
        <div id="photoModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="image-crop-container">
                    <img id="image-to-crop" src="" alt="Imagem a ser cortada">
                </div>
                <button id="save-photo-btn">Salvar</button>
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
                        {{--Os gêneros serão adicionados dinamicamente--}}
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
                <h3>Hobbies</h3>
                <ul id="edit-hobbies">
                    {{--Aqui virá a lista de hobbies--}}
                </ul>
                <input type="text" id="new-hobby" placeholder="Novo hobby">
                <button class="edit-btn" id="add-hobby-btn">+ Adicionar hobby</button>
            </div>
            <div class="item list-item">
                <h3>Interesses</h3>
                <ul id="edit-interests">
                    {{--Aqui virá a lista dos interesses--}}
                </ul>
                <input type="text" id="new-interest" placeholder="Novo interesse">
                <button class="edit-btn" id="add-interest-btn">+ Adicionar interesse</button>
            </div>
        </div>

        <div class="edit-field big-items">

            <div class="edit-education">
                <h3>Educação</h3>
                <div class="education-items" id="edit-education">
                    {{--Aqui serão inseridos os itens da educação--}}
                </div>

                <div class="add-education-header">
                    <h4>Adicionar educação</h4>
                    <button class="edit-btn" id="add-education-btn">+ Adicionar Educação</button>
                </div>
                <div class="item new-education">
                    <input type="text" id="new-education-description" placeholder="Descrição">
                    <input type="text" id="new-education-institution" placeholder="Instituição">
                    <input type="text" id="new-education-course" placeholder="Curso">
                    <input type="date" id="new-education-startDate" placeholder="Data de Início">
                    <input type="date" id="new-education-endDate" placeholder="Data de Término">
                </div>
            </div>
        </div>

    </div>

    <script src="{{ url('assets/js/menu.js') }}"></script>
    <script src="{{url('assets/js/profile.js')}}"></script>
    <script src="{{url('assets/js/profile-edit.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
</body>
</html>
