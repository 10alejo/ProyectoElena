<?php
header('Content-Type: application/json');
require_once 'conexion.php';
require_once 'accesoadatos.php';

$acceso = new AccesoDatos($conexion);
// Usamos los nombres exactos que aparecen en tu phpMyAdmin
$ejercicios = ['pressbanca', 'sentadilla', 'pesomuerto']; 
$resultados = [];

foreach ($ejercicios as $ejer) {
    $resultados[$ejer] = $acceso->obtenerTop5PorEjercicio($ejer);
}

echo json_encode($resultados);