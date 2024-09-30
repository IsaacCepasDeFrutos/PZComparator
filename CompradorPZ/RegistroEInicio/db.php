<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class DB {
    private $host = 'localhost';
    private $usuario = 'admin';
    private $contrasenia = '1234';
    private $baseDatos = 'Comparador';

    public function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->baseDatos}";
        $conexion = new PDO($dsn, $this->usuario, $this->contrasenia);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    }

    public function validarUsuario($email, $contrasena) {
        $conexion = $this->connect();
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario && password_verify($contrasena, $usuario['contrasenia'])) {
            return $usuario;
        } else {
            return false;
        }
    }
    
    public function cerrarSesion() {
        session_start();
        session_unset();
        session_destroy();
        header("Location:/index.php ");
        exit();
    }

    public function agregarAFavoritos($usuarioId, $nombreOrdenador) {
        $conexion = $this->connect();
        $sql = "INSERT INTO favoritos (usuario_id, nombreOrdenador) VALUES (:usuario_id, :nombreOrdenador)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->bindParam(':nombreOrdenador', $nombreOrdenador);
        return $stmt->execute();
    }

}
?>
