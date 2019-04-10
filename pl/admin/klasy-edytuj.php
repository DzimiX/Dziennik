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

    if( isset($_POST) AND !empty($_POST) ){
        $klasa = $_POST['nazwa'];
        $wirtualna = $_POST['wirtualna'];
        $rocznik = $_POST['rocznik'];
        $wychowawca = $_POST['wychowawca'];

        $klasa = htmlentities($klasa);
        $wirtualna = htmlentities($wirtualna);
        $rocznik = htmlentities($rocznik);
        $wychowawca = htmlentities($wychowawca);

        try {
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if ($connection->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            } else {
                $sql = "UPDATE klasy SET nazwa = '".$klasa."', wirtualna = '".$wirtualna."', rocznik = '".$rocznik."', wychowawca = '".$wychowawca."' WHERE id='".$id."';";

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
            $sql = "SELECT * from klasy WHERE id='".$id."' LIMIT 1;";
            
            if(!$result = $connection->query($sql)){
                die();
            } else {
                while($row = $result->fetch_assoc()){
                  $klasa = $row['nazwa'];
                  $wirtualna = $row['wirtualna'];
                  $rocznik = $row['rocznik'];
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
        <form method="POST">
            <table class="table">
                <tr>
                    <td>
                        <span>Nazwa: </span>
                    </td>
                    <td>
                        <input type="text" id="nazwa" value="<?php echo $klasa; ?>" name="nazwa"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Rocznik: </span>
                    </td>
                    <td>
                        <input type="text" id="rocznik" value="<?php echo $rocznik; ?>" name="rocznik"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Wirtualna: </span>
                    </td>
                    <td>
                        <select name="wirtualna" id="wirtualna">
                            <option <?php if($wirtualna==0){echo "selected";} ?> value="0">Nie</option>
                            <option <?php if($wirtualna==1){echo "selected";} ?> value="1">Tak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Wychowawca: </span>
                    </td>
                    <td>
                        <select type="text" id="wychowawca" name="wychowawca">
                            <option <?php if($wirtualna==0){echo "selected";} ?> value="0">Brak (klasa wirtualna)</option>
                            <?php
                                try {
                                    $connection = new mysqli($host, $db_user, $db_password, $db_name);
                                    if ($connection->connect_errno!=0){
                                        throw new Exception(mysqli_connect_errno());
                                    } else {
                                        $sql = "SELECT * from uzytkownicy WHERE id_uprawnienia='3';";
                                        
                                        if(!$result = $connection->query($sql)){
                                            die();
                                        } else {
                                            while($row = $result->fetch_assoc()){
                                              echo "<option value='".$row['id']."'";
                                              if($row['id']==$wychowawca){ echo " selected ";}
                                              echo ">".$row['imie']." ".$row['nazwisko']."</option>";
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
                <tr>
                <td colspan="2">
                
                </td>
                </tr>
            </table>
            <input type="submit" class="btn btn-primary" value="Edytuj"></input>
        </form><br/>
        <button onclick="usun(<?php echo $id; ?>)" class="btn btn-danger">Usuń klasę</button>
      </div>
    </main>

    <script src="/js/jquery.min.js"></script>
	  <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/klasy-lista.js"></script>
  </body>
</html>