<?php
/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 2014-11-10
 * Time: 08:28
 */

class LoginController extends Aso_Controller_Action
{
    public function init() {
        parent::init();
    }
    public function indexAction(){
        try {

            $auth = Zend_Auth::getInstance();
            $db = $this->_getParam('db');
            $msg = null;

            if ($this->getRequest()->isPost()) {
                if (($this->getRequest()->getPost('email') != '') || ($this->getRequest()->getPost('password') != '')) {
                    $adapter = new Zend_Auth_Adapter_DbTable(
                        $db,
                        'user',
                        'email',
                        'password',
                        "SHA1(CONCAT('" . DB_USER_PASSWORD_STATIC_SALT . "',?))"
                    );
                    $adapter->setIdentity($this->getRequest()->getPost('email'));
                    $adapter->setCredential($this->getRequest()->getPost('password'));
                    $result = $auth->authenticate($adapter);
                    $loginRow = $adapter->getResultRowObject(array('id', 'active', 'name'));

                    if ($loginRow != false) {
                        if ($loginRow->active == 1) {
                            $ms = new Zend_Session_Namespace(SESSION_NAMESPACE);
                            $ms->u_id = $loginRow->id;
                            $ms->u_name = $loginRow->name;
                            $ms->u_role = 1;
                            $ms->u_use_id = $loginRow->id;
                            $msg = $this->messageBox("Zostałeś zalogowany(a) prawidłowo.", "success");
                        }else {
                            $msg = $this->messageBox("Podany użytkownik nie został aktywowany. Skontaktuj się z administratorem w celu dokończenia aktywacji konta. <a href=\"mailto:aleksander.sowiak@gmail.com\">Pod tym adresem email</a>", "warning");
                        }
                    }else {
                        $msg = $this->messageBox("Uzytkownik nie istnieje. Bądź podane dane są nie prawidłowe.","danger");
                    }
                }
            }
            $this->_helper->FlashMessenger($msg);
            $this->_helper->redirector->gotoRoute(array(
                'controller'=> 'index',
                'action' =>'index'));
        } catch(exception $e) {
            $this->logError("indexAction() exception: ".$e->getMessage());
            return $this->aso_internalError();
        }
    }

    public function logoutAction() {

        try {
            $ms = new Zend_Session_Namespace(SESSION_NAMESPACE);
            $msg = $this->messageBox("Zostałeś prawidołwo wylogowany(a).","success");
            unset($ms->u_id);
            unset($ms->u_name);
            unset($ms->u_role);
            unset($ms->u_use_id);
            $this->_helper->FlashMessenger($msg);
            $this->_redirect('/');
        } catch(exception $e) {
            $this->logError("logoutAction() exception: ".$e->getMessage());
            return $this->cc_internalError();
        }
    }
} 