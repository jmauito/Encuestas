<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MZ\Encuestas;

/**
 * Description of opcion
 *
 * @author mauit
 */

require_once GL_DIR_APP . 'commons/Model/EncuestaModel.php';

class Opcion extends EncuestaModel {
    private int $preguntaId;
    private string $nombre;
    private string $descripcion;
    private int $orden;
    private float $valor;
    private int $esCorrecta;
    
    function getPreguntaId(): int {
        return $this->preguntaId;
    }

    function getNombre(): string {
        return $this->nombre;
    }

    function getDescripcion(): string {
        return $this->descripcion;
    }

    function getOrden(): int {
        return $this->orden;
    }

    function getValor(): float {
        return $this->valor;
    }

    function getEsCorrecta(): int {
        return $this->esCorrecta;
    }

    function setPreguntaId(int $preguntaId): void {
        $this->preguntaId = $preguntaId;
    }

    function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    function setOrden(int $orden): void {
        $this->orden = $orden;
    }

    function setValor(float $valor): void {
        $this->valor = $valor;
    }

    function setEsCorrecta(int $esCorrecta): void {
        $this->esCorrecta = $esCorrecta;
    }

    
    
}
