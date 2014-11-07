<?php
/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 07.11.14
 * Time: 10:23
 */
class Aso_Controller_Action extends Zend_Controller_Action
{
    public function setModuleName($module) {
        $this->_module = $module;
    }
//
    public function setModel($model, $model_name = 'base_model') {
        $this->_model[$model_name] = $model;
        return $this->_model[$model_name];
    }
//
    public function getModel($model_name = 'base_model') {
        return $this->_model[$model_name];
    }
//
    public function setLayout($layout) {
        $this->_layout = $layout;
    }
//
    public function setLayoutName($name) {
        if($this->_layout != null) {
            $this->_layout->setLayout($name);
        } else {
            $this->logError("setLayoutName: operation on NULL obj");
        }
    }
//
    public function getLayout() {
        return $this->_layout;
    }
//
    public function logError($msg) {
        $this->_log->err($this->_module.': '.$msg);
    }
}