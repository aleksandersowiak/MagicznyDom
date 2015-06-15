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
                            $msg = $this->messageBox("Google login failed. <b>".$this->_getParam('error')."</b>","danger");
                        }
                        break;
                }
                // What to do when invalid
                if (isset($result) && !$result->isValid()) {
                    $auth->clearIdentity($this->_getParam('provider'));
                    throw new Zend_Controller_Action_Exception('Login failed');
                } else {
                    if ($auth->hasIdentity()) {
                        $login = new Application_Model_Login();
                        foreach ($auth->getIdentity() as $provider){
                            if ($login->getUserData(null, $provider->getApi()->getProfile()) == TRUE) {
                                $this->getSession()->u_id = $provider->getApi()->getProfile()['id'];
                                $this->getSession()->u_name = $provider->getApi()->getProfile()['name'];
                                $this->getSession()->u_active = 1;
//                                role 0 becouse, google user can not modify pages
                                $this->getSession()->u_role = 0;
                                $msg = $this->messageBox("Zostałeś zalogowany(a) prawidłowo.<br>Używając konta Google", "success");
                            }else{

                                if ($login->getUserData(null, array('email' => $provider->getApi()->getProfile()['email'])) == TRUE) {
                                    $msg = $this->messageBox("Przy próbie zalogowania za pomocą konta Google.<br>Wykryto że adres email<br><b><ul><li>".$provider->getApi()->getProfile()['email']."</li></ul></b><br>jest przypisany do innego konta.", "danger");
                                }else{
                                    if ($login->getUserData($provider->getApi()->getProfile()['id'], array('email' => $provider->getApi()->getProfile()['email'])) == FALSE) {
                                        $login->addNewGoogleUser($provider->getApi()->getProfile());
                                    }
                                    $this->getSession()->u_id = $provider->getApi()->getProfile()['id'];
                                    $this->getSession()->u_name = $provider->getApi()->getProfile()['name'];
                                    $this->getSession()->u_active = 1;
                                    $this->getSession()->u_role = 0;
                                    $msg = $this->messageBox("Zostałeś zalogowany(a) prawidłowo.<br>Używając konta Google", "success");
                                }
                            }
                        }
                        $this->_helper->FlashMessenger($msg);
                        $this->_redirect(($this->getRequest()->getPost('redirurl') != NULL) ? $this->getRequest()->getPost('redirurl') : '/');
                    }
                }

            } elseif ($this->getRequest()->isPost()) {

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
                    $loginRow = $adapter->getResultRowObject(array('id', 'name', 'given_name', 'family_name', 'link', 'picture', 'gender', 'locale', 'active', 'role'));

                    if ($loginRow != false) {
                        if ($loginRow->active == 1) {

                            $this->getSession()->u_id = $loginRow->id;
                            $this->getSession()->u_name = $loginRow->name;
                            $this->getSession()->u_active = $loginRow->active;
                            $this->getSession()->u_role = $loginRow->role;

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
            $this->_redirect(($this->getRequest()->getPost('redirurl') != NULL) ? $this->getRequest()->getPost('redirurl') : '/');
        } catch(exception $e) {
//            $this->logError("indexAction() exception: ".$e->getMessage());
            $this->_helper->FlashMessenger($this->messageBox($e,'danger'));
            $this->redirect('/');
        }
    }

    public function logoutAction() {

        try {
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();

            $msg = $this->messageBox("Zostałeś prawidołwo wylogowany(a).","success");

            \TBS\Auth::getInstance()->clearIdentity();

            unset($this->getSession()->u_id);
            unset($this->getSession()->u_name);
            unset($this->getSession()->u_active);
            unset($this->getSession()->u_role);

            $this->_helper->FlashMessenger($msg);
            $this->_redirect('/');
        } catch(exception $e) {
            $this->_helper->FlashMessenger($this->messageBox($e,'danger'));
            $this->redirect('/');
        }
    }
} 