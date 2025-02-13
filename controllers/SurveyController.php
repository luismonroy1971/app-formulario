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

        $applications = $_POST['applications'] ?? [];
        $success = true;

        foreach ($applications as $appId) {
            $surveyData = [
                'doc_identidad' => $_POST['doc_identidad'],
                'id_aplicacion' => $appId,
                'frecuencia_uso' => $_POST["frecuencia_uso_$appId"],
                'recibio_capacitacion' => $_POST["capacitacion_$appId"] ?? 'No',
                'tiene_fallas' => $_POST["fallas_$appId"] ?? 'No',
                'cubre_necesidades' => $_POST["cubre_necesidades_$appId"] ?? 'No',
                'tiempo_ahorro' => $_POST["tiempo_ahorro_$appId"],
                'tiempo_unidad' => $_POST["tiempo_unidad_$appId"],
                'agrega_valor' => $_POST["agrega_valor_$appId"] ?? 'No',
                'recomendaria' => $_POST["recomendaria_$appId"] ?? 'No'
            ];

            if (!$this->surveyModel->save($surveyData)) {
                $success = false;
                break;
            }
        }

        if ($success) {
            header('Location: index.php?success=1');
        } else {
            header('Location: index.php?error=1');
        }
    }
}