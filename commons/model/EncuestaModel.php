<?php

/*
 *Clase base para todos los modelos del sistema
 */

/**
 * Description of EncuestaModel
 *
 * @author mauit
 */

namespace MZ\Encuestas;

abstract class EncuestaModel {
    protected $id;
    protected $activo;
    protected $createdAt;
    protected $updatedAt;
    
    function getId() {
        return $this->id;
    }
    
    function getActivo() {
        return $this->activo;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function setId($id): void {
        $this->id = $id;
    }
    
    function setActivo($activo): void {
        $this->activo = $activo;
    }

    function setCreatedAt($createdAt): void {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt($updatedAt): void {
        $this->updatedAt = $updatedAt;
    }

    
    public function __construct() {
        $this->id = null;
        $this->activo = 1;
    }
    
    

}
