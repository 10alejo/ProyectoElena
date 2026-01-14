<?php
// 1. Incluimos la clase y la conexión
require_once "accesoadatos.php";

// Iniciamos sesión para guardar los datos del usuario logueado
session_start();

// Instanciamos la clase pasando la variable $conexion (que viene de conexion.php incluido dentro de accesoadatos)
$db = new AccesoDatos($conexion);

$mensaje = "";
$mensaje_registro = "";

// ---------------------------------------------------------
// LÓGICA DE REGISTRO
// ---------------------------------------------------------
if (isset($_POST['accion']) && $_POST['accion'] == 'registrar') {
    $nombre = $_POST['nombre_reg'];
    $password = $_POST['password_reg'];

    // Intentamos registrar
    $resultado = $db->registrarUsuario($nombre, $password);

    if ($resultado) {
        $mensaje_registro = "<p style='color:green;'>¡Usuario registrado! Ahora puedes iniciar sesión.</p>";
    } else {
        $mensaje_registro = "<p style='color:red;'>Error: El nombre de usuario ya existe.</p>";
    }
}

// ---------------------------------------------------------
// LÓGICA DE LOGIN
// ---------------------------------------------------------
if (isset($_POST['accion']) && $_POST['accion'] == 'login') {
    $nombre = $_POST['nombre_login'];
    $password = $_POST['password_login'];

    // Buscamos el usuario en la BD
    $usuarioDatos = $db->obtenerUsuarioPorNombre($nombre);

    // Verificamos si existe el usuario Y si la contraseña coincide con el Hash
    if ($usuarioDatos && password_verify($password, $usuarioDatos['password'])) {
        
        // ¡LOGIN CORRECTO!
        $_SESSION['usuario'] = $usuarioDatos['nombre'];
        
        // Redirigimos a la página principal (cambia 'panel.php' por tu archivo de destino)
        header('Location: ../pages/home.html'); 
        exit();

    } else {
        $mensaje = "<p style='color:red;'>Usuario o contraseña incorrectos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso a AllGim</title>
    <link rel="stylesheet" href="../css/estiloAcceso.css">
</head>

<body>

    <div class="container">
        <div class="form-box active">
            <h2>Acceso a AllGim</h2>
            <p>Inicio de Sesión</p>

            <?= $mensaje ?>

            <form method="POST">
                <input type="hidden" name="accion" value="login">

                <input type="text" name="nombre_login" placeholder="Nombre" required>
                <input type="password" name="password_login" placeholder="Contraseña" required>

                <button type="submit">Acceder</button>

                <label for="">¿Aun no estás registrado? <a href=""></label>
            </form>
        </div>
    </div>

    <br>
    <div class="registrar">
        <div class="form-box active">
            <h2>Registro</h2>

            <?= $mensaje_registro ?>

            <form method="POST">
                <input type="hidden" name="accion" value="registrar">

                <input type="text" name="nombre_reg" placeholder="Nombre de usuario" required>

                <input type="password" name="password_reg" placeholder="Contraseña (mínimo 8 caracteres)" required>

                <button type="submit">Registrarse</button>
            </form>
        </div>
    </div>

</body>

</html>