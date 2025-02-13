<?php
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