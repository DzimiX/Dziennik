<?php

    session_start();

    if($_SESSION['upr']!=1 AND $_SESSION['upr']!=2){
        header('Location: /');
        exit();
    }

    if( !isset($_GET) OR !isset($_GET['id']) ){
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/uzytkownicy');
        exit();
    } else if( $_GET['id']=='' ) {
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/admin/uzytkownicy');
        exit();
    } else {
        $id = $_GET['id'];

        function randomPassword() {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }

        $haslo = randomPassword();
        $haslo_szyfrowane = password_hash($haslo, PASSWORD_DEFAULT);
        
        mysqli_report(MYSQLI_REPORT_STRICT);

        define("BAZA", true);
        require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");
        
        try {
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if ($connection->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            } else {
                $sql = "UPDATE uzytkownicy ";
                $sql.= "SET haslo='".$haslo_szyfrowane."', haslo_start='".$haslo."', zmien_haslo=1 ";
                $sql.= "WHERE id='".$id."';";
                
                if(!$result = $connection->query($sql)){
                    die();
                }

                $connection->close();
            }
        } catch(Exception $e) {
        }
        $_SESSION['error'] = "Zmieniono hasło!";
        header ('Location: /pl/admin/uzytkownicy');
    }
?>