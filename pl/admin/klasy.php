<?php
  define("STANDARD", true);
  require_once($_SERVER['DOCUMENT_ROOT']."/config/standard.php");

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
        <h1>Klasy</h1>
        <?php if(isset($_SESSION['error'])){echo "<h5>".$_SESSION['error']."</h5>";unset($_SESSION['error']);} ?>
        <div>
            <button type="button" onclick="location.href='/pl/admin/klasa-nowa';" class="btn btn-primary">Nowa klasa</button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Nazwa</td>
                        <td>Rocznik</td>
                        <td>Czy klasa wirtualna?</td>
                        <td>Wychowawca</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      mysqli_report(MYSQLI_REPORT_STRICT);
                      
                      define("BAZA", true);
                      require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");
                      
                      try {
                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($connection->connect_errno!=0){
                          throw new Exception(mysqli_connect_errno());
                        } else {
                          $sql = "SELECT * ";
                          $sql.= "FROM klasy ";
                          $sql.= "ORDER BY rocznik DESC,nazwa";
                          
                          if(!$result = $connection->query($sql)){
                            die();
                          } else {
                            while($row = $result->fetch_assoc()){
                                echo "<tr style='background-color:";
                                switch( $row['rocznik'] % 4 ){
                                    case 0:
                                        echo "#ffb3ba";
                                        break;
                                    case 1:
                                        echo "#fff8b3";
                                        break;
                                    case 2:
                                        echo "#baffb3";
                                        break;
                                    case 3:
                                        echo "#bae1ff";
                                        break;
                                }
                                echo "'>";
                                  echo "<td>";
                                  echo $row['id'];
                                  echo "</td>";
                                  echo "<td>";
                                  echo $row['nazwa'];
                                  echo "</td>";
                                  echo "<td>";
                                  echo $row['rocznik'];
                                  echo "</td>";
                                  echo "<td>";
                                  if($row['wirtualna']==1){
                                      echo "TAK";
                                  }else {
                                      echo "NIE";
                                  }
                                  echo "<td>";
                                  if($row['wychowawca']!=0){
                                    try {
                                      $connection2 = new mysqli($host, $db_user, $db_password, $db_name);
                                      if ($connection2->connect_errno!=0){
                                        throw new Exception(mysqli_connect_errno());
                                      } else {
                                        $sql2 = "SELECT * FROM uzytkownicy where id=".$row['wychowawca']." LIMIT 1;";
                                        
                                        if(!$result2 = $connection->query($sql2)){
                                          die();
                                        } else {
                                          while($row2 = $result2->fetch_assoc()){
                                            echo $row2['imie']." ".$row2['nazwisko'];
                                          }
                                        }
                                    
                                        $connection2->close();
                                      }
                                    } catch(Exception $e) {
                                    }
                                  } else {
                                    echo "brak";
                                  }
                                  echo "</td>";
                                  echo "</td>";
                                  echo "<td>";
                                  echo "<button class='btn btn-danger' onclick='edytuj(".$row['id'].")'>Edytuj</button>";
                                  echo "</td>";
                                  echo "<td>";
                                  echo "<button class='btn btn-warning' onclick='dodaj(".$row['id'].")'>Uczestnicy</button>";
                                  echo "</td>";
                                echo "</tr>";
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
