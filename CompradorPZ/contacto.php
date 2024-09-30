<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'RegistroEInicio/db.php';

function validar_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = htmlspecialchars(trim($_POST['email']));
    $sugerencia = htmlspecialchars(trim($_POST['sugerencia']));

    if (empty($nombre) || empty($email) || empty($sugerencia)) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    if (!validar_email($email)) {
        echo "El correo electrónico no es válido.";
        exit();
    }

    $db = new DB();
    $conexion = $db->connect();

    $sql = "INSERT INTO comentarios (nombre, email, sugerencia) VALUES (:nombre, :email, :sugerencia)";
    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':sugerencia', $sugerencia);

    if ($stmt->execute()) {
        echo "Sugerencia enviada con éxito.";
	
        
    } else {
        echo "Hubo un error al enviar tu sugerencia. Por favor, inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .caja_pr {
            width: 100%;
            text-align: center;
            padding: 20px;
        }
        .contenedor {
            max-width: 1200px;
            margin: 0 auto;
        }
        .contact-section {
            margin: 20px 0;
        }
        .contact-info {
            margin: 20px 0;
            font-size: 1.2em;
        }
        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            text-align: left;
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        .contact-form button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        .contact-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php session_start(); ?>
  <div class="caja_pr">
    <div class="contenedor">
      <?php include "includes/nav.php"; ?>
    </div>
    <section class="contact-section">
        <h1><img src="computer-highfivebloke.gif" alt="highfive"><br>Contacta con nosotros</h1>
        <div class="contact-info">
            <p><strong>Correo Electrónico:</strong> contacto@ejemplo.com</p>
            <p><strong>Teléfono:</strong> +34 123 456 789</p>
        </div>
        <div class="contact-form">
            <h2>Envíanos tus sugerencias</h2>
            <form action="contacto.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="sugerencia">Sugerencia:</label>
                <textarea id="sugerencia" name="sugerencia" rows="4" required></textarea>

                <button type="submit">Enviar</button>
            </form>
        </div>
    </section>
  </div>
</body>
</html>
