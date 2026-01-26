<?php
require_once 'tiempo.php';
require_once 'conexion.php'; // Tu archivo que usa PDO

try {
    // Consulta corregida para PDO (evita el Fatal Error)
    $query = "SELECT nombre, edad, peso FROM usuarios ORDER BY nombre ASC";
    $stmt = $conexion->query($query);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $usuarios = []; // Si falla, creamos un grupo vacío para que no explote la web
}

if (isset($_SESSION['usuario'])) {
    $usuario_logueado = $_SESSION['usuario'];
    $inicial = mb_strtoupper(mb_substr($usuario_logueado, 0, 1));
} else {
    $usuario_logueado = null;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comunidad — AllGim</title>
    <link rel="stylesheet" href="../css/estiloHome.css">
    <link rel="stylesheet" href="../css/estiloComunidad.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header-bar">
        <a href="home.php">
            <img src="../php/mostrar_foto.php?nombre=logo" alt="AllGim" class="logo-icon" />
        </a>
        <h1 class="header-title">COMUNIDAD ALLGIM</h1>

        <div class="header-actions">
            <?php if ($usuario_logueado): ?>
                <div id="session-timer" class="session-timer" data-seconds="<?= $tiempo_restante ?>">
                    ⏱️ <span id="timer-display">--:--</span>
                </div>

                <div class="user-dropdown">
                    <span class="user-avatar"><?= $inicial ?></span>
                    <span>Hola, <?= htmlspecialchars($usuario_logueado) ?> <span class="arrow-down">▼</span></span>
                    <div class="dropdown-content">
                        <a href="perfil_usuario.php?user=<?= urlencode(strtolower($usuario_logueado)) ?>">Mi Perfil 👤</a>
                        <hr style="margin: 0; border: 0; border-top: 1px solid #eee;">
                        <a href="logout.php" style="color: red;">Cerrar sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="acceso.php" class="user-link-icon" title="Acceso">👤</a>
            <?php endif; ?>

            <input type="checkbox" id="menu-toggle">
            <label class="menu-button" for="menu-toggle">
                <span></span><span></span><span></span>
            </label>

            <label class="menu-overlay" for="menu-toggle"></label>
            <nav class="sidebar">
                <a href="home.php">Inicio</a>
                <a href="clasificaciones.php">Clasificaciones</a>
                <a href="sugerencias.php">Sugerencias</a>
                <a href="comunidad.php">Comunidad</a>
                <a href="../php/reservas.php">Reservar Clases</a>
            </nav>
        </div>
    </header>

    <div class="community-grid">
        <?php foreach ($usuarios as $user): ?>
            <div class="photo-card">
                <div class="photo-name"><?= htmlspecialchars($user['nombre']) ?></div>
                <div class="photo-img">
                    <img src="../php/mostrar_foto.php?nombre=<?= urlencode($user['nombre']) ?>" alt="Atleta">
                </div>

                <div class="preview">
                    <h3><?= htmlspecialchars($user['nombre']) ?></h3>

                    <p>Edad: <?= ($user['edad'] > 0) ? $user['edad'] : '--' ?> años</p>
                    <p>Peso: <?= ($user['peso'] > 0) ? $user['peso'] : '--' ?> Kg</p>

                    <button onclick="location.href='perfil_usuario.php?user=<?= urlencode($user['nombre']) ?>'">
                        Ver perfil
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="../js/home.js"></script>
</body>

</html>