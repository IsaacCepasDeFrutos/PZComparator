<?php
require_once 'db.php'; // Incluir la clase DB


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new DB();
$db->cerrarSesion(); // Llamar al método cerrarSesion
