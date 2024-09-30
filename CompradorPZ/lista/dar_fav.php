<?php
// dar_fav.php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

// Verificar que la solicitud se haga mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require_once '../RegistroEInicio/db.php';

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['usuario_id'])) {
        echo json_encode(['resultado' => false, 'mensaje' => 'Necesitas iniciar sesión']);
        exit();
    }

    $usuarioId = $_SESSION['usuario_id'];
    $nombreOrdenador = $_POST['valor'];

    $db = new DB();
    if ($db->agregarAFavoritos($usuarioId, $nombreOrdenador)) {
        echo json_encode(['resultado' => true, 'mensaje' => 'Ordenador agregado a favoritos']);
    } else {
        echo json_encode(['resultado' => false, 'mensaje' => 'Error al agregar a favoritos']);
    }
    exit();
}
?>
