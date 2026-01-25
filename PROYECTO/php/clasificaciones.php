<?php

// require_once 'tiempo.php';

session_start();

if (isset($_SESSION['usuario'])) {

    $usuario_logueado = $_SESSION['usuario'];
    $inicial = mb_strtoupper(mb_substr($usuario_logueado, 0, 1));
} 

else {

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
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&family=Poppins:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/estiloClasificaciones.css">

</head>

<body>
    <header class="header-bar">

        <a href="../php/home.php">
            <img src="../php/mostrar_foto.php?nombre=logo" alt="AllGim" class="logo-icon" />
        </a>

        <div class="header-center">
            <h1 class="header-title">Clasificaciones de AllGim</h1>
            <p class="subheader-title">Nuestras clasificaciones en nuestros ejercicios</p>
        </div>

        <div class="header-actions">

            <?php if ($usuario_logueado): ?>
            <div class="user-dropdown">
                <span class="user-avatar"><?= $inicial ?></span>
                <span>Hola, <?= htmlspecialchars($usuario_logueado) ?> <span class="arrow-down">▼</span></span>
                <div class="dropdown-content">
                    <a>Perfil Verificado <img src="https://cdn-icons-png.flaticon.com/512/6364/6364343.png" alt="Verificado" width="12" height="12"></a>
                    <hr style="margin: 0; border: 0; border-top: 1px solid #eee;">
                    <a href="../php/logout.php" style="color: red;">Cerrar sesión</a>
                </div>
            </div>
            <?php else: ?>
            <a href="../php/acceso.php" class="user-link-icon" title="Acceso">👤</a>
            <?php endif; ?>

            <input type="checkbox" id="menu-toggle" />
            <label class="menu-button" for="menu-toggle">
                <span></span><span></span><span></span>
            </label>
            <label class="menu-overlay" for="menu-toggle"></label>
            <nav class="sidebar">
                <a href="../php/clasificaciones.php">Clasificaciones</a>
                <a href="../php/sugerencias.php">Sugerencias</a>
                <a href="../php/opiniones.php">Opiniones</a>
            </nav>
        </div>
    </header>

    <div class="container">

        <h2 class="rankings-title">Ranking de Ejercicios</h2>
        <div class="rankings" id="rankingsContainer">

        </div>
    </div>

    <script src="../js/clasificaciones.js"></script>

</body>
</html>