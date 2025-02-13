<?php
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
