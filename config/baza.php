<?php
	if(defined("BAZA")){
		$host = "localhost";
		$db_user = "root";
		$db_password = "";
		$db_name = "dziennik";
	} else {
		header('Location: /');
		exit();
	}
?>