<?php
session_start();
header('Content-Type: application/json');

// Si no hay usuario, devolvemos array vacío
if (!isset($_SESSION['usuario'])) {
    echo json_encode([]);
    exit();
}

// CONEXIÓN
$host = "localhost";
$usuario = "root";
$clave = "";
$bd = "allgim"; 
$conexion = new mysqli($host, $usuario, $clave, $bd);

$usuario_actual = $_SESSION['usuario'];

// Seleccionamos fecha y peso, ordenados por fecha
$sql = "SELECT ejercicio, peso, fecha FROM registros_pesos WHERE usuario = ? ORDER BY fecha ASC";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario_actual);
$stmt->execute();
$resultado = $stmt->get_result();

$datos = [];
while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
}

// Devolvemos los datos en formato JSON para que JavaScript los entienda
echo json_encode($datos);

$stmt->close();
$conexion->close();
?>