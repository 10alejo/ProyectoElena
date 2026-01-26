<?php
// Iniciamos sesión solo si no ha sido iniciada antes
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario'])) {
    // Si es la primera vez que entra tras loguearse, fijamos el destino (10 min)
    if (!isset($_SESSION['expire_time'])) {
        $_SESSION['expire_time'] = time() + 600; // 600 segundos = 10 min
    }

    // Calculamos cuánto falta
    $tiempo_restante = $_SESSION['expire_time'] - time();

    // Si el tiempo es 0 o menos, cerramos sesión
    if ($tiempo_restante <= 0) {
        // Es importante limpiar la sesión antes de redirigir
        session_unset();
        session_destroy();
        header("Location: ../php/logout.php");
        exit();
    }
} else {
    $tiempo_restante = 0;
}
?>