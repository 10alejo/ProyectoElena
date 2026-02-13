<?php

session_start();

ob_clean();

header('Content-Type: application/json');

$host = "localhost";
$db_user = "root";
$clave = "";
$db = "allgim"; 

try {

    $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $db_user, $clave);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_SESSION['usuario'])) {

        echo json_encode(["status" => "Error", "message" => "Sesión no iniciada. Por favor, loguéate de nuevo."]);
        exit;
    }

    if (isset($_POST['ejercicio']) && isset($_POST['peso']) && !empty($_POST['peso'])) {
        
        $usuario_sesion = strtolower(trim($_SESSION['usuario']));
        $ejercicio = strtolower(trim($_POST['ejercicio']));
        $peso = str_replace(',', '.', trim($_POST['peso']));
        $fecha = date('Y-m-d');

        $sql = "INSERT INTO registros_pesos (usuario, ejercicio, peso, fecha) VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE peso = VALUES(peso), fecha = VALUES(fecha)";
        $stmt = $conexion->prepare($sql);

        if ($stmt->execute([$usuario_sesion, $ejercicio, $peso, $fecha])) {

            echo json_encode(["status" => "Success", "message" => "Registro guardado en la base de datos."]);
        } 
        
        else {

            echo json_encode(["status" => "Error", "message" => "Error al ejecutar la operación Insert."]);
        }
    } 
    
    else {

        echo json_encode(["status" => "Error", "message" => "Faltan datos en el formulario (ejercicio o peso)"]);
    }
} 

catch (PDOException $e) {

    echo json_encode(["status" => "Error", "message" => "Error de BD: " . $e->getMessage()]);
}

$stmt = null;
$conexion = null;

?>