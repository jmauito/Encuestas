<?php

/*
 * Manejo de las fechas y las horas
 */

/**
 * Description of DateTime
 *
 * @author mzaratep
 */
namespace MZ\Encuestas;

const FECHA_FORMATO_MYSQL = 1;

final class DateTime {
    //put your code here
    public static function getCurrentDateTime($formato = FECHA_FORMATO_MYSQL){
        $hoy = getdate();
        switch ($formato){
            case FECHA_FORMATO_MYSQL :
                return $hoy['year'] . '-' 
                    . str_pad($hoy['mon'],2, '0', STR_PAD_LEFT) . '-' 
                    . str_pad($hoy['mday'],2 ,'0', STR_PAD_LEFT) . ' ' 
                    . str_pad($hoy['hours'], 2,'0', STR_PAD_LEFT) . ':' 
                    . str_pad($hoy['minutes'],2, '0', STR_PAD_LEFT) .':'
                    . str_pad($hoy['seconds'], 2,'0', STR_PAD_LEFT);
        }
    }
    
    public static function getCurrentDate($formato = FECHA_FORMATO_MYSQL){
        $hoy = getdate();
        switch ($formato){
            case FECHA_FORMATO_MYSQL :
                return $hoy['year'] . '-' 
                    . str_pad($hoy['mon'],2, '0', STR_PAD_LEFT) . '-' 
                    . str_pad($hoy['mday'],2 ,'0', STR_PAD_LEFT)  
                    ;
        }
    }
    
    public static function validarRangoFechas($fechaInicio, $fechaFin){
        if ($fechaInicio === '0000-00-00'){
            return 'El valor de la fecha de inicio no es válido';
        }
        if ($fechaFin === '0000-00-00'){
            return 'El valor de la fecha de fin no es válido';
        }
        if ((new DateTime($fechaInicio)) > (new DateTime($fechaFin))){
            return 'El rango no es válido. La fecha de inicio no debe ser mayor a la fecha de fin';
        }
        return TRUE;
    }
    
}
