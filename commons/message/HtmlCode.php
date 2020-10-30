<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MZ\Encuestas;

/**
 * Description of HtmlCode
 *
 * @author mauit
 */
final class HtmlCode {
    
    public static function getOk():string{
        return "HTTP/1.1 200 Created";
    }
    public static function getFail(): string{
        return "HTTP/1.1 409 Conflict";
    }
    public static function getBadRequest(): string{
        return "HTTP/1.1 400 Bad Request";
    }
    public static function getServerFail(): string{
        return "HTTP/1.1 500 Internal Server";
    }
}
