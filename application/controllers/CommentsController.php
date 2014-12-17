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
        $page = $params['page'];
            if ($this->getModel("Model_Read")->getComments($resultComments,$id, $page)!= FALSE) {
                if ($resultComments['result']) {
                    $this->view->comments = $resultComments['result']['comments'];
                    $this->view->commentsCount = $resultComments['result']['count'];
                }
            }
        $this->_helper->layout()->disableLayout();

        return $this->renderScript('read/commentsSidebar.phtml');
    }

    public function voteAction(){
        $request = $this->getRequest();
        $params = $request->getParams();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();

        if (isset($params['plus'])!=null){
            $id = $params['plus'];
            $parameter = 'plus';
        }elseif (isset($params['minus'])!=null){
            $id = $params['minus'];
            $parameter = 'minus';
        }
        $where = '`id` = '.$id;
        $table = 'comments';

        if ($this->getModel("Model_Read")->updateVote($result, $table, $parameter, $where, $ip = $this->getRequest()->getServer('REMOTE_ADDR'))!=FALSE){
            echo ($result['result'][$parameter]);
        }

    }
}
