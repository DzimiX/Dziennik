<!DOCTYPE html>
<html lang="pl-PL">
    <head>
        <meta charset="UTF-8"/>
        <title>Jamnik</title>
        <meta name="description" content="Dziennik Elektroniczny"/>
        <meta name="author" content="Maciej Dzimira"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="keywords" content="dzienik, dziennik elektroniczny"/>
        <link rel="icon" href="/img/favicon.ico"/>
        <link href="/css/jamnik.css" rel="stylesheet"/>
    </head>
    <body>
        <!-- Menu -->
        <ul id="menu">
            <li><a class="active" href="">Panel</a></li>
            <li class="dropdown">
                <a href="" class="dropbtn">Administracja</a>
                <div class="dropdown-content">
                    <a href="#">Szkoła</a>
                    <a href="#">Użytkownicy</a>
                    <a href="#">Plan lekcji</a>
                    <a href="#">Klasy</a>
                    <a href="#">Przedmioty</a>
                    <a href="#">Zarządzanie dziennikiem</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="" class="dropbtn">Statystyki</a>
                <div class="dropdown-content">
                    <a href="#">Oceny</a>
                    <a href="#">Frekwencja</a>
                    <a href="#">Klasy</a>
                    <a href="#">Przedmioty</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="" class="dropbtn">Lekcje</a>
                <div class="dropdown-content">
                    <a href="#">Plan</a>
                    <a href="#">Nowa lekcja</a>
                    <a href="#">Edytuj lekcje</a>
                    <a href="#">Przegląd</a>
                </div>
            </li>
            <li><a href="">Oceny</a></li>
            <li><a href="">Frekwencja</a></li>
            <li class="dropdown">
                <a href="" class="dropbtn">Wiadomości</a>
                <div class="dropdown-content">
                    <a href="#">Skrzynka odbiorcza</a>
                    <a href="#">Nowa wiadomość</a>
                </div>
            </li>
            <li><a href="">Terminarz</a></li>
            <li><a href="">Zadania domowe</a></li>
            <li><a href="">Biblioteka</a></li>

            <li style="float:right" class="dropdown">
                <a href="" class="dropbtn">Twój stary (Administrator)</a>
                <div class="dropdown-content">
                    <a href="#">Ustawienia</a>
                    <a href="#">Wyloguj</a>
                </div>
            </li>
        </ul>
        <!-- /Menu -->

        <!-- Nagłówek -->
        <div class="col-12">
            <div class="col-2 ukryte"></div>
            <div class="col-8 naglowek">
                <h1>Nagłówek</h1>
                <button class='brazowy'>Dupa1</button>
                <button class='czerwony'>Dupa2</button>
                <button class='zielony'>Dupa3</button>
                <button class='niebieski'>Dupa4</button>
                <button class='czarny'>Dupa5</button>
            </div>
            <div class="col-2 ukryte"></div>
        </div>
        <!-- /Nagłówek -->

        <!-- Treść -->
        <div class="col-12">
            <div class="col-2 ukryte"></div>
            <div class="col-4 tresc" id="lewa">
                <h1>Ogłoszenia</h1>
                <p><h3>Dupsko</h3>Dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa dupa</p>
            </div>
            <div class="col-4 tresc" id="prawa">
                <h1>Szczęśliwy numerek: <span id="numerek">5</span></h1>
            </div>
            <div class="col-2 ukryte"></div>
        </div>
        <!-- /Treść -->

        <!-- Tabelka -->
        <div class="col-12">
            <div class="col-2 ukryte"></div>
            <div class="col-8 tabelka">
            <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Points</th>
            </tr>
            <tr>
                <td>Peter</td>
                <td>Griffin</td>
                <td>$100</td>
            </tr>
            <tr>
                <td>Lois</td>
                <td>Griffin</td>
                <td>$150</td>
            </tr>
            <tr>
                <td>Joe</td>
                <td>Swanson</td>
                <td>$300</td>
            </tr>
            <tr>
                <td>Cleveland</td>
                <td>Brown</td>
                <td><button class='czerwony'>Usuń</button></td>
            </tr>
            </table>
            </div>
            <div class="col-2 ukryte"></div>
        </div>
        <!-- /Tabelka -->
    </body>
</html>