<?php
define("BAZA", true);
require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");
session_start();
if (isset($_POST)) {
	$post_username = $_POST['username'];
    $post_password = $_POST['password'];
	$post_username = htmlentities($post_username, ENT_QUOTES, "UTF-8");
	
	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if ($connection->connect_errno!=0){
		  throw new Exception(mysqli_connect_errno());
		} else {
		  $sql = "SELECT *, uzytkownicy.id as idusr, uprawnienia.nazwa as uprawnienia ";
		  $sql.= "FROM uzytkownicy, uprawnienia ";
		  $sql.= "WHERE login='".$post_username."' AND uprawnienia.id = id_uprawnienia ";
		  $sql.= "LIMIT 1;";
		  
		  if(!$result = $connection->query($sql)){
			die();
		  } else {
			while($row = $result->fetch_assoc()){
			  if(password_verify($post_password,$row['haslo'])){
					$_SESSION['id'] = $row['idusr'];
					$_SESSION['login'] = $row['login'];
					$_SESSION['imie'] = $row['imie'];
					$_SESSION['nazwisko'] = $row['nazwisko'];
					$_SESSION['uprawnienia'] = $row['uprawnienia'];
					$_SESSION['upr'] = $row['id_uprawnienia'];
					$_SESSION['bibliotekarz'] = $row['bibliotekarz'];
					$_SESSION['zmien_haslo'] = $row['zmien_haslo'];
					echo $_SESSION['login'];
			  }else {
					return false;
				}
			}
		  }
	  
		  $connection->close();
		}
	  } catch(Exception $e) {
	  }

}
?>