<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

session_start(); // Iniciar sesión al principio del script
require_once 'db.php'; // Incluir la clase DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    $db = new DB();
    $usuario = $db->validarUsuario($email, $contrasena);

    if ($usuario) {
        // Verificar si el usuario es administrador
        if ($email === 'Admin@Admin.Admin') {
            $_SESSION['admin'] = true; // Establece una sesión para el administrador
            
            header("Location: administrarUsuarios.php"); // Redirigir a la página de administración
        } else {
            // Usuario válido, iniciar sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_email'] = $usuario['email'];
            header("Location: /index.php"); // Redirigir a la página principal
        }
        exit();
    } else {
        $mensajeError = "Correo electrónico o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="indexRegistro.css">
</head>
<body>
    <div class="contenedorInicioDeSesion">   
        <form action="inicioSesion.php" method="post">
            <label for="email">Correo Electrónico:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="contrasena">Contraseña:</label><br>
            <input type="password" id="contrasena" name="contrasena" required><br><br>

            <input type="submit" value="Iniciar">
        </form>
        <?php if (isset($mensajeError)): ?>
            <p style="color: red;"><?= $mensajeError ?></p>
        <?php endif; ?>
        <a href="Registro.php">¿Bienvenido, quieres crear una cuenta?</a>
    </div>
</body>
</html>
