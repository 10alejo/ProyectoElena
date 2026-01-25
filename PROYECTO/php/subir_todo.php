<?php
// --- CONFIGURACIÓN ---
$host = "localhost";
$usuario = "root";
$clave = "";
$bd = "allgim"; // <--- ¡CAMBIA ESTO POR EL NOMBRE DE TU BASE DE DATOS!

// Conexión
$conexion = new mysqli($host, $usuario, $clave, $bd);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Ruta a la carpeta de imágenes (subimos un nivel con ".." y entramos a "images")
$carpetaImagenes = "../images/";

// Buscamos todos los archivos .png, .jpg y .jpeg en esa carpeta
$patron = $carpetaImagenes . "*.{png,jpg,jpeg,JPG,PNG}";
$listaArchivos = glob($patron, GLOB_BRACE);

echo "<h1>🚀 Iniciando carga de imágenes...</h1>";
echo "<hr>";

if (!$listaArchivos) {
    echo "<h3 style='color:red'>Error: No se encontraron imágenes en la ruta: $carpetaImagenes</h3>";
    echo "<p>Asegúrate de que la carpeta 'images' está al lado de la carpeta 'php'.</p>";
    exit();
}

// Preparamos la sentencia SQL una sola vez para ser más eficientes
$stmt = $conexion->prepare("INSERT INTO imagenes_usuarios (usuario_nombre, tipo_imagen, datos_imagen) VALUES (?, ?, ?)");

foreach ($listaArchivos as $rutaCompleta) {
    // 1. Obtener el nombre del archivo sin extensión (ej: 'adrian')
    $nombreSinExtension = pathinfo($rutaCompleta, PATHINFO_FILENAME);
    
    // 2. Obtener la extensión para saber el tipo (ej: 'png')
    $extension = strtolower(pathinfo($rutaCompleta, PATHINFO_EXTENSION));
    $tipoMime = ($extension == 'png') ? 'image/png' : 'image/jpeg';
    
    // 3. Leer el contenido del archivo (los datos binarios)
    $datosBinarios = file_get_contents($rutaCompleta);
    
    if ($datosBinarios === false) {
        echo "<p>❌ No se pudo leer el archivo: $nombreSinExtension</p>";
        continue;
    }

    // 4. Insertar en la Base de Datos
    // "sss" significa que pasamos 3 strings (o datos binarios tratados como string)
    $stmt->bind_param("sss", $nombreSinExtension, $tipoMime, $datosBinarios);
    
    if ($stmt->execute()) {
        echo "<p style='color:green'>✅ <b>$nombreSinExtension</b> ($extension) subido correctamente.</p>";
    } else {
        echo "<p style='color:red'>❌ Error al subir $nombreSinExtension: " . $stmt->error . "</p>";
    }
}

echo "<hr>";
echo "<h3>¡Proceso terminado! Ya puedes borrar este archivo si quieres.</h3>";

$stmt->close();
$conexion->close();
?>