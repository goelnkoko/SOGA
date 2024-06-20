<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="{{url('assets/css/profile_user.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="profile-card">
        <div class="header">
            <div class="profile-pic"></div>
            <div class="edit-icon">
                <i class="fas fa-camera"></i>
            </div>
        </div>
        <div class="profile-info">
            <h2>User</h2>
            <p>User@gmail.com</p>
            <p><i class="fas fa-briefcase"></i>Trabalho</p> 
            <p><i class="fas fa-map-marker-alt"></i> Cidade/País</p>
            <p><i class="fas fa-gift"></i> Nascido(a) </p>
            <p><i class="fas fa-school"></i> Instituições Academicas</p>
           
            <button class="edit-button">Editar perfil</button>
        </div>
        <div class="profile-tabs">
            <div class="tab active" onclick="showTab('publicacoes')"><i class="fas fa-edit"></i> Publicações</div>
            <div class="tab" onclick="showTab('fotos')"><i class="fas fa-image"></i> Fotos</div>
            <div class="tab" onclick="showTab('videos')"><i class="fas fa-video"></i> Vídeos</div>
        </div>

        
    </div>
    <script src="{{url('assets/js/profile_user.js')}}"></script>
</body>
</html>
