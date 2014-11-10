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
            if ($this->getModel("Model_Index")->getSetings($result, 'menu')== FALSE) {
                return $this->aso_sendCommand($result['error']);
            }
            $menu = json_decode(($result[0]['data']),true);
            $this->view->menu = $menu;

            $this->renderScript('login_popup.phtml');
	    return $this->render('index');
        } catch(exception $e) {
            $this->logError("indexAction() exception: ".$e->getMessage());
            return $this->aso_internalError();
        }
    }
}
?>