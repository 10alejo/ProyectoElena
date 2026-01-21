<?php
// INICIO DE SESIÓN
session_start();

// Comprobamos si hay alguien logueado
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página de Inicio - AllGim</title>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Quicksand:wght@700&family=Poppins:wght@700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css/estiloHome.css" />
</head>

<body>

    <header class="header-bar">
        <a href="../php/home.php">
        <img src="../images/logo.png" alt="AllGim" class="logo-icon" />
        </a>
        <h1 class="header-title">ENTRENA Y COMPITE</h1>

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
                <a href="../pages/opiniones.html">Opiniones</a>
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
                    <p class="data-item">📍 <a href="https://www.google.com/maps/search/?api=1&query=Calle+Juan+Mieg+12+28054+Madrid">Vía Límite 14</a></p>
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
                        <source src="../videos/video-allgim.mp4" type="video/mp4">
                        Tu navegador no soporta videos.
                    </video>
                </div>
            </div>
        </div>
    </section>

    <section class="founders-section">
        <h2 class="founders-title">FUNDADORES</h2>
        <p class="founders-text">AllGim nace de nuestra pasión compartida por el entrenamiento de fuerza y la superación
            personal. Decidimos crear este proyecto porque queríamos un espacio que no solo fuera un gimnasio, sino un
            centro de competición real. Somos cuatro amigos unidos por el deporte que han diseñado este entorno para que
            cada repetición cuente y cada socio pueda alcanzar su máximo nivel.</p>

        <div class="founders-grid">
            <div class="photo-card">
                <div class="photo-name">Diego</div>
                <div class="photo-img"><img src="../images/diego.png" alt="Diego"></div>
                <div class="preview">
                    <h3>Diego</h3>
                    <p><strong>Edad:</strong> 19 años</p>
                    <p><strong>Peso:</strong> 66 Kg</p>
                    <button onclick="location.href='../pages/paginaDiego.html'">Ver perfil</button>
                </div>
            </div>
            <div class="photo-card">
                <div class="photo-name">Alejandro</div>
                <div class="photo-img"><img src="../images/alejandro.png" alt="Alejandro"></div>
                <div class="preview">
                    <h3>Alejandro</h3>
                    <p><strong>Edad:</strong> 19 años</p>
                    <p><strong>Peso:</strong> 72 Kg</p>
                    <button onclick="location.href='../pages/paginaAlejandro.html'">Ver perfil</button>
                </div>
            </div>
            <div class="photo-card">
                <div class="photo-name">Iván</div>
                <div class="photo-img"><img src="../images/ivan.png" alt="Iván"></div>
                <div class="preview">
                    <h3>Iván</h3>
                    <p><strong>Edad:</strong> 19 años</p>
                    <p><strong>Peso:</strong> 68 Kg</p>
                    <button onclick="location.href='../pages/paginaIvan.html'">Ver perfil</button>
                </div>
            </div>
            <div class="photo-card">
                <div class="photo-name">Adrián</div>
                <div class="photo-img"><img src="../images/adrian.png" alt="Adrián"></div>
                <div class="preview">
                    <h3>Adrián</h3>
                    <p><strong>Edad:</strong> 21 años</p>
                    <p><strong>Peso:</strong> 97 Kg</p>
                    <button onclick="location.href='../pages/paginaAdrian.html'">Ver perfil</button>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>© 2025 AllGim. Todos los derechos reservados.</p>
    </footer>

    <script src="../js/home.js"></script>

</body>
</html>