<?php
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "lanificio_sella";

$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}
?>