<?php

$servername = "localhost";
$username = "root";
$password = "coderslab";
$baseName = "cinema_network";

//Tworzenie nowego połączenia z bazą danych
$conn = new mysqli($servername, $username, $password, $baseName);


//Sprawdzenie, czy połączenie się udało
if($conn->connect_error) {
    die("Connection failed. Error:" . $conn->connect_error);
}
else {
    $conn->set_charset("utf8");
}