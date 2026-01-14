<?php

$host = "localhost";
$user = "admin";
$pass = "1234";
$db   = "allgim";

try {
    // 1. Definimos el DSN (Data Source Name)
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    // 2. Creamos la instancia PDO
    $conexion = new PDO($dsn, $user, $pass);

    // 3. Configuramos el modo de error para que lance excepciones
    // Esto es vital para ver errores SQL claramente
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "buena conexion";

} catch (PDOException $e) {
    // 4. Capturamos el error si falla la conexión
    die("error de conexion: " . $e->getMessage());
}

?>