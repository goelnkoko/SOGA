<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat rede social</title>
    <link rel="stylesheet" href="{{url('assets/css/chat.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    @extends('layouts.menu')

    <div class="chat-user-friend">
        <div class="leftbar">
            <div class="chat-header friends-list"><h4>Conexões</h4></div>
            <div class="search">
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar">
            </div>

            <div class="connections-list">

            </div>
        </div>

        <div class="chat-container">
            <div class="chat-header friend-profile">
                <div id="profile-photo"><img src="assets/img/user.png" alt="Foto"></div>
                <div><h4>Benvinda João</h4></div>
            </div>
            <div class="chat-messages">

            </div>

            <form class="input-form">
                <textarea id="message-text" name="story" rows="1" cols="33" placeholder="Mensagem"></textarea>
                <button id="btn-send" type="submit" class="button send-button"></button>
            </form>
        </div>

    </div>



    <script src="{{ url('assets/js/menu.js') }}"></script>
    <script src="{{ url('assets/js/chat.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
