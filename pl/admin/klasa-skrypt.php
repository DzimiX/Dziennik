<?php

    session_start();

    if($_SESSION['upr']!=1 AND $_SESSION['upr']!=2){
        header('Location: /');
        exit();
      }

    if( !isset($_POST) OR !isset($_POST['nazwa']) OR !isset($_POST['rocznik']) OR !isset($_POST['wirtualna']) ){
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/klasa-nowa');
        exit();
    } else if( $_POST['nazwa']=='' OR $_POST['rocznik']=='' OR $_POST['wychowawca']=='') {
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/klasa-nowa');
        exit();
    }  else {
        $nazwa = $_POST['nazwa'];
        $rocznik = $_POST['rocznik'];
        $wirtualna = $_POST['wirtualna'];
        $wychowawca = $_POST['wychowawca'];

        $nazwa = htmlentities($nazwa);
        $rocznik = htmlentities($rocznik);
        $wirtualna = htmlentities($wirtualna);
        $wychowawca = htmlentities($wychowawca);

        mysqli_report(MYSQLI_REPORT_STRICT);

        define("BAZA", true);
        require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");
        
        try {
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if ($connection->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            } else {
                $sql = "INSERT INTO klasy ";
                $sql.= "( nazwa, rocznik, wirtualna, wychowawca )";
                $sql.= " VALUES ";
                $sql.= "( '$nazwa', '$rocznik', '$wirtualna', '$wychowawca' )";
                
                if(!$result = $connection->query($sql)){
                    die();
                }

                $connection->close();
            }
        } catch(Exception $e) {
        }
        header('Location: /pl/admin/klasy');
    }
?>