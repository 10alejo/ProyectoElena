<?php

require_once 'conexion.php';

class AccesoDatos {

    private $pdo;

    public function __construct($conexion) {

        $this->pdo = $conexion;
    }

    // Función 1: Registrar Usuario (Solo nombre y password)
    public function registrarUsuario($nombre, $password) {

        try {
            // Encriptamos la contraseña
            $hash = password_hash($password, PASSWORD_BCRYPT);

            // SQL: Ya no pedimos email
            $sql = "INSERT INTO usuarios (nombre, password) VALUES (:n, :p)";
            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([
                ':n' => $nombre,
                ':p' => $hash
            ]);
        } 
        
        catch (PDOException $e) {
            // Si el nombre ya existe (gracias al UNIQUE de la BD), dará error y retornará false
            return false;
        }
    }

    // Función 2: Obtener usuario para Login (BUSCAMOS POR NOMBRE)
    // Antes se llamaba 'obtenerUsuarioPorEmail', ahora cambiamos el nombre
    public function obtenerUsuarioPorNombre($nombre) {

        $sql = "SELECT * FROM usuarios WHERE nombre = :n";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':n' => $nombre]);

        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    // Función 3: Listar usuarios
    public function obtenerTodosLosUsuarios() {

        $sql = "SELECT id, nombre FROM usuarios";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>