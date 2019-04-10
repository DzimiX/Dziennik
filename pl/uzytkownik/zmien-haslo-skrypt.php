<?php
session_start();
if(!isset($_SESSION['id'])){
    header('Location: /');
    exit();
}
if(!isset($_POST)){
    header('Location: /pl/uzytkownik/zmien-haslo');
    exit();
}
if($_POST['haslo-nowe'] != $_POST['haslo-nowe2']){
    $_SESSION['error'] = "<h6 style='color:red'>Hasła się nie zgadzają!</h6>";
    header('Location: /pl/uzytkownik/zmien-haslo');
    exit();
}

$haslo = $_POST['haslo-nowe'];
if($haslo == 'NULL' OR $haslo == ""){
    $_SESSION['error'] = "<h6 style='color:red'>Problem z hasłem!</h6>";
    header('Location: /pl/uzytkownik/zmien-haslo');
    exit();
}
$haslo = password_hash($haslo, PASSWORD_DEFAULT);
$id = $_SESSION['id'];



define("BAZA", true);
require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");

try {
    $connection = new mysqli($host, $db_user, $db_password, $db_name);
    if ($connection->connect_errno!=0){
        throw new Exception(mysqli_connect_errno());
    } else {
        $sql = "UPDATE uzytkownicy ";
        $sql.= "SET haslo='".$haslo."' , zmien_haslo=0 ";
        $sql.= "WHERE id=".$id." ;";

        $connection->query($sql);
        $connection->close();

        $_SESSION['error'] = "<h6 style='color:green'>Zmieniono hasło!</h6>";
        $_SESSION['zmien_haslo']=0;
    }
} catch(Exception $e) {
}
header('Location: /pl/uzytkownik/zmien-haslo');


?>