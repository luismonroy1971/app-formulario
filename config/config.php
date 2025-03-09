<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'u220252535_encuesta');
define('DB_USER', 'u220252535_encuesta');
define('DB_PASS', 'Lm@03051971');

#define('DB_NAME', 'encuesta_app');
#define('DB_USER', 'root');
#define('DB_PASS', '');
// Rutas base
define('BASE_URL', 'https://encuesta-app.temalitoclean.com/');
#define('BASE_URL', 'http://localhost/survey_app');

define('ROOT_PATH', dirname(__DIR__) . '/');

// Configuración de zona horaria
date_default_timezone_set('America/Lima');

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);