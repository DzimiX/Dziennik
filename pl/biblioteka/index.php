<?php
  define("STANDARD", true);
  require_once($_SERVER['DOCUMENT_ROOT']."/config/standard.php");
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
              <h1>Dostępne książki</h1>
              <button type='button' onclick="location.href='/pl/panel';" class='btn btn-success'>Powrót</button>
              <?php
                if($_SESSION['bibliotekarz']==1){
                  echo " <button type='button' onclick=\"location.href='/pl/biblioteka/dodaj';\" class='btn btn-primary'>Nowa książka</button> ";
                  echo " <button type='button' onclick=\"location.href='/pl/biblioteka/gatunki';\" class='btn btn-primary'>Gatunki</button> ";
                  echo " <button type='button' onclick=\"location.href='/pl/biblioteka/wypozyczenia';\" class='btn btn-primary'>Wypożyczenia i rezerwacje</button> "; 
                }
              ?>
              <button type='button' onclick="location.href='/pl/biblioteka/moje-wypozyczenia';" class='btn btn-primary'>Moje wypożyczenia i rezerwacje</button>
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
                          <td>Gatunek</td>
                          <td>ISBN</td>
                          <td>Dostępność</td>
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
                            $sql = "SELECT *, biblioteka_ksiazki.id AS id, ksiazka_gatunek.id AS gid, biblioteka_ksiazki.nazwa as nazwa, ksiazka_gatunek.nazwa AS gatunek FROM biblioteka_ksiazki,ksiazka_gatunek WHERE ksiazka_gatunek.id=biblioteka_ksiazki.id_gatunek;";
                            
                            if(!$result = $connection->query($sql)){
                              die('There was an error running the query [' . $connection->error . ']');
                            } else {
                              while($row = $result->fetch_assoc()){
                                  echo "<tr>";
                                      echo "<td>";
                                          echo $row['nazwa'];
                                      echo "</td>";
                                      echo "<td>";
                                          echo $row['autor'];
                                      echo "</td>";
                                      echo "<td>";
                                          echo $row['gatunek'];
                                      echo "</td>";
                                      echo "<td>";
                                          echo "<a href='";
                                          echo "http://katalogi.bn.org.pl/iii/encore/search/C__S".$row['ISBN'];
                                          echo "'>";
                                          echo $row['ISBN'];
                                          echo "</a>";
                                      echo "</td>";
                                      
                                      // Sprawdzanie ile zostało wypożyczonych i odejmowanie od całkowitej ilości...
                                      echo "<td>";
                                      $sql2 = "SELECT COUNT(id) as wypozyczone FROM biblioteka_wypozyczone WHERE id_ksiazka='".$row['id']."' AND czy_oddane='0' OR id_ksiazka=".$row['id']." AND rezerwacja='1';";
                                      
                                      if(!$result2 = $connection->query($sql2)){
                                        die();
                                      } else {
                                        while($row2 = $result2->fetch_assoc()){
                                          $roznica = $row2['wypozyczone'];
                                        }
                                      }
                                      $sql3 = "SELECT COUNT(id) AS magazyn FROM ksiazka_unikalne WHERE id_ksiazka=".$row['id'].";";
                                      
                                      if(!$result3 = $connection->query($sql3)){
                                        die();
                                      } else {
                                        while($row3 = $result3->fetch_assoc()){
                                          $magazyn = $row3['magazyn'];
                                        }
                                      }
                                        echo ($magazyn-$roznica)." (na ".$magazyn.")";
                                      echo "</td>";
                                      echo "<td>";
                                      echo "<button class='btn btn-info' onclick='zarezerwuj(".$row['id'].",".$_SESSION['id'].")'>Zarezerwuj</button>";
                                      echo "</td>";
                                      if ($_SESSION['bibliotekarz']==1){
                                        echo "<td>";
                                        echo "<button class='btn btn-danger' onclick='edytuj(".$row['id'].")'>Edytuj</button>";
                                        echo "</td>";
                                      }
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
