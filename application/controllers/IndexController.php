<?php
class IndexController extends Aso_Controller_Action
{
	public function init() {
        parent::init();
        $this->setModel(new Application_Model_Index(), "Model_Index");
        $messages = $this->_helper->flashMessenger->getMessages();
        if(!empty($messages))
            $this->_helper->layout->getView()->message = $messages[0];
    }
 
    public function indexAction()
    {
        try {
            if ($this->getModel("Model_Index")->getSetings($resultMenu, 'menu')== FALSE) {
                return $this->aso_sendCommand($resultMenu['error']);
            }
            $this->view->menu = json_decode(($resultMenu[0]['data']),true);

            if ($this->getModel("Model_Index")->getSetings($resultAbout, 'about')== FALSE) {
                return $this->aso_sendCommand($resultAbout['error']);
            }
            $this->view->about = json_decode(($resultAbout[0]['data']),true);

            if ($this->getModel("Model_Index")->getRecipe($resultRecipe)== FALSE) {
                return $this->aso_sendCommand($resultRecipe['error']);
            }
            $this->view->resultRecipe = $resultRecipe;

            $this->renderScript('login_popup.phtml');
	    return $this->render('index');
        } catch(exception $e) {
            $this->logError("indexAction() exception: ".$e->getMessage());
            return $this->aso_internalError();
        }
    }
}
?>