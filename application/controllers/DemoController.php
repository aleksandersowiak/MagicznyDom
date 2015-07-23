<?php

class DemoController extends Aso_Controller_Action
{
    public function init()
    {
        parent::init();

    }

    public function indexAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();

        $login = new Application_Model_Login();

        foreach ($login->getUserData() as $user_id) {
            if ($user_id['provider'] == 'facebook' && $user_id['access_token'] != NULL) {

                $post_data = array("access_token" => $user_id['access_token'],
                    "message" => "Witam! Właśnie został dodany nowy przepis do mojej strony. Strona Testowa.",
                    "link" => 'http://markonmt.i8p.eu/MagicznyDom/public',
//                "privacy" => "{'value': 'ALL_FRIENDS'}"
                );
                $fields_string = http_build_query($post_data);
                $url = 'https://graph.facebook.com/' . $user_id['id'] . '/feed?';
                $this->curl($url, $user_id, $fields_string);

            }
        }

    }

}