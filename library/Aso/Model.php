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

    public function setModuleName($module) {
        $this->_module = $module;
    }
}