<?php
    session_start();

    define("BAZA", true);
    require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");

    $id = $_SESSION['id'];

    try {
      $connection = new mysqli($host, $db_user, $db_password, $db_name);
      if ($connection->connect_errno!=0){
          throw new Exception(mysqli_connect_errno());
      } else {
          $sql = "SELECT * from uzytkownicy, uprawnienia WHERE id_uprawnienia=uprawnienia.id AND uzytkownicy.id='".$id."';";
          
          if(!$result = $connection->query($sql)){
              die();
          } else {
              while($row = $result->fetch_assoc()){
                $imie = $row['imie'];
                $nazwisko = $row['nazwisko'];
                $PESEL = $row['PESEL'];
                $nazwa = $row['nazwa'];
                $login = $row['login'];
                $email = $row['email'];
                $telefon = $row['telefon'];
              }
            }
            $connection->close();
      }
  } catch(Exception $e) {
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
        <?php
            if($_SESSION['zmien_haslo']==1){
                echo "<h6 style='color:orange'>Musisz zmienić hasło!</h6>";
            }
        ?>
        <h1>Ustawienia:</h1>
        <a href="/pl/panel"<button class="btn btn-success">Powrót</button></a>
        <a href="/pl/uzytkownik/zmien-haslo"<button class="btn btn-danger">Zmień hasło</button></a>
        <?php 
            if(isset($_SESSION['error'])){
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            }
        ?>
            <table class="table">
                <tr>
                    <td>
                        <span>Imię: </span>
                    </td>
                    <td>
                        <input disabled type="text" value="<?php echo $imie; ?>" placeholder=""></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Nazwisko: </span>
                    </td>
                    <td>
                        <input disabled type="text" value="<?php echo $nazwisko; ?>" placeholder=""></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>PESEL: </span>
                    </td>
                    <td>
                        <input disabled type="text" value="<?php echo $PESEL; ?>" placeholder=""></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Uprawnienia: </span>
                    </td>
                    <td>
                        <input disabled type="text" value="<?php echo $nazwa; ?>" placeholder=""></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Login: </span>
                    </td>
                    <td>
                        <input disabled type="text" value="<?php echo $login; ?>" placeholder=""></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Email: </span>
                    </td>
                    <td>
                        <input disabled type="text" value="<?php echo $email; ?>" placeholder=""></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Telefon: </span>
                    </td>
                    <td>
                        <input disabled type="text" value="<?php echo $telefon; ?>" placeholder=""></input>
                    </td>
                </tr>
            </table>
      </div>

    </main>

    <script src="/js/jquery.min.js"></script>
	<script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>