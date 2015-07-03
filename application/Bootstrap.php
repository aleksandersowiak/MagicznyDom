<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initSession() {
        $session = $this->getPluginResource('session');

        Zend_Session::start();
        error_reporting(E_ALL);
    }

    protected function _initConstants() {
        require_once(APPLICATION_PATH ."/configs/constants.php");
    }

    protected function _initConfig()
    {
        Zend_Registry::set('config', $this->getOptions());
    }

    protected function _initRoutes()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $router->addRoute('Index', new Zend_Controller_Router_Route('/page/:page', array(
                'controller' => 'Index',
                'action' => 'index'
            )
        ));
        $router->addRoute('readRecipe', new Zend_Controller_Router_Route('/read/:id', array(
                'controller' => 'Read',
                'action' => 'index'
            )
        ));
	    $router->addRoute('viewCategory', new Zend_Controller_Router_Route('/category/:id', array(
                'controller' => 'Category',
                'action' => 'view'
			)
		));
        $router->addRoute('viewByTag', new Zend_Controller_Router_Route('/category/byTag/:tag', array(
                'controller' => 'Category',
                'action' => 'byTag'
            )
        ));
        $router->addRoute('about', new Zend_Controller_Router_Route('/about', array(
                'controller' => 'Index',
                'action' => 'about'
            )
        ));
        $router->addRoute('page', new Zend_Controller_Router_Route('/id/:id/offset/:offset', array(
                'controller' => 'Comments',
                'action' => 'getComments'
            )
        ));
        $router->addRoute('provider', new Zend_Controller_Router_Route('/login/provider/:value', array(
                'controller' => 'login',
                'action' => 'provider'
            )
        ));
//        $router->addRoute('turnOffSetting', new Zend_Controller_Router_Route('/:app', array(
//                'controller' => 'Index',
//                'action' => 'index'
//            )
//        ));

        $route = new Zend_Controller_Router_Route('login/:provider',
            array(
                'controller' => 'login',
                'action' => 'index'
            ));
        $router->addRoute('login/:provider', $route);

        $route = new Zend_Controller_Router_Route_Static('public/login',
            array(
                'controller' => 'login',
                'action' => 'index'
            ));
        $router->addRoute('login', $route);

        $route = new Zend_Controller_Router_Route_Static('login/logout',
            array(
                'controller' => 'login',
                'action' => 'logout'
            ));
        $router->addRoute('logout', $route);
    }
    protected function _initPlaceholders() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');

        $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', APPLICATION_ENV);
        if($config->head->css->compress == true) {
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/bootstrap-wyswig-editor.css');
            $view->headLink()->prependStylesheet('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/js/external/google-code-prettify/prettify.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/bootstrap.min.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/aso.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/bootstrap-tokenfield.min.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/tokenfield-typeahead.min.css');
            $view->headLink()->prependStylesheet("//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
        } else {
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/bootstrap-wyswig-editor.css');
            $view->headLink()->prependStylesheet('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/js/external/google-code-prettify/prettify.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/bootstrap.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/summernote.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/aso.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/bootstrap-tokenfield.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/tokenfield-typeahead.css');
            $view->headLink()->prependStylesheet("//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
        }

        $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/style_ie6.css', 'screen', 'IE 6');

        // set the initial javascript files
        if($config->head->js->compress == true) {
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/bootstrap.min.js','text/javascript');
            $view->headScript()->appendFile('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');
            $view->headScript()->appendFile('//code.jquery.com/ui/1.10.3/jquery-ui.js');
            $view->headScript()->appendFile('https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js','text/javascript');
            $view->headScript()->appendFile('http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/external/jquery.hotkeys.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/external/google-code-prettify/prettify.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/summernote.min.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/bootstrap-tokenfield.min.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/jquery.easy-paging.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/scripts.min.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/jquery.easy-paging.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/jquery.paging.min.js','text/javascript');
        } else {
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/bootstrap.js','text/javascript');
            $view->headScript()->appendFile('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js');
            $view->headScript()->appendFile('//code.jquery.com/ui/1.10.3/jquery-ui.js');
            $view->headScript()->appendFile('https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.js','text/javascript');
            $view->headScript()->appendFile('http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/external/jquery.hotkeys.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/external/google-code-prettify/prettify.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/summernote.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/bootstrap-tokenfield.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/jquery.easy-paging.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/jquery.paging.js','text/javascript');
        }

        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8');

    }

    protected function _initViewHelperPaths()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->addHelperPath(APPLICATION_PATH . '/views/helpers', 'Zend_View_Helper_');

        $view = new Zend_View();
        $view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
    }

    protected function _initSidebar()
    {
        $this->bootstrap('View');
        $view = $this->getResource('View');

        $view->placeholder('sidebar')
            ->setPrefix("<div class=\"col-sm-4\">")

            ->setPostfix("</div>\n</div>");
    }

    protected function _initHotIndex()
    {
        $this->bootstrap('View');
        $view = $this->getResource('View');

        $view->placeholder('hotIndex');
    }

    protected function _initNavigation()
    {
        $this->bootstrap('View');
        $view = $this->getResource('View');
        $view->placeholder('navigation');
    }
}
?>