<?php
namespace MZ\Encuestas;
require_once GL_DIR_APP . 'commons/dao/ConnectionMySql.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/CuestionarioService.php';
require_once GL_DIR_APP . 'src/encuesta/poblacion/PoblacionService.php';
require_once GL_DIR_APP . 'src/encuesta/respuesta/RespuestaService.php';

class encuestaService {
    
    private $connection;
    
    public function __construct(Dao $connection) {
        $this->connection = $connection;
    }
    
    function generarEncuesta($cuestionarioId, $poblacionId){
        
        $cuestionarioService = new CuestionarioService($this->connection);
        $poblacionService = new \mz\Encuestas\PoblacionService($this->connection);
        $respuestaService = new RespuestaService($this->connection);
        
        $cuestionario = $cuestionarioService->findOne($cuestionarioId);
        $poblacion = $poblacionService->findOne($poblacionId);
        $listaRespuestas = $respuestaService->find(['poblacionId' => $poblacionId]);
        
        $objEncuesta = new \stdClass();
        $objEncuesta->cuestionarioId = $cuestionario->getId();
        $objEncuesta->poblacionId = $poblacion->getId();
        $objEncuesta->nombre = $cuestionario->getNombre();
        $objEncuesta->descripcion = $cuestionario->getDescripcion();
        foreach ($cuestionario->getSecciones() as $seccion){
            
            if ($seccion->getActivo() === 0){
                continue;
            }
            
            $auxSeccion = new \stdClass();
            $auxSeccion->id = $seccion->getId();
            $auxSeccion->orden =  $seccion->getOrden();
            $auxSeccion->nombre = $seccion->getNombre();
            $auxSeccion->descripcion = $seccion->getDescripcion();
            foreach ($seccion->getPreguntas() as $pregunta){
                
                if ($pregunta->getActivo() === 0){
                    continue;
                }
                
                $auxPregunta = new \stdClass();
                $auxPregunta->id =  $pregunta->getId();
                $auxPregunta->orden =  $pregunta->getOrden();
                $auxPregunta->nombre =  $pregunta->getNombre();
                $auxPregunta->descripcion =  $pregunta->getDescripcion();
                $auxPregunta->tipoPregunta =  $pregunta->getTipoPreguntaId();
                foreach ($pregunta->getOpciones() as $opcion){
                    
                    if ($opcion->getActivo() === 0){
                        continue;
                    }
                    
                    $auxOpcion = new \stdClass();
                    $auxOpcion->id = $opcion->getId();
                    $auxOpcion->activo = $opcion->getActivo();
                    $auxOpcion->nombre = $opcion->getNombre();
                    $auxOpcion->descripcion = $opcion->getDescripcion();
                    $auxOpcion->orden = $opcion->getOrden();
                    $auxOpcion->valor = $opcion->getValor();
                        
                    $opcionId = $opcion->getId();
                    $respuesta =  array_filter($listaRespuestas, function($arr) use ($opcionId){
                        return $arr->getOpcionId() == $opcionId;
                    });
                    
                    if (count($respuesta)>0){
                        $auxOpcion->selected = true;
                        $auxOpcion->respuesta = current($respuesta)->getRespuesta();
                    }
                    
                    $auxPregunta->opciones[] = $auxOpcion;
                }
                $auxSeccion->preguntas[] = $auxPregunta;
            }
            $objEncuesta->secciones[] = $auxSeccion;
        }
        return $objEncuesta;
    }
}
