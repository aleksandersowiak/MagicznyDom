<?php

/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 07.11.14
 * Time: 10:23
 */
class Aso_Controller_Action extends Zend_Controller_Action
{
    private $_log = null; // logger pointer
    private $_module = ""; // module name
    private $_model = null;
    private $_layout = null; // layout pointer
    private $_params = null;
    private $_model_read = null;
    private $_model_index = null;
    private $_model_category = null;
    private $_ms = null;
    private $_model_login = null;

//    private $_trans = null;

    public function init()
    {
//        parent::init();
        $this->_ms = new Zend_Session_Namespace(SESSION_NAMESPACE);
        $messages = $this->_helper->flashMessenger->getMessages();
        if (!empty($messages)) $this->_helper->layout->getView()->message = $messages[0];

        $this->_model_read = $this->setModel(new Application_Model_Read(), "Model_Read");
        $this->_model_index = $this->setModel(new Application_Model_Index(), "Model_Index");
        $this->_model_category = $this->setModel(new Application_Model_Category(), "Model_Category");
        $this->_model_login = $this->setModel(new Application_Model_Login(), "Model_Login");

        if (isset($this->_ms->u_id) && $this->_ms->u_id != NULL) {
            $user_data = $this->_model_login->getUserData($this->_ms->u_id);
            if ($user_data != false) {
                foreach ($user_data[0] as $key => $value) {
                    $view_key = 'u_' . $key;
                    if (is_array($value)){
                        foreach ($value as $key_p => $value_p) {
                            $view_key_p = 'u_' . $value_p;
                            $this->view->$view_key_p = 1;
                        }
                    }
                    $this->view->$view_key = $value;
                }
            }
        }
        if ($this->_model_login->getProviderSettings($user_provider, $this->_ms->u_id) == TRUE) {
            $this->view->message_share = $user_provider['result'][0];
        }

        $this->view->googleAuthUrl = TBS\Auth\Adapter\Google::getAuthorizationUrl();
        $this->view->googleAuthUrlOffline = TBS\Auth\Adapter\Google::getAuthorizationUrl(true);
        $this->view->facebookAuthUrl = TBS\Auth\Adapter\Facebook::getAuthorizationUrl();
//        $this->view->twitterAuthUrl = \TBS\Auth\Adapter\Twitter::getAuthorizationUrl();

        if ($this->_model_index->getSetings($settings, NULL) == FALSE) {
            return $this->aso_sendCommand('Wystąpił problem z pobraniem ustawień strony.');
        }
        if (!empty($settings)) {
            for ($x = 0; $x < count($settings); $x++) {
                $this->view->$settings[$x]['type'] = array('data' => $settings[$x]['data'],
                    'additional_settings' => $settings[$x]['additional_settings']);
            }
        }

        if ($this->getModel("Model_Index")->getCategory($getCategory) == FALSE) {
            return $this->aso_sendCommand('Nie znaleniono żdnej kategori', 'denger');
        }
        $this->view->Category = $getCategory;

        $form = new Application_Form_Login();
        $this->view->form = $form;
//            echo '</pre>';
//            exit;

    }

    public function getSession()
    {
        return $this->_ms;
    }

    public function aso_Redirect($where = null)
    {
//        $ms = new Zend_Session_Namespace(SESSION_NAMESPACE);
//        if ($where == null) {
//            $where = array( 'action' => DEF_ACTION__USER,
//                            'controller' => 'error');
//        }
//        $this->_helper->redirector($where['action'], $where['controller']);
    }

    public function aso_sendCommand($command, $message = '', $type = '')
    {
        $this->view->message = $message;
        $this->view->command = $command;
        $this->view->type = $type;
        $msg = $this->messageBox($command, $message, $type);
        $this->_helper->FlashMessenger($msg);
        $this->aso_Redirect();

    }

    public function aso_internalError($r = FALSE)
    {
        $cmd = CMD_INTERNAL_ERROR;
        if ($r === FALSE) $cmd = CMD_INTERNAL_ERROR;
        else if (isset($r['error']) == FALSE) $cmd = CMD_INTERNAL_ERROR;
        else                                    $cmd = $r['error'];
        //header('HTTP/1.0 500 Internal Error');
        return $this->aso_sendCommand($cmd, 'global_popup_db_error', 'error');
    }

    public function setModuleName($module)
    {
        $this->_module = $module;
    }

//
    public function setModel($model, $model_name = 'base_model')
    {
        $this->_model[$model_name] = $model;
        return $this->_model[$model_name];
    }

//
    public function getModel($model_name = 'base_model')
    {
        return $this->_model[$model_name];
    }

//
    public function setLayout($layout)
    {
        $this->_layout = $layout;
    }

//
    public function setLayoutName($name)
    {
        if ($this->_layout != null) {
            $this->_layout->setLayout($name);
        } else {
//            $this->logError("setLayoutName: operation on NULL obj");
        }
    }

//
    public function getLayout()
    {
        return $this->_layout;
    }

//

    public function messageBox($message, $style)
    {
        $array = array("message" => $message,
            "style" => $style);
        return $array;
    }

    public function restrictText($text, $count)
    {
        $countText = strlen($text);
        if ($countText >= $count) {
            $cut = substr($text, 0, $count);
            $restrict = $cut . "...";
        } else {
            $restrict = $text;
        }
        return $restrict;
    }

//    public function getSetings(&$result, $where = null) {
//        if ($where != null) {
//            $where = $this->getAdapter()->quoteInto("type LIKE ?", $where);
//        }else{
//            $where = 1;
//        }
//        $select = $this->_db    ->select()
//            ->from("setings")
//            ->where($where);
//        $result = $this->getAdapter()->fetchAll($select);
//        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
//    }
    public function  implodeFunction($array = null, $separator = null)
    {
        if ($array != null) {

            foreach ($array as $key => $value) {
                $array_result[] = ($value->tag);
            }
            $result = (json_encode($array_result));
            return $result;
        }
    }

    public function curl($url = null, $user = null, $data = null)
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));
        $response = curl_exec($ch);
        curl_close($ch);

        if (!is_array($response)) {
            $error = (json_decode($response, true));
            if (isset($error['error'])) {
                $data = array('code' => $error['error']['code'],
                    'message' => $error['error']['message'],
                    'user_id' => $user_id = $user['id']);
                $this->_model_login->updateProvider($data);
            }
        }
    }
}