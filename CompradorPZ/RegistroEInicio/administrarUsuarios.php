<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/


session_start();
require_once 'db.php';
require_once 'usuario.php';

// Verificar si el usuario es administrador


$db = new DB();
$conexion = $db->connect();

// Obtener lista de usuarios
$sql = "SELECT * FROM usuarios";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Actualizar usuario
if (isset($_POST['actualizar'])) {
    $usuario = new Usuario($_POST['id'], $_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['nombreUsuario'], $_POST['contrasenia']);
    $usuario->actualizar($conexion);
    header("Location: administrarUsuarios.php"); // Corregido para redirigir a la página actual
    exit();
}

// Borrar usuario
if (isset($_POST['borrar'])) {
    $usuario = new Usuario($_POST['id'], '', '', '', '','');
    $usuario->borrar($conexion);
    header("Location: administrarUsuarios.php"); // Corregido para redirigir a la página actual
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administración de Usuarios</title>
</head>
<body>
    <h2>Administración de Usuarios</h2>
    <a href="cerrarSesion.php">Cerrar Sesión</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Nombre de Usuario</th>
            <th>Contraseña</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($usuarios as $usuario) { ?>
        <tr>
            <form method="POST" action="">
                <td><input type="hidden" name="id" value="<?php echo $usuario['id']; ?>"><?php echo $usuario['id']; ?></td>
                <td><input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>"></td>
                <td><input type="text" name="apellidos" value="<?php echo $usuario['apellidos']; ?>"></td>
                <td><input type="email" name="email" value="<?php echo $usuario['email']; ?>"></td>
                <td><input type="text" name="nombreUsuario" value="<?php echo $usuario['nombreUsuario']; ?>"></td>
                <td><input type="password" name="contrasenia" value="<?php echo $usuario['contrasenia']; ?>"></td>
                <td>
                    <button type="submit" name="actualizar">Actualizar</button>
                    <button type="submit" name="borrar">Borrar</button>
                </td>
            </form>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
