<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace MZ\Encuestas;
require_once GL_DIR_APP . 'commons/model/EncuestaModel.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/model/Opcion.php';

/**
 * Description of PreguntaDao
 *
 * @author mauit
 */
class Pregunta extends EncuestaModel{
    private $seccionId;
    private $nombre;
    private $descripcion;
    private $orden;
    private $tipoPreguntaId;
    private $opciones;
    
    function getSeccionId() {
        return $this->seccionId;
    }

    function getNombre() {
        return $this->nombre;
    }
        
    function getDescripcion() {
        return $this->descripcion;
    }

    function getOrden() {
        return $this->orden;
    }

    function getTipoPreguntaId() {
        return $this->tipoPreguntaId;
    }

    function getOpciones() {
        return $this->opciones;
    }

    function setSeccionId( int $seccionId): void {
        $this->seccionId = $seccionId;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    function setOrden(int $orden): void {
        $this->orden = $orden;
    }
    
    function setTipoPreguntaId(int $tipoPreguntaId): void {
        $this->tipoPreguntaId = $tipoPreguntaId;
    }

    function setOpciones($opciones): void {
        if (!is_array($opciones)){
            throw new \Exception("Se esperaba una lista de opciones para la pregunta",001);
        }
        $this->opciones = $opciones;
    }

    
    /*
     * Genera un array con las propiedades del objeto
     * @param properties Se debe enviar la clase hija de la cual se necesitan los parámetros.
     * 
     */    
    public function convertPropertiesToArray(){
        $columns = [];
        foreach ($this as $field=>$value){
            if ($field !== 'opciones'){
                $columns[$field] = $value; 
            }
        }
        return $columns;
    }
    
    
    
}
