<?php
session_start();
header('Content-Type: application/json');

// 1. Prioridad: Si el JS envía un usuario por la URL (?user=...), usamos ese.
// Si no, usamos el de la sesión. Si no hay ninguno, cerramos.
$usuario_a_consultar = isset($_GET['user']) ? $_GET['user'] : (isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null);

if (!$usuario_a_consultar) {

    echo json_encode([]);
    exit();
}

// CONEXIÓN
$host = "localhost";
$db_user = "root";
$clave = "";
$db = "allgim"; 

try {

    $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $db_user, $clave);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Filtramos por el usuario que recibimos (sea el de la URL o el de la sesión)
    $sql = "SELECT ejercicio, peso, fecha FROM registros_pesos WHERE usuario = ? ORDER BY fecha ASC";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$usuario_a_consultar]);

    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($datos);

} 

catch (PDOException $e) {
    // Es mejor no enviar detalles del error en producción, pero útil para debug
    echo json_encode(["error" => "Error de conexión"]);
}

$stmt = null;
$conexion = null;

?>