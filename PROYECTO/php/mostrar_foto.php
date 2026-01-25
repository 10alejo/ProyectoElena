<?php
// 1. CONEXIÓN (Asegúrate de poner tu contraseña y nombre de BD correctos)
$conexion = new mysqli("localhost", "root", "", "allgim");

// Verificar si nos piden una imagen por su nombre (ej: ?nombre=adrian)
if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];

    // 2. CONSULTA SEGURA
    $stmt = $conexion->prepare("SELECT tipo_imagen, datos_imagen FROM imagenes_usuarios WHERE usuario_nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $stmt->store_result();

    // 3. SI EXISTE LA IMAGEN...
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($tipo, $datos);
        $stmt->fetch();

        // Le decimos al navegador: "Oye, lo que viene ahora es una imagen, no texto HTML"
        header("Content-type: $tipo");
        echo $datos;
    } else {
        // Opcional: Si no encuentra la foto, podrías mostrar una imagen por defecto
        // readfile("../images/default_user.png");
        echo "Imagen no encontrada";
    }
    $stmt->close();
}
$conexion->close();
?>