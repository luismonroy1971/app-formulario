<?php
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
