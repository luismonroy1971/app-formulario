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
                (doc_identidad, id_aplicacion, ha_usado, frecuencia_uso, como_se_entero,
                 recibio_capacitacion, utilidad_capacitacion, facilidad_uso, aspectos_reforzar,
                 tiene_fallas, fallas_remoto, fallas_frecuencia, fallas_tipo, fallas_otro_tipo,
                 funciona_dispositivos, dispositivos_problema, cubre_necesidades, reduce_errores,
                 descripcion_reduce_errores, sugerencias_optimizacion, mejoras_funcionalidades,
                 tiempo_ahorro, tiempo_unidad, agrega_valor, valor_calidad, valor_tiempo,
                 razon_no_valor, recomendaria, aspectos_mejora, razon_no_recomienda, fecha_registro)
                VALUES
                (:doc_identidad, :id_aplicacion, :ha_usado, :frecuencia_uso, :como_se_entero,
                 :recibio_capacitacion, :utilidad_capacitacion, :facilidad_uso, :aspectos_reforzar,
                 :tiene_fallas, :fallas_remoto, :fallas_frecuencia, :fallas_tipo, :fallas_otro_tipo,
                 :funciona_dispositivos, :dispositivos_problema, :cubre_necesidades, :reduce_errores,
                 :descripcion_reduce_errores, :sugerencias_optimizacion, :mejoras_funcionalidades,
                 :tiempo_ahorro, :tiempo_unidad, :agrega_valor, :valor_calidad, :valor_tiempo,
                 :razon_no_valor, :recomendaria, :aspectos_mejora, :razon_no_recomienda, :fecha_registro)';

        try {
            $stmt = $this->conn->prepare($query);
            
            return $stmt->execute([
                ':doc_identidad' => $data['doc_identidad'],
                ':id_aplicacion' => $data['id_aplicacion'],
                ':ha_usado' => $data['ha_usado'],
                ':frecuencia_uso' => $data['frecuencia_uso'],
                ':como_se_entero' => $data['como_se_entero'],
                ':recibio_capacitacion' => $data['recibio_capacitacion'],
                ':utilidad_capacitacion' => $data['utilidad_capacitacion'],
                ':facilidad_uso' => $data['facilidad_uso'],
                ':aspectos_reforzar' => $data['aspectos_reforzar'],
                ':tiene_fallas' => $data['tiene_fallas'],
                ':fallas_remoto' => $data['fallas_remoto'],
                ':fallas_frecuencia' => $data['fallas_frecuencia'],
                ':fallas_tipo' => $data['fallas_tipo'],
                ':fallas_otro_tipo' => $data['fallas_otro_tipo'],
                ':funciona_dispositivos' => $data['funciona_dispositivos'],
                ':dispositivos_problema' => $data['dispositivos_problema'],
                ':cubre_necesidades' => $data['cubre_necesidades'],
                ':reduce_errores' => $data['reduce_errores'],
                ':descripcion_reduce_errores' => $data['descripcion_reduce_errores'],
                ':sugerencias_optimizacion' => $data['sugerencias_optimizacion'],
                ':mejoras_funcionalidades' => $data['mejoras_funcionalidades'],
                ':tiempo_ahorro' => $data['tiempo_ahorro'],
                ':tiempo_unidad' => $data['tiempo_unidad'],
                ':agrega_valor' => $data['agrega_valor'],
                ':valor_calidad' => $data['valor_calidad'],
                ':valor_tiempo' => $data['valor_tiempo'],
                ':razon_no_valor' => $data['razon_no_valor'],
                ':recomendaria' => $data['recomendaria'],
                ':aspectos_mejora' => $data['aspectos_mejora'],
                ':razon_no_recomienda' => $data['razon_no_recomienda'],
                ':fecha_registro' => $data['fecha_registro']
            ]);
        } catch (PDOException $e) {
            error_log("Error en save: " . $e->getMessage());
            return false;
        }
    }

    public function saveNoUsage($data) {
        try {
            $query = 'INSERT INTO ' . $this->table . ' 
                    (doc_identidad, ha_usado, razon_no_uso_1, razon_no_uso_2, razon_no_uso_3, fecha_registro)
                    VALUES 
                    (:doc_identidad, :ha_usado, :razon_no_uso_1, :razon_no_uso_2, :razon_no_uso_3, :fecha_registro)';
    
            $stmt = $this->conn->prepare($query);
            
            return $stmt->execute([
                ':doc_identidad' => $data['doc_identidad'],
                ':ha_usado' => $data['ha_usado'],
                ':razon_no_uso_1' => $data['razon_no_uso_1'],
                ':razon_no_uso_2' => $data['razon_no_uso_2'],
                ':razon_no_uso_3' => $data['razon_no_uso_3'],
                ':fecha_registro' => $data['fecha_registro']
            ]);
    
        } catch (PDOException $e) {
            error_log("Error en saveNoUsage: " . $e->getMessage());
            return false;
        }
    }

    public function getAllResults() {
        $query = "SELECT 
            e.*,
            c.APELLIDOS_NOMBRES as nombre_colaborador,
            c.AREA as area_colaborador,
            CASE 
                WHEN e.ha_usado = 'No' THEN NULL 
                ELSE a.nombre_aplicacion 
            END as nombre_aplicacion
        FROM encuestas e
        LEFT JOIN colaboradores c ON e.doc_identidad = c.DOC_IDENTIDAD
        LEFT JOIN aplicaciones a ON e.id_aplicacion = a.id
        ORDER BY e.fecha_registro DESC";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en getAllResults: " . $e->getMessage());
            return [];
        }
    }
}