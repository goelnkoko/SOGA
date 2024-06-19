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
  <div class="wrapper">
    <form method="POST" action="{{route('register')}}">
      @csrf
      <h1>Criar sua conta</h1>
      <div class="input-box">
        <input name="name" type="text" placeholder="Nome" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input name="username" type="text" placeholder="Username" required>
        <i class='bx bxs-username'></i>
      </div>
      <div class="input-box">
        <input name="email" type="email" placeholder="Email" required>
        <i class='bx bxs-e-mail'></i>
      </div>
      <div class="input-box">
        <input name="phone" type="tel" placeholder="Telefone">
        <i class='bx bxs-phone'></i>
      </div>
      <div class="input-box">
        <input name="password" type="password" placeholder="Senha" required>
        <i class='bx bxs-lock-alt' ></i>
      </div> <div class="input-box">
        <input name="confirm_password" type="password" placeholder=" Confirmar senha" required>
        <i class='bx bxs-lock-alt' ></i>
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