<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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

@extends('layouts.rightbar')

<script src="{{ url('assets/js/menu.js') }}"></script>
<script src="{{ url('assets/js/rightbar.js') }}"></script>
<script src="{{ url('assets/js/home.js') }}"></script>
</body>
</html>
