<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Amizades</title>

    <link rel="stylesheet" href="{{url('assets/css/friend.css')}}">
</head>
<body>

    @extends('layouts.menu')


    <div class="container">
        <div class="friend-space suggestions" id="profile-suggestions">
            <h4>Sugestões</h4>
        </div>
        <div class="friend-space request-sent">
            <h4>Pedidos enviados</h4>

        </div>
        <div class="friend-space request-received" id="friend-request">
            <h4>Pedidos recebidos</h4>

        </div>
        <div class="friend-space ">
            <h4>Reserva</h4>

        </div>
    </div>

    <script src="{{ url('assets/js/menu.js') }}"></script>
    <script src="{{ url('assets/js/friend.js') }}"></script>
    <script src="{{ url('assets/js/rightbar.js') }}"></script>
</body>
</html>
