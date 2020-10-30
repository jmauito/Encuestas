<?php

require_once '../../config.php';
require_once GL_DIR_APP . 'commons/dao/ConnectionMySql.php';
require_once GL_DIR_APP . 'src/encuesta/encuestaService.php';

$connection = new MZ\Encuestas\ConnectionMySql();

$cl = new MZ\Encuestas\encuestaService($connection);

$args = json_decode( file_get_contents("php://input") , true );
header('Content-Type: application/json');
print json_encode( $cl->generarEncuesta($args['cuestionarioId'], $args['poblacionId']) );

