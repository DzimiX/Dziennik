<?php
    session_start();

    if($_SESSION['upr']!=1 AND $_SESSION['upr']!=2){
        header('Location: /');
        exit();
    }

    define("BAZA", true);
    require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");
    
    if( isset($_POST) AND !empty($_POST) ){
        $nazwa = $_POST['nazwa'];
        $adres = $_POST['adres'];
        $kodpocztowy = $_POST['kodpocztowy'];
        $miasto = $_POST['miasto'];
        $telefon = $_POST['telefon'];
        $email = $_POST['email'];

        $nazwa = htmlentities($nazwa);
        $adres = htmlentities($adres);
        $kodpocztowy = htmlentities($kodpocztowy);
        $miasto = htmlentities($miasto);
        $telefon = htmlentities($telefon);
        $email = htmlentities($email);

        try {
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if ($connection->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            } else {
                $sql = "UPDATE szkola SET nazwa = '$nazwa', adres = '$adres', kodpocztowy = '$kodpocztowy', miasto = '$miasto', telefon = '$telefon', email = '$email' WHERE id=1;";
        
                $connection->query($sql);
                $connection->close();
            }
        } catch(Exception $e) {
        }
    }

    try {
        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        if ($connection->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } else {
            $sql = "SELECT * from szkola LIMIT 1;";
            
            if(!$result = $connection->query($sql)){
                die();
              } else {
                while($row = $result->fetch_assoc()){
                  $nazwa = $row['nazwa'];
                  $adres = $row['adres'];
                  $kodpocztowy = $row['kodpocztowy'];
                  $miasto = $row['miasto'];
                  $telefon = $row['telefon'];
                  $email = $row['email'];
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
    <style>
        .szkola {
            width: 400px;
        }
    </style>
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
                <a class='dropdown-item active' href='/pl/admin/szkola'>Szkoła</a>
                <a class='dropdown-item' href='/pl/admin/uzytkownicy'>Użytkownicy</a>
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
        <h1>Dane szkoły</h1>
        <form method="POST" action="/pl/admin/szkola">
            <table class="table">
                <tr>
                    <td>
                        <span>Nazwa: </span>
                    </td>
                    <td>
                        <input class="szkola" type="text" id="nazwa" value="<?php echo $nazwa ?>" name="nazwa"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Adres: </span>
                    </td>
                    <td>
                        <input class="szkola" type="text" id="adres" value="<?php echo $adres ?>" name="adres"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Kod pocztowy: </span>
                    </td>
                    <td>
                        <input class="szkola" type="text" id="kodpocztowy" value="<?php echo $kodpocztowy ?>" name="kodpocztowy"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Miasto: </span>
                    </td>
                    <td>
                        <input class="szkola" type="text" id="miasto" value="<?php echo $miasto ?>" name="miasto"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Telefon: </span>
                    </td>
                    <td>
                        <input class="szkola" type="text" id="telefon" value="<?php echo $telefon ?>" name="telefon"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Email: </span>
                    </td>
                    <td>
                        <input class="szkola" type="text" id="email" value="<?php echo $email ?>" name="email"></input>
                    </td>
                </tr>
            </table>
            <input type="submit" class="btn btn-primary" value="Edytuj"></input>
        </form>
      </div>

    </main>

    <script src="/js/jquery.min.js"></script>
	<script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/uzytkownik.js"></script>
  </body>
</html>
