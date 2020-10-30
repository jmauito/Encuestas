<?php
namespace MZ\Encuestas;

require_once GL_DIR_APP . 'src/encuesta/respuesta/model/Respuesta.php';
require_once GL_DIR_APP . 'src/encuesta/respuesta/dao/RespuestaDao.php';

class RespuestaService {
    private $connection;
    
    public function __construct(Dao $connection) {
        #$this->connection = new ConnectionMySql();
        $this->connection = $connection;
    }
    
    function find($criteria = []){
        $respuestaDao = new RespuestaDao($this->connection);
        
        $listRespuesta = $respuestaDao->find($criteria);
               
        return $listRespuesta;
    }
    
    function findOne($id){
        $respuestaDao = new RespuestaDao($this->connection);
        $respuesta = $respuestaDao->findOne($id);
        return $respuesta;
    }
    
    function insert(Respuesta $respuesta){
        $respuesta->setActivo(1);
        $cl = new RespuestaDao($this->connection);
        
        try{

            $this->connection->connection->beginTransaction();

            $respuestaId = $cl->insert($respuesta);

            $this->connection->connection->commit();

        }catch(\Exception $e){
            $this->connection->connection->rollBack();
            throw $e;
        }


        header(HtmlCode::getOk());
        return $respuestaId;

    }
    
    function update(Respuesta $respuesta){
        
        $respuestaDao = new RespuestaDao($this->connection);
        
        try{
            $this->connection->connection->beginTransaction();
            $rowsUpdated = $respuestaDao->update($respuesta);
            $this->connection->connection->commit();
        } catch (\Exception $e){
            $this->connection->connection->rollBack();
            throw $e;
        }
        return $rowsUpdated;

    }

    function delete(Respuesta $respuesta){
        try {
            $this->connection->connection->beginTransaction();
            $respuestaDao = new RespuestaDao($this->connection);
            $rowsDeleted = $respuestaDao->delete($respuesta->getId());
            $this->connection->connection->commit();
        } catch (\Exception $e){
            $this->connection->connection->rollBack();
            throw $e;
        }
        return $rowsDeleted;
    }

}
