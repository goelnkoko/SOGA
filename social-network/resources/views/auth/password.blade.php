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
    <form method="POST" action="{{route('password-recover')}}">
      <h1 style="font-size: 150%;">Reedefinir senha</h1>
      <p> Informe o e-mail para o qual deseja </p>
      <p >reedefinir a sua senha.</p>
      <div class="input-box">
        <input name="username" type="text" placeholder="Username " required>
        <i class='bx bxs-user'></i>
      </div>
      
      <div class="remember-forgot">
     
       
      </div>
      <button type="submit" class="btn">Reedefinir</button>
      <div class="register-link">
       
      </div>
    </form>
  </div>
</body>
</html>