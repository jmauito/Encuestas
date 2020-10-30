<?php
namespace MZ\Encuestas;

require_once GL_DIR_APP . 'src/encuesta/cuestionario/dao/CuestionarioDao.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/dao/SeccionDao.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/dao/PreguntaDao.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/dao/OpcionDao.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/model/Cuestionario.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/model/Seccion.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/model/Pregunta.php';
require_once GL_DIR_APP . 'src/encuesta/cuestionario/model/Opcion.php';
class CuestionarioService {
    private $connection;
    
    public function __construct(Dao $connection) {
        $this->connection = $connection;
    }
    
    function find($criteria = []){
        $cuestionarioDao = new CuestionarioDao($this->connection);
        $seccionDao = new SeccionDao($this->connection);
        $preguntaDao = new PreguntaDao($this->connection);
        $opcionDao = new OpcionDao($this->connection);
        
        $listCuestionarios = $cuestionarioDao->find($criteria);
        for ($i=0; $i<count($listCuestionarios); $i++){
            $listSecciones = $seccionDao->find(['cuestionarioId' =>$listCuestionarios[$i]->getId()]);
            for ($j=0; $j<count($listSecciones); $j++){
                $listPreguntas = $preguntaDao->find(['seccionId' => $listSecciones[$j]->getId()]);
                for ($k=0; $k<count($listPreguntas); $k++){
                    $listPreguntas[$k]->setOpciones($opcionDao->find(['preguntaId' => $listPreguntas[$k]->getId()]));
                }
                $listSecciones[$j]->setPreguntas($listPreguntas);
            }
            $listCuestionarios[$i]->setSecciones($listSecciones);
        }
        
        return $listCuestionarios;
    }
    
    function findOne($id){
        
        $cuestionarioDao = new CuestionarioDao($this->connection);
        $seccionDao = new SeccionDao($this->connection);
        $preguntaDao = new PreguntaDao($this->connection);
        $opcionDao = new OpcionDao($this->connection);

        $cuestionario = $cuestionarioDao->findOne($id);
        if ($cuestionario === null){
            return new Cuestionario();
        }
        $listaSecciones = $seccionDao->find(['cuestionarioId' => $id]);
        for($i=0; $i < count($listaSecciones); $i++){
            $listaPreguntas = $preguntaDao->find(['seccionId' => $listaSecciones[$i]->getId()]);
            for($j=0; $j<count($listaPreguntas); $j++){
                $listaOpciones = $opcionDao->find(['preguntaId'=> $listaPreguntas[$j]->getId()]);
                $listaPreguntas[$j]->setOpciones($listaOpciones);
            }
            $listaSecciones[$i]->setPreguntas($listaPreguntas);
        }

        $cuestionario->setSecciones($listaSecciones);

        return $cuestionario;
    }
    
    function insert(Cuestionario $cuestionario){
        $cuestionario->setActivo(1);
        $cl = new CuestionarioDao($this->connection);
        $seccionDao = new SeccionDao($this->connection);
        $preguntaDao = new PreguntaDao($this->connection);
        $opcionDao = new OpcionDao($this->connection);
        try{

            $this->connection->connection->beginTransaction();

            $cuestionarioId = $cl->insert($cuestionario);

            foreach ($cuestionario->getSecciones() as $seccion){
                $seccion->setCuestionarioId($cuestionarioId);
                $seccionId = $seccionDao->insert($seccion);
                foreach ($seccion->getPreguntas() as $pregunta){
                    $pregunta->setSeccionId($seccionId);
                    $preguntaId = $preguntaDao->insert($pregunta);
                    foreach ($pregunta->getOpciones() as $opcion){
                        $opcion->setPreguntaId($preguntaId);
                       $idSeccion = $opcionDao->insert($opcion); 
                    }
                }
            }
            $this->connection->connection->commit();

        }catch(\Exception $e){
            $this->connection->connection->rollBack();
            throw $e;
        }


        header(HtmlCode::getOk());
        return [$cuestionarioId, $seccionId];

    }
    
    function update(Cuestionario $cuestionario){
        
        $cuestionarioDao = new CuestionarioDao($this->connection);
        $seccionDao = new SeccionDao($this->connection);
        $preguntaDao = new PreguntaDao($this->connection);
        $opcionDao = new OpcionDao($this->connection);

        
        try{
            $this->connection->connection->beginTransaction();
            $rowsUpdated = $cuestionarioDao->update($cuestionario);
            
            foreach ($cuestionario->getSecciones() as $seccion){
                $rowsUpdated = $seccionDao->update($seccion);
                
                foreach ($seccion->getPreguntas() as $pregunta){
                    $rowsUpdated = $preguntaDao->update($pregunta);
                    
                    foreach ($pregunta->getOpciones() as $opcion){
                        $rowsUpdated = $opcionDao->update($opcion);
                    }
                    
                }
                
            }
            
            
            $this->connection->connection->commit();
        } catch (\Exception $e){
            $this->connection->connection->rollBack();
            throw $e;
        }
        return $rowsUpdated;

    }

    function delete(Cuestionario $cuestionario){
        try {
            $this->connection->connection->beginTransaction();
            $cuestionarioDao = new CuestionarioDao($this->connection);
            $rowsDeleted = $cuestionarioDao->delete($cuestionario->getId());
            $this->connection->connection->commit();
        } catch (\Exception $e){
            $this->connection->connection->rollBack();
            throw $e;
        }
        return $rowsDeleted;
    }
    
}
