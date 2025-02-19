<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if ($conn === false) {
    die("Erreur de connexion : ".mysqli_connect_error());
}
?>