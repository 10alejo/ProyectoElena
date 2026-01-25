<?php
// 1. Iniciar sesión DEBE ser lo primero antes de cualquier salida
session_start();

// 2. Limpiar cualquier salida previa accidental (espacios en blanco, errores previos)
ob_clean();

// 3. Establecer el encabezado JSON
header('Content-Type: application/json');

// CONFIGURACIÓN DE BASE DE DATOS
$host = "localhost";
$usuario = "root";
$clave = "";
$db = "allgim"; 

try {
    // Conexión usando PDO
    $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $usuario, $clave);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificación de sesión
    if (!isset($_SESSION['usuario'])) {

        echo json_encode(["status" => "error", "message" => "Sesión no iniciada. Por favor, loguéate de nuevo."]);
        exit;
    }

    // Verificación de datos POST (Asegúrate de que coincidan con los 'name' del HTML)
    if (isset($_POST['ejercicio']) && isset($_POST['peso']) && !empty($_POST['peso'])) {
        
        $usuario_sesion = $_SESSION['usuario'];
        $ejercicio = $_POST['ejercicio'];
        $peso = $_POST['peso'];
        $fecha = date('Y-m-d');

        // Preparamos la consulta
        $sql = "INSERT INTO registros_pesos (usuario, ejercicio, peso, fecha) VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE peso = VALUES(peso), fecha = VALUES(fecha)";
        $stmt = $conexion->prepare($sql);

        if ($stmt->execute([$usuario_sesion, $ejercicio, $peso, $fecha])) {

            echo json_encode(["status" => "success", "message" => "Registro guardado en MySQL"]);
        } 
        
        else {

            echo json_encode(["status" => "error", "message" => "Error al ejecutar el insert"]);
        }
    } 
    
    else {

        echo json_encode(["status" => "error", "message" => "Faltan datos en el formulario (ejercicio o peso)"]);
    }
} 

catch (PDOException $e) {

    echo json_encode(["status" => "error", "message" => "Error de BD: " . $e->getMessage()]);
}

// Limpieza de recursos
$stmt = null;
$conexion = null;

?>