<?php

    session_start();

    if($_SESSION['upr']!=1 AND $_SESSION['upr']!=2){
        header('Location: /');
        exit();
      }

    if( !isset($_POST) OR !isset($_POST['login']) OR !isset($_POST['haslo']) OR !isset($_POST['imie']) OR !isset($_POST['nazwisko']) OR !isset($_POST['uprawnienia']) OR !isset($_POST['bibliotekarz']) ){
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/uzytkownicy-nowy');
        exit();
    } else if( $_POST['login']=='' OR $_POST['haslo']=='' OR $_POST['imie']=='' OR $_POST['nazwisko']=='' OR $_POST['uprawnienia']=='' OR $_POST['bibliotekarz']=='' ) {
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/uzytkownicy-nowy');
        exit();
    } else {
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $PESEL = $_POST['PESEL'];
        $PESEL = htmlentities($PESEL);
        $uprawnienia = $_POST['uprawnienia'];
        $bibliotekarz = $_POST['bibliotekarz'];
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $haslo_start = $haslo;
        $haslo = password_hash($haslo, PASSWORD_DEFAULT);
        $imie = htmlentities($imie);
        $uprawnienia = htmlentities($uprawnienia);
        $nazwisko = htmlentities($nazwisko);
        
        mysqli_report(MYSQLI_REPORT_STRICT);

        define("BAZA", true);
        require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");

        $pusto = true;
        
        $connection = new mysqli($host, $db_user, $db_password, $db_name);

        $sql="SELECT * FROM uzytkownicy WHERE login='".$login."'";
        if( mysqli_num_rows($connection->query($sql))!=0 ){
            $pusto = false;
        }
        
        if($pusto == true){
            try {
                $connection = new mysqli($host, $db_user, $db_password, $db_name);
                if ($connection->connect_errno!=0){
                    throw new Exception(mysqli_connect_errno());
                } else {
                    $sql = "INSERT INTO uzytkownicy ";
                    $sql.= "( login, haslo, imie, nazwisko, PESEL, id_uprawnienia, haslo_start, zmien_haslo, bibliotekarz )";
                    $sql.= " VALUES ";
                    $sql.= "( '$login', '$haslo', '$imie', '$nazwisko', '$PESEL', '$uprawnienia', '$haslo_start', '1', '$bibliotekarz' )";
                    
                    if(!$result = $connection->query($sql)){
                        die('There was an error running the query [' . $connection->error . ']');
                    }

                    $connection->close();
                }
            } catch(Exception $e) {
                echo '<span class="error">Wystąpił problem z serwerem. :( </span>';
            }
        } else {
            $pusto = true;
            $_SESSION['error'] = "Użytkownik o takim loginie już istnieje!";
        }
        header('Location: /pl/admin/uzytkownicy');
    }
?>