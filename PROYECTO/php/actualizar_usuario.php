<?php
session_start();
require_once 'conexion.php'; // Tu conexión PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['usuario'])) {
    $nombre = $_SESSION['usuario'];
    $edad = intval($_POST['edad']);
    $peso = intval($_POST['peso']);

    try {
        // Actualizamos los datos en la tabla 'usuarios'
        $stmt = $conexion->prepare("UPDATE usuarios SET edad = :e, peso = :p WHERE nombre = :n");
        $stmt->execute([
            'e' => $edad,
            'p' => $peso,
            'n' => $nombre
        ]);

        // Redirigimos de vuelta al perfil dinámico
        header("Location: perfil_usuario.php?user=" . urlencode($nombre));
        exit();

    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
    }
} else {
    header("Location: home.php");
    exit();
}
?>