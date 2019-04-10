<?php
    session_start();
?>
<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Dziennik Elektroniczny">
    <link rel="icon" href="/img/favicon.ico">
    <title>Jamnik</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/starter-template.css" rel="stylesheet">
  </head>

  <body>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="/pl/panel">Jamnik</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <?php 
      if($_SESSION['upr']==1 OR $_SESSION['upr']==2){
        echo "
        <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='' id='dropdown01' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Administracja</a>
        <div class='dropdown-menu' aria-labelledby='dropdown01'>
          <a class='dropdown-item' href='/pl/admin/szkola'>Szkoła</a>
          <a class='dropdown-item' href='/pl/admin/uzytkownicy'>Użytkownicy</a>
          <a class='dropdown-item' href='/pl/admin/klasy'>Klasy</a>
          <a class='dropdown-item' href='/pl/admin/przedmioty'>Przedmioty</a>
        </div>
      </li>
        ";
      }
      ?>
      <li class="nav-item">
        <a class="nav-link" href="/pl/biblioteka">Biblioteka</a>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle active" href="" id="dropdown99" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['imie']." ".$_SESSION['nazwisko']." (".$_SESSION['uprawnienia'].")"; ?></a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown99">
          <a class="dropdown-item" href="/pl/uzytkownik">Ustawienia</a>
          <a class="dropdown-item" href="/pl/wyloguj">Wyloguj</a>
        </div>
      </li>
    </ul>
  </div>
</nav>

    <main role="main" class="container">

      <div class="starter-template">
        <h1>Zmiana hasła:</h1>
        <?php
            if($_SESSION['zmien_haslo']==1){
                echo "<h6 style='color:orange'>Musisz zmienić hasło!</h6>";
            }else {
              echo "<a href='/pl/uzytkownik'><button class='btn btn-success'>Powrót</button></a>";
            }
        ?>
        <?php 
            if(isset($_SESSION['error'])){
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            }
        ?>
        <form method="POST" action="/pl/uzytkownik/zmien-haslo-skrypt">
            <table class="table">
                <tr>
                    <td>
                        <span>Nowe hasło: </span>
                    </td>
                    <td>
                        <input type="text" id="haslo-nowe" name="haslo-nowe"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Powtórz nowe hasło: </span>
                    </td>
                    <td>
                        <input type="text" id="haslo-nowe2" name="haslo-nowe2"></input>
                    </td>
                </tr>
            </table>
            <input type="submit" class="btn btn-primary" value="Zmień hasło"></input>
        </form>
      </div>

    </main>

    <script src="/js/jquery.min.js"></script>
	<script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>