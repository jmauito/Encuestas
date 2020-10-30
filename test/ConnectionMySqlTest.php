<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConnectionMySqlTest
 *
 * @author mauit
 */

require_once '../commons/dao/ConnectionMySql.php';
require_once '../commons/error/Error.php';

class ConnectionMySqlTest {
    //put your code here
    function find(){
        $connection = new MZ\Encuestas\ConnectionMySql();
        $result = $connection->find([], "Encuesta");
        print_r($result);
    }
}

$cl = new ConnectionMySqlTest();
$cl->find();
