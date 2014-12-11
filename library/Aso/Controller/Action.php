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
    private $_params = null;
//    private $_trans = null;

    public function init() {
        parent::init();

        $messages = $this->_helper->flashMessenger->getMessages();
        if(!empty($messages)) $this->_helper->layout->getView()->message = $messages[0];

        $this->renderScript('login_popup.phtml');

        $this->setModel(new Application_Model_Read(), "Model_Read");
        $this->setModel(new Application_Model_Index(), "Model_Index");
        $this->setModel(new Application_Model_Category(), "Model_Category");

        $this->getModel("Model_Index")->getSetings($title, 'title');
        if ($title != NULL) { $this->view->webtitle = $title[0]['data']; }else{ $this->view->webtitle = 'Default Data'; }
        if ($this->getModel("Model_Index")->getSetings($resultAbout, 'about')== FALSE) {
            return $this->aso_sendCommand('Sekcja "O mnie" nie działa prawidłowo.','danger');
        }
        if ($resultAbout != null) { $this->view->about = $resultAbout[0]; }else{ $this->view->about = array("active" => 0); }
        if ($this->getModel("Model_Index")->getCategory($getCategory)== FALSE) {
            return $this->aso_sendCommand('Nie znaleniono żdnej kategori','denger');
        }
        $this->view->Category = $getCategory;
    }


    public function aso_Redirect($where = null){
        $ms = new Zend_Session_Namespace(SESSION_NAMESPACE);
        if ($where == null) {
            $where = array( 'action' => DEF_ACTION__USER,
                            'controller' => 'error');
        }
        $this->_helper->redirector($where['action'], $where['controller']);
    }
    public function aso_sendCommand($command, $message = '', $type = '') {
        $this->view->message = $message;
        $this->view->command = $command;
        $this->view->type = $type;
        $msg = $this->messageBox($command,$message ,$type);
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
    public function  implodeFunction($array = null, $separator = null){
        if ($array != null){
            return implode($array, $separator);
        }
    }
}