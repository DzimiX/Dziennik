<?php

    session_start();

    if($_SESSION['upr']!=1 AND $_SESSION['upr']!=2){
        header('Location: /');
        exit();
      }

    if( !isset($_GET) OR !isset($_GET['id_k']) OR !isset($_GET['id_u']) OR !isset($_GET['d'])){
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/klasy');
        exit();
    } else if( $_GET['id_u']=='' OR $_GET['id_k']=='' OR $_GET['d']=='' ) {
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/klasy');
        exit();
    } else {

        mysqli_report(MYSQLI_REPORT_STRICT);
        
        define("BAZA", true);
        require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");

        $id_klasa = $_GET['id_k'];
        $id_klasa = htmlentities($id_klasa);

        $id_uzytkownik = $_GET['id_u'];
        $id_uzytkownik = htmlentities($id_uzytkownik);

        $dodaj = $_GET['d'];
        $dodaj = htmlentities($dodaj);
        
        if($dodaj == 1){
            try {
                $connection = new mysqli($host, $db_user, $db_password, $db_name);
                if ($connection->connect_errno!=0){
                    throw new Exception(mysqli_connect_errno());
                } else {
                    $sql = "INSERT INTO uczen_klasa ";
                    $sql.= "( id_uczen, id_klasa ) ";
                    $sql.= "VALUES ";
                    $sql.= "('".$id_uzytkownik."','".$id_klasa."');";
                    
                    if(!$result = $connection->query($sql)){
                        die();
                    }
    
                    $connection->close();
                }
            } catch(Exception $e) {
            }
            header('Location: /pl/admin/klasy-dodaj?id='.$id_klasa);
            exit();
        }else if($dodaj == 0){
            try {
                $connection = new mysqli($host, $db_user, $db_password, $db_name);
                if ($connection->connect_errno!=0){
                    throw new Exception(mysqli_connect_errno());
                } else {
                    $sql = "DELETE from uczen_klasa ";
                    $sql.= "WHERE id_uczen='".$id_uzytkownik."' AND id_klasa='".$id_klasa."';";
                    
                    if(!$result = $connection->query($sql)){
                        die();
                    }
    
                    $connection->close();
                }
            } catch(Exception $e) {
            }
            header('Location: /pl/admin/klasy-dodaj?id='.$id_klasa);
            exit();
        }else {
            $_SESSION['error'] = "Wystąpił błąd";
            header('Location: /pl/admin/klasy');
            exit();
        }
    }
?>