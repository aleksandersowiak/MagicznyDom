<?php
/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 11.05.15
 * Time: 11:50
 */
class Zend_View_Helper_isJson extends Zend_View_Helper_Abstract
{
    public function isJson($string) {
        //json_decode($string);
         return is_string($string) && is_object(json_decode($string)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
		 //return (json_last_error() == JSON_ERROR_NONE);
    }
}