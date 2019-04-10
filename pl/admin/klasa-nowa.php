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
          <a class='dropdown-item' href='/pl/admin/uzytkownicy'>Użytkownicy</a>
          <a class='dropdown-item active' href='/pl/admin/klasy'>Klasy</a>
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
        <h1>Nowa klasa</h1><a href="/pl/admin/klasy"<button class="btn btn-success">Powrót</button></a>
        <?php 
            if(isset($_SESSION['error'])){
                echo "<div>";
                echo $_SESSION['error'];
                echo "</div>";
                unset($_SESSION['error']);
            }
        ?>
        <form method="POST" action="/pl/admin/klasa-skrypt">
            <table class="table">
                <tr>
                    <td>
                        <span>Nazwa: </span>
                    </td>
                    <td>
                        <input type="text" id="nazwa" name="nazwa"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Rocznik: </span>
                    </td>
                    <td>
                        <input type="text" id="rocznik" name="rocznik"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Klasa wirtualna: </span>
                    </td>
                    <td>
                        <select id="wirtualna" name="wirtualna">
                            <option value="0" selected>Nie</option>
                            <option value="1">Tak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Wychowawca: </span>
                    </td>
                    <td>
                        <select id="wychowawca" name="wychowawca">
                            <option value="0" selected>Brak (klasa wirtualna)</option>
                            <?php
                                mysqli_report(MYSQLI_REPORT_STRICT);
                                
                                define("BAZA", true);
                                require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");
                                
                                try {
                                  $connection = new mysqli($host, $db_user, $db_password, $db_name);
                                  if ($connection->connect_errno!=0){
                                    throw new Exception(mysqli_connect_errno());
                                  } else {
                                    $sql = "SELECT *, uzytkownicy.id AS iduser FROM uzytkownicy WHERE id_uprawnienia='3';";
                                    
                                    if(!$result = $connection->query($sql)){
                                      die();
                                    } else {
                                      while($row = $result->fetch_assoc()){
                                        echo "<option value='".$row['iduser']."'>".$row['imie']." ".$row['nazwisko']."</option>";
                                      }
                                    }
                                
                                    $connection->close();
                                  }
                                } catch(Exception $e) {
                                }
                            ?>
                        </select>
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
