<?php
  session_start();
  if( isset($_SESSION['id'])){
    header('Location: /pl/panel');
  }
?>
<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Dziennik Elektroniczny">
    <link rel="icon" href="/img/favicon.ico">
    <title>Jamnik - Logowanie</title>
    <link href="/css/signin.css" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>

  <body>
    <div class="container">
      <form class="form-signin">
        <a href="/pl/clicker"><img id="logo" style="width:250px;margin:25px;margin-bottom:15px;" src="/img/logo.svg" alt="Jamnik Logo"></img></a>
        <input id="username" type="text" placeholder="Login" required autofocus>
        <input id="password" type="password" placeholder="Hasło" required></br>
        <button id="submit_login" class="btn btn-lg btn-primary btn-block" type="submit">Zaloguj się</button>
        <div class="errormess"></div>
      </form>
    </div>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/login.js"></script>
  </body>
</html>
