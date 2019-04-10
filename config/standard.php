<?php
    if(defined("STANDARD")){
        session_start();
        if(!isset($_SESSION['id'])){
            header('Location: /');
        }
        if($_SESSION['zmien_haslo'] == 1){
            define("ZMIEN-HASLO", true);
            header('Location: /pl/uzytkownik/zmien-haslo');
        }
	} else {
        header('Location: /');
        exit();
	}
?>