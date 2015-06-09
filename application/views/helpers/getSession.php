<?php
/**
 * Created by PhpStorm.
 * User: Aleksander Sowiak
 * Date: 09.06.15
 * Time: 19:47
 */
class Zend_View_Helper_getSession extends Zend_View_Helper_Abstract
{
    public function getSession(){
        return new Zend_Session_Namespace(SESSION_NAMESPACE);
    }
}