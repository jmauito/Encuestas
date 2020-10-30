<?php
namespace mz\Encuestas;
require_once GL_DIR_APP . 'commons/dao/ConnectionMySql.php';
require_once GL_DIR_APP . 'commons/datetime/DateTime.php';
require_once GL_DIR_APP . 'src/encuesta/poblacion/model/Poblacion.php';

class PoblacionDao {
    private static $tableName = 'poblacion';
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
            $poblacion = new Poblacion();
            $poblacion->setId($object->id);
            $poblacion->setNombre($object->nombre);
            $poblacion->setEmail($object->email);
            $poblacion->setCodigoExterno($object->codigoExterno);
            $poblacion->setActivo($object->activo);
            $poblacion->setCreatedAt($object->createdAt);
            $poblacion->setUpdatedAt($object->updatedAt);
            
            $listCuestionarios[] = $poblacion;
            
        }
        
        return $listCuestionarios;
        
        
    }
    
    public function findOne($id){
        $result = $this->connection->findOne($id, self::$tableName, $this->connection);
                
        $poblacion = new Poblacion();
        
        if ($result === null){
            throw new \Exception("La población solicitada no existe.",1);
        }
        
        $poblacion->setId($result->id);
        $poblacion->setNombre($result->nombre);
        $poblacion->setEmail($result->email);
        $poblacion->setCodigoExterno($result->codigoExterno);
        $poblacion->setActivo($result->activo);
        $poblacion->setCreatedAt($result->createdAt);
        $poblacion->setUpdatedAt($result->updatedAt);
        return $poblacion;
    }
    
    public function insert(Poblacion $poblacion){
        $poblacion->setCreatedAt(DateTime::getCurrentDateTime(FECHA_FORMATO_MYSQL));
        $std = new \stdClass();
        $std->id = $poblacion->getId();
        $std->nombre = $poblacion->getNombre();
        $std->email = $poblacion->getEmail();
        $std->codigoExterno = $poblacion->getCodigoExterno();
        $std->activo = $poblacion->getActivo();
        $std->createdAt = $poblacion->getCreatedAt();
        $std->updatedAt = $poblacion->getUpdatedAt();
                
        return $this->connection->insert($std, self::$tableName, $this->connection);
    }
    
    public function update(Poblacion $poblacion){
        
        $poblacion->setUpdatedAt(DateTime::getCurrentDateTime(FECHA_FORMATO_MYSQL));
        $poblacion->setCreatedAt(DateTime::getCurrentDateTime(FECHA_FORMATO_MYSQL));
        $std = new \stdClass();
        $std->id = $poblacion->getId();
        $std->nombre = $poblacion->getNombre();
        $std->email = $poblacion->getEmail();
        $std->codigoExterno = $poblacion->getCodigoExterno();
        $std->activo = $poblacion->getActivo();
        $std->createdAt = $poblacion->getCreatedAt();
        $std->updatedAt = $poblacion->getUpdatedAt();
        return $this->connection->update($std, self::$tableName, $this->connection);
    }
    
    public function delete($id){
        return $this->connection->delete($id, self::$tableName, $this->connection);
    }
}
