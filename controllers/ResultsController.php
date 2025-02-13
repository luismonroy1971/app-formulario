<?php
// controllers/ResultsController.php
class ResultsController {
    private $surveyModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->surveyModel = new Survey($db);
    }

    public function getResults() {
        try {
            $results = $this->surveyModel->getAllResults();
            header('Content-Type: application/json');
            echo json_encode($results);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}