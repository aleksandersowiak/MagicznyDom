<?php
class IndexController extends Aso_Controller_Action
{
	public function init() {
        parent::init();
        $this->setModel(new Application_Model_Index(), "Model_Index");
    }
 
    public function indexAction()
    {
        try {
        $this->view->ddd = "dupa";


	    return $this->render('index');
        } catch(exception $e) {
            $this->logError("indexAction() exception: ".$e->getMessage());
            return $this->cc_internalError();
        }
    }
}
?>