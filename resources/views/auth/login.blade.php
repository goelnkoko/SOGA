<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Soga</title>
  <link rel="stylesheet" href="{{url('assets/css/autenticacao.css')}}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="wrapper">
    <form method="POST" action="{{route('login')}}">
        @csrf
      <h1>Login</h1>
      <div class="input-box">
        <input name="username" type="text" placeholder="Email ou Numero de telefone" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input name="password" type="password" placeholder="Senha" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      @error('message')
        <span class="text-red-600">{{ $message }}</span>
      @enderror
      <div class="remember-forgot">
        <label><input type="checkbox">Lembrar-me</label>
        <a href="{{route('password-recover')}}">Esqueceu a senha?</a>
      </div>
      <button type="submit" class="btn">Iniciar Sessao</button>
      <div class="register-link">
        <p>Ja tem uma conta? <a href="{{route('register')}}">Registrar-se</a></p>
      </div>
    </form>
  </div>
</body>
</html>