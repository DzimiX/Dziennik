
<?php

    session_start();

    if($_SESSION['bibliotekarz']!=1){
        header('Location: /');
        exit();
    }

    if( !isset($_POST) OR !isset($_POST['nazwa']) OR !isset($_POST['autor']) OR !isset($_POST['ISBN']) ){
        $_SESSION['error'] = "Pola nie mogą być puste!";
        header('Location: /pl/biblioteka/dodaj');
        exit();
    } else if( $_POST['nazwa']=='' OR $_POST['autor']=='' OR $_POST['ISBN']=='') {
        $_SESSION['error'] = "Pola nie mogą być puste!";
        var_dump($_POST);
        header('Location: /pl/biblioteka/dodaj');
        exit();
    }  else {
        $nazwa = $_POST['nazwa'];
        $autor = $_POST['autor'];
        $ISBN = $_POST['ISBN'];
        $gatunek = $_POST['gatunek'];

        $nazwa = htmlentities($nazwa);
        $autor = htmlentities($autor);
        $ISBN = htmlentities($ISBN);
        $gatunek = htmlentities($gatunek);

        mysqli_report(MYSQLI_REPORT_STRICT);

        define("BAZA", true);
        require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");
        
        try {
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if ($connection->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            } else {
                $sql = "INSERT INTO biblioteka_ksiazki ";
                $sql.= "( nazwa, autor, ISBN, id_gatunek )";
                $sql.= " VALUES ";
                $sql.= "( '$nazwa', '$autor', '$ISBN', '$gatunek' )";
                
                if(!$result = $connection->query($sql)){
                    die();
                }

                $connection->close();
            }
        } catch(Exception $e) {
        }
        header('Location: /pl/biblioteka');
    }
?>