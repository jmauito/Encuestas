<?php
namespace mz\Encuestas;

require_once GL_DIR_APP . 'src/encuesta/poblacion/dao/PoblacionDao.php';
require_once GL_DIR_APP . 'src/encuesta/poblacion/model/Poblacion.php';

class PoblacionService {
    private $connection;
    
    public function __construct() {
        $this->connection = new ConnectionMySql();
    }
    
    function find($criteria = []){
        $poblacionDao = new PoblacionDao($this->connection);
        
        $listPoblacion = $poblacionDao->find($criteria);
               
        return $listPoblacion;
    }
    
    function findOne($id){
        $poblacionDao = new PoblacionDao($this->connection);
        $poblacion = $poblacionDao->findOne($id);
        return $poblacion;
    }
    
    function insert(Poblacion $poblacion){
        $poblacion->setActivo(1);
        $cl = new PoblacionDao($this->connection);
        
        try{

            $this->connection->connection->beginTransaction();

            $poblacionId = $cl->insert($poblacion);

            $this->connection->connection->commit();

        }catch(\Exception $e){
            $this->connection->connection->rollBack();
            throw $e;
        }


        header(HtmlCode::getOk());
        return [$poblacionId];

    }
    
    function update(Poblacion $poblacion){
        
        $poblacionDao = new PoblacionDao($this->connection);
        
        try{
            $this->connection->connection->beginTransaction();
            $rowsUpdated = $poblacionDao->update($poblacion);
            $this->connection->connection->commit();
        } catch (\Exception $e){
            $this->connection->connection->rollBack();
            throw $e;
        }
        return $rowsUpdated;

    }

    function delete(Poblacion $poblacion){
        try {
            $this->connection->connection->beginTransaction();
            $poblacionDao = new PoblacionDao($this->connection);
            $rowsDeleted = $poblacionDao->delete($poblacion->getId());
            $this->connection->connection->commit();
        } catch (\Exception $e){
            $this->connection->connection->rollBack();
            throw $e;
        }
        return $rowsDeleted;
    }

}
