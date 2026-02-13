<?php

session_start();
header('Content-Type: application/json');

$usuario_a_consultar = null;

if (isset($_GET['user'])) {

    $usuario_a_consultar = strtolower($_GET['user']);
} 

$host = "localhost";
$db_user = "root";
$clave = "";
$db = "allgim"; 

try {

    $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $db_user, $clave);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($usuario_a_consultar) {

        $sql = "SELECT ejercicio, MAX(peso) as peso FROM registros_pesos WHERE usuario = ? GROUP BY ejercicio";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$usuario_a_consultar]);
    } 

    else {

        $sql = "SELECT usuario, ejercicio, MAX(peso) as peso FROM registros_pesos GROUP BY usuario, ejercicio";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
    }

    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($datos);

} 

catch (PDOException $e) {

    echo json_encode(["error" => "Error de conexión"]);
}

?>