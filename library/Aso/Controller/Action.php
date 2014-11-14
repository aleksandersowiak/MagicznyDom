<?php
/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 07.11.14
 * Time: 10:23
 */
class Aso_Controller_Action extends Zend_Controller_Action
{
    private $_log = null;           // logger pointer
    private $_module = "";          // module name
    private $_model = null;
    private $_layout = null;        // layout pointer
//    private $_trans = null;

    public function aso_Redirect($where = null){
        $ms = new Zend_Session_Namespace(SESSION_NAMESPACE);
        if ($where == null) {
            $where = array( 'action' => DEF_ACTION__USER,
                            'controller' => DEF_CONTROLER__USER);
        }
        $this->_helper->redirector($where['action'], $where['controller']);
    }
    public function aso_sendCommand($command, $message = '', $type = '') {
        $this->view->message = $message;
        $this->view->command = $command;
        $this->view->type = $type;
        $msg = $this->messageBox("Nie odnaleziono takiego artykułu. $message","danger");
        $this->_helper->FlashMessenger($msg);
        $this->aso_Redirect();

    }

    public function aso_internalError($r = FALSE) {
        $cmd = CMD_INTERNAL_ERROR;
        if($r === FALSE)                        $cmd = CMD_INTERNAL_ERROR;
        else if(isset($r['error']) == FALSE)    $cmd = CMD_INTERNAL_ERROR;
        else                                    $cmd = $r['error'];
        //header('HTTP/1.0 500 Internal Error');
        return $this->aso_sendCommand($cmd,$this->_('global_popup_db_error'));
    }

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

    public function messageBox($message, $style) {
        $array = array( "message"   => $message,
                        "style"     => $style);
        return $array;
    }

    public function restrictText($text,$count) {
        $countText = strlen($text);
        if ($countText>=$count) {
            $cut = substr($text,0,$count);
            $restrict = $cut."...";
        }else {
            $restrict = $text;
        }
        return $restrict;
    }

    public function getSetings(&$result, $where = null) {
        if ($where != null) {
            $where = $this->getAdapter()->quoteInto("type LIKE ?", $where);
        }else{
            $where = 1;
        }
        $select = $this->_db    ->select()
            ->from("setings")
            ->where($where);
        $result = $this->getAdapter()->fetchAll($select);
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }
}