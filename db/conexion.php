<?php
///// variables for docker  ////
// $host = "mariadb";
// $pass = "clara";

// $host = "localhost";
// $db = "plataforma_resta";
// $user = "root";
// $pass = "";

$host = "localhost";
$db = "pwgrupo5_clara";
$user = "pwgrupo5_clara";
$pass = "123456Rojo123.%#";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
