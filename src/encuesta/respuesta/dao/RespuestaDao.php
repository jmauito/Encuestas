<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MZ\Encuestas;

/**
 * Description of RespuestaDao
 *
 * @author mauit
 */
require_once GL_DIR_APP . 'commons/dao/ConnectionMySql.php';
require_once GL_DIR_APP . 'commons/datetime/DateTime.php';
require_once GL_DIR_APP . 'src/encuesta/respuesta/model/Respuesta.php';


class RespuestaDao {
    private static $tableName = 'respuesta';
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
        
        $listRespuestas = [];
        
        foreach ($listObjects as $object){
            $respuesta = new Respuesta();
            $respuesta->setId($object->id);
            $respuesta->setPoblacionId($object->poblacionId);
            $respuesta->setOpcionId($object->opcionId);
            $respuesta->setRespuesta($object->respuesta);
            $respuesta->setActivo($object->activo);
            $respuesta->setCreatedAt($object->createdAt);
            $respuesta->setUpdatedAt($object->updatedAt);
            
            $listRespuestas[] = $respuesta;
            
        }
        
        return $listRespuestas;
        
        
    }
    
    public function findOne($id){
        $result = $this->connection->findOne($id, self::$tableName, $this->connection);
                
        $respuesta = new Respuesta();
        
        if ($result === null){
            throw new \Exception("La respuesta solicitada no existe.",1);
        }
        
        $respuesta->setId($result->id);
        $respuesta->setPoblacionId($result->poblacionId);
        $respuesta->setOpcionId($result->opcionId);
        $respuesta->setRespuesta($result->respuesta);
        $respuesta->setActivo($result->activo);
        $respuesta->setCreatedAt($result->createdAt);
        $respuesta->setUpdatedAt($result->updatedAt);
        return $respuesta;
    }
    
    public function insert(Respuesta $respuesta){
        $respuesta->setCreatedAt(DateTime::getCurrentDateTime(FECHA_FORMATO_MYSQL));
        
        $data = [
            'poblacionId' => $respuesta->getPoblacionId(),
            'opcionId' => $respuesta->getOpcionId(),
            'respuesta' => $respuesta->getRespuesta(),
            'activo' => $respuesta->getActivo(),
            'createdAt' => $respuesta->getCreatedAt(),
            'updatedAt' => $respuesta->getUpdatedAt()
        ];
        
        return $this->connection->insert($data, self::$tableName, $this->connection);
    }
    
    public function update(Respuesta $respuesta){
        
        $respuesta->setUpdatedAt(DateTime::getCurrentDateTime(FECHA_FORMATO_MYSQL));
        $data = [
            'id' => $respuesta->getId(),
            'poblacionId' => $respuesta->getPoblacionId(),
            'opcionId' => $respuesta->getOpcionId(),
            'respuesta' => $respuesta->getRespuesta(),
            'activo' => $respuesta->getActivo(),
            'createdAt' => $respuesta->getCreatedAt(),
            'updatedAt' => $respuesta->getUpdatedAt()
        ];
        return $this->connection->update($data, self::$tableName, $this->connection);
    }
    
    public function delete($id){
        return $this->connection->delete($id, self::$tableName, $this->connection);
    }
}
