<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MZ\Encuestas;

/**
 *
 * @author mauit
 */
interface Dao {
    
    public function getConnection();
    public function find(array $criteria, $tableName);
    public function findOne($id, $tableName);
    public function insert($columns, $tableName);
    public function update($columns, $tableName);
    public function delete($id, $tableName);
}
