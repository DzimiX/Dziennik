<?php
    session_start();

    if($_SESSION['upr']!=1 AND $_SESSION['upr']!=2){
        header('Location: /');
        exit();
      }
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
      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class='nav-item dropdown'>
            <a class='nav-link active dropdown-toggle' href='' id='dropdown01' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Administracja</a>
            <div class='dropdown-menu' aria-labelledby='dropdown01'>
                <a class='dropdown-item' href='/pl/admin/szkola'>Szkoła</a>
                <a class='dropdown-item active' href='/pl/admin/uzytkownicy'>Użytkownicy</a>
                <a class='dropdown-item' href='/pl/admin/klasy'>Klasy</a>
                <a class='dropdown-item' href='/pl/admin/przedmioty'>Przedmioty</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/pl/biblioteka">Biblioteka</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="" id="dropdown99" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['imie']." ".$_SESSION['nazwisko']." (".$_SESSION['uprawnienia'].")"; ?></a>
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
        <h1>Nowy użytkownik</h1>
        <a href="/pl/admin/uzytkownicy"<button class="btn btn-success">Powrót</button></a>
        <?php 
            if(isset($_SESSION['error'])){
                echo "<div>";
                echo $_SESSION['error'];
                echo "</div>";
                unset($_SESSION['error']);
            }
        ?>
        <form method="POST" action="/pl/admin/uzytkownik-skrypt">
            <table class="table">
                <tr>
                    <td>
                        <span>Imię: </span>
                    </td>
                    <td>
                        <input type="text" id="imie" name="imie"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Nazwisko: </span>
                    </td>
                    <td>
                        <input type="text" id="nazwisko" name="nazwisko"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>PESEL: </span>
                    </td>
                    <td>
                        <input type="text" id="PESEL" name="PESEL"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Uprawnienia: </span>
                    </td>
                    <td>
                        <select type="text" id="uprawnienia" name="uprawnienia">
                            <option value="1">Administrator</option>
                            <option value="2">Dyrektor</option>
                            <option value="3">Nauczyciel</option>
                            <option value="4">Rodzic</option>
                            <option selected value="5">Uczeń</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Pracownik biblioteki: </span>
                    </td>
                    <td>
                        <select type="text" id="bibliotekarz" name="bibliotekarz">
                            <option selected value="0">Nie</option>
                            <option value="1">Tak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Login: </span>
                    </td>
                    <td>
                        <input type="text" id="login" name="login"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Hasło: </span>
                    </td>
                    <td>
                        <input type="text" id="haslo" name="haslo"></input>
                    </td>
                </tr>
            </table>
            <input type="submit" class="btn btn-primary" value="Dodaj"></input>
        </form>
      </div>

    </main>

    <script src="/js/jquery.min.js"></script>
	<script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/uzytkownik.js"></script>
  </body>
</html>
