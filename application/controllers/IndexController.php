<?php

class IndexController extends Aso_Controller_Action
{
    public function init()
    {
        parent::init();

    }

    public function indexAction()
    {
        try {
            $request = $this->getRequest();
            $params = $request->getParams();

            if ($this->getModel("Model_Index")->getCount($count) == FALSE) {
                return $this->aso_sendCommand('Nie pobrano żadnego przepisu', 'denger');
            }

            define('MAX_LIMIT', ((!empty($count['max_limit'][0]['data']) != NULL) ? $count['max_limit'][0]['data'] : MAX_LIMIT_INDEX));

            if (isset($params['page']) != NULL) {
                $page = $params['page'];
                $offset = MAX_LIMIT * $page;
            } else {
                $page = 0;
                $offset = 0;
            }

            if (!empty($count[0])) {
                $left_rec = $count[0]['count'] - ($page * MAX_LIMIT);
                $this->view->page = $page;
                $this->view->count = $left_rec;

                if (($page * MAX_LIMIT) > $count[0]['count']) {
                    return $this->aso_sendCommand('Coś się zepsuło, albo przekombinowałeś.', 'warning');
                }
            }

            if ($this->getModel("Model_Index")->getRecipe($resultHotIndex, 0, MAX_LIMIT_HOT_INDEX, 'hits', 'DESC') == FALSE) {
                return $this->aso_sendCommand('Menu użytkownika, nie działa prawidłowo.', 'danger');
            }
            $this->view->hotIndex = $resultHotIndex;

            if ($this->getModel("Model_Index")->getRecipe($resultRecipe, $offset, MAX_LIMIT, 'updated', 'DESC') == FALSE) {
                return $this->aso_sendCommand('Nie pobrano żadnego przepisu', 'denger');
            }
            $this->view->Recipes = $resultRecipe;
            $this->view->render('index/hotIndex.phtml');
            $this->view->render('sidebar.phtml');
            $this->view->render('navigation/index-navigation.phtml');
            return $this->render('index');

        } catch (exception $e) {
            $this->_helper->FlashMessenger($this->messageBox($e, 'danger'));
            $this->redirect('/');
        }
    }

    public function aboutAction()
    {
        if ($this->view->about != FALSE) {
            return $this->renderScript('about/index.phtml');
        } else {
            $this->_redirect('/');
        }
    }

    public function turnOffSettingAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = $request->getParams();
        $app = $params['app'];
        if ($this->getModel("Model_Index")->turnedOffApp($resultRecipe, $app) == FALSE) {
            return $this->aso_sendCommand('Coś poszło nie tak!', 'denger');
        }
        $this->aso_sendCommand("Wystąpił błąd przy sprawdzaniu ustawień aplikacji $app.</br>Jeżli problem będzie się powtarzał.</br>Skontaktuj się z administratorem strony.", "danger");
        $this->_helper->redirector->gotoRoute(array(
            'controller' => 'index',
            'action' => 'index'));
    }
}

?>