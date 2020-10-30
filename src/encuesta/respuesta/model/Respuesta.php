<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MZ\Encuestas;

/**
 * Description of Respuesta
 *
 * @author mauit
 */
require_once GL_DIR_APP . 'commons/model/EncuestaModel.php';

class Respuesta extends EncuestaModel {
    private $poblacionId;
    private $opcionId;
    private $respuesta;
    
    function getPoblacionId() {
        return $this->poblacionId;
    }

    function getOpcionId() {
        return $this->opcionId;
    }

    function getRespuesta() {
        return $this->respuesta;
    }

    function setPoblacionId($poblacionId): void {
        $this->poblacionId = $poblacionId;
    }

    function setOpcionId($opcionId): void {
        $this->opcionId = $opcionId;
    }

    function setRespuesta($respuesta): void {
        $this->respuesta = $respuesta;
    }


    
}
