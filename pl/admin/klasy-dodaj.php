<?php
  define("STANDARD", true);
  require_once($_SERVER['DOCUMENT_ROOT']."/config/standard.php");

  if($_SESSION['upr']!=1 AND $_SESSION['upr']!=2){
    header('Location: /');
    exit();
  }

  if( !isset($_GET) OR !isset($_GET['id']) ){
    $_SESSION['error'] = "Pola nie mogą być puste!";
    header('Location: /pl/admin/klasy');
    exit();
} else if( $_GET['id']=='' ) {
    $_SESSION['error'] = "Pola nie mogą być puste!";
    header('Location: /pl/admin/klasy');
    exit();
} else {
    $id = $_GET['id'];
    
    define("BAZA", true);
    require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");

    try {
        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        if ($connection->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } else {
            $sql = "SELECT * from klasy WHERE id='".$id."' LIMIT 1;";
            
            if(!$result = $connection->query($sql)){
                die();
            } else {
                while($row = $result->fetch_assoc()){
                  $klasa = $row['nazwa'];
                  $wychowawca = $row['wychowawca'];
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
        <h1><?php echo $klasa; ?></h1><a href="/pl/admin/klasy"<button class="btn btn-success">Powrót</button></a>
        <?php if(isset($_SESSION['error'])){echo "<h5>".$_SESSION['error']."</h5>";unset($_SESSION['error']);} ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Imie</td>
                        <td>Nazwisko</td>
                        <td>Uprawnienia</td>
                        <td>Login</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      mysqli_report(MYSQLI_REPORT_STRICT);
                      
                        $dodaj = 1;

                      try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->connect_errno!=0){
                          throw new Exception(mysqli_connect_errno());
                        } else {
                          $sql = "SELECT *, uzytkownicy.id as iduser ";
                          $sql.= "FROM uzytkownicy,uprawnienia ";
                          $sql.= "WHERE id_uprawnienia=uprawnienia.id AND id_uprawnienia = 5 ";
                          $sql.= "ORDER BY id_uprawnienia, nazwisko;";
                          
                          if(!$result = $connection->query($sql)){
                            die();
                          } else {
                            while($row = $result->fetch_assoc()){
                              switch ($row['id_uprawnienia']) {
                                case 1:
                                  $kolor = '#f9c0c3';
                                  break;
                                case 2:
                                  $kolor = '#c3f9c0';
                                  break;
                                case 3:
                                  $kolor = '#c0c3f9';
                                  break;
                                default:
                                  $kolor = '';
                                  break;
                              }
                              try {
                                  $sql2 = "SELECT * from uczen_klasa WHERE id_uczen='".$row['iduser']."' AND id_klasa='".$id."' LIMIT 1";
                                  if(!$result2 = $connection->query($sql2)){
                                    die();
                                  } else {
                                    while($row2 = $result2->fetch_assoc()){
                                        $dodaj = 0;
                                    }
                              }
                            }catch(Exception $e) {
                            }
                                echo "<tr>";
                                  echo "<td>";
                                  echo $row['iduser'];
                                  echo "</td>";
                                  echo "<td>";
                                  echo $row['imie'];
                                  echo "</td>";
                                  echo "<td>";
                                  echo $row['nazwisko'];
                                  echo "</td>";
                                  echo "<td style='background-color:".$kolor."'>";
                                  echo $row['nazwa'];
                                  echo "</td>";
                                  echo "<td>";
                                  echo $row['login'];
                                  echo "</td>";
                                  if($dodaj==0){
                                    echo "<td>";
                                    echo "<button id='reset-haslo' onclick='dodajusun(".$id.",".$row['iduser'].",0)' class='btn btn-danger'>Usuń</button>";
                                    echo "</td>";
                                  }else{
                                    echo "<td>";
                                    echo "<button id='reset-haslo' onclick='dodajusun(".$id.",".$row['iduser'].",1)' class='btn btn-warning'>Dodaj</button>";
                                    echo "</td>";
                                  }
                                echo "</tr>";
                                $dodaj = 1;
                            }
                          }
                          $connection->close();
                        }
                      } catch(Exception $e) {
                        echo '<span class="error">Wystąpił problem z serwerem. :( </span>';
                      }
                    ?>
                </tbody>
            </table>
        </div>
      </div>

    </main>

    <script src="/js/jquery.min.js"></script>
	  <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/klasy-lista.js"></script>
  </body>
</html>