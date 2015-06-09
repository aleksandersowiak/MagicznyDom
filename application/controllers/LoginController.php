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

            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();

            $db = $this->_getParam('db');
            $msg = null;

            $auth = TBS\Auth::getInstance();

            $providers = $auth->getIdentity();

            // Here the response of the providers are registered
            if ($this->_hasParam('provider')) {
                $provider = $this->_getParam('provider');

                switch ($provider) {
                    case "facebook":
                        if ($this->_hasParam('code')) {
                            $adapter = new TBS\Auth\Adapter\Facebook(
                                $this->_getParam('code'));
                            $result = $auth->authenticate($adapter);
                        }
                        if($this->_hasParam('error')) {
                            throw new Zend_Controller_Action_Exception('Facebook login failed, response is: ' .
                                $this->_getParam('error'));
                        }
                        break;
                    case "twitter":
                        if ($this->_hasParam('oauth_token')) {
                            $adapter = new TBS\Auth\Adapter\Twitter($_GET);
                            $result = $auth->authenticate($adapter);
                        }
                        break;
                    case "google":

                        if ($this->_hasParam('code')) {
                            $adapter = new TBS\Auth\Adapter\Google(
                                $this->_getParam('code'));
                            $result = $auth->authenticate($adapter);
                            $msg = $this->messageBox("Zostałeś prawidołwo zalogowany(a). Używając konta Google.","success");
                        }
                        if($this->_hasParam('error')) {
                            throw new Zend_Controller_Action_Exception('Google login failed, response is: ' .
                                $this->_getParam('error'));
                            $msg = $this->messageBox("Google login failed.","danger");
                        }
                        break;

                }
                // What to do when invalid
                if (isset($result) && !$result->isValid()) {
                    $auth->clearIdentity($this->_getParam('provider'));
                    throw new Zend_Controller_Action_Exception('Login failed');
                } else {
                    if ($auth->hasIdentity()) {
                        foreach ($auth->getIdentity() as $provider){
                            $ms = new Zend_Session_Namespace(SESSION_NAMESPACE);
                            $ms->u_id = $provider->getApi()->getProfile()['id'];
                            $ms->u_name = $provider->getApi()->getProfile()['name'];
                            $ms->u_role = 0;
                            $ms->u_use_id = $provider->getApi()->getProfile()['id'];
                        }
                    }
                    $this->_helper->FlashMessenger($msg);
                    $this->_redirect('/');
                }
            } else { // Normal login page
                $this->view->googleAuthUrl = TBS\Auth\Adapter\Google::getAuthorizationUrl();
                $this->view->googleAuthUrlOffline = TBS\Auth\Adapter\Google::getAuthorizationUrl(true);
//                $this->view->facebookAuthUrl = TBS\Auth\Adapter\Facebook::getAuthorizationUrl();
//                $this->view->twitterAuthUrl = \TBS\Auth\Adapter\Twitter::getAuthorizationUrl();
            }
            if ($this->getRequest()->isPost()) {

                if (($this->getRequest()->getPost('email') != '') || ($this->getRequest()->getPost('password') != '')) {
                    $auth = Zend_Auth::getInstance();
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
//            $this->logError("indexAction() exception: ".$e->getMessage());
            return $this->aso_internalError();
        }
    }

    public function logoutAction() {

        try {
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();
            $ms = new Zend_Session_Namespace(SESSION_NAMESPACE);
            $msg = $this->messageBox("Zostałeś prawidołwo wylogowany(a).","success");

            \TBS\Auth::getInstance()->clearIdentity();

            unset($ms->u_id);
            unset($ms->u_name);
            unset($ms->u_role);
            unset($ms->u_use_id);

            $this->_helper->FlashMessenger($msg);
            $this->_redirect('/');
        } catch(exception $e) {
//            $this->logError("logoutAction() exception: ".$e->getMessage());
            return $this->aso_internalError();
        }
    }
} 