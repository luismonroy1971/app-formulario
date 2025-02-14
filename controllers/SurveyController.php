<?php
// controllers/SurveyController.php
class SurveyController {
    private $surveyModel;
    private $applicationModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->surveyModel = new Survey($db);
        $this->applicationModel = new Application($db);
    }

    public function index() {
        $applications = $this->applicationModel->getAll();
        include_once __DIR__ . '/../views/survey/index.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            return;
        }
    
        $has_used = $_POST['has_used'];
        $success = true;
        $fecha_registro = $_POST['fecha_local'];
    
        if ($has_used === 'No') {
            // Guardar encuesta con razones de no uso
            $surveyData = [
                'doc_identidad' => $_POST['doc_identidad'],
                'ha_usado' => 'No',
                'razon_no_uso_1' => $_POST['razon_no_uso_1'] ?? null,
                'razon_no_uso_2' => $_POST['razon_no_uso_2'] ?? null,
                'razon_no_uso_3' => $_POST['razon_no_uso_3'] ?? null,
                'fecha_registro' => $fecha_registro
            ];
    
            if (!$this->surveyModel->saveNoUsage($surveyData)) {
                $success = false;
            }
        } else {
            // Guardar encuesta normal con aplicaciones seleccionadas
            $applications = $_POST['applications'] ?? [];
            
            foreach ($applications as $appId) {
                $surveyData = [
                    'doc_identidad' => $_POST['doc_identidad'],
                    'ha_usado' => 'Si',
                    'id_aplicacion' => $appId,
                    'como_se_entero' => $_POST["como_se_entero_{$appId}"],
                    'frecuencia_uso' => $_POST["frecuencia_uso_{$appId}"],
                    'recibio_capacitacion' => $_POST["capacitacion_{$appId}"] ?? 'No',
                    'utilidad_capacitacion' => ($_POST["capacitacion_{$appId}"] === 'Si') ? 
                        $_POST["utilidad_capacitacion_{$appId}"] : null,
                    'facilidad_uso' => ($_POST["capacitacion_{$appId}"] === 'Si') ? 
                        $_POST["facilidad_uso_{$appId}"] : null,
                    'tiene_fallas' => $_POST["fallas_{$appId}"] ?? 'No',
                    'cubre_necesidades' => $_POST["cubre_necesidades_{$appId}"] ?? 'No',
                    'tiempo_ahorro' => $_POST["tiempo_ahorro_{$appId}"],
                    'tiempo_unidad' => $_POST["tiempo_unidad_{$appId}"],
                    'agrega_valor' => $_POST["agrega_valor_{$appId}"] ?? 'No',
                    'recomendaria' => $_POST["recomendaria_{$appId}"] ?? 'No',
                    'fecha_registro' => $fecha_registro
                ];
    
                if (!$this->surveyModel->save($surveyData)) {
                    $success = false;
                    break;
                }
            }
        }
    
        if ($success) {
            header('Location: index.php?success=1');
        } else {
            header('Location: index.php?error=1');
        }
    }
}