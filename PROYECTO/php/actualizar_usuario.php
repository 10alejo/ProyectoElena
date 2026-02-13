<?php

session_start();
require_once 'conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['usuario'])) {

    $nombre = $_SESSION['usuario'];
    $edad = intval($_POST['edad']);
    $peso = intval($_POST['peso']);

    try {

        $stmt = $conexion->prepare("UPDATE usuarios SET edad = :e, peso = :p WHERE nombre = :n");
        $stmt->execute([
            'e' => $edad,
            'p' => $peso,
            'n' => $nombre
        ]);

        header("Location: perfil_usuario.php?user=" . urlencode($nombre));
        exit();

    } 
    
    catch (PDOException $e) {

        die("Error en la base de datos: " . $e->getMessage());
    }
} 

else {

    header("Location: home.php");
    exit();
}

?>