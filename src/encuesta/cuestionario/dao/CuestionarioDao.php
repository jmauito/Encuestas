<?php
namespace MZ\Encuestas;
require_once GL_DIR_APP . 'commons/dao/ConnectionMySql.php';
require_once GL_DIR_APP . 'commons/datetime/DateTime.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/model/Cuestionario.php';

class CuestionarioDao {
    private static $tableName = 'cuestionario';
    private $connection;
    private Dao $dto;
    
    public function __construct(Dao $connection) {
        $this->connection = $connection;
    }  
    
    static function getTableName() {
        return self::$tableName;
    }
        
    public function find($criteria = []){
        $listObjects = $this->connection->find($criteria, self::$tableName);
        
        $listCuestionarios = [];
        
        foreach ($listObjects as $object){
            $cuestionario = new Cuestionario();
            $cuestionario->setId($object->id);
            $cuestionario->setNombre($object->nombre);
            $cuestionario->setDescripcion($object->descripcion);
            $cuestionario->setActivo($object->activo);
            $cuestionario->setCreatedAt($object->createdAt);
            $cuestionario->setUpdatedAt($object->updatedAt);
            
            $listCuestionarios[] = $cuestionario;
            
        }
        
        return $listCuestionarios;
        
        
    }
    
    public function findOne($id){
        $result = $this->connection->findOne($id, self::$tableName, $this->connection);
                
        $cuestionario = new Cuestionario();
        
        if ($result === null){
            throw new \Exception("El cuestionario solicitado no existe.",1);
        }
        
        $cuestionario->setId($result->id);
        $cuestionario->setNombre($result->nombre);
        $cuestionario->setDescripcion($result->descripcion);
        $cuestionario->setActivo($result->activo);
        $cuestionario->setCreatedAt($result->createdAt);
        $cuestionario->setUpdatedAt($result->updatedAt);
        return $cuestionario;
    }
    
    public function insert(Cuestionario $cuestionario){
        $cuestionario->setCreatedAt(DateTime::getCurrentDateTime(FECHA_FORMATO_MYSQL));
        return $this->connection->insert($cuestionario->convertPropertiesToArray(), self::$tableName, $this->connection);
    }
    
    public function update(Cuestionario $cuestionario){
        
        $cuestionario->setUpdatedAt(DateTime::getCurrentDateTime(FECHA_FORMATO_MYSQL));
        return $this->connection->update($cuestionario->convertPropertiesToArray(), self::$tableName, $this->connection);
    }
    
    public function delete($id){
        return $this->connection->delete($id, self::$tableName, $this->connection);
    }
}
