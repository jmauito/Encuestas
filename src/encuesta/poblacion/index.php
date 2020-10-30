<?php
namespace mz\Encuestas;
require_once '../../../config.php';
require_once  GL_DIR_APP . 'commons/message/HtmlCode.php';

require_once 'PoblacionService.php';

require_once 'dao/PoblacionDao.php';
require_once 'model/Poblacion.php';


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


if (key_exists('id', $_GET)){
    $pob = findOne();
    print ($pob);
    exit();
}

if (!key_exists('action', $_GET)){
    print find();
    exit();
}else{
   $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING); 
}

$args = json_decode( file_get_contents("php://input") , true );
if (json_last_error() !== JSON_ERROR_NONE){
    print error::getErrorMessage(new \Exception("Los datos enviados no son válidos. " . json_last_error_msg() , 1));
    exit();
}

$cl = new Poblacion();
if (key_exists('id', $args)){
    $cl->setId($args['id']);
}
$cl->setNombre($args['nombre']);
$cl->setEmail($args['email']);
$cl->setCodigoExterno($args['codigoExterno']);
$cl->setActivo($args['activo']);
$cl->setCreatedAt($args['createdAt']);
$cl->setUpdatedAt($args['updatedAt']);

switch ($action){

    case 'insert':
        $result = insert($cl);
        break;
    case 'update':
        $result = update($cl);
        break;
    case 'delete':
        $result = delete($cl);
        break;

    default :
        $result = "Operación no válida";



}
    
print $result;
    
function findOne(){
    $id = filter_input(INPUT_GET,'id' );
    if (!is_numeric($id)){
        return Error::getErrorMessage(new \Exception("El id enviado no es válido",1));
    }
    try{
        $service = new PoblacionService();
        $poblacion = $service->findOne($id);
    } catch (\Exception $e){
        return Error::getErrorMessage($e);
    }
    
    $cl = new \stdClass();
    $cl->id = $poblacion->getId() ;
    $cl->nombre = $poblacion->getNombre() ;
    $cl->email = $poblacion->getEmail() ;
    $cl->codigoExterno = $poblacion->getCodigoExterno() ;
    $cl->activo = $poblacion->getActivo() ;
    $cl->updatedAt = $poblacion->getUpdatedAt() ;
    $cl->createdAt = $poblacion->getCreatedAt() ;
    
    return json_encode($cl);
}

function find(){
    $service = new PoblacionService();
    try{
        $listaPoblacion = $service->find() ;
    }catch (\Exception $e){
        return Error::getErrorMessage($e);
    }
    for ( $i = 0; $i < count($listaPoblacion); $i++ ){
        $cl = new \stdClass();
        $cl->id = $listaPoblacion[$i]->getId();
        $cl->nombre = $listaPoblacion[$i]->getNombre();
        $cl->email = $listaPoblacion[$i]->getEmail();
        $cl->codigoExterno = $listaPoblacion[$i]->getCodigoExterno();
        $cl->activo = $listaPoblacion[$i]->getActivo();
        $cl->createdAt = $listaPoblacion[$i]->getCreatedAt();
        $cl->updatedAt = $listaPoblacion[$i]->getUpdatedAt();
        
        $listaPoblacion[$i] = $cl;
    }
    
    return json_encode($listaPoblacion);
}
    
function insert(Poblacion $poblacion){
    try{
     $poblacionService = new PoblacionService();
     return json_encode( $poblacionService->insert($poblacion));
    }catch(\Exception $e){
        return Error::getErrorMessage($e);
    }
}

function update(Poblacion $poblacion) {
    $poblacionService = new PoblacionService();
    try{
     return $poblacionService->update($poblacion);
    }catch(\Exception $e){
        return Error::getErrorMessage($e);
    }
    
}

function delete(Poblacion $poblacion) {
    $poblacionService = new PoblacionService();
    try{
        $rowsDeleted = $poblacionService->delete($poblacion);
    } catch (\Exception $e){
        return Error::getErrorMessage($e);  
    }
    return $rowsDeleted;
}
