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
                return $this->aso_sendCommand('Menu użytkownika, nie działa prawidłowo.','danger');
            }
                $this->view->menu = json_decode(($resultMenu[0]['data']),true);

            if ($this->getModel("Model_Index")->getRecipe($resultHotIndex, MAX_LIMIT_HOT_INDEX, 'hits', 'DESC')== FALSE) {
                return $this->aso_sendCommand('Menu użytkownika, nie działa prawidłowo.','danger');
            }
                $this->view->hotIndex = $resultHotIndex;

            if ($this->getModel("Model_Index")->getSetings($resultAbout, 'about')== FALSE) {
                return $this->aso_sendCommand('Sekcja "O mnie" nie działa prawidłowo.','danger');
            }
                $this->view->about = json_decode(($resultAbout[0]['data']),true);

            if ($this->getModel("Model_Index")->getRecipe($resultRecipe, MAX_LIMIT_INDEX, 'updated', 'DESC')== FALSE) {
                return $this->aso_sendCommand('Nie pobrano żadnego przepisu','denger');
            }
                $this->view->resultRecipe = $resultRecipe;

            if ($this->getModel("Model_Index")->getCategory($getCategory)== FALSE) {
                return $this->aso_sendCommand('Nie znaleniono żdnej kategori','denger');
            }
                $this->view->getCategory = $getCategory;

            $this->renderScript('login_popup.phtml');

	        return $this->render('index');

        } catch(exception $e) {
            $this->logError("indexAction() exception: ".$e->getMessage());
            return $this->aso_internalError();
        }
    }
}
?>