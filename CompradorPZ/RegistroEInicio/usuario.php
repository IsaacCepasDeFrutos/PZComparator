<?php
class Usuario {
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $nombreUsuario;
    private $contrasenia;

    public function __construct($id = null, $nombre, $apellidos, $email, $nombreUsuario, $contrasenia) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->nombreUsuario = $nombreUsuario;
        $this->contrasenia = $contrasenia;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function getContrasenia() {
        return $this->contrasenia;
    }

    // Métodos para actualizar y borrar
    public function actualizar($conexion) {
        $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, nombreUsuario = :nombreUsuario, contrasenia = :contrasenia WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':nombreUsuario', $this->nombreUsuario);
        $stmt->bindParam(':contrasenia', $this->contrasenia);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function borrar($conexion) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }
}
?>
