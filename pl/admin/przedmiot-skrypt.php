<?php

    session_start();

    if($_SESSION['upr']!=1 AND $_SESSION['upr']!=2){
        header('Location: /');
        exit();
      }

    if( !isset($_POST) OR !isset($_POST['nazwa']) ){
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/przedmiot-nowy');
        exit();
    } else if( $_POST['nazwa']=='' ) {
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/przedmiot-nowy');
        exit();
    } else {
        $nazwa = $_POST['nazwa'];
        $nazwa = htmlentities($nazwa);
        
        mysqli_report(MYSQLI_REPORT_STRICT);

        define("BAZA", true);
        require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");
        
        try {
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if ($connection->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            } else {
                $sql = "INSERT INTO przedmioty ";
                $sql.= "( nazwa )";
                $sql.= " VALUES ";
                $sql.= "( '$nazwa' )";
                
                if(!$result = $connection->query($sql)){
                    die();
                }

                $connection->close();
            }
        } catch(Exception $e) {
        }
        header('Location: /pl/admin/przedmioty');
    }
?>