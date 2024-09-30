<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db.php'; // Incluye la clase de conexión

header('Content-Type: application/json'); // Asegúrate de que la respuesta es JSON

$response = array("disponible" => false);

try {
    file_put_contents('php://stderr', print_r($_POST, TRUE));
    if (isset($_POST['valor'])) {
        $nombreUsuario = $_POST['valor'];

        $db = new DB();
        $conexion = $db->connect();

        if ($conexion) {
            $sql = "SELECT * FROM usuarios WHERE nombreUsuario = :nombreUsuario";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombreUsuario', $nombreUsuario);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $response["disponible"] = ($resultado === false);
        } else {
            throw new Exception("Error al conectar con la base de datos.");
        }
    } else {
        throw new Exception("No se proporcionó ningún valor de nombre de usuario en la solicitud.");
    }
} catch (Exception $e) {
    $response["error"] = $e->getMessage();
}

echo json_encode($response);
