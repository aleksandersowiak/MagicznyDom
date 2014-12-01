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
            $request = $this->getRequest();
            $params = $request->getParams();

            if ($this->getModel("Model_Index")->getCount($count) == FALSE) {
                return $this->aso_sendCommand('Nie pobrano żadnego przepisu','denger');
            }

            if(isset($params['page']) != null) {
                $page = $params['page'] ;
                $offset = MAX_LIMIT_INDEX  * $page ;
            }else{
                $page = 0;
                $offset = 0;
            }
            $left_rec = $count[0]['count'] - ($page * MAX_LIMIT_INDEX);
            $this->view->page = $page;
            $this->view->count = $left_rec;
            if (($page * MAX_LIMIT_INDEX) > $count[0]['count']) {
                return $this->aso_sendCommand('Coś się zepsuło, albo przekąbinowałeś.','danger');
            }
//            var_dump($dd);


            if ($this->getModel("Model_Index")->getRecipe($resultHotIndex, 0, MAX_LIMIT_HOT_INDEX, 'hits', 'DESC')== FALSE) {
                return $this->aso_sendCommand('Menu użytkownika, nie działa prawidłowo.','danger');
            }
                $this->view->hotIndex = $resultHotIndex;

            if ($this->getModel("Model_Index")->getRecipe($resultRecipe, $offset, MAX_LIMIT_INDEX, 'updated', 'DESC')== FALSE) {
                return $this->aso_sendCommand('Nie pobrano żadnego przepisu','denger');
            }
                $this->view->Recipes = $resultRecipe;
            if ($this->getModel("Model_Index")->getCategory($getCategory)== FALSE) {
                return $this->aso_sendCommand('Nie znaleniono żdnej kategori','denger');
            }
                $this->view->Category = $getCategory;
	        return $this->render('index');
        } catch(exception $e) {
            $this->logError("indexAction() exception: ".$e->getMessage());
            return $this->aso_internalError();
        }
    }
}
?>