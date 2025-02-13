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
    public function saveNoUsage($data) {
        try {
            $query = 'INSERT INTO ' . $this->table . ' 
                    (doc_identidad, ha_usado, razon_no_uso_1, razon_no_uso_2, razon_no_uso_3, fecha_registro)
                    VALUES 
                    (:doc_identidad, :ha_usado, :razon_no_uso_1, :razon_no_uso_2, :razon_no_uso_3, :fecha_registro)';
    
            $stmt = $this->conn->prepare($query);
            
            $params = [
                ':doc_identidad' => $data['doc_identidad'],
                ':ha_usado' => $data['ha_usado'],
                ':razon_no_uso_1' => $data['razon_no_uso_1'],
                ':razon_no_uso_2' => $data['razon_no_uso_2'],
                ':razon_no_uso_3' => $data['razon_no_uso_3'],
                ':fecha_registro' => $data['fecha_registro']
            ];
    
            return $stmt->execute($params);
    
        } catch (PDOException $e) {
            // Puedes manejar el error como prefieras
            error_log("Error en saveNoUsage: " . $e->getMessage());
            return false;
        }
    }
    // models/Survey.php
    public function getAllResults() {
        $query = "SELECT 
            e.id,
            e.fecha_registro,
            e.ha_usado,
            e.doc_identidad,
            c.APELLIDOS_NOMBRES as nombre_colaborador,
            c.AREA as area_colaborador,
            CASE 
                WHEN e.ha_usado = 'No' THEN NULL 
                ELSE a.nombre_aplicacion 
            END as nombre_aplicacion,
            e.como_se_entero,
            e.frecuencia_uso,
            e.recibio_capacitacion,
            e.utilidad_capacitacion,
            e.facilidad_uso,
            e.tiene_fallas,
            e.cubre_necesidades,
            e.tiempo_ahorro,
            e.tiempo_unidad,
            e.agrega_valor,
            e.recomendaria,
            e.razon_no_uso_1,
            e.razon_no_uso_2,
            e.razon_no_uso_3
        FROM encuestas e
        LEFT JOIN colaboradores c ON e.doc_identidad = c.DOC_IDENTIDAD
        LEFT JOIN aplicaciones a ON e.id_aplicacion = a.id
        ORDER BY e.fecha_registro DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
