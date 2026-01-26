<?php
// 1. Carga de lógica y sesión
require_once 'tiempo.php';
require_once 'conexion.php';

// Verificación de usuario para el header
if (isset($_SESSION['usuario'])) {
    $usuario_logueado = $_SESSION['usuario'];
    $inicial = mb_strtoupper(mb_substr($usuario_logueado, 0, 1));
} else {
    $usuario_logueado = null;
    $inicial = '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clasificaciones - AllGim</title>
    <link rel="icon" href="../php/mostrar_foto.php?nombre=logo" type="image/png">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/estiloHome.css">
    <link rel="stylesheet" href="../css/estiloClasificaciones.css">
</head>
<body>
    <header class="header-bar">
        <a href="home.php">
            <img src="../php/mostrar_foto.php?nombre=logo" alt="AllGim" class="logo-icon" />
        </a>
        <h1 class="header-title">RANKINGS ALLGIM</h1>

        <div class="header-actions">
            <?php if ($usuario_logueado): ?>
                <div id="session-timer" class="session-timer" data-seconds="<?= $tiempo_restante ?>">
                    ⏱️ <span id="timer-display">--:--</span>
                </div>

                <div class="user-dropdown">
                    <span class="user-avatar" style="background-color: #ff6b00;"><?= $inicial ?></span>
                    <span>Hola, <?= htmlspecialchars($usuario_logueado) ?> <span class="arrow-down">▼</span></span>
                    <div class="dropdown-content">
                        <a href="perfil_usuario.php?user=<?= urlencode($usuario_logueado) ?>">Mi Perfil 👤</a>
                        <hr style="margin: 0; border: 0; border-top: 1px solid #eee;">
                        <a href="logout.php" style="color: red;">Cerrar sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="acceso.php" class="user-link-icon">👤</a>
            <?php endif; ?>

            <input type="checkbox" id="menu-toggle">
            <label class="menu-button" for="menu-toggle">
                <span></span><span></span><span></span>
            </label>
            <label class="menu-overlay" for="menu-toggle"></label>
            <nav class="sidebar">
                <a href="home.php">Inicio</a>
                <a href="comunidad.php">Comunidad</a>
                <a href="reservas.php">Reservar Clases</a>
                <a href="sugerencias.php">Sugerencias</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <h2 class="rankings-title">🏆 TOP 5 MARCAS PERSONALES</h2>
        
        <div class="rankings" id="rankingsContainer">
            <div class="loading-msg" style="text-align: center; color: white;">
                <p>Cargando marcas de los atletas...</p>
            </div>
        </div>
    </main>

    <script src="../js/home.js"></script>
    <script src="../js/clasificaciones.js"></script>
</body>
</html>