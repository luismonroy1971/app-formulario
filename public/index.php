<?php
// Iniciar sesión
session_start();

// Configuración
require_once '../config/config.php';
require_once '../config/Database.php';

// Autoload de clases
spl_autoload_register(function($className) {
    // Buscar en controllers/
    if (file_exists('../controllers/' . $className . '.php')) {
        require_once '../controllers/' . $className . '.php';
        return;
    }
    
    // Buscar en models/
    if (file_exists('../models/' . $className . '.php')) {
        require_once '../models/' . $className . '.php';
        return;
    }
});

// Enrutamiento básico
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Survey';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$controllerName = ucfirst($controller) . 'Controller';
$controller = new $controllerName();
$controller->$action();