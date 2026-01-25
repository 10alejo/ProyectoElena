<?php
session_start();

// 1. ¿A quién visitamos? (Ejemplo: perfil.php?user=diego)
$user_url = isset($_GET['user']) ? strtolower($_GET['user']) : 'ivan';

// 2. ¿Quién está logueado?
$user_login = isset($_SESSION['usuario']) ? strtolower($_SESSION['usuario']) : null;

// 3. ¿Es el dueño?
$es_dueño = ($user_login === $user_url);

// 4. Diccionario de datos para no repetir archivos
$datos_usuarios = [
    'ivan' => ['nombre' => 'Iván', 'edad' => 19, 'peso' => 68, 'rutina' => 'Judo + Push/Pull/Legs'],
    'diego' => ['nombre' => 'Diego', 'edad' => 20, 'peso' => 75, 'rutina' => 'Powerlifting'],
    'alejandro' => ['nombre' => 'Alejandro', 'edad' => 19, 'peso' => 70, 'rutina' => 'Calistenia'],
    'adrian' => ['nombre' => 'Adrián', 'edad' => 21, 'peso' => 80, 'rutina' => 'Bodybuilding']
];

// Si el usuario no existe en el array, volvemos a Ivan por defecto
$u = isset($datos_usuarios[$user_url]) ? $datos_usuarios[$user_url] : $datos_usuarios['ivan'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title><?php echo $u['nombre']; ?> — AllGim</title>
  <link rel="stylesheet" href="../css/estiloIvan.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <a class="back" href="../php/home.php">← Volver</a>

  <div class="top-section">
    <div class="profile-img">
      <img src="../php/mostrar_foto.php?nombre=<?php echo $user_url; ?>" alt="Perfil" />
    </div>
    <div class="profile-info">
      <h2>💪 <?php echo $u['nombre']; ?></h2>
      <p>Edad: <?php echo $u['edad']; ?> años</p>
      <p>Peso: <?php echo $u['peso']; ?> kg</p>
    </div>
  </div>

  <div class="chart-section">
    <h3>📊 <?php echo $es_dueño ? "Registrar y visualizar tus marcas" : "Marcas de " . $u['nombre']; ?></h3>
    
    <?php if ($es_dueño): ?>
      <form id="pesoForm" action="../php/guardar_peso.php" method="post">
        <select id="ejercicio" name="ejercicio">
          <option value="pressbanca">Press banca</option>
          <option value="sentadilla">Sentadilla</option>
          <option value="pesomuerto">Peso muerto</option>
          <option value="pressmilitar">Press militar</option>
          <option value="dominadaslastradas">Dominadas lastradas</option>
        </select>
        <input type="number" id="peso" name="peso" placeholder="Peso (kg)" required min="1">
        <button type="submit">Añadir</button>
      </form>
    <?php else: ?>
      <p style="text-align:center; color:#9bb3ff;">Estás viendo el perfil de <?php echo $u['nombre']; ?>.</p>
    <?php endif; ?>

    <div class="chart-wrapper">
      <canvas id="pesoChart"></canvas>
    </div>
  </div>

  <script>const usuarioPerfil = "<?php echo $user_url; ?>";</script>
  <script src="../js/ivan.js"></script>
</body>
</html>