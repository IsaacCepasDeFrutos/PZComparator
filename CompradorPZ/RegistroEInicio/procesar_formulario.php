<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("db.php");
require_once("usuario.php");

header('Content-Type: application/json');

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$nombreUsuario = $_POST['nombreUsuario'];
$contrasenia = $_POST['contrasenia'];

// Conectar a la base de datos
$conexionBD = new DB();
$conexion = $conexionBD->connect();

// Función para verificar la disponibilidad de un campo en la base de datos
function verificarDisponibilidad($conexion, $campo, $valor) {
    $sql = "SELECT COUNT(*) as count FROM usuarios WHERE $campo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$valor]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['count'] == 0;
}

// Inicializar la respuesta
$response = ['success' => false, 'message' => ''];

// Verificar la disponibilidad del email y nombre de usuario
if (!verificarDisponibilidad($conexion, 'email', $email)) {
    $response['message'] = "El correo electrónico ya está registrado.";
} elseif (!verificarDisponibilidad($conexion, 'nombreUsuario', $nombreUsuario)) {
    $response['message'] = "El nombre de usuario ya está registrado.";
} else {
    // Hashear la contraseña usando bcrypt
    $hashedPassword = password_hash($contrasenia, PASSWORD_BCRYPT);

    // Crear el objeto Usuario con la contraseña hasheada
    $usuario = new Usuario(null,$nombre, $apellidos, $email, $nombreUsuario, $hashedPassword);

    // Realizar la inserción del usuario en la base de datos
    $sqlAniadirUsuario = "INSERT INTO usuarios(nombre, apellidos, email, nombreUsuario, contrasenia) VALUES (?, ?, ?, ?, ?)";
    $insert = $conexion->prepare($sqlAniadirUsuario);
    $insert->execute([$usuario->getNombre(), $usuario->getApellidos(), $usuario->getEmail(), $usuario->getNombreUsuario(), $usuario->getContrasenia()]);

    // Actualizar la respuesta
    $response['success'] = true;
    $response['message'] = "Usuario registrado exitosamente";
    
}

echo json_encode($response);
?>
