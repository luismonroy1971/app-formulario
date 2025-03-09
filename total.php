<?php
// config/Database.php
class Database {
    private $host = 'localhost';
    private $db_name = 'encuesta_app';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }
}

// models/Employee.php
class Employee {
    private $conn;
    private $table = 'colaboradores';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByDocIdentidad($docIdentidad) {
        $query = 'SELECT 
                    DOC_IDENTIDAD,
                    APELLIDOS_NOMBRES as APELLIDOS_NOMBRES_COLABORADOR,
                    CORREO as CORREO_ELECTRONICO,
                    AREA
                  FROM ' . $this->table . '
                  WHERE DOC_IDENTIDAD = :docIdentidad';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docIdentidad', $docIdentidad);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// models/Application.php
class Application {
    private $conn;
    private $table = 'aplicaciones';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function importFromExcel($filePath) {
        require 'vendor/autoload.php';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $worksheet = $spreadsheet->getSheetByName('APLICACIONES');
        
        if (!$worksheet) {
            throw new Exception('Hoja "APLICACIONES" no encontrada');
        }

        $data = $worksheet->toArray();
        array_shift($data); // Remove header row

        $this->conn->beginTransaction();
        try {
            // Clear existing applications
            $this->conn->exec('TRUNCATE TABLE ' . $this->table);

            // Insert new applications
            $stmt = $this->conn->prepare(
                'INSERT INTO ' . $this->table . ' (nombre_aplicacion) VALUES (:nombre)'
            );

            foreach ($data as $row) {
                $stmt->bindParam(':nombre', $row[0]);
                $stmt->execute();
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function getAll() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// models/Survey.php
class Survey {
    private $conn;
    private $table = 'encuestas';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function save($data) {
        $query = 'INSERT INTO ' . $this->table . '
                (doc_identidad, id_aplicacion, frecuencia_uso, recibio_capacitacion,
                 tiene_fallas, cubre_necesidades, tiempo_ahorro, tiempo_unidad,
                 agrega_valor, recomendaria)
                VALUES
                (:doc_identidad, :id_aplicacion, :frecuencia_uso, :recibio_capacitacion,
                 :tiene_fallas, :cubre_necesidades, :tiempo_ahorro, :tiempo_unidad,
                 :agrega_valor, :recomendaria)';

        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            ':doc_identidad' => $data['doc_identidad'],
            ':id_aplicacion' => $data['id_aplicacion'],
            ':frecuencia_uso' => $data['frecuencia_uso'],
            ':recibio_capacitacion' => $data['recibio_capacitacion'],
            ':tiene_fallas' => $data['tiene_fallas'],
            ':cubre_necesidades' => $data['cubre_necesidades'],
            ':tiempo_ahorro' => $data['tiempo_ahorro'],
            ':tiempo_unidad' => $data['tiempo_unidad'],
            ':agrega_valor' => $data['agrega_valor'],
            ':recomendaria' => $data['recomendaria']
        ]);
    }
}

// controllers/EmployeeController.php
class EmployeeController {
    private $employeeModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->employeeModel = new Employee($db);
    }

    public function findByDocument() {
        if (!isset($_GET['doc'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Documento de identidad requerido']);
            return;
        }

        $employee = $this->employeeModel->findByDocIdentidad($_GET['doc']);
        
        if (!$employee) {
            http_response_code(404);
            echo json_encode(['error' => 'Colaborador no encontrado']);
            return;
        }

        echo json_encode($employee);
    }
}

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
        include 'views/survey/index.php';
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