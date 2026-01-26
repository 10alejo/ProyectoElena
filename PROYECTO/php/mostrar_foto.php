<?php

$host = "localhost";
$db_user = "root";
$clave = "";
$db = "allgim";

try {

    $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $db_user, $clave);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['nombre'])) {
        
        $nombre = $_GET['nombre'];

        $stmt = $conexion->prepare("SELECT tipo_imagen, datos_imagen FROM imagenes_usuarios WHERE usuario_nombre = ?");
        $stmt->execute([$nombre]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {

            $tipo = $resultado['tipo_imagen'];
            $datos = $resultado['datos_imagen'];

            header("Content-type: $tipo");
            echo $datos;
        } 
        
        else {

            echo "Imagen no encontrada";
        }
    }
} 

catch (PDOException $e) {

    echo "Error de conexión";
}

$stmt = null;
$conexion = null;

?>