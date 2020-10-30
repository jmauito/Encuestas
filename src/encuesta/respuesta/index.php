<?php
namespace mz\Encuestas;
define ('GL_DIR_APP','D:\phpProjects\encuestas\\');
require_once '../../../commons/message/HtmlCode.php';

require_once 'RespuestaService.php';

require_once 'dao/RespuestaDao.php';
require_once 'model/Respuesta.php';


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

$connection = new \MZ\Encuestas\ConnectionMySql();

if (key_exists('id', $_GET)){
    $res = findOne($connection);
    print ($res);
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

$cl = new Respuesta();
if (key_exists('id', $args)){
    $cl->setId($args['id']);
}
$cl->setPoblacionId($args['poblacionId']);
$cl->setOpcionId($args['opcionId']);
$cl->setRespuesta($args['respuesta']);
$cl->setActivo($args['activo']);
$cl->setCreatedAt($args['createdAt']);
$cl->setUpdatedAt($args['updatedAt']);

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
        $service = new \MZ\Encuestas\RespuestaService($connection);
        $respuesta = $service->findOne($id);
    } catch (\Exception $e){
        return Error::getErrorMessage($e);
    }
    
    $cl = new \stdClass();
    $cl->id = $respuesta->getId() ;
    $cl->poblacionId = $respuesta->getPoblacionId() ;
    $cl->opcionId = $respuesta->getOpcionId() ;
    $cl->respuesta = $respuesta->getRespuesta() ;
    $cl->activo = $respuesta->getActivo() ;
    $cl->updatedAt = $respuesta->getUpdatedAt() ;
    $cl->createdAt = $respuesta->getCreatedAt() ;
    
    return json_encode($cl);
}

function find($connection){
    $service = new RespuestaService($connection);
    try{
        $listaRespuesta = $service->find() ;
    }catch (\Exception $e){
        return Error::getErrorMessage($e);
    }
    for ( $i = 0; $i < count($listaRespuesta); $i++ ){
        $cl = new \stdClass();
        $cl->id = $listaRespuesta[$i]->getId();
        $cl->opcionId = $listaRespuesta[$i]->getOpcionId();
        $cl->poblacionId = $listaRespuesta[$i]->getPoblacionId();
        $cl->respuesta = $listaRespuesta[$i]->getRespuesta();
        $cl->activo = $listaRespuesta[$i]->getActivo();
        $cl->createdAt = $listaRespuesta[$i]->getCreatedAt();
        $cl->updatedAt = $listaRespuesta[$i]->getUpdatedAt();
        
        $listaRespuesta[$i] = $cl;
    }
    
    return json_encode($listaRespuesta);
}
    
function insert(Respuesta $respuesta, \MZ\Encuestas\Dao $connection){
    try{
     $respuestaService = new \MZ\Encuestas\RespuestaService($connection);
     return json_encode( $respuestaService->insert($respuesta));
    }catch(\Exception $e){
        return Error::getErrorMessage($e);
    }
}

function update(Respuesta $respuesta, \MZ\Encuestas\Dao $connection) {
    $respuestaService = new \MZ\Encuestas\RespuestaService($connection);
    try{
     return $respuestaService->update($respuesta);
    }catch(\Exception $e){
        return Error::getErrorMessage($e);
    }
    
}

function delete(\MZ\Encuestas\Respuesta $respuesta, \MZ\Encuestas\Dao $connection) {
    $respuestaService = new \MZ\Encuestas\RespuestaService($connection);
    try{
        $rowsDeleted = $respuestaService->delete($respuesta);
    } catch (\Exception $e){
        return Error::getErrorMessage($e);  
    }
    return $rowsDeleted;
}
