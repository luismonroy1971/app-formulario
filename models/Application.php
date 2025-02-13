<?php
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