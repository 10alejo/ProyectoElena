<?php

require_once 'tiempo.php';


// Configuración de idioma y zona horaria
setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
date_default_timezone_set('Europe/Madrid'); 

// Comprobamos usuario
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Suscripciones - AllGim</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Quicksand:wght@700&display=swap"
        rel="stylesheet" />
    <link rel="icon" href="../php/mostrar_foto.php?nombre=logo" type="image/png">
    <link rel="stylesheet" href="../css/estiloSuscripciones.css" />
</head>

<body>

    <header class="header-bar">
        <a href="../php/home.php">
            <img src="../php/mostrar_foto.php?nombre=logo" alt="AllGim" class="logo-icon" />
        </a>
        <h1 class="header-title">PLANES DE ENTRENAMIENTO</h1>

        <div class="header-actions">

            <?php if ($usuario_logueado): ?>
            <div class="user-dropdown">
                <span class="user-avatar"><?= $inicial ?></span>
                <span>Hola, <?= htmlspecialchars($usuario_logueado) ?> <span class="arrow-down">▼</span></span>
                <div class="dropdown-content">
                    <a>Perfil Verificado <img src="https://cdn-icons-png.flaticon.com/512/6364/6364343.png"
                            alt="Verificado" width="12" height="12"></a>
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
                <a href="../php/comunidad.php">Comunidad</a>
                <a href="../php/reservas.php">Reservar Clases</a>
            </nav>
        </div>
    </header>

    <main class="pricing-container">
        <div class="pricing-header">
            <h2>ELIGE TU PLAN</h2>
            <p>Entrena en el mejor ambiente de Madrid con tecnología de élite.</p>
        </div>

        <div class="pricing-grid">
            <div class="price-card">
                <div class="card-header">
                    <h3>Principiante</h3>
                    <p class="old-price">€24,99</p>
                    <div class="main-price">€10,00<span>/ 4 semanas</span></div>
                    <p class="fee">€19,99 cuota de inscripción</p>
                </div>
                <div class="promo-tag">
                    🎁 Primeras 4 semanas por €10,00 + una mochila
                </div>
                <ul class="feature-list">
                    <li class="check">Entrena en Madrid (Calle Juan Mieg)</li>
                    <li class="check">
                        Acceso a sala de máquinas de última generación
                    </li>
                    <li class="check">App AllGim básica de seguimiento</li>
                    <li class="cross">Clases colectivas ilimitadas</li>
                    <li class="cross">Zona de recuperación y masajes</li>
                    <li class="cross">Invita a un amigo 1 vez por semana</li>
                </ul>
                <button class="btn-plan" onclick="window.location.href='../php/checkout.php?plan=basico'">
                    SELECCIONAR PRINCIPIANTE
                </button>
            </div>

            <div class="price-card featured">
                <div class="best-value">MÁS POPULAR</div>
                <div class="card-header">
                    <h3>AVANZADO</h3>
                    <p class="old-price">€29,99</p>
                    <div class="main-price">€15,00<span>/ 4 semanas</span></div>
                    <p class="fee">€10,00 cuota de inscripción</p>
                </div>
                <div class="promo-tag">
                    🎁 Primeras 4 semanas por €15,00 + mochila + bidón
                </div>
                <ul class="feature-list">
                    <li class="check">Entrena en toda España</li>
                    <li class="check">Clases colectivas ilimitadas</li>
                    <li class="check">App AllGim Premium con rutinas</li>
                    <li class="check">Invita a un amigo 1 vez por semana</li>
                    <li class="check">Hidratación Yanga Sports Water</li>
                    <li class="cross">Zona de masajes ilimitada</li>
                </ul>
                <button class="btn-plan orange" onclick="window.location.href='../php/checkout.php?plan=avanzado'">
                    SELECCIONAR AVANZADO
                </button>
            </div>

            <div class="price-card highlight">
                <div class="best-value yellow">MEJOR VALORADA</div>
                <div class="card-header">
                    <h3>PRO ALLGIM</h3>
                    <p class="old-price">€39,99</p>
                    <div class="main-price">€19,99<span>/ 4 semanas</span></div>
                    <p class="fee">€1,00 cuota de inscripción</p>
                </div>
                <div class="promo-tag">
                    🎁 Primeras 4 semanas por €19,99 + Kit Completo
                </div>
                <ul class="feature-list">
                    <li class="check">Entrena en toda Europa</li>
                    <li class="check">Clases colectivas y Bootcamps</li>
                    <li class="check">Uso ilimitado de sillones de masaje</li>
                    <li class="check">Entrena siempre acompañado/a</li>
                    <li class="check">Hidratación y suplementación básica</li>
                    <li class="check">Plan nutricional mensual personalizado</li>
                </ul>
                <button class="btn-plan yellow" onclick="window.location.href='../php/checkout.php?plan=ultimate'">
                    SELECCIONAR PRO ALLGIM
                </button>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>© 2025 AllGim Madrid. Todos los derechos reservados.</p>
    </footer>

</body>

</html>