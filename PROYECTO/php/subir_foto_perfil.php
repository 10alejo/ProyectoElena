<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    
    $nombre = $_SESSION['usuario'];
    $tipo = $_FILES['foto']['type'];
    $contenido = file_get_contents($_FILES['foto']['tmp_name']);

    try {
        // Comprobamos si el usuario ya tiene una entrada en imagenes_usuarios
        $check = $conexion->prepare("SELECT id FROM imagenes_usuarios WHERE usuario_nombre = :n");
        $check->execute(['n' => $nombre]);

        if ($check->fetch()) {
            // Si ya existe, actualizamos (UPDATE)
            $sql = "UPDATE imagenes_usuarios SET datos_imagen = :d, tipo_imagen = :t WHERE usuario_nombre = :n";
        } else {
            // Si no existe, insertamos (INSERT)
            $sql = "INSERT INTO imagenes_usuarios (datos_imagen, tipo_imagen, usuario_nombre) VALUES (:d, :t, :n)";
        }

        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            'd' => $contenido,
            't' => $tipo,
            'n' => $nombre
        ]);

        header("Location: perfil_usuario.php?user=" . urlencode($nombre));
        exit();

    } catch (PDOException $e) {
        die("Error al subir la foto: " . $e->getMessage());
    }
} else {
    die("No se seleccionó ninguna imagen o hubo un error en la subida.");
}
?>