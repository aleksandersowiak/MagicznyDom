<?php
/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 07.11.14
 * Time: 10:38
 */
class Aso_Model extends Zend_Db_Table_Abstract {
    public function init() {
        parent::init();
    }

    public function aso_return(&$return, $error, $result = null,$count = null) {
        $return = Array("error" => $error);
        if ($result !== null) { $return["result"] = $result; }
        if ($count !== null) { $return["count"] = $count; }
        return ($error == CMD_DB_ERROR_NO_ERROR);
    }
    public function setModuleName($module) {
        $this->_module = $module;
    }
    public function logError($msg) {
        $this->_log->err($this->_module.': '.$msg);
    }
}