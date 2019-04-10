<?php

    session_start();

    if($_SESSION['upr']!=1 AND $_SESSION['upr']!=2){
        header('Location: /');
        exit();
      }

    if( !isset($_GET) OR !isset($_GET['id_p']) OR !isset($_GET['id_u']) OR !isset($_GET['d'])){
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/przedmioty');
        exit();
    } else if( $_GET['id_u']=='' OR $_GET['id_p']=='' OR $_GET['d']=='' ) {
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/przedmioty');
        exit();
    } else {

        mysqli_report(MYSQLI_REPORT_STRICT);
        
        define("BAZA", true);
        require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");

        $id_przedmiot = $_GET['id_p'];
        $id_przedmiot = htmlentities($id_przedmiot);

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
                    $sql = "INSERT INTO przedmiot_nauczyciel ";
                    $sql.= "(id_nauczyciel, id_przedmiot) ";
                    $sql.= "VALUES ";
                    $sql.= "('".$id_uzytkownik."','".$id_przedmiot."');";
                    
                    if(!$result = $connection->query($sql)){
                        die();
                    }
    
                    $connection->close();
                }
            } catch(Exception $e) {
            }
            header('Location: /pl/admin/przedmioty-dodaj?id='.$id_przedmiot);
            exit();
        }else if($dodaj == 0){
            try {
                $connection = new mysqli($host, $db_user, $db_password, $db_name);
                if ($connection->connect_errno!=0){
                    throw new Exception(mysqli_connect_errno());
                } else {
                    $sql = "DELETE from przedmiot_nauczyciel ";
                    $sql.= "WHERE id_nauczyciel='".$id_uzytkownik."' AND id_przedmiot='".$id_przedmiot."';";
                    
                    if(!$result = $connection->query($sql)){
                        die();
                    }
    
                    $connection->close();
                }
            } catch(Exception $e) {
            }
            header('Location: /pl/admin/przedmioty-dodaj?id='.$id_przedmiot);
            exit();
        }else {
            $_SESSION['error'] = "Wystąpił błąd";
            header('Location: /pl/admin/przedmioty');
            exit();
        }
    }
?>