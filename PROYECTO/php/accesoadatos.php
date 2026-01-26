<?php

require_once 'conexion.php';

class AccesoDatos {

    private $pdo;

    public function __construct($conexion) {

        $this->pdo = $conexion;
    }

    // Funcion para registrar un usuario
    public function registrarUsuario($nombre, $password) {

        try {

            $hash = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO usuarios (nombre, password) VALUES (:n, :p)";
            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute([
                ':n' => $nombre,
                ':p' => $hash
            ]);
        } 
        
        catch (PDOException $e) {

            return false;
        }
    }

    // Funcion para obtener un usuario por el nombre
    public function obtenerUsuarioPorNombre($nombre) {

        $sql = "SELECT * FROM usuarios WHERE nombre = :n";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':n' => $nombre]);

        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    // Funcion para obtener todos los usuarios por id y nombre
    public function obtenerTodosLosUsuarios() {

        $sql = "SELECT id, nombre FROM usuarios";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>