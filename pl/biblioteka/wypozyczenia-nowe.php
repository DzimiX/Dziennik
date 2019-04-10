<?php
  define("STANDARD", true);
  require_once($_SERVER['DOCUMENT_ROOT']."/config/standard.php");

  if($_SESSION['bibliotekarz']!=1){
    header('Location: /');
    exit();
  }

  define("BAZA", true);
  require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");

  if (isset($_GET) AND isset($_POST)){
      if(isset($_GET['ksiazka']) AND isset($_POST['u_ksiazka']) AND isset($_POST['id_uzytkownik'])){
          if($_POST['u_ksiazka']!="" AND $_POST['id_uzytkownik']!=""){
              $ksiazka = htmlentities($_GET['ksiazka']);
              $u_ksiazka = htmlentities($_POST['u_ksiazka']);
              $uzytkownik = htmlentities($_POST['id_uzytkownik']);
              unset($_POST);
              
              try {
                $connection = new mysqli($host, $db_user, $db_password, $db_name);
                if ($connection->connect_errno!=0){
                    throw new Exception(mysqli_connect_errno());
                } else {
                    $sql = "INSERT INTO biblioteka_wypozyczone (id_uzytkownika, id_ksiazka, id_ksiazka_unikalne, data_wypozyczenie, czy_oddane, rezerwacja) ";
                    $sql.= "VALUES ('".$uzytkownik."', '".$ksiazka."', '".$u_ksiazka."', '".date('Y-m-d')."', '0', '0');";
                    
                    if(!$result = $connection->query($sql)){
                        die();
                    }
                
                    $connection->close();
                    header('Location: /pl/biblioteka/wypozyczenia');
                    }
                } catch(Exception $e) {
                }
          }
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
          <a class="nav-link active" href="/pl/biblioteka">Biblioteka</a>
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
        <h1>Nowa książka</h1>
        <button type='button' onclick="location.href='/pl/biblioteka/wypozyczenia';" class='btn btn-success'>Powrót</button>
        <?php 
            if(isset($_SESSION['error'])){
                echo "<div>";
                echo $_SESSION['error'];
                echo "</div>";
                unset($_SESSION['error']);
            }
        ?>
            <table class="table">
                <tr>
                    <td>
                        <span>Książka: </span>
                    </td>
                    <td>
                    <form method='get'>
                        <select id='ksiazka' onchange="this.form.submit()" name='ksiazka'>
                            <?php
                                mysqli_report(MYSQLI_REPORT_STRICT);

                                try {
                                    $connection = new mysqli($host, $db_user, $db_password, $db_name);
                                    if ($connection->connect_errno!=0){
                                        throw new Exception(mysqli_connect_errno());
                                    } else {
                                        $sql = "SELECT * FROM biblioteka_ksiazki;";
                                        
                                        if(!$result = $connection->query($sql)){
                                        die();
                                        } else {
                                            while($row = $result->fetch_assoc()){
                                                echo "<option ";
                                                if( isset($_GET['ksiazka']) ) {
                                                    if( $_GET['ksiazka']==$row['id'] ) { 
                                                        echo "selected"; 
                                                    } 
                                                }
                                                echo " value='".$row['id']."'>".$row['nazwa']."</option>";
                                            }
                                        }
                                    
                                        $connection->close();
                                }
                            } catch(Exception $e) {
                            }
                            ?>
                        </select>
                    </form>
                    <form method='post'>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Unikalny numer książki: </span>
                    </td>
                    <td>
                        <select id='u_ksiazka' name='u_ksiazka'>
                            <?php
                                if(!isset($_GET['ksiazka'])){ $_GET['ksiazka']=1; }
                                if(isset($_GET) AND $_GET['ksiazka']!=""){

                                    mysqli_report(MYSQLI_REPORT_STRICT);
                                    
                                                                    try {
                                                                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                                                                        if ($connection->connect_errno!=0){
                                                                            throw new Exception(mysqli_connect_errno());
                                                                        } else {
                                                                            $sql = "SELECT * FROM ksiazka_unikalne WHERE id_ksiazka='".$_GET['ksiazka']."';";
                                                                            
                                                                            if(!$result = $connection->query($sql)){
                                                                            die();
                                                                            } else {
                                                                                while($row = $result->fetch_assoc()){
                                                                                    echo "<option value='".$row['id']."'>".$row['numer']."</option>";
                                                                                }
                                                                            }
                                                                        
                                                                            $connection->close();
                                                                    }
                                                                } catch(Exception $e) {
                                                                }

                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Użytkownik: </span>
                    </td>
                    <td>
                        <select id='id_uzytkownik' name='id_uzytkownik'>
                        <?php
                                mysqli_report(MYSQLI_REPORT_STRICT);

                                try {
                                    $connection = new mysqli($host, $db_user, $db_password, $db_name);
                                    if ($connection->connect_errno!=0){
                                        throw new Exception(mysqli_connect_errno());
                                    } else {
                                        $sql = "SELECT * FROM uzytkownicy;";
                                        
                                        if(!$result = $connection->query($sql)){
                                        die();
                                        } else {
                                            while($row = $result->fetch_assoc()){
                                                echo "<option value='".$row['id']."'>".$row['login']."</option>";
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
  </body>
</html>
