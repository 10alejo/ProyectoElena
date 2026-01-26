<?php
// 1. Cargamos la lógica de tiempo y conexión
require_once 'tiempo.php'; 
require_once 'conexion.php'; 

if (isset($_SESSION['usuario'])) {
    $usuario_logueado = $_SESSION['usuario'];
    $inicial = mb_strtoupper(mb_substr($usuario_logueado, 0, 1));
} else {
    $usuario_logueado = null;
    $inicial = '';
}

// 2. BUSCAR DATOS REALES DE LOS FUNDADORES
$nombres_fundadores = ['diego', 'alejandro', 'ivan', 'adrian'];
try {
    $placeholders = str_repeat('?,', count($nombres_fundadores) - 1) . '?';
    $stmt_f = $conexion->prepare("SELECT nombre, edad, peso FROM usuarios WHERE nombre IN ($placeholders)");
    $stmt_f->execute($nombres_fundadores);
    $resultados = $stmt_f->fetchAll(PDO::FETCH_ASSOC);

    $datos_f = [];
    foreach ($resultados as $fila) {
        $datos_f[strtolower($fila['nombre'])] = $fila;
    }
} catch (Exception $e) {
    $datos_f = []; 
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página de Inicio - AllGim</title>
    <link rel="icon" href="../php/mostrar_foto.php?nombre=logo" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Quicksand:wght@700&family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/estiloHome.css" />
</head>

<body>
    <header class="header-bar">
        <a href="../php/home.php">
            <img src="../php/mostrar_foto.php?nombre=logo" alt="AllGim" class="logo-icon" />
        </a>
        <h1 class="header-title">ENTRENA Y COMPITE CON ALLGIM</h1>

        <div class="header-actions">
            <?php if ($usuario_logueado): ?>
                <div id="session-timer" class="session-timer" data-seconds="<?= $tiempo_restante ?>">
                    ⏱️ <span id="timer-display">--:--</span>
                </div>

                <div class="user-dropdown">
                    <span class="user-avatar"><?= $inicial ?></span>
                    <span>Hola, <?= htmlspecialchars($usuario_logueado) ?> <span class="arrow-down">▼</span></span>
                    <div class="dropdown-content">
                        <a href="../php/perfil_usuario.php?user=<?= urlencode(strtolower($usuario_logueado)) ?>">Mi Perfil 👤</a>
                        <hr style="margin: 0; border: 0; border-top: 1px solid #eee;">
                        <a href="../php/logout.php" style="color: red;">Cerrar sesión</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="../php/acceso.php" class="user-link-icon" title="Acceso">👤</a>
            <?php endif; ?>

            <input type="checkbox" id="menu-toggle">
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

    <section class="hero-orange">
        <div class="hero-container">
            <div class="hero-left">
                <span class="tag-abierto">Abierto desde 27.02.26</span>
                <h2 class="gym-title">PRIMER GIMNASIO<br>VÍA LÍMITE 14</h2>

                <div class="white-timer-box slider-container">
                    <a class="prev-slide" onclick="plusSlides(-1)"></a>
                    <a class="next-slide" onclick="plusSlides(1)"></a>

                    <div class="mySlides fade">
                        <p class="label-valido">VÁLIDO HASTA</p>
                        <div class="timer-display">
                            <div class="t-unit"><span id="h">05</span><small>H</small></div>
                            <div class="t-unit"><span id="m">17</span><small>M</small></div>
                            <div class="t-unit"><span id="s">10</span><small>S</small></div>
                        </div>
                        <h3 class="offer-forever">OFERTAS LIMITADAS</h3>
                        <button class="btn-subscribe" onclick="location.href='../php/suscripciones.php'">SUSCRÍBETE AHORA</button>
                    </div>

                    <div class="mySlides fade" style="display: none;">
                        <div class="slide-content-news">
                            <div class="news-icon">🏊‍♂️</div>
                            <h3 class="news-title">CLASES GRATIS</h3>
                            <p class="news-desc">Clases de natación incluidas<br>con tu primera suscripción.</p>
                            <p class="news-sub">¡Plazas Limitadas!</p>
                            <button class="btn-subscribe" onclick="location.href='reservas.php'">RESERVAR CLASE</button>
                        </div>
                    </div>

                    <div class="dots-container">
                        <span class="dot" onclick="currentSlide(1)"></span>
                        <span class="dot" onclick="currentSlide(2)"></span>
                    </div>
                </div>
            </div>

            <div class="hero-right">
                <div class="price-card pc1">
                    <div class="p-val">24,99 €</div><small>/ 4 SEMANAS</small>
                    <p>Hasta el día de apertura</p>
                </div>
                <div class="price-card pc2">
                    <div class="p-val">29,99 €</div><small>/ 4 SEMANAS</small>
                    <p>Hasta una semana después de la apertura</p>
                </div>
                <div class="price-card pc3">
                    <div class="p-val">39,99 €</div><small>/ 4 SEMANAS</small>
                    <p>Hasta cuatro semanas después de la apertura</p>
                </div>
            </div>
        </div>
    </section>

    <section class="gym-detail-section">
        <div class="gym-detail-container">
            <div class="gym-info-side">
                <h2 class="gym-detail-title"><span class="orange-text">VAMOS</span><br>GIMNASIO MADRID</h2>
                <div class="gym-data">
                    <p class="data-item">📍 <a href="https://www.google.com/maps/search/?api=1&query=Calle+Via+Limite+14+28029+Madrid">Calle Vía Límite 14</a></p>
                    <p class="data-item">🕒 Lunes - Viernes: 6:00h - 00:00h<br>Sábados, Domingos y Festivos: 08:00h - 21:00h</p>
                </div>
                <hr class="divider">
                <div class="gym-features-grid">
                    <div class="feature">🚿 Duchas</div>
                    <div class="feature">👕 Vestuarios</div>
                    <div class="feature">🔐 Taquillas</div>
                    <div class="feature">⚡ 7 Zonas de entrenamiento</div>
                    <div class="feature">🌐 WiFi gratuito</div>
                </div>
                <button class="btn-subscribe-purple" onclick="location.href='../php/reservas.php'">RESERVA TUS CLASES</button>
            </div>
            <div class="gym-video-side">
                <div class="video-wrapper">
                    <video controls poster="../images/poster-gym.jpg">
                        <source src="../videos/video-allgim.mp4" type="video/mp4"> Tu navegador no soporta videos.
                    </video>
                </div>
            </div>
        </div>
    </section>

    <section class="founders-section">
        <h2 class="founders-title">FUNDADORES</h2>
        <p class="founders-text">AllGim nace de nuestra pasión compartida por el entrenamiento de fuerza...</p>

        <div class="founders-grid">
            <?php 
            $fundadores = ['diego' => 'Diego', 'alejandro' => 'Alejandro', 'ivan' => 'Iván', 'adrian' => 'Adrián'];
            foreach ($fundadores as $slug => $nombre_real): 
                $edad = $datos_f[$slug]['edad'] ?? '--';
                $peso = $datos_f[$slug]['peso'] ?? '--';
            ?>
            <div class="photo-card">
                <div class="photo-name"><?= $nombre_real ?></div>
                <div class="photo-img">
                    <img src="../php/mostrar_foto.php?nombre=<?= $slug ?>" alt="<?= $nombre_real ?>" />
                </div>
                <div class="preview">
                    <h3><?= $nombre_real ?></h3>
                    <p><strong>Edad:</strong> <?= $edad ?> años</p>
                    <p><strong>Peso:</strong> <?= $peso ?> Kg</p>
                    <button onclick="location.href='../php/perfil_usuario.php?user=<?= $slug ?>'">
                        <?= ($usuario_logueado && strtolower($usuario_logueado) === $slug) ? 'Ver perfil' : 'Previsualizar' ?>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer class="footer">
        <p>© 2025 AllGim. Todos los derechos reservados.</p>
    </footer>

    <script src="../js/home.js"></script>
</body>
</html>