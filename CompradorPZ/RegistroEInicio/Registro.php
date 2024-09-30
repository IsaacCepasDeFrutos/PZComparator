<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="indexRegistro.css">
    <script src="validaciones_formulario.js"></script>
    <style>
        .error {
            color: red;
        }
        .correcto {
            color: green;
        }
    </style>
</head>
<body>
    <div class="contenedorRegistrarse">
        <img src="img/iconoPNG.png" alt="icono persona anónima">
        <form id="registroForm">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" oninput="validarNombre()"><br>
            <div id="erroresNombre"></div><br>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" oninput="validarApellidos()"><br>
            <div id="erroresApellidos"></div><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" onblur="verificarDisponibilidadEmail()"><br>
            <div id="emailDisponibilidad"></div><br>

            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" id="nombre_usuario" name="nombreUsuario" onblur="verificarDisponibilidadNombreUsuario()" required><br>
            <div id="nombreUsuarioDisponibilidad"></div><br>

            <label for="contrasenia">Contraseña:</label>
            <input type="password" id="contrasenia" name="contrasenia" oninput="verificarContrasenias()"><br><br>
            <label for="repiteContrasenia">Repite la Contraseña:</label>
            <input type="password" id="repiteContrasenia" name="repiteContrasenia" oninput="verificarContrasenias()"><br>
            <div id="erroresContrasenia"></div><br>

            <input type="submit" value="Registrarse">
            <div id="errores"></div>
        </form>
    </div>
</body>
</html>
