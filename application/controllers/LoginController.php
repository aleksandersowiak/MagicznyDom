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

                            $this->getSession()->u_id = $provider->getApi()->getProfile()['id'];
                            $this->getSession()->u_name = $provider->getApi()->getProfile()['name'];
                            $this->getSession()->u_given_name = $provider->getApi()->getProfile()['given_name'];
                            $this->getSession()->u_family_name = $provider->getApi()->getProfile()['family_name'];
                            $this->getSession()->u_link = $provider->getApi()->getProfile()['link'];
                            $this->getSession()->u_picture = $provider->getApi()->getProfile()['picture'];
                            $this->getSession()->u_gender = $provider->getApi()->getProfile()['gender'];
                            $this->getSession()->u_locale = $provider->getApi()->getProfile()['locale'];
                            $this->getSession()->u_active = 1;
                            $this->getSession()->u_role = 0;

                            $login = new Application_Model_Login();
                            if ($login->checkLogin($provider->getApi()->getProfile()['id']) == FALSE){
                                $login->addNewGoogleUser($provider->getApi()->getProfile());
                            }
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
                    $loginRow = $adapter->getResultRowObject(array('id', 'name', 'given_name', 'family_name', 'link', 'picture', 'gender', 'locale', 'active', 'role'));

                    if ($loginRow != false) {
                        if ($loginRow->active == 1) {

                            $this->getSession()->u_id = $loginRow->id;
                            $this->getSession()->u_name = $loginRow->name;
                            $this->getSession()->u_given_name = $loginRow->given_name;
                            $this->getSession()->u_family_name = $loginRow->family_name;
                            $this->getSession()->u_link = $loginRow->link;
                            $this->getSession()->u_picture = $loginRow->picture;
                            $this->getSession()->u_gender = $loginRow->gender;
                            $this->getSession()->u_locale = $loginRow->locale;
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
            $this->_helper->redirector->gotoRoute(array(
                'controller'=> 'index',
                'action' =>'index'));
        } catch(exception $e) {
//            $this->logError("indexAction() exception: ".$e->getMessage());
            $this->_helper->FlashMessenger($this->messageBox($e,'denger'));
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
            unset($this->getSession()->u_given_name);
            unset($this->getSession()->u_family_name);
            unset($this->getSession()->u_link);
            unset($this->getSession()->u_picture);
            unset($this->getSession()->u_gender);
            unset($this->getSession()->u_locale);
            unset($this->getSession()->u_active);
            unset($this->getSession()->u_role);
            unset($this->getSession()->u_id);
            unset($this->getSession()->u_name);
            unset($this->getSession()->u_given_name);

            $this->_helper->FlashMessenger($msg);
            $this->_redirect('/');
        } catch(exception $e) {
//            $this->logError("logoutAction() exception: ".$e->getMessage());
            return $this->aso_internalError();
        }
    }
} 