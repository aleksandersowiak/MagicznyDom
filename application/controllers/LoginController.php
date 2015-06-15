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
            $dataProvider =null;
            $auth = TBS\Auth::getInstance();

            $providers = $auth->getIdentity();

            // Here the response of the providers are registered
            if ($this->_hasParam('provider')) {
                $providerParam = $this->_getParam('provider');

                switch ($providerParam) {
                    case "facebook":
                        if ($this->_hasParam('code')) {
                            $adapter = new TBS\Auth\Adapter\Facebook(
                                $this->_getParam('code'));
                            $result = $auth->authenticate($adapter);

                        }
                        if($this->_hasParam('error')) {
                            $msg = $this->messageBox("$providerParam login failed. <b>".$this->_getParam('error')."</b>","danger");
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

                        }
                        if($this->_hasParam('error')) {
                            $msg = $this->messageBox("$providerParam login failed. <b>".$this->_getParam('error')."</b>","danger");
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

                        foreach ($auth->getIdentity() as $provider) {

                            $dataProvider = $provider->getApi()->getProfile();
                            $dataProvider['provider'] = $providerParam;
                            if ($providerParam == "facebook") {

                                    $dataProvider = $this->change_key($dataProvider, "first_name", "given_name");
                                    $dataProvider = $this->change_key($dataProvider, "last_name", "family_name");
                                    $dataProvider = $this->change_key($dataProvider, "verified", "verified_email");
                                    $dataProvider["picture"] = "http://graph.facebook.com/".$dataProvider['id']."/picture?type=large";
                            }

                            if ($login->getUserData(null, $dataProvider) == TRUE) {
                                $this->getSession()->u_id = $dataProvider['id'];
                                $this->getSession()->u_name = $$dataProvider['name'];
                                $this->getSession()->u_active = 1;
//                                role 0 becouse, google user can not modify pages
                                $this->getSession()->u_role = 0;
                                $msg = $this->messageBox("Zostałeś zalogowany(a) prawidłowo.<br>Używając konta <b>$providerParam</b>", "success");
                            }else{

                                if ($login->getUserData(null, array('email' => $dataProvider['email'])) == TRUE) {
                                    $msg = $this->messageBox("Przy próbie zalogowania za pomocą konta <b>$providerParam</b>.<br>Wykryto że adres email<br><b><ul><li>".$dataProvider['email']."</li></ul></b><br>jest przypisany do innego konta.", "danger");
                                }else{
                                    if ($login->getUserData($dataProvider['id'], array('email' => $dataProvider['email'])) == FALSE) {
                                        $login->addNewSocialNetworkUser($dataProvider);
                                    }
                                    $this->getSession()->u_id = $dataProvider['id'];
                                    $this->getSession()->u_name = $dataProvider['name'];
                                    $this->getSession()->u_active = 1;
                                    $this->getSession()->u_role = 0;
                                    $msg = $this->messageBox("Zostałeś zalogowany(a) prawidłowo.<br>Używając konta <b>$providerParam</b>", "success");
                                }
                            }
                        }
                        $this->_helper->FlashMessenger($msg);
                        $dataProvider = null;
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

    public function change_key( $array, $old_key, $new_key) {

        if( ! array_key_exists( $old_key, $array ) )
            return $array;

        $keys = array_keys( $array );
        $keys[ array_search( $old_key, $keys ) ] = $new_key;

        return array_combine( $keys, $array );
    }
} 