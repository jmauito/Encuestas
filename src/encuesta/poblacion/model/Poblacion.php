<?php



namespace mz\Encuestas;

require_once GL_DIR_APP . 'commons/model/EncuestaModel.php';

class Poblacion extends EncuestaModel{
    private $nombre;
    private $email;
    private $codigoExterno;
    
    function getNombre() {
        return $this->nombre;
    }

    function getEmail() {
        return $this->email;
    }

    function getCodigoExterno() {
        return $this->codigoExterno;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function setCodigoExterno($codigoExterno): void {
        $this->codigoExterno = $codigoExterno;
    }

    function toJson(){
        $cl = new \stdClass();
        $cl->id = $this->getId() ;
        $cl->nombre = $this->getNombre() ;
        $cl->email = $this->getEmail() ;
        $cl->codigoExterno = $this->getCodigoExterno() ;
        $cl->activo = $this->getActivo() ;
        $cl->updatedAt = $this->getUpdatedAt() ;
        $cl->createdAt = $this->getCreatedAt() ;
        return json_encode($cl);
    }
    
}
