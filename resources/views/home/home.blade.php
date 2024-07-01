<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOGA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link rel="stylesheet" href="{{ url('assets/css/home.css') }}">
</head>

<body>
    @extends('layouts.menu')

    <div class="container">
        <div class="feed">
            <div class="publicar" id="drop-zone">
                <div class="user-photo">
                    <img src="{{ url('assets/img/obanai-iguro.png') }}" alt="Foto do Gyomei">
                </div>
                <form id="post-form" class="post-content">
                    @csrf
                    <textarea name="content" id="post" cols="30" rows="1" placeholder="Escreva uma postagem, haha, tosse!" oninput="adjustTextarea(this)"></textarea>
                    <div id="thumbnails"></div>
                    <div class="icons">
                        <button id="upload-button" type="button">
                            <span class="material-symbols-outlined">image</span>
                            <p>Media</p>
                        </button>
                        <input type="file" id="file-input" multiple style="display:none;" accept="image/*,video/*">
                        <button type="submit" id="send-button"><span class="material-symbols-outlined">send</span></button>
                    </div>
                </form>
            </div>

            <div class="posts" id="posts-container">
                <!-- Publicações serão inseridas aqui -->
            </div>
        </div>
    </div>

    <div id="modal" class="modal hidden">
        <div class="modal-content">
            <div class="modal-left">
                <button class="prev-button" onclick="prevSlide()">❮</button>
                <div id="media-container" class="media-container"></div>
                <button class="next-button" onclick="nextSlide()">❯</button>
            </div>
            <div class="modal-right">
                <div class="post-info">
                    <img src="assets/img/ningning.jpg" alt="Profile Photo" class="profile-photo">
                    <div class="user-details">
                        <span id="modal-username">Username</span>
                        <p id="modal-handle">@handle</p>
                        <p id="modal-time">Time</p>
                    </div>
                    <span class="material-symbols-outlined material-style" id="modal-more-options">more_vert</span>
                </div>
                <div id="modal-content-text" class="modal-content-text"></div>
                <div class="modal-reactions">
                    <button id="modal-like" class="unliked">
                        <span class="material-symbols-outlined material-style">sentiment_sad</span>
                    </button>
                    <button id="modal-comment">
                        <span class="material-symbols-outlined material-style">comment</span>
                    </button>
                    <button id="modal-share">
                        <span class="material-symbols-outlined material-style">share</span>
                    </button>
                </div>
                <textarea id="modal-comment-input" class="comment-input" placeholder="Escreva um comentário..."></textarea>
            </div>
        </div>
    </div>

    @extends('layouts.rightbar')

    <script src="{{ url('assets/js/menu.js') }}"></script>
    <script src="{{ url('assets/js/rightbar.js') }}"></script>
    <script src="{{ url('assets/js/friend.js') }}"></script>
    <script src="{{ url('assets/js/home.js') }}"></script>
</body>
</html>
