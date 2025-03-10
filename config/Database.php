<?php
// config/Database.php
class Database {
    private $host = 'localhost';
    #private $db_name = 'u220252535_encuesta';
    #private $username = 'u220252535_encuesta';
    #private $password = 'Lm@03051971';
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
