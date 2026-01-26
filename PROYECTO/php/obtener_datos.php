<?php
session_start();
header('Content-Type: application/json');

// 1. Detectamos si se pide un usuario concreto o "todos"
$usuario_a_consultar = null;

if (isset($_GET['user'])) {
    $usuario_a_consultar = strtolower($_GET['user']);
} 
// Eliminamos el "else if session" para que el ranking no se confunda con tu sesión

$host = "localhost";
$db_user = "root";
$clave = "";
$db = "allgim"; 

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $db_user, $clave);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($usuario_a_consultar) {
        // MODO PERFIL: Solo un usuario
        $sql = "SELECT ejercicio, peso, fecha FROM registros_pesos WHERE usuario = ? ORDER BY fecha ASC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$usuario_a_consultar]);
    } else {
        // MODO RANKING: Todos los usuarios (porque no se pasó ?user=)
        $sql = "SELECT usuario, ejercicio, peso FROM registros_pesos";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
    }

    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($datos);

} catch (PDOException $e) {
    echo json_encode(["error" => "Error de conexión"]);
}
?>