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
            $this->aso_sendCommand('Nie można wyświetlić wybranej kategorii, ponieważ takowa nie istnieje.', 'warning');
            $this->_helper->redirector('index','category');
        }

        $this->view->SelectedCategory = $resultCategories;
    }

    public function bytagAction(){
        $request = $this->getRequest();
        $params = $request->getParams();

        if ($this->getModel("Model_Category")->getRecipesFromTags($resultTag, $params['tag'])== FALSE) {
            $this->_helper->redirector('index','category');
            $this->aso_sendCommand('Nie można wyświetlić wybranej kategorii, ponieważ takowa nie istnieje.', 'warning');
        }
        if (empty($resultTag)){
            $this->aso_sendCommand('Podane nazwy tagów nie pasują do zapisanych.', 'warning');
            $this->_helper->redirector('index','category');
        }else{
            $this->view->SelectedTag = $resultTag;
        }

        if ($this->getModel("Model_Category")->getTags($resultTags, $params['tag']) == FALSE) {
            $this->_helper->redirector('index','category');
            $this->aso_sendCommand('Coś poszło nie tak z wypisaniem tagów.', 'warning');
        }
            $this->view->getTags = $resultTags;
    }
} 