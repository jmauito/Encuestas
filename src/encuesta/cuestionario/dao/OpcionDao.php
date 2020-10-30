<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MZ\Encuestas;

/**
 * Description of opcionDao
 *
 * @author mauit
 */
require_once GL_DIR_APP . 'commons/dao/ConnectionMySql.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/model/Opcion.php';

class OpcionDao {
    
    private static $tableName = "Opcion";
    
    private $connection;
    
    public function __construct($connection) {
        $this->connection = $connection;
    }
    
    public function findOne($id){
        $object = $this->connection->findOne($id, self::$tableName);
        $opcion = new Opcion();
        $opcion->setId($object->id);
        $opcion->setPreguntaId($object->preguntaId);
        $opcion->setNombre($object->nombre);
        $opcion->setOrden($object->orden);
        $opcion->setDescripcion($object->descripcion);
        $opcion->setValor($object->valor);
        $opcion->setEsCorrecta($object->esCorrecta);
        $opcion->setActivo($object->activo);
        $opcion->setCreatedAt($object->createdAt);
        $opcion->setUpdatedAt($object->updatedAt);
        
        return $opcion;
    }
    
    public function find($criteria){
        $lista = $this->connection->find($criteria, self::$tableName);
        
        $listOpciones = [];
        foreach ($lista as $object){
            $opcion = new Opcion();
            $opcion->setId($object->id);
            $opcion->setPreguntaId($object->preguntaId);
            $opcion->setNombre($object->nombre);
            $opcion->setDescripcion($object->descripcion);
            $opcion->setOrden($object->orden);
            $opcion->setValor($object->valor);
            $opcion->setEsCorrecta($object->esCorrecta);
            $opcion->setActivo($object->activo);
            $opcion->setCreatedAt($object->createdAt);
            $opcion->setUpdatedAt($object->updatedAt);
            
            $listOpciones[] = $opcion;
        }
        return $listOpciones;
    }
    
    public function insert(Opcion $opcion){
        
        $columns = [
            'preguntaId' => $opcion->getPreguntaId(),
            'nombre' => $opcion->getNombre(),
            'descripcion' => $opcion->getDescripcion(),
            'orden' => $opcion->getOrden(),
            'valor' => $opcion->getValor(),
            'esCorrecta' => $opcion->getEsCorrecta(),
            'activo' => $opcion->getActivo(),
            'createdAt' => $opcion->getCreatedAt(),
            'updatedAt' => $opcion->getUpdatedAt(),
        ];
        
        return $this->connection->insert($columns, self::$tableName);
    }
    
    public function update(Opcion $opcion){
        $columns = [
            'id' => $opcion->getId(),
            'preguntaId' => $opcion->getPreguntaId(),
            'nombre' => $opcion->getNombre(),
            'descripcion' => $opcion->getDescripcion(),
            'orden'=>$opcion->getOrden(),
            'valor' => $opcion->getValor(),
            'esCorrecta' => $opcion->getEsCorrecta(),
            'activo' => $opcion->getActivo(),
            'createdAt' => $opcion->getCreatedAt(),
            'updatedAt' => $opcion->getUpdatedAt(),
            
        ];
        
        return $this->connection->update($columns, self::$tableName);
    }
}
