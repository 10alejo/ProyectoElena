<?php

require_once "accesoadatos.php";
session_start();

$db = new AccesoDatos($conexion);

$mensaje_login = "";
$mensaje_registro = "";

$vista_actual = 'login'; 

if (isset($_GET['v']) && $_GET['v'] == 'registro') {

    $vista_actual = 'registro';
}

// REGISTRO 
if (isset($_POST['accion']) && $_POST['accion'] == 'registrar') {

    $nombre = trim($_POST['nombre_reg']);
    $password = $_POST['password_reg'];

    if (empty($nombre)) {

        $mensaje_registro = "<p style='color:#b30000; font-weight: bold;'>El nombre de Usuario no puede estar vacío.</p>";
        $vista_actual = 'registro';
    }

    else if (strpos($nombre, ' ') !== false) {

        $mensaje_registro = "<p style='color:#b30000; font-weight: bold;'>El nombre de Usuario no puede contener espacios en blanco.</p>";
        $vista_actual = 'registro';
    }

    else if (strlen($password) < 8) {

        $mensaje_registro = "<p style='color:#b30000; font-weight: bold;'>La contraseña debe de contener almenos 8 carácteres.</p>";
        $vista_actual = 'registro';
    }

    else {

    $resultado = $db->registrarUsuario($nombre, $password);

    if ($resultado) {

        $mensaje_login = "<p style='color:#155724; font-weight: bold;'>¡Registro exitoso! Por favor, inicia sesión.</p>";
        $vista_actual = 'login'; 
    } 
    
    else {

        $mensaje_registro = "<p style='color:#b30000; font-weight: bold;'>El usuario ya existe.</p>";
        $vista_actual = 'registro'; 
    }
}
}

// LOGIN
if (isset($_POST['accion']) && $_POST['accion'] == 'login') {

    $nombre = trim($_POST['nombre_login']);
    $password = $_POST['password_login'];

    $usuarioDatos = $db->obtenerUsuarioPorNombre($nombre);

    if ($usuarioDatos && password_verify($password, $usuarioDatos['password'])) {

        $_SESSION['usuario'] = $usuarioDatos['nombre'];
        
        header('Location: home.php'); 
        exit();
    } 
    
    else {

        $mensaje_login = "<p style='color:#b30000; font-weight : bold;'>Usuario o contraseña incorrectos.</p>";
        $vista_actual = 'login';
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - AllGim</title>
    <link rel="icon" href="../php/mostrar_foto.php?nombre=logo" type="image/png">
    <link rel="stylesheet" href="../css/estiloAcceso.css">
</head>

<body>
    <div class="container">
        <div class="form-box <?= ($vista_actual == 'login') ? 'active' : '' ?>">
            <img src="../php/mostrar_foto.php?nombre=logo" alt="AllGim" class="imagen-logo" />
            <h2>Inicio de Sesión</h2>

            <?= $mensaje_login ?>

            <form method="POST">
                <input type="hidden" name="accion" value="login">
                <input type="text" name="nombre_login" placeholder="Nombre de Usuario" autofocus required
                    pattern="^\S+$" title="No se permiten espacios en blanco">
                <input type="password" name="password_login" placeholder="Contraseña" autofocus required>

                <button type="submit">Acceder</button>

                <p style="text-align: center; margin-top: 15px;">
                    ¿Aún no tienes cuenta?
                    <a href="acceso.php?v=registro" style="color: #090909; font-weight: bold;">Regístrate aquí</a>
                </p>
            </form>
        </div>

        <div class="form-box <?= ($vista_actual == 'registro') ? 'active' : '' ?>">
            <img src="../php/mostrar_foto.php?nombre=logo" alt="AllGim" class="imagen-logo" />
            <h2>Registro</h2>

            <?= $mensaje_registro ?>

            <form method="POST">
                <input type="hidden" name="accion" value="registrar">
                <input type="text" name="nombre_reg" placeholder="Nombre" required pattern="^\S+$"
                    title="No se permiten espacios en blanco">
                <input type="password" name="password_reg" placeholder="Contraseña (mínimo 8 caracteres)" required>

                <button type="submit">Registrarse</button>

                <p style="text-align: center; margin-top: 15px;">
                    ¿Ya tienes cuenta?
                    <a href="acceso.php?v=login" style="color: #090909; font-weight: bold;">Inicia sesión</a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>