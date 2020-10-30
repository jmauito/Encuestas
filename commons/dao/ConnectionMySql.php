<?php

/*
 * Clase base para la conexión con la base de datos
 */

/**
 * Description of Connection
 *
 * @author mauit
 */
namespace MZ\Encuestas;

require_once GL_DIR_APP . 'commons/error/Error.php';
require_once GL_DIR_APP . 'commons/dao/Dao.php';

class ConnectionMySql implements Dao{
    /*
     * Devuelve una conexión a la base de datos
     */
    
    private $host = 'localhost';
    private $dataBase = 'encuesta';
    private $port = '3307';
    private $user = 'root';
    private $password = 'admin';
    
    public $connection;
    
    public function __construct() {
        $this->connection = $this->getConnection();
    }
    
    
    public function getConnection(){
        
        try {
            $connection = new \PDO("mysql:host={$this->host};dbname={$this->dataBase};port={$this->port};charset=utf8", $this->user,$this->password);
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $connection;
    }
    
    /**
     * Devuelve una lista de resultados de una tabla
     * @param criteria: Array asociativo que tiene los filtros.
     * @param tableName: Nombre de la tabla de la cual se obtendrá la información
     * @param connection: Si desea usar una conexión. Si no envía ningún valor, la conexión se creará automáticamente.
     * @returns: Object con la información.
     */
    public function find(array $criteria, $tableName){
        $statement = "SELECT * FROM $tableName ";
        
        $separator = ' WHERE ';
        foreach ($criteria as $field => $value){
            $statement .= "$separator $field = :$field ";
            $separator = ' AND ';
        }
        $stmt = $this->connection->prepare($statement);
        
        foreach ($criteria as $field => $value){
            $stmt->bindParam(":$field", $$field);
            $$field = $value;
        }
        
        $stmt->execute();
        $arrayData = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return $arrayData;
    }
    
    public function findOne($id, $tableName){
        
        $statement = "SELECT * FROM $tableName WHERE id = :id;";
        
        $stmt = $this->connection->prepare($statement);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $arrayData = $stmt->fetchAll(\PDO::FETCH_OBJ);
        if (count($arrayData) === 0){
            return null;
        }
        
        foreach ($arrayData as $data){
            return $data;
        }
        
        
    }
    
    public function insert($columns, $tableName){
        
        $sentencia = "INSERT INTO $tableName SET " ;
        $separator = '';
        foreach ($columns as $field => $value) {
            $sentencia .= "$separator $field = :$field ";
            $separator = ', ';
        }
        
        $stmt = $this->connection->prepare($sentencia);
        
        foreach ($columns as $field => $value){
            $stmt->bindParam(":$field", $$field);
            $$field = $value;
        }
        $stmt->execute();
        
        return $this->connection->lastInsertId();
    }
    
    public function update($columns, $tableName){
        
        $sentencia = "UPDATE $tableName SET " ;
        $separator = '';
        foreach ($columns as $field => $value) {
            if ($field === 'id') {
                continue;
            }
            $sentencia .= "$separator $field = :$field ";
            $separator = ', ';
        }
        
        $sentencia .= " WHERE id = :id ";
        $stmt = $this->connection->prepare($sentencia);
        foreach ($columns as $field => $value){
            $stmt->bindParam(":$field", $$field);
            $$field = $value;
        }
        $stmt->execute();
        return $stmt->rowCount();
        
    }
    
    public function delete($id, $tableName){
        
        $sentencia = "DELETE FROM $tableName " 
            . " WHERE id = :id ";
        
        $stmt = $this->connection->prepare($sentencia);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
        
        return $stmt->rowCount();
        
    }
    
}