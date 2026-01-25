<?php
session_start();

// CONFIGURACIÓN DE BASE DE DATOS
$host = "localhost";
$usuario = "root";
$clave = "";
$bd = "allgim"; 

$conexion = new mysqli($host, $usuario, $clave, $bd);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si el usuario está logueado
if (isset($_SESSION['usuario']) && isset($_POST['ejercicio']) && isset($_POST['peso'])) {
    
    $usuario = $_SESSION['usuario'];
    $ejercicio = $_POST['ejercicio'];
    $peso = $_POST['peso'];
    $fecha = date('Y-m-d'); // Fecha de hoy

    // Insertar en la base de datos
    $stmt = $conexion->prepare("INSERT INTO registros_pesos (usuario, ejercicio, peso, fecha) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $usuario, $ejercicio, $peso, $fecha);

    if ($stmt->execute()) {
        // Si sale bien, volvemos al home con un mensaje de éxito (opcional)
        header("Location: home.php?status=success");
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    // Si intentan entrar sin datos, los devolvemos al home
    header("Location: home.php");
}

$conexion->close();
?>