<?php
/* Definice konstant pro připojení DB */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'zakaznici');
 
/* Pokus o připojení k databázi MySQL */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Kontrola spojení
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>