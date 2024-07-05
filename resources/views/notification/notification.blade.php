<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Notificações</title>

    <link rel="stylesheet" href="{{url('assets/css/notification.css')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+DE+Grund:wght@100..400&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>

    @extends('layouts.menu')

    <div class="content">
        <div class="notifications">
            <div class="new-notifications">
                <h3>Novas</h3>
                <div class="notification">
                    <div class="user-icon"></div>
                    <p>User 4 gostou da tua publicação</p>
                </div>
            </div>
            <div class="old-notifications">
                <h3>Anteriores</h3>
                <div class="notification">
                    <div class="user-icon"></div>
                    <p>User 3 começou a seguir-te</p>
                </div>
                <div class="notification">
                    <div class="user-icon"></div>
                    <p>User 4 fez uma nova publicação</p>
                </div>
                <div class="notification">
                    <div class="user-icon"></div>
                    <p>User 2 adicionou 2 vídeos novos</p>
                </div>
            </div></div>
    </div>

    @extends('layouts.rightbar')

    <script src="{{ url('assets/js/menu.js') }}"></script>
    <script src="{{ url('assets/js/rightbar.js') }}"></script>
    <script src="{{ url('assets/js/friend.js') }}"></script>
    <script src="{{url('assets/js/notification.js')}}"></script>
</body>
</html>
