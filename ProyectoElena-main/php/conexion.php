<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "allgim";

try {

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $conexion = new PDO($dsn, $user, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 

catch (PDOException $e) {

    die("error de conexion: " . $e->getMessage());
}

?>