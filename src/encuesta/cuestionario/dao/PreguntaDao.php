<?php
namespace MZ\Encuestas;
use MZ\Encuestas as App;
require_once GL_DIR_APP . 'commons/dao/ConnectionMySql.php';
require_once GL_DIR_APP . 'commons/datetime/DateTime.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/model/Pregunta.php';

class PreguntaDao {
    private static $tableName = 'pregunta';
    private $connection;
    
    public function __construct($connection) {
        $this->connection = $connection;
        
    }  
    
    static function getTableName() {
        return self::$tableName;
    }
        
    public function find($criteria = []){
        $list =  $this->connection->find($criteria, self::$tableName);
        $listPreguntas = [];
        
        foreach ($list as $cl){
            $pregunta = new Pregunta();
            $pregunta->setId($cl->id);
            $pregunta->setSeccionId($cl->seccionId);
            $pregunta->setNombre($cl->nombre);
            $pregunta->setDescripcion($cl->descripcion);
            $pregunta->setOrden($cl->orden);
            $pregunta->setTipoPreguntaId($cl->tipoPreguntaId);
            $pregunta->setActivo($cl->activo);
            $pregunta->setCreatedAt($cl->createdAt);
            $pregunta->setUpdatedAt($cl->updatedAt);
            $listPreguntas[] = $pregunta;
        }
        return $listPreguntas;
    }
    
    public function findOne($id){
        $result = $this->connection->findOne($id, self::$tableName);
        if (count($result) === 0){
            return null;
        }
        
        $pregunta = new Pregunta();
        $pregunta->setId($result->id);
        $pregunta->setSeccionId($result->seccionId);
        $pregunta->setNombre($result->nombre);
        $pregunta->setDescripcion($result->descripcion);
        $pregunta->setOrden($result->orden);
        $pregunta->setActivo($result->activo);
        $pregunta->setCreatedAt($result->createdAt);
        $pregunta->setUpdatedAt($result->updatedAt);
        
        return $pregunta;
    }
    
    public function insert($cl){
        $cl->setCreatedAt(App\DateTime::getCurrentDateTime(FECHA_FORMATO_MYSQL));
        return $this->connection->insert($cl->convertPropertiesToArray(), self::$tableName);
    }
    
    public function update($cl){
        
        $cl->setUpdatedAt(App\DateTime::getCurrentDateTime(FECHA_FORMATO_MYSQL));
        return $this->connection->update($cl->convertPropertiesToArray(), self::$tableName);
    }
    
    public function delete($id){
        return $this->connection->delete($id, self::$tableName);
    }
}
