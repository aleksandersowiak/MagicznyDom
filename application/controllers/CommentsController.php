<?php
class CommentsController extends Aso_Controller_Action {
    public function init() {
        parent::init();
    }
    public function indexAction() {
        return $this->render('index');
    }
    public function getcommentsAction(){
        $request = $this->getRequest();
        $params = $request->getParams();
        $id = $params['id'];
        $offset = $params['offset'];
            if ($this->getModel("Model_Read")->getComments($resultComments,$id, $offset)!= FALSE) {
                if ($resultComments['result']) {
                    $this->view->comments = $resultComments['result']['comments'];
                    $this->view->commentsCount = $resultComments['result']['count'];
                }
            }
        $this->_helper->layout()->disableLayout();

        return $this->renderScript('read/commentsSidebar.phtml');

    }
}
