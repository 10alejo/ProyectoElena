<?php

session_start();

$tiempo_limite = 600;

if (!isset($_SESSION['usuario'])) {

    header('Location: index.php');
    exit();
}

if ($_SESSION['ultimoAcceso']) {

    $tiempoAntiguo = time() - $_SESSION['ultimoAcceso'];

    if ($tiempoAntiguo >= $tiempo_limite) {
        
        session_unset();
        session_destroy();
        header('Location: login.php');
        exit();
    }
}

$_SESSION['ultimoAcceso'] = time();

?>