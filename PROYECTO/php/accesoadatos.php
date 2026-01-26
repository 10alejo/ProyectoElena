<?php
require_once 'conexion.php';

class AccesoDatos {
    private $pdo;

    public function __construct($conexion) {
        $this->pdo = $conexion;
    }

    // --- FUNCIONES DE USUARIO (Ya las tenías) ---
    public function registrarUsuario($nombre, $password) {
        try {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO usuarios (nombre, password) VALUES (:n, :p)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':n' => $nombre, ':p' => $hash]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function obtenerUsuarioPorNombre($nombre) {
        $sql = "SELECT * FROM usuarios WHERE nombre = :n";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':n' => $nombre]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function obtenerTodosLosUsuarios() {
        $sql = "SELECT id, nombre FROM usuarios";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- NUEVA FUNCIÓN PARA RANKINGS ---
    public function obtenerTop5PorEjercicio($ejercicio) {
        try {
            // Usamos 'usuario' y 'peso' tal cual están en tu tabla
            $sql = "SELECT usuario as nombre, MAX(peso) as peso 
                    FROM registros_pesos 
                    WHERE ejercicio = :e 
                    GROUP BY usuario 
                    ORDER BY peso DESC 
                    LIMIT 5";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':e' => $ejercicio]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return []; // Retorna array vacío si hay error
        }
    }
}
?>