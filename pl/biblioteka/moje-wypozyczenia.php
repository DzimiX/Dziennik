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
              <h1>Moje wypożyczenia i rezerwacje</h1>
              <button type='button' onclick="location.href='/pl/biblioteka';" class='btn btn-success'>Powrót</button>
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
                          <td>Nazwa książki</td>
                          <td>Unikalny ID książki</td>
                          <td>Data wypożyczenia/rezerwacji</td>
                          <td></td>
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
                                            $sql = "SELECT * FROM biblioteka_wypozyczone,biblioteka_ksiazki,ksiazka_unikalne ";
                                            $sql.= "WHERE id_uzytkownika='".$_SESSION['id']."' AND biblioteka_wypozyczone.id_ksiazka = biblioteka_ksiazki.id AND id_ksiazka_unikalne=ksiazka_unikalne.id;";
                                            
                                            if(!$result = $connection->query($sql)){
                                            die('There was an error running the query [' . $connection->error . ']');
                                            } else {
                                            while($row = $result->fetch_assoc()){
                                                echo "<tr>";
                                                echo "<td>";
                                                echo $row['nazwa'];
                                                echo "</td>";
                                                echo "<td>";
                                                echo $row['numer'];
                                                echo "</td>";
                                                if ($row['czy_oddane']==1){
                                                  echo "<td>";
                                                  echo $row['data_wypozyczenie'];
                                                  echo "</td>";
                                                  echo "<td><span style='color:green'>ODDANE</span></td>";
                                                }else if($row['rezerwacja']==1) {
                                                    echo "<td>";
                                                    echo $row['data_rezerwacji'];
                                                    echo "</td>";
                                                    echo "<td><span style='color:blue'>REZERWACJA</span></td><td><button type=button onclick=\"location.href='/pl/biblioteka/rezerwacja-usun-bibliotekarz?id_k_u=".$row['id']."&id_u=".$row['id_uzytkownika']."'\" class='btn btn-danger'>Anuluj rezerwacje</button></td>";
                                                }else {
                                                    echo "<td>";
                                                    echo $row['data_wypozyczenie'];
                                                    echo "</td>";
                                                    echo "<td><span style='color:red'>NIE ODDANE</span></td>";
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
