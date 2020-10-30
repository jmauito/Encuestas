<?php
namespace MZ\Encuestas;
use MZ\Encuestas as App;
require_once GL_DIR_APP . 'commons/dao/ConnectionMySql.php';
require_once GL_DIR_APP . 'commons/datetime/DateTime.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/model/Seccion.php';
class SeccionDao {
    
    private static $tableName = 'seccion';
    private $connection;
    
    public function __construct($connection = null) {
        
        $this->connection = $connection;
        
    }  
    
    static function getTableName() {
        return self::$tableName;
    }
    
    public function find($criteria = []){
        $list = $this->connection->find($criteria, self::$tableName);
        $listSecciones = [];
        foreach ($list as $cl){
            $seccion = new Seccion();
            $seccion->setId($cl->id);
            $seccion->setNombre($cl->nombre);
            $seccion->setDescripcion($cl->descripcion);
            $seccion->setCuestionarioId($cl->cuestionarioId);
            $seccion->setOrden($cl->orden);
            $seccion->setActivo($cl->activo);
            $seccion->setCreatedAt($cl->createdAt);
            $seccion->setUpdatedAt($cl->updatedAt);
            $listSecciones[] = $seccion;
        }
        return $listSecciones;
    }
    
    public function findOne($id){
        $result = $this->connection->findOne($id, self::$tableName);
        if ($result[0] !== 0){
            return $result;
        }
        
        $seccion = new Seccion();
        $seccion->getId($result->id);
        $seccion->getNombre($result->nombre);
        $seccion->getDescripcion($result->descripcion);
        $seccion->getCuestionarioId($result->encuestaId);
        $seccion->getOrden($result->encuesta);
        $seccion->getActivo($result->activo);
        $seccion->getCreatedAt($result->createdAt);
        $seccion->getUpdatedAt($result->updatedAt);
        
        return $seccion;
    }
    
    public function insert(Seccion $seccion){
        $seccion->setCreatedAt(App\DateTime::getCurrentDateTime(FECHA_FORMATO_MYSQL));
        return $this->connection->insert($seccion->convertPropertiesToArray(),self::$tableName);
    }
    
    public function update($seccion){
        $seccion->setUpdatedAt(App\DateTime::getCurrentDateTime(FECHA_FORMATO_MYSQL));
        return $this->connection->update($seccion->convertPropertiesToArray(), self::$tableName);
    }
    
    public function delete($id){
        return $this->connection->delete($id, self::$tableName);
    }
}
