<?php

    session_start();

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
        
        mysqli_report(MYSQLI_REPORT_STRICT);

        define("BAZA", true);
        require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");
        
        try {
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if ($connection->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            } else {
                $sql = "DELETE FROM klasy WHERE id='".$id."';";
                
                if(!$result = $connection->query($sql)){
                    die();
                }
                $sql = "DELETE FROM klasy WHERE id='".$id."';";
                
                if(!$result = $connection->query($sql)){
                    die();
                }

                $sql = "DELETE FROM uczen_klasa WHERE id_klasa='".$id."';";
                
                if(!$result = $connection->query($sql)){
                    die();
                }

                $connection->close();
            }
        } catch(Exception $e) {
        }
        $_SESSION['error'] = "Usunięto klasę!";
        header ('Location: /pl/admin/klasy');
    }
?>