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
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}