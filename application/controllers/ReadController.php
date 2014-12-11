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
    }

    /**
     *
     */
    public function  indexAction(){
        try {
            $request = $this->getRequest();
            $params = $request->getParams();
            $pass = TRUE;
            $id = $params['id'];
            if ($this->getModel("Model_Index")->getSetings($resultMenu, 'menu')== FALSE) {
                return $this->aso_sendCommand($resultMenu['error']);
            }
            $this->view->menu = json_decode(($resultMenu[0]['data']),true);

            if ($this->getModel("Model_Read")->getRecipeDetail($resultRecipeDetail,$id , null)== FALSE) {
                return $this->aso_sendCommand('Wybrany link jest uszkodzony, i zawartość nie może zostać wyświetlona..','warning');
            }

            $this->view->title      = $resultRecipeDetail[0]['title'];
            $this->view->autor      = $resultRecipeDetail[0]['autor'];
            $this->view->updated    = $resultRecipeDetail[0]['updated'];
            $this->view->recipe     = $resultRecipeDetail[0]['recipe'];
            $tags                   = json_decode($resultRecipeDetail[0]['tags']);
            $this->view->tags       = $this->implodeFunction($tags, ',');
            $this->view->comments   = $resultRecipeDetail[0]['comment'];


            if ($this->getModel("Model_Read")->getRecipeDetail($resultNext, $id, "<")!= FALSE) {
                if ($resultNext) $this->view->nextRecipe = $resultNext[0]['title'];
            }
            if ($this->getModel("Model_Read")->getRecipeDetail($resultPrev, $id, ">")!= FALSE) {
                if ($resultPrev) $this->view->prevRecipe = $resultPrev[0]['title'];
            }

            return $this->render('index');
        } catch(exception $e) {
            $this->logError("indexAction() exception: ".$e->getMessage());
            return $this->aso_internalError();
        }
    }
} 