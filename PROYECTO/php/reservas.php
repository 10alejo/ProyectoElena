<?php
require_once 'tiempo.php';

setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
date_default_timezone_set('Europe/Madrid'); 

if (isset($_SESSION['usuario'])) {

    $usuario_logueado = $_SESSION['usuario'];
    $inicial = mb_strtoupper(mb_substr($usuario_logueado, 0, 1));
}

else {

    $usuario_logueado = null;
    $inicial = '';
}

if (isset($_GET['fecha'])) {

    $fecha_actual_str = $_GET['fecha'];
}

else {

    $fecha_actual_str = date('Y-m-d');
}

$timestamp_actual = time(); 
$fecha_obj = new DateTime($fecha_actual_str);

$dias_semana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
$meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

$dia_semana_texto = $dias_semana[$fecha_obj->format('w')];
$dia_mes = $fecha_obj->format('j');
$mes_texto = $meses[$fecha_obj->format('n') - 1];
$texto_fecha_completa = "$dia_semana_texto, $dia_mes de $mes_texto";

$fecha_manana = clone $fecha_obj;
$fecha_manana->modify('+1 day');
$link_manana = '?fecha=' . $fecha_manana->format('Y-m-d');

$fecha_ayer = clone $fecha_obj;
$fecha_ayer->modify('-1 day');
$link_ayer = '?fecha=' . $fecha_ayer->format('Y-m-d');


$actividades = [
    [
        "nombre" => "Body Pump",
        "hora_inicio" => "09:30",
        "hora_fin" => "10:30",
        "monitor" => "Diego",
        "plazas_totales" => 20,
        "plazas_ocupadas" => 18,
        "intensidad" => "Alta",
        "imagen" => "🏋️"
    ],
    [
        "nombre" => "Boxeo",
        "hora_inicio" => "11:00",
        "hora_fin" => "12:00",
        "monitor" => "Alejandro",
        "plazas_totales" => 15,
        "plazas_ocupadas" => 5,
        "intensidad" => "Alta",
        "imagen" => "🥊"
    ],
    [
        "nombre" => "Natación",
        "hora_inicio" => "12:30",
        "hora_fin" => "13:30",
        "monitor" => "Iván",
        "plazas_totales" => 10,
        "plazas_ocupadas" => 2,
        "intensidad" => "Media",
        "imagen" => "🏊‍♂️"
    ],
    [
        "nombre" => "Yoga",
        "hora_inicio" => "17:00",
        "hora_fin" => "18:00",
        "monitor" => "Adrián",
        "plazas_totales" => 25,
        "plazas_ocupadas" => 25,
        "intensidad" => "Baja",
        "imagen" => "🧘"
    ],
    [
        "nombre" => "CrossFit",
        "hora_inicio" => "18:30",
        "hora_fin" => "19:30",
        "monitor" => "Lucía",
        "plazas_totales" => 12,
        "plazas_ocupadas" => 8,
        "intensidad" => "Muy Alta",
        "imagen" => "🔥"
    ],
    [
        "nombre" => "Zumba",
        "hora_inicio" => "20:00",
        "hora_fin" => "21:00",
        "monitor" => "Sara",
        "plazas_totales" => 30,
        "plazas_ocupadas" => 15,
        "intensidad" => "Media",
        "imagen" => "💃"
    ]
];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reservar Clases - AllGim</title>
    <link rel="icon" href="../php/mostrar_foto.php?nombre=logo" type="image/png">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Quicksand:wght@500;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../css/estiloHome.css" />
    <link rel="stylesheet" href="../css/estiloReservas.css" />
</head>

<body>

    <header class="header-bar">
        <a href="../php/home.php">
            <img src="../php/mostrar_foto.php?nombre=logo" alt="AllGim" class="logo-icon" />
        </a>
        <h1 class="header-title">RESERVA TUS CLASES</h1>

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
                <a href="../php/Comunidad.php">Comunidad</a>
                <a href="../php/reservas.php">Reservar Clases</a>
            </nav>
        </div>
    </header>

    <main class="reservas-container">

        <div class="date-navigation-wrapper">
            <div class="date-navigation">
                <?php if($fecha_actual_str > date('Y-m-d')): ?>
                <a href="<?= $link_ayer ?>" class="nav-btn prev" title="Día Anterior">❮</a>
                <?php else: ?>
                <span class="nav-btn prev disabled">❮</span>
                <?php endif; ?>

                <div class="current-date-group">
                    <h2 class="titulo-fecha"><?= $texto_fecha_completa ?></h2>

                    <form action="" method="GET" class="form-calendario">
                        <label for="date-input" class="calendar-icon">📅 Cambiar fecha</label>
                        <input type="date" id="date-input" name="fecha" value="<?= $fecha_actual_str ?>"
                            onchange="this.form.submit()">
                    </form>
                </div>

                <a href="<?= $link_manana ?>" class="nav-btn next" title="Día Siguiente">❯</a>
            </div>
        </div>

        <div class="grid-actividades">
            <?php foreach ($actividades as $clase): 
                
                $fecha_clase_str = $fecha_actual_str . ' ' . $clase['hora_inicio'] . ':00';
                $timestamp_clase = strtotime($fecha_clase_str);
                
                $diferencia_segundos = $timestamp_clase - $timestamp_actual;
                $horas_restantes = $diferencia_segundos / 3600;

                $estado_btn = "activo"; 
                $texto_btn = "RESERVAR PLAZA";
        
                if ($diferencia_segundos < 0) {

                    $estado_btn = "pasada";
                    $texto_btn = "FINALIZADA";
                }

                elseif ($horas_restantes > 24) {

                    $estado_btn = "futura";
                    $texto_btn = "DISPONIBLE EN BREVE";
                }

                elseif ($clase['plazas_ocupadas'] >= $clase['plazas_totales']) {

                    $estado_btn = "llena";
                    $texto_btn = "COMPLETA";
                }

                $porcentaje = ($clase['plazas_ocupadas'] / $clase['plazas_totales']) * 100;
            ?>
            
            <div class="card-actividad <?= ($estado_btn != 'activo') ? 'deshabilitada' : '' ?>">
                <div class="card-header">
                    <div class="icono-actividad"><?= $clase['imagen'] ?></div>
                    <div class="info-top">
                        <h3><?= $clase['nombre'] ?></h3>
                        <span class="hora">🕒 <?= $clase['hora_inicio'] ?> - <?= $clase['hora_fin'] ?></span>
                    </div>
                </div>

                <div class="card-body">
                    <p class="monitor">Monitor: <strong><?= $clase['monitor'] ?></strong></p>

                    <div class="intensidad-box">
                        <span>Intensidad:</span>
                        <span class="badge-intensidad <?= strtolower(str_replace(' ', '-', $clase['intensidad'])) ?>">
                            <?= $clase['intensidad'] ?>
                        </span>
                    </div>

                    <div class="plazas-info">
                        <span>Ocupación:</span>
                        <div class="barra-progreso">
                            <div class="progreso-relleno" style="width: <?= $porcentaje ?>%;"></div>
                        </div>
                        <small><?= $clase['plazas_ocupadas'] ?> / <?= $clase['plazas_totales'] ?> plazas</small>
                    </div>
                </div>

                <div class="card-footer">
                    <?php if ($estado_btn == 'activo'): ?>
                    <button class="btn-reservar"
                        onclick="confirmarReserva('<?= $clase['nombre'] ?>', '<?= $clase['hora_inicio'] ?> del <?= $fecha_actual_str ?>')">
                        <?= $texto_btn ?>
                    </button>
                    <?php else: ?>
                    <button class="btn-reservar disabled" disabled>
                        <?= $texto_btn ?>
                        <?php if($estado_btn == 'futura'): ?>
                        <br><small style="font-size: 0.7em;">Abre 24h antes</small>
                        <?php endif; ?>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </main>

    <footer class="footer">
        <p>© 2025 AllGim. Todos los derechos reservados.</p>
    </footer>

    <script src="../js/reservas.js"></script>

</body>
</html>