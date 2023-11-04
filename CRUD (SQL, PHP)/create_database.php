<?php
$servername = "localhost"; // adresa serveru databáze
$username = "root"; // uživatelské jméno databáze
$password = "root"; // heslo uživatele databáze
$dbname = "zakaznici"; // název databáze

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Chyba při připojení k databázi: " . $conn->connect_error);
}

$sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    $createDbSql = "CREATE DATABASE $dbname";
    if ($conn->query($createDbSql) === TRUE) {
        echo "<p style='color: green;'>Databáze '$dbname' byla úspěšně vytvořena</p>";
    } else {
        echo "<p style='color: red;'>Chyba při vytváření databáze: " . $conn->error . "</p>";
        $conn->close();
        exit();
    }
} else {
    echo "<p style='color: orange;'>Databáze '$dbname' již existuje</p>";
}

$conn->select_db($dbname);

$sql = "CREATE TABLE zakaznici (
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    jmeno char(50) NOT NULL,
    prijmeni char(50) NOT NULL,
    ulice char(100) NOT NULL,
    cp int(10) UNSIGNED NOT NULL,
    mesto char(30) NOT NULL,
    psc int(10) UNSIGNED NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>Tabulka 'zakaznici' byla úspěšně vytvořena</p>";

    $insertDataSql = "INSERT INTO zakaznici (jmeno, prijmeni, ulice, cp, mesto, psc) VALUES
                        ('Jan', 'Novák', 'Hlavní ulice', 10, 'Praha', 12000),
                        ('Petr', 'Svoboda', 'Náměstí republiky', 5, 'Brno', 60200),
                        ('Eva', 'Kovářová', 'Masarykova ulice', 8, 'Ostrava', 70030),
                        ('Jana', 'Dvořáková', 'Třída Míru', 15, 'Plzeň', 30100),
                        ('Michal', 'Procházka', 'Dlouhá ulice', 20, 'Olomouc', 77900)";

    if ($conn->query($insertDataSql) === TRUE) {
        echo "<p style='color: green;'>Data byla úspěšně vložena do tabulky 'zakaznici'</p>";
    } else {
        echo "<p style='color: red;'>Chyba při vkládání dat: " . $conn->error . "</p>";
    }
} else {
    echo "<p style='color: red;'>Chyba při vytváření tabulky 'zakaznici': " . $conn->error . "</p>";
}

$conn->close();

header("Location: index.php");
exit();
?>



