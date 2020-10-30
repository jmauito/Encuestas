<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MZ\Encuestas;

/**
 * Description of Error
 *
 * @author mauit
 */
final class Error {
    public static function setErrorPDO($e){
        
        
        
        return self::getErrorMessage($e[0], $e[2]);
        
    }
    
    public static function getErrorMessage(\Exception $err){
        $developer = true;
        if ($developer){
            return ($err);
        }
        
        if ($err->getCode() === 1){
            header(HtmlCode::getBadRequest());
            return json_encode(['errorMessage' => $err->getMessage()]);
        }
        
        $error = [
            '23000' => ["mensaje" => "El registro ya existe. Intente con otro valor", "header"=> HtmlCode::getBadRequest()],
            '42S02' => ["mensaje" => "No existe la tabla para registrar la información. . Comuníquese con el departamento de informática ","header"=> HtmlCode::getServerFail()],
            '42000' => ["mensaje" => "Error en la consulta a la base de datos. Comuníquese con el departamento de informática." ,"header"=> HtmlCode::getServerFail()],
        ];
        
        if (!key_exists($err->getCode(), $error)){
            header(HtmlCode::getServerFail());
            $errorMessage = "Error desconocido";
        }else {
            header($error[$err->getCode()]['header']);
            $errorMessage =  $error[$err->getCode()]['mensaje'];
        }
        return json_encode( ['errorMessage' => $errorMessage] );
        
    }
}



