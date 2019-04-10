<?php

    echo "Uzupełnianie bazy danych, tworzenie administratora...<br/>";

    try {
        define("BAZA", true);
        require_once($_SERVER['DOCUMENT_ROOT']."/config/baza.php");
        
        $connection = mysqli_connect($host, $db_user, $db_password, $db_name);

        // UZUPEŁNIANIE POZIOMÓW UPRAWNIEŃ
        $sql="INSERT INTO uprawnienia VALUES (1,'Administrator')";
        $connection->query($sql);
        $sql="INSERT INTO uprawnienia VALUES (2,'Dyrektor')";
        $connection->query($sql);
        $sql="INSERT INTO uprawnienia VALUES (3,'Nauczyciel')";
        $connection->query($sql);
        $sql="INSERT INTO uprawnienia VALUES (4,'Rodzic')";
        $connection->query($sql);
        $sql="INSERT INTO uprawnienia VALUES (5,'Uczeń')";
        $connection->query($sql);

        // BIBLIOTEKA
        $sql = "INSERT INTO ksiazka_gatunek (nazwa) VALUES ('Nieokreślony');";
        $connection->query($sql);

        //DANE SZKOŁY
        $sql="INSERT INTO szkola VALUES (1,'Elektroniczne Zakłady Naukowe','ul. Braniborska 57','53-680','Wrocław','71 798 67 02','ezn@ezn.edu.pl')";
        $connection->query($sql);

        $login = "admin";
        $haslo = "admin";
        $imie = "Administrator";
        $nazwisko = "Testowy";
        $PESEL = "";
        $PESEL = htmlentities($PESEL);
        $uprawnienia = "1";
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $haslo_start = $haslo;
        $haslo = password_hash($haslo, PASSWORD_DEFAULT);
        $imie = htmlentities($imie);
        $uprawnienia = htmlentities($uprawnienia);
        $nazwisko = htmlentities($nazwisko);

        $pusto = true;

        $sql="SELECT * FROM uzytkownicy WHERE login='".$login."'";
        if( mysqli_num_rows($connection->query($sql))!=0 ){
            $pusto = false;
        }

        if($pusto==true){
            $sql = "INSERT INTO uzytkownicy ";
            $sql.= "( login, haslo, imie, nazwisko, PESEL, id_uprawnienia, haslo_start, zmien_haslo )";
            $sql.= " VALUES ";
            $sql.= "( '$login', '$haslo', '$imie', '$nazwisko', '$PESEL', '$uprawnienia', '$haslo_start', '1' )";
    
            if(!$result = $connection->query($sql)){
                die('There was an error running the query [' . $connection->error . ']');
            }
            $connection->close();
            echo "Chyba dodano admina...";
        }else{
            $pusto = true;
            $_SESSION['error'] = "Użytkownik o takim loginie już istnieje!";
            echo $_SESSION['error'];
        }
    }
	catch(Exception $e){
		echo '<span class="error">Wystąpił problem z serwerem. :( </span>';
	}

?>