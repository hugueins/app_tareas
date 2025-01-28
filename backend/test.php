
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Verificando estructura de archivos:<br>";
$base = dirname(__FILE__);
$files = [
    '/controllers/TaskController.php',
    '/models/UserModel.php',
    '/models/TaskModel.php',
    '/config/config.php'
];

foreach ($files as $file) {
    $path = $base . $file;
    echo "$path : " . (file_exists($path) ? 'Existe' : 'No existe') . "<br>";
}

echo "<br>Verificando conexión a la base de datos:<br>";
require_once $base . '/config/config.php';
try {
    $db = Database::getInstance()->getConnection();
    echo "Conexión exitosa a la base de datos";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>