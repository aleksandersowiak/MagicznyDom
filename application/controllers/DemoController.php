<?php
class DemoController extends Aso_Controller_Action
{
    public function init() {
        parent::init();

    }

    public function indexAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $post_data = array();
        $login = new Application_Model_Login();
//        $url = new Zend_Controller_Front();
        foreach ($login->getUserData() as $user_id){
            if ($user_id['provider'] == 'facebook' && $user_id['access_token'] != NULL) {

                $post_data =  array("access_token" => $user_id['access_token'],
                "message" => iconv("ISO-8859-2","UTF-8","Witam! Właśnie został dodany nowy przepis do mojej strony. Strona Testowa."),
                "link" => 'http://markonmt.i8p.eu/MagicznyDom/public',
                "privacy" => "{'value': 'ALL_FRIENDS'}");
                $fields_string = http_build_query($post_data);
echo 'https://graph.facebook.com/'.$user_id['id'].'/feed?'.$fields_string;
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL            => 'https://graph.facebook.com/'.$user_id['id'].'/feed?',
                    CURLOPT_HEADER			=> 0,
                    CURLOPT_POST			=>1,
                    CURLOPT_POSTFIELDS 		=> $fields_string,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_FOLLOWLOCATION => 1,
                    CURLOPT_VERBOSE        => 1,
                    CURLOPT_SSL_VERIFYHOST=> 0,
                    CURLOPT_SSL_VERIFYPEER=> 0,
                ));
                $response = curl_exec($ch);
                curl_close($ch);

                var_dump($response);
            }
        }
//        var_dump($login->getUserData());
    }
}