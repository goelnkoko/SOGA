<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="{{url('assets/css/definicoes.css')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="definicoes.css">
</head>
<body>
@extends('layouts.menu')
    <leftBar></leftBar>

    <div class="menu">
        <div class="menu-item">
            <i class="material-icons">help_outline</i>
            <span>Ajuda e Suporte</span>
        </div>
       
        
        <div class="menu-item">
            <i class="material-icons">person</i>
            <span>Ajuste do perfil</span>
        </div>
        <div class="menu-item">
            <i class="material-icons">swap_horiz</i>
            <span>Mudar conta</span>
        </div>
        <div class="menu-item">
            <i class="material-icons">logout</i>
            <a href="mudar conta"> <span  >Terminar sessão</span>  </a>
        </div>
    </div>

    <script src="../geral/js/include.js"></script>
    <script src="../geral/css/leftBar.css"></script>
   
</body>
</html>
