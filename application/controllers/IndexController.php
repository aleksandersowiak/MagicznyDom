<?php
class IndexController extends Aso_Controller_Action
{
	public function init() {
        parent::init();
    }
 
    public function indexAction()
    {
        try {
            if ($this->getModel("Model_Index")->getRecipe($resultHotIndex, MAX_LIMIT_HOT_INDEX, 'hits', 'DESC')== FALSE) {
                return $this->aso_sendCommand('Menu użytkownika, nie działa prawidłowo.','danger');
            }
                $this->view->hotIndex = $resultHotIndex;
            if ($this->getModel("Model_Index")->getRecipe($resultRecipe, MAX_LIMIT_INDEX, 'updated', 'DESC')== FALSE) {
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