<?php

require_once 'tiempo.php';
require_once 'conexion.php';

if (isset($_GET['user'])) {

  $user_url = strtolower($_GET['user']);
}

else {

  $user_url = null;
}

if (!$user_url) {

  header("Location: home.php");
  exit();
}

$stmt = $conexion->prepare("SELECT nombre, edad, peso FROM usuarios WHERE nombre = :nom");
$stmt->execute(['nom' => $user_url]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {

  die ("El deportista no existe en la base de datos.");
}

if (isset($_SESSION['usuario'])) {

  $user_login = strtolower($_SESSION['usuario']);
}

else {

  $user_login = null;
}


if ($user_login === $user_url && $user_login !== null) {

  $es_dueño = true;
}

else {

  $es_dueño = false;
}
 
$nombre = htmlspecialchars(ucfirst($usuario['nombre']));

if (isset($usuario['edad'])) {

  $edad = $usuario['edad'] ;
}

else {

  $edad = 0;
}

if (isset($usuario['peso'])) {

  $peso = $usuario['peso'];
}

else {

  $peso = 0;
}

if ($user_login) {

  $inicial = mb_strtoupper(mb_substr($user_login, 0, 1));
}

else {

  $inicial = '';
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <title><?= $nombre ?> — AllGim</title>
  <link rel="icon" href="../php/mostrar_foto.php?nombre=logo" type="image/png">

  <link rel="stylesheet" href="../css/estiloHome.css">
  <link rel="stylesheet" href="../css/estiloPerfilAtleta.css">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <header class="header-bar">
    <a href="home.php">
        <img src="../php/mostrar_foto.php?nombre=logo" alt="AllGim" class="logo-icon" />
    </a>

    <h1 class="header-title">
        <?php 
            $archivo_actual = basename($_SERVER['PHP_SELF']);
            if ($archivo_actual == 'comunidad.php') echo "COMUNIDAD ALLGIM";
            elseif ($archivo_actual == 'perfil_usuario.php') echo "PERFIL DEL DEPORTISTA";
            else echo "ENTRENA Y COMPITE CON ALLGIM";
        ?>
    </h1>

    <div class="header-actions">
        <?php if ($user_login): ?>
            <div id="session-timer" class="session-timer" data-seconds="<?= $tiempo_restante ?>">
                ⏱️ <span id="timer-display">--:--</span>
            </div>

            <div class="user-dropdown">
                <span class="user-avatar" style="background-color: #ff6b00;"><?= mb_strtoupper(mb_substr($user_login, 0, 1)) ?></span>
                <span>Hola, <?= htmlspecialchars(ucfirst($user_login)) ?> <span class="arrow-down">▼</span></span>
                <div class="dropdown-content">
                    <a href="perfil_usuario.php?user=<?= urlencode($user_login) ?>">Mi Perfil 👤</a>
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
            <a href="clasificaciones.php">Clasificaciones</a>
            <a href="sugerencias.php">Sugerencias</a>
            <a href="comunidad.php">Comunidad</a>
            <a href="../php/reservas.php">Reservar Clases</a>
        </nav>
    </div>
</header>
  <div class="nav-buttons" style="display: flex; gap: 10px; margin: 20px;">
    <a class="back" href="home.php" style="text-decoration: none;">← Volver al Inicio</a>
    <a class="community-link" href="comunidad.php" style="text-decoration: none;">👥 Volver a la Comunidad</a>
  </div>

  <div class="top-section">
    <div class="profile-img">
      <img src="../php/mostrar_foto.php?nombre=<?= urlencode($user_url) ?>" alt="Perfil de <?= $nombre ?>" />
    </div>
      <?php if ($es_dueño): ?>
        <form action="subir_foto_perfil.php" method="POST" enctype="multipart/form-data" id="fotoForm">
          <label class="btn-photo">
            📷 Cambiar Foto
            <input type="file" name="foto" onchange="document.getElementById('fotoForm').submit()" style="display:none">
          </label>
        </form>
      <?php endif; ?>
    

    <div class="profile-info">
      <h2>💪 <?= $nombre ?></h2>

      <?php if ($es_dueño): ?>
        <form action="actualizar_usuario.php" method="POST" class="edit-zone">
          <p>Edad: <input type="number" name="edad" value="<?= $edad ?>" class="input-mini"> años</p>
          <p>Peso: <input type="number" name="peso" value="<?= $peso ?>" class="input-mini"> kg</p>
          <button type="submit" class="btn-save">Guardar Cambios</button>
        </form>
      <?php else: ?>
        <p>Edad: <?= $edad ?> años</p>
        <p>Peso: <?= $peso ?> kg</p>
        <p style="color: #4b2ccf; font-size: 0.8em; margin-top: 10px;">Estás viendo el perfil de <?= $nombre ?>.</p>
      <?php endif; ?>
    </div>
  </div>

  <div class="chart-section">
    <h3>📊 <?= $es_dueño ? "Tus Marcas Personales" : "Marcas de " . $nombre ?></h3>

    <?php if ($es_dueño): ?>
      <form id="pesoForm" action="guardar_peso.php" method="post">
        <select id="ejercicio" name="ejercicio">
          <option value="pressbanca">Press banca</option>
          <option value="sentadilla">Sentadilla</option>
          <option value="pesomuerto">Peso muerto</option>
        </select>
        <input type="number" id="peso" name="peso" placeholder="Peso (kg)" required min="1">
        <button type="submit">Añadir</button>
      </form>
    <?php endif; ?>

    <div class="chart-wrapper">
      <canvas id="pesoChart"></canvas>
    </div>
  </div>

  <script>
    const usuarioPerfil = "<?= $user_url ?>";
  </script>
  
  <script src="../js/ivan.js"></script>
  <script src="../js/home.js"></script>

</body>
</html>