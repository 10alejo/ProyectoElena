<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario'])) {

    if (!isset($_SESSION['expire_time'])) {

        $_SESSION['expire_time'] = time() + 600; 
    }

    $tiempo_restante = $_SESSION['expire_time'] - time();

    if ($tiempo_restante <= 0) {
        
        session_unset();
        session_destroy();
        header("Location: ../php/logout.php");
        exit();
    }
} 

else {

    $tiempo_restante = 0;
}

?>