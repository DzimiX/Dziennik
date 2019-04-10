<?php
  define("STANDARD", true);
  require_once($_SERVER['DOCUMENT_ROOT']."/config/standard.php");

  define("BAZA", true);
  require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");

  if($_SESSION['bibliotekarz']!=1){
    header('Location: /');
    exit();
  }
  if( !isset($_GET) OR $_GET['id_k']=="" ){
    header('Location: /pl/biblioteka');
    $_SESSION['error'] = "Nie wybrano książki!";
    exit();
  }
  $id = $_GET['id_k'];
  if( isset($_POST['nazwa']) AND isset($_POST['autor']) AND isset($_POST['ISBN']) AND isset($_POST['gatunek'] ) ) {
      if( $_POST['nazwa']!='' AND $_POST['autor']!='' AND $_POST['ISBN']!='' AND $_POST['gatunek']!='' ) {
          $nazwa = htmlentities($_POST['nazwa']);
          $autor = htmlentities($_POST['autor']);
          $ISBN = htmlentities($_POST['ISBN']);
          $gatunek = htmlentities($_POST['gatunek']);

          mysqli_report(MYSQLI_REPORT_STRICT);
          
                          try {
                          $connection = new mysqli($host, $db_user, $db_password, $db_name);
                          if ($connection->connect_errno!=0){
                              throw new Exception(mysqli_connect_errno());
                          } else {
                              $sql = "UPDATE biblioteka_ksiazki SET nazwa='".$nazwa."', autor='".$autor."', ISBN='".$ISBN."', id_gatunek='".$gatunek."' WHERE id='".$id."' ;";
                              if(!$result = $connection->query($sql)){
                                  die();
                              }
                              $_SESSION['error'] = "Edytowano pomyślnie!";
                              $connection->close();
                          }
                          } catch(Exception $e) {
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

                        <?php
                            mysqli_report(MYSQLI_REPORT_STRICT);
                            
                            try {
                            $connection = new mysqli($host, $db_user, $db_password, $db_name);
                            if ($connection->connect_errno!=0){
                                throw new Exception(mysqli_connect_errno());
                            } else {
                                $sql = "SELECT *,biblioteka_ksiazki.nazwa AS nazwa, ksiazka_gatunek.nazwa AS gatunek FROM biblioteka_ksiazki,ksiazka_gatunek WHERE ksiazka_gatunek.id=biblioteka_ksiazki.id AND biblioteka_ksiazki.id='".$id."';";
                                
                                if(!$result = $connection->query($sql)){
                                die('There was an error running the query [' . $connection->error . ']');
                                } else {
                                while($row = $result->fetch_assoc()){
                                    $nazwa = $row['nazwa'];
                                    $autor = $row['autor'];
                                    $ISBN = $row['ISBN'];
                                    $gatunek = $row['gatunek'];
                                }
                                }
                            
                                $connection->close();
                            }
                            } catch(Exception $e) {
                            }
                        ?>

        <div class="starter-template">
              <h1>Edycja książki</h1>
              <button type='button' onclick="location.href='/pl/biblioteka';" class='btn btn-success'>Powrót</button>
              <button type='button' onclick="location.href='/pl/biblioteka/dodaj-unikat?id_k=<?php echo $id; ?>'" class='btn btn-success'>Dodaj unikalną książkę</button>
              <button type='button' onclick="location.href='/pl/biblioteka/usun?id_k=<?php echo $id; ?>'" class='btn btn-danger'>Usuń książkę</button>
              <?php
                if(isset($_SESSION['error'])){
                    echo "<br/>";
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }
              ?>
          <div class="table-responsive">
              <table class="table table-hover">
                  <thead>
                      <tr>
                          <td>Nazwa</td>
                          <td>Autor</td>
                          <td>ISBN</td>
                          <td>Gatunek</td>
                      </tr>
                  </thead>
                  <tbody>
                        <tr>
                        <form method="POST">
                            <td>
                                <input id='nazwa' name='nazwa' value='<?php echo $nazwa; ?>'></input>
                            </td>
                            <td>
                                <input id='autor' name='autor' value='<?php echo $autor; ?>'></input>
                            </td>
                            <td>
                                <input id='ISBN' name='ISBN' value='<?php echo $ISBN; ?>'></input>
                            </td>
                            <td>
                                <select id='gatunek' name='gatunek'>
                                    <?php
                                        mysqli_report(MYSQLI_REPORT_STRICT);
                                        
                                        try {
                                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                                        if ($connection->connect_errno!=0){
                                            throw new Exception(mysqli_connect_errno());
                                        } else {
                                            $sql = "SELECT * FROM ksiazka_gatunek;";
                                            
                                            if(!$result = $connection->query($sql)){
                                            die('There was an error running the query [' . $connection->error . ']');
                                            } else {
                                            while($row = $result->fetch_assoc()){
                                                echo "<option ";
                                                if($id==$row['id']){
                                                    echo "selected";
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
                            </td>
                        </tr>
                        <tr>
                            <td colspan='4'>
                                <input type='submit' value="Edytuj" class='btn btn-primary'></input>
                            </td>
                        </tr>
                        </form>
                        <tr>
                            <td colspan='2'>Unikalne numery książek:</td>
                        </tr>
                        <?php
                                        $id = $_GET['id_k'];
                                        mysqli_report(MYSQLI_REPORT_STRICT);
                                        
                                        try {
                                        $connection = new mysqli($host, $db_user, $db_password, $db_name);
                                        if ($connection->connect_errno!=0){
                                            throw new Exception(mysqli_connect_errno());
                                        } else {
                                            $sql = "SELECT * FROM ksiazka_unikalne WHERE id_ksiazka='".$id."';";
                                            
                                            if(!$result = $connection->query($sql)){
                                            die();
                                            } else {
                                            while($row = $result->fetch_assoc()){
                                                echo "<tr>";
                                                    echo "<td colspan='2'>";
                                                    echo $row['numer'];
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo "<button onclick=\"location.href='/pl/biblioteka/usun-unikat?id_k_u=".$id."'\" class='btn btn-danger'>Usuń</button>";
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo "<button onclick=\"location.href='/pl/biblioteka/historia-unikat?id_k_u=".$id."'\" class='btn btn-info'>Historia</button>";
                                                    echo "</td>";
                                                echo "</tr>";
                                            }
                                            }
                                        
                                            $connection->close();
                                        }
                                        } catch(Exception $e) {
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
    <script src="/js/biblioteka.js"></script>
  </body>
</html>
