<?php 

namespace Webkul\Measurement\AttributeTypes; 

class Measurement 
{ 
    const TYPE = 'measurement';
    
    public static function prepareValue($value) 
    { if (is_array($value)) 
        {
             return json_encode($value); 
        } 
        return $value;
     } 
     public static function castValue($value) { 
        if (is_string($value) && self::isJson($value)) 
            {
                 return json_decode($value, true); 
                } 
                return $value; 
            } 
            protected static function isJson($string) { json_decode($string); return json_last_error() === JSON_ERROR_NONE; } }