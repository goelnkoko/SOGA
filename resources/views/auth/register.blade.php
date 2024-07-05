<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastrar</title>
  <link rel="stylesheet" href="{{url('assets/css/autenticacao.css')}}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="wrapper-2">
    <form method="POST" action="{{route('register')}}">
      @csrf
      <h1>Criar sua conta</h1>
      <div class="input-box-2">
        <input name="name" type="text" placeholder="Nome" required>

        <input name="username" type="text" placeholder="Username" required>

        <input name="email" type="email" placeholder="Email" required>

        <input name="gender" type="" placeholder="Genero">
        <input name="gender" type="" placeholder="Genero">

        <input name="password" type="password" placeholder="Senha" required>

        <input name="confirm_password" type="password" placeholder=" Confirmar senha" required>

      </div>

<div class="pp">
    <p>Ao clicar em registar, voce aceita as nossas </p>
</div>

<div class="ppc">
    <p>Politicas de Privacidade e a Politica de Cookies</p>
</div>

<button type="submit" class="btn">Criar</button>

    </form>
  </div>
</body>
</html>
