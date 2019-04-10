<?php
    session_start();

    if($_SESSION['upr']!=1 AND $_SESSION['upr']!=2){
        header('Location: /');
        exit();
    }

    if( !isset($_GET) OR !isset($_GET['id']) ){
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/uzytkownicy');
        exit();
    } else if( $_GET['id']=='' ) {
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/uzytkownicy');
        exit();
    } else {
        $id = $_GET['id'];
        
        define("BAZA", true);
        require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");

        if( isset($_POST) AND !empty($_POST) ){
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];
            $PESEL = $_POST['PESEL'];
            $id_uprawnienia = $_POST['id_uprawnienia'];
            $bibliotekarz = $_POST['bibliotekarz'];
            $login = $_POST['login'];
    
            $imie = htmlentities($imie);
            $nazwisko = htmlentities($nazwisko);
            $PESEL = htmlentities($PESEL);
            $id_uprawnienia = htmlentities($id_uprawnienia);
            $bibliotekarz = htmlentities($bibliotekarz);
            $login = htmlentities($login);
    
            try {
                $connection = new mysqli($host, $db_user, $db_password, $db_name);
                if ($connection->connect_errno!=0){
                    throw new Exception(mysqli_connect_errno());
                } else {
                    $sql = "UPDATE uzytkownicy SET imie = '$imie', nazwisko = '$nazwisko', pesel = '$PESEL', id_uprawnienia = '$id_uprawnienia', bibliotekarz = '$bibliotekarz', login = '$login' WHERE id='".$id."';";
            
                    $connection->query($sql);
                    $_SESSION['error'] = "Zaktualizowano dane!";
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
                $sql = "SELECT * from uzytkownicy WHERE id='".$id."';";
                
                if(!$result = $connection->query($sql)){
                    die();
                } else {
                    while($row = $result->fetch_assoc()){
                      $imie = $row['imie'];
                      $nazwisko = $row['nazwisko'];
                      $PESEL = $row['PESEL'];
                      $id_uprawnienia = $row['id_uprawnienia'];
                      $bibliotekarz = $row['bibliotekarz'];
                      $login = $row['login'];
                    }
                  }
                  $connection->close();
                
    
            }
        } catch(Exception $e) {
        }
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
        <h1>Edycja użytkownika</h1>
        <a href="/pl/admin/uzytkownicy"<button class="btn btn-success">Powrót</button></a>
        <?php 
            if(isset($_SESSION['error'])){
                echo "<div>";
                echo $_SESSION['error'];
                echo "</div>";
                unset($_SESSION['error']);
            }
        ?>
        <form method="POST">
            <table class="table">
                <tr>
                    <td>
                        <span>Imię: </span>
                    </td>
                    <td>
                        <input type="text" id="imie" value="<?php echo $imie; ?>" name="imie"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Nazwisko: </span>
                    </td>
                    <td>
                        <input type="text" id="nazwisko" value="<?php echo $nazwisko; ?>" name="nazwisko"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>PESEL: </span>
                    </td>
                    <td>
                        <input type="text" id="PESEL" value="<?php echo $PESEL; ?>" name="PESEL"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Uprawnienia: </span>
                    </td>
                    <td>
                        <select type="text" id="id_uprawnienia" name="id_uprawnienia">
                            <option <?php if($id_uprawnienia == 1){echo "selected";} ?> value="1">Administrator</option>
                            <option <?php if($id_uprawnienia == 2){echo "selected";} ?> value="2">Dyrektor</option>
                            <option <?php if($id_uprawnienia == 3){echo "selected";} ?> value="3">Nauczyciel</option>
                            <option <?php if($id_uprawnienia == 4){echo "selected";} ?> value="4">Rodzic</option>
                            <option <?php if($id_uprawnienia == 5){echo "selected";} ?> value="5">Uczeń</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Pracownik biblioteki: </span>
                    </td>
                    <td>
                        <select type="text" id="bibliotekarz" name="bibliotekarz">
                            <option <?php if($bibliotekarz == 0){echo "selected";} ?> value="0">Nie</option>
                            <option <?php if($bibliotekarz == 1){echo "selected";} ?> value="1">Tak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Login: </span>
                    </td>
                    <td>
                        <input type="text" id="login" value="<?php echo $login; ?>" name="login"></input>
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
  </body>
</html>
