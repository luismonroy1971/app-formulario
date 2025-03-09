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
                // Manejo de capacitación
                $recibio_capacitacion = $_POST["capacitacion_{$appId}"] ?? 'No';
                $utilidad_capacitacion = ($recibio_capacitacion === 'Si') ? 
                    ($_POST["utilidad_capacitacion_{$appId}"] ?? null) : null;
    
                // Manejo de fallas
                $tiene_fallas = $_POST["fallas_{$appId}"] ?? 'No';
                $fallas_remoto = ($tiene_fallas === 'Si') ? 
                    ($_POST["fallas_remoto_{$appId}"] ?? null) : null;
                $fallas_frecuencia = ($tiene_fallas === 'Si' && $fallas_remoto === 'Si') ? 
                    ($_POST["fallas_frecuencia_{$appId}"] ?? null) : null;
    
                // Manejo de necesidades
                $cubre_necesidades = $_POST["cubre_necesidades_{$appId}"] ?? 'No';
                $reduce_errores = ($cubre_necesidades === 'Si') ? 
                    ($_POST["reduce_errores_{$appId}"] ?? null) : null;
    
                // Manejo de valor agregado
                $agrega_valor = $_POST["agrega_valor_{$appId}"] ?? 'No';
                
                $surveyData = [
                    'doc_identidad' => $_POST['doc_identidad'],
                    'ha_usado' => 'Si',
                    'id_aplicacion' => $appId,
                    'fecha_registro' => $fecha_registro,
                    'como_se_entero' => $_POST["como_se_entero_{$appId}"] ?? null,
                    'frecuencia_uso' => $_POST["frecuencia_uso_{$appId}"] ?? null,
                    
                    // Campos de capacitación
                    'recibio_capacitacion' => $recibio_capacitacion,
                    'utilidad_capacitacion' => $utilidad_capacitacion,
                    'facilidad_uso' => $_POST["facilidad_uso_{$appId}"] ?? null,
                    'aspectos_reforzar' => ($recibio_capacitacion === 'No') ? 
                        ($_POST["aspectos_reforzar_{$appId}"] ?? null) : null,
                    
                    // Campos de fallas
                    'tiene_fallas' => $tiene_fallas,
                    'fallas_remoto' => $fallas_remoto,
                    'fallas_frecuencia' => $fallas_frecuencia,
                    'fallas_tipo' => ($tiene_fallas === 'Si') ? 
                        ($_POST["fallas_tipo_{$appId}"] ?? null) : null,
                    'fallas_otro_tipo' => ($tiene_fallas === 'Si' && $_POST["fallas_tipo_{$appId}"] === 'otros') ? 
                        ($_POST["fallas_otro_tipo_{$appId}"] ?? null) : null,
                    'funciona_dispositivos' => ($tiene_fallas === 'No') ? 
                        ($_POST["funciona_dispositivos_{$appId}"] ?? null) : null,
                    'dispositivos_problema' => ($tiene_fallas === 'No' && $_POST["funciona_dispositivos_{$appId}"] === 'No') ? 
                        ($_POST["dispositivos_problema_{$appId}"] ?? null) : null,
                    
                    // Campos de necesidades
                    'cubre_necesidades' => $cubre_necesidades,
                    'reduce_errores' => $reduce_errores,
                    'descripcion_reduce_errores' => ($reduce_errores === 'Si') ? 
                        ($_POST["descripcion_reduce_errores_{$appId}"] ?? null) : null,
                    'sugerencias_optimizacion' => ($reduce_errores === 'No') ? 
                        ($_POST["sugerencias_optimizacion_{$appId}"] ?? null) : null,
                    'mejoras_funcionalidades' => ($cubre_necesidades === 'No') ? 
                        ($_POST["mejoras_funcionalidades_{$appId}"] ?? null) : null,
                    
                    // Campos de tiempo
                    'tiempo_ahorro' => $_POST["tiempo_ahorro_{$appId}"] ?? null,
                    'tiempo_unidad' => $_POST["tiempo_unidad_{$appId}"] ?? null,
                    
                    // Campos de valor
                    'agrega_valor' => $agrega_valor,
                    'valor_calidad' => ($agrega_valor === 'Si') ? 
                        ($_POST["valor_calidad_{$appId}"] ?? null) : null,
                    'valor_tiempo' => ($agrega_valor === 'Si') ? 
                        ($_POST["valor_tiempo_{$appId}"] ?? null) : null,
                    'razon_no_valor' => ($agrega_valor === 'No') ? 
                        ($_POST["razon_no_valor_{$appId}"] ?? null) : null,
                    
                    // Campos de recomendación
                    'recomendaria' => $_POST["recomendaria_{$appId}"] ?? 'No',
                    'aspectos_mejora' => ($_POST["recomendaria_{$appId}"] === 'Si') ? 
                        ($_POST["aspectos_mejora_{$appId}"] ?? null) : null,
                    'razon_no_recomienda' => ($_POST["recomendaria_{$appId}"] === 'No') ? 
                        ($_POST["razon_no_recomienda_{$appId}"] ?? null) : null
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