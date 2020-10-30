<?php
namespace MZ\Encuestas;

require_once GL_DIR_APP . 'commons/model/EncuestaModel.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/model/Seccion.php';


class Cuestionario extends EncuestaModel{
    private $nombre;
    private $descripcion;  
    
    private $secciones = [];

    function getNombre() {
        return $this->nombre;
    }
        
    function getDescripcion() {
        return $this->descripcion;
    }
    
    function getSecciones() {
        return $this->secciones;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }
    
    function setSecciones($secciones){
        $this->secciones = $secciones;
    }
    
    /*
     * Genera un array con las propiedades del objeto
     * @param properties Se debe enviar la clase hija de la cual se necesitan los parámetros.
     * 
     */    
    public function convertPropertiesToArray(){
        $properties = [];
        foreach ($this as $field=>$value){
            if ($field !== 'secciones'){
                $properties[$field] = $value;
            }
        }
        return $properties;
    }
    
    function toJson(){
        $cl = new \stdClass();
        $cl->id = $this->getId() ;
        $cl->nombre = $this->getNombre() ;
        $cl->descripcion = $this->getDescripcion() ;
        $cl->activo = $this->getActivo() ;
        $cl->updatedAt = $this->getUpdatedAt() ;
        $cl->createdAt = $this->getCreatedAt() ;

        foreach ($this->getSecciones() as $seccion){
            $stdSeccion = new \stdClass();
            $stdSeccion->id  = $seccion->getId() ;
            $stdSeccion->encuestaId  = $seccion->getCuestionarioId() ;
            $stdSeccion->nombre  = $seccion->getNombre() ;
            $stdSeccion->descripcion  = $seccion->getDescripcion() ;
            $stdSeccion->orden  = $seccion->getOrden() ;
            $stdSeccion->activo  = $seccion->getActivo() ;
            $stdSeccion->createdAt  = $seccion->getCreatedAt() ;
            $stdSeccion->updatesAt  = $seccion->getUpdatedAt() ;

            foreach ($seccion->getPreguntas() as $pregunta){
                $stdPregunta = new \stdClass();
                $stdPregunta->id  = $pregunta->getId() ;
                $stdPregunta->seccionId  = $pregunta->getSeccionId() ;
                $stdPregunta->nombre  = $pregunta->getNombre() ;
                $stdPregunta->descripcion  = $pregunta->getDescripcion() ;
                $stdPregunta->orden  = $pregunta->getOrden() ;
                $stdPregunta->tipoPreguntaId  = $pregunta->getTipoPreguntaId() ;
                $stdPregunta->activo  = $pregunta->getActivo() ;
                $stdPregunta->createdAt  = $pregunta->getCreatedAt() ;
                $stdPregunta->updatedAt  = $pregunta->getUpdatedAt() ;

                foreach ($pregunta->getOpciones() as $opcion){
                    $stdOpcion = new \stdClass();
                    $stdOpcion->id  = $opcion->getId() ;
                    $stdOpcion->preguntaId  = $opcion->getPreguntaId() ;
                    $stdOpcion->nombre  = $opcion->getNombre() ;
                    $stdOpcion->descripcion  = $opcion->getDescripcion() ;
                    $stdOpcion->orden  = $opcion->getOrden() ;
                    $stdOpcion->valor  = $opcion->getValor() ;
                    $stdOpcion->esCorrecta  = $opcion->getEsCorrecta() ;
                    $stdOpcion->activo  = $opcion->getActivo() ;
                    $stdOpcion->createdAt  = $opcion->getCreatedAt() ;
                    $stdOpcion->updatesAt  = $opcion->getUpdatedAt() ;
                    $stdPregunta->opciones[] = $stdOpcion;
                }
                $stdSeccion->preguntas[] = $stdPregunta;
            }
            $cl->secciones[] = $stdSeccion;
        }

        return json_encode($cl);
    }
    
}
