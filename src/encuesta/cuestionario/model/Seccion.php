<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace MZ\Encuestas;

/**
 * Description of Seccion
 *
 * @author mauit
 */

require_once GL_DIR_APP . "commons/model/EncuestaModel.php";
require_once GL_DIR_APP . 'src/encuesta/cuestionario/model/Pregunta.php';

class Seccion extends EncuestaModel {
    private $cuestionarioId;
    private $nombre;
    private $descripcion;
    private $orden;
    private $preguntas;
    
    function getCuestionarioId() {
        return $this->cuestionarioId;
    }
    
    function getNombre() {
        return $this->nombre;
    }

    function getOrden() {
        return $this->orden;
    }

        
    function getDescripcion() {
        return $this->descripcion;
    }

    function getPreguntas(){
        return $this->preguntas;
    }
    
    function setCuestionarioId($encuestaId): void {
        $this->cuestionarioId = $encuestaId;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

    function setOrden($orden): void {
        $this->orden = $orden;
    }
    
    function setPreguntas($preguntas): void {
        if (!is_array($preguntas)){
            throw new \Exception("Se esperaba un array en el parámetro preguntas");
        }
        
        $this->preguntas = $preguntas;
    }

    /*
     * Genera un array con las propiedades del objeto
     * @param properties Se debe enviar la clase hija de la cual se necesitan los parámetros.
     * 
     */    
    public function convertPropertiesToArray(){
        $columns = [];
        foreach ($this as $field=>$value){
            if ($field !== 'preguntas'){
                $columns[$field] = $value; 
            }
        }
        
        return $columns;
    }
    
    
    
}
