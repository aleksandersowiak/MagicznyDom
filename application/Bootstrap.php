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

    protected function _initRoutes()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $router->addRoute('readRecipe', new Zend_Controller_Router_Route('/read/:id', array(
                'controller' => 'Read',
                'action' => 'index'
            )
        ));
        $router->addRoute('page', new Zend_Controller_Router_Route('/page/:page', array(
                'controller' => 'Index',
                'action' => 'index'
            )
        ));
	    $router->addRoute('viewCategory', new Zend_Controller_Router_Route('/category/:id', array(
                'controller' => 'Category',
                'action' => 'view'
			)
		));
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
        } else {
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/bootstrap-wyswig-editor.css');
            $view->headLink()->prependStylesheet('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/js/external/google-code-prettify/prettify.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/bootstrap.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/summernote.css');
            $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/aso.css');
        }

        $view->headLink()->prependStylesheet(WEB_ROOT_PATH.'/css/style_ie6.css', 'screen', 'IE 6');

        // set the initial javascript files
        if($config->head->js->compress == true) {
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/bootstrap.min.js','text/javascript');
            $view->headScript()->appendFile('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js','text/javascript');
            $view->headScript()->appendFile('https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js','text/javascript');
            $view->headScript()->appendFile('https://oss.maxcdn.com/respond/1.4.2/respond.min.js','text/javascript');
            $view->headScript()->appendFile('http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/external/jquery.hotkeys.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/external/google-code-prettify/prettify.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/summernote.min.js','text/javascript');
//            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/wysiwyg-keys.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/scripts.min.js','text/javascript');
        } else {
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/bootstrap.js','text/javascript');
            $view->headScript()->appendFile('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js','text/javascript');
            $view->headScript()->appendFile('https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.js','text/javascript');
            $view->headScript()->appendFile('https://oss.maxcdn.com/respond/1.4.2/respond.js','text/javascript');
            $view->headScript()->appendFile('http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/external/jquery.hotkeys.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/external/google-code-prettify/prettify.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/summernote.js','text/javascript');
//            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/wysiwyg-keys.js','text/javascript');
            $view->headScript()->appendFile(WEB_ROOT_PATH.'/js/scripts.js','text/javascript');
        }

        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8');

    }

    protected function _initViewHelperPaths()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->addHelperPath(APPLICATION_PATH . '/views/helpers', 'Zend_View_Helper_');
    }
}
?>