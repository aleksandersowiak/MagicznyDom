<?php
/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 2014-11-13
 * Time: 09:45
 */

class ReadController extends Aso_Controller_Action
{
    public function init() {
        parent::init();
        $this->setModel(new Application_Model_Read(), "Model_Read");
        $this->setModel(new Application_Model_Index(), "Model_Index");
        $messages = $this->_helper->flashMessenger->getMessages();
        if(!empty($messages))
            $this->_helper->layout->getView()->message = $messages[0];
    }

    public function  indexAction(){
        try {
            $request = $this->getRequest();
            $params = $request->getParams();
            $pass = TRUE;
            if ($this->getModel("Model_Index")->getSetings($resultMenu, 'menu')== FALSE) {
                return $this->aso_sendCommand($resultMenu['error']);
            }
            $this->view->menu = json_decode(($resultMenu[0]['data']),true);

            if ($this->getModel("Model_Read")->getRecipeDetail($resultRecipeDetail, $params['id'])== FALSE) {
                return $this->aso_sendCommand('Nie znaleziono artykułu spełniającego podane kryteria.','danger');
            }

            $this->view->title = $resultRecipeDetail[0]['title'];
            $this->view->autor = $resultRecipeDetail[0]['autor'];
            $this->view->updated = $resultRecipeDetail[0]['updated'];
            $this->view->recipe = $resultRecipeDetail[0]['recipe'];
            $this->renderScript('login_popup.phtml');
            return $this->render('index');
        } catch(exception $e) {
            $this->logError("indexAction() exception: ".$e->getMessage());
            return $this->aso_internalError();
        }
    }
} 