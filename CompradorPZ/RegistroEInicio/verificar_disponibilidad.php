<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db.php'; // Incluye la clase de conexión
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); // Asegúrate de que la respuesta es JSON

$response = array("disponible" => false);

try {
    if (isset($_POST['valor'])) {
        $email = $_POST['valor'];

        $db = new DB();
        $conexion = $db->connect();

        if ($conexion) {
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $response["disponible"] = ($resultado === false);
        } else {
            throw new Exception("Error al conectar con la base de datos.");
        }
    } else {
        throw new Exception("No se proporcionó ningún valor de correo electrónico en la solicitud.");
    }
} catch (Exception $e) {
    $response["error"] = $e->getMessage();
}

echo json_encode($response);
