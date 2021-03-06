<?php

/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 2014-11-13
 * Time: 09:45
 */
class ReadController extends Aso_Controller_Action
{
    public function init()
    {
        parent::init();
    }

    /**
     *
     */
    public function  indexAction()
    {
        try {
            $request = $this->getRequest();
            $params = $request->getParams();
            $id = $params['id'];

            if ($this->getModel("Model_Read")->getRecipeDetail($resultRecipeDetail, $id, null) == FALSE) {
                $this->_helper->redirector('index', 'category');
                $this->aso_sendCommand('Wybrany link jest uszkodzony, i zawartość nie może zostać wyświetlona..', 'warning');
            }

            $this->view->title = $resultRecipeDetail[0]['title'];
            $this->view->autor = $resultRecipeDetail[0]['autor'];
            $this->view->updated = $resultRecipeDetail[0]['updated'];
            $this->view->recipe = $resultRecipeDetail[0]['recipe'];

            if (!empty($resultRecipeDetail['tagList'])) $this->view->tags = $resultRecipeDetail['tagList'];

            if ($this->getModel("Model_Read")->getRecipeDetail($resultNext, $id, "<") != FALSE) {
                if ($resultNext) $this->view->nextRecipe = $resultNext[0]['title'];
            }

            if ($this->getModel("Model_Read")->getRecipeDetail($resultPrev, $id, ">") != FALSE) {
                if ($resultPrev) $this->view->prevRecipe = $resultPrev[0]['title'];
            }

            if ($this->getModel("Model_Read")->getCountComments($resultCount, $params['id']) != FALSE) {
                $this->view->commentsCount = $resultCount['result'][0]['comments_count'];
                $this->view->per_page = $resultCount['result']['per_page'];
            }

            $this->view->issCommentToAdd = true;
            $this->view->render('sidebar.phtml');
            $this->view->render('navigation/read-navigation.phtml');

            return $this->render('index');

        } catch (exception $e) {
            $this->_helper->FlashMessenger($this->messageBox($e, 'danger'));
            $this->redirect('/');
        }
    }

} 