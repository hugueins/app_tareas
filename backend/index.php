<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Definir la ruta base
define('BASE_PATH', dirname(__FILE__));

// Debug temporal
error_log("BASE_PATH: " . BASE_PATH);
error_log("Controller Path: " . BASE_PATH . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'TaskController.php');

// Incluir archivos necesarios
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'TaskController.php';

// Verificar método
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Procesar solicitud
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data === null) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos JSON inválidos'
    ]);
    exit();
}

$controller = new TaskController();
$controller->handleRequest();
?>