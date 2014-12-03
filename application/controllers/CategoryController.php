<?php
/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 2014-11-28
 * Time: 12:09
 */

class CategoryController extends Aso_Controller_Action {
    public function init() {
        parent::init();
    }
    public function indexAction() {
         return $this->render('index');
    }
    public function viewAction(){
        $request = $this->getRequest();
        $params = $request->getParams();

        if ($this->getModel("Model_Category")->getRecipesFromCategory($resultCategories, $params['id'])== FALSE) {
            return $this->aso_sendCommand('Nie można wyświetlić wybranej kategorii, ponieważ takowa nie istnieje.', 'warning');
        }
        $this->view->SelectedCategory = $resultCategories;
        return $this->renderScript('category/viewCategory.phtml');
    }
} 