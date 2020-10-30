<?php
namespace MZ\Encuestas;
require_once '../../../config.php';
require_once GL_DIR_APP . 'commons/dao/ConnectionMySql.php';
require_once GL_DIR_APP . 'commons/message/HtmlCode.php';

require_once 'CuestionarioService.php';

require_once 'dao/CuestionarioDao.php';
require_once 'dao/SeccionDao.php';
require_once 'dao/PreguntaDao.php';
require_once 'dao/OpcionDao.php';
require_once 'model/Cuestionario.php';
require_once 'model/Seccion.php';
require_once 'model/Pregunta.php';
require_once 'model/Opcion.php';


session_start();
$datosUsuario = [
    'user'=>'mzaratep',
    'name'=>'Mauricio Zárate',
    'email'=>'mzaratep@ucacue.edu.ec'
];
if (!isset($_SESSION)){
    $_SESSION['user'] = 'mzaratep';
    $_SESSION['name'] = 'Mauricio Zárate';
    $_SESSION['email'] = 'mzaratep@ucacue.edu.ec';
}

header('Content-Type: application/json');
$action = null;
$result = null;

$connection = new ConnectionMySql();


if (key_exists('id', $_GET)){
    $enc = findOne($connection);
    print ($enc);
    exit();
}

if (!key_exists('action', $_GET)){
    print find($connection);
    exit();
}else{
   $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING); 
}

$args = json_decode( file_get_contents("php://input") , true );
if (json_last_error() !== JSON_ERROR_NONE){
    print error::getErrorMessage(new \Exception("Los datos enviados no son válidos. " . json_last_error_msg() , 1));
    exit();
}

$cl = new Cuestionario();
if (key_exists('id', $args)){
    $cl->setId($args['id']);
}
$cl->setNombre($args['nombre']);
$cl->setDescripcion($args['descripcion']);
$cl->setActivo($args['activo']);
$cl->setCreatedAt($args['createdAt']);
$cl->setUpdatedAt($args['updatedAt']);

$arrSecciones = [];
foreach ($args['secciones'] as $sec){
    $seccion = new Seccion;
    if (key_exists('id', $sec)){
        $seccion->setId($sec['id']);
    }
    if (key_exists('encuestaId', $sec)){
        $seccion->setCuestionarioId($sec['encuestaId']);
    }
    $seccion->setNombre($sec['nombre']);
    $seccion->setOrden($sec['orden']);
    $seccion->setDescripcion($sec['descripcion']);
    $arrPreguntas = [];
    foreach ($sec['preguntas'] as $pre){
        $pregunta = new Pregunta();
        if (key_exists('id', $pre)){
            $pregunta->setId($pre['id']);
        }
        if (key_exists('seccionId', $pre)){
            $pregunta->setSeccionId($pre['seccionId']);
        }
        $pregunta->setNombre($pre['nombre']);
        $pregunta->setDescripcion($pre['descripcion']);
        $pregunta->setOrden($pre['orden']);
        $pregunta->setTipoPreguntaId($pre['tipoPreguntaId']);
        
        $arrOpciones = [];
        foreach ($pre['opciones'] as $op){
            $opcion = new Opcion();
            if (key_exists('id', $op)){
                $opcion->setId($op['id']);
            }
            if (key_exists('preguntaId', $op)){
                $opcion->setPreguntaId($op['preguntaId']);
            }
            $opcion->setNombre($op['nombre']);
            $opcion->setDescripcion($op['descripcion']);
            $opcion->setOrden($op['orden']);
            $opcion->setValor($op['valor']);
            $opcion->setEsCorrecta($op['esCorrecta']);
            
            $arrOpciones[] = $opcion;
        }
        $pregunta->setOpciones($arrOpciones);
        $arrPreguntas[] = $pregunta;
        
    }
    $seccion->setPreguntas($arrPreguntas);
    $arrSecciones[] = $seccion;
}
$cl->setSecciones($arrSecciones);



switch ($action){

    case 'insert':
        $result = insert($cl, $connection);
        break;
    case 'update':
        $result = update($cl, $connection);
        break;
    case 'delete':
        $result = delete($cl, $connection);
        break;

    default :
        $result = "Operación no válida";



}
    
print $result;
    
function findOne($connection){
    $id = filter_input(INPUT_GET,'id' );
    if (!is_numeric($id)){
        return Error::getErrorMessage(new \Exception("El id enviado no es válido",1));
    }
    try{
        $service = new CuestionarioService($connection);
        $encuesta = $service->findOne($id);
    } catch (\Exception $e){
        return Error::getErrorMessage($e);
    }
    return $encuesta->toJson();
}

function find($connection){
    $service = new CuestionarioService($connection);
    try{
        $listaCuestionario = $service->find() ;
    }catch (\Exception $e){
        return Error::getErrorMessage($e);
    }
    for ( $i = 0; $i < count($listaCuestionario); $i++ ){
        $cl = new \stdClass();
        $cl->id = $listaCuestionario[$i]->getId();
        $cl->nombre = $listaCuestionario[$i]->getNombre();
        $cl->descripcion = $listaCuestionario[$i]->getDescripcion();
        $cl->activo = $listaCuestionario[$i]->getActivo();
        $cl->createdAt = $listaCuestionario[$i]->getCreatedAt();
        $cl->updatedAt = $listaCuestionario[$i]->getUpdatedAt();
        
        foreach ($listaCuestionario[$i]->getSecciones() as $seccion){
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
        
        $listaCuestionario[$i] = $cl;
    }
    
    return json_encode($listaCuestionario);
}
    
function insert(Cuestionario $cuestionario, Dao $connection){
    try{
     $cuestionarioService = new CuestionarioService($connection);
     return json_encode( $cuestionarioService->insert($cuestionario));
    }catch(\Exception $e){
        return Error::getErrorMessage($e);
    }
}

function update(Cuestionario $cuestionario, Dao $connection) {
    $cuestionarioService = new CuestionarioService($connection);
    try{
     return $cuestionarioService->update($cuestionario);
    }catch(\Exception $e){
        return Error::getErrorMessage($e);
    }
    
}

function delete(Cuestionario $cuestionario, Dao $connection) {
    $cuestionarioService = new CuestionarioService($connection);
    try{
        $rowsDeleted = $cuestionarioService->delete($cuestionario);
    } catch (\Exception $e){
        return Error::getErrorMessage($e);  
    }
    return $rowsDeleted;
}

