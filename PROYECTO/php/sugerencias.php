<?php

require_once 'tiempo.php';


if (isset($_SESSION['usuario'])) {

    $usuario_logueado = $_SESSION['usuario'];
    $inicial = mb_strtoupper(mb_substr($usuario_logueado, 0, 1));
} 

else {

    $usuario_logueado = null;
    $inicial = '';
}

require_once "conexion.php"; 
$mensaje_status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['nombre']) {

        $nombre = $_POST['nombre'];
    }

    else {

        $nombre = '';
    }

    if ($_POST['categoria']) {

        $categoria = $_POST['categoria'];
    }

    else {

        $categoria = '';
    }

    if ($_POST['mensaje']) {

        $mensaje = $_POST['mensaje'];
    }

    else {

        $mensaje = '';
    }

    if (!empty($nombre) && !empty($mensaje) && !empty($categoria)) {

        try {

            $sql = "INSERT INTO sugerencias (nombre, categoria, mensaje) VALUES (:nombre, :categoria, :mensaje)";
            $stmt = $conexion->prepare($sql);
            $resultado = $stmt->execute([':nombre' => $nombre, ':categoria' => $categoria, ':mensaje' => $mensaje]);

            if ($resultado) { 
                
                header("Location: " . $_SERVER['PHP_SELF']);
                exit; 
            }
        } 
        
        catch (PDOException $e) { 

            $mensaje_status = "Error al guardar."; 
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugerencias - AllGim</title>
    <link rel="icon" href="../php/mostrar_foto.php?nombre=logo" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&family=Poppins:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/estiloSugerencias.css">
</head>

<body>

    <header class="header-bar">
        <a href="../php/home.php">
            <img src="../php/mostrar_foto.php?nombre=logo" alt="AllGim" class="logo-icon" />
        </a>

        <div class="header-center">
            <h1 class="header-title">Sugerencias para AllGim</h1>
            <p class="subheader-title">Comparte tus sugerencias para la Web o Ejercicios</p>
        </div>

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

    <div class="container">
        <div class="form-card">
            <h2 class="form-title">ENVÍA TU SUGERENCIA</h2>
            <form method="POST" class="suggestion-form">
                <input type="text" name="nombre" placeholder="Nombre" required>
                <select name="categoria" required>
                    <option value="">Selecciona tipo de sugerencia</option>
                    <option value="Idea para la Web">Idea para la web</option>
                    <option value="Ejercicio">Ejercicio</option>
                    <option value="Otra sugerencia">Otro</option>
                </select>
                <textarea name="mensaje" rows="6" placeholder="Escribe tu sugerencia..." required></textarea>
                <button type="submit" class="submit-button">ENVIAR SUGERENCIA</button>
            </form>
        </div>
    </div>

</body>

</html>