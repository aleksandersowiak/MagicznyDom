<?php
class CommentsController extends Aso_Controller_Action {
    public function init() {
        parent::init();
    }
    public function indexAction() {
        return $this->_helper->viewRenderer->setNoRender(true);
//        return $this->render('index');
    }
    public function getcommentsAction(){
        $request = $this->getRequest();
        $params = $request->getParams();
        $id = $params['id'];
        $page = $params['page'];
            if ($this->getModel('Model_Read')->getComments($resultComments,$id, $page)!= FALSE) {
                if ($resultComments['result']) {
                    $this->view->comments = $resultComments['result']['comments'];
                    $this->view->commentsCount = $resultComments['result']['count'][0]['comments_count'];
                }
            }
        $this->view->issCommentToAdd = true;
        $this->_helper->layout()->disableLayout();
    }

    public function getCommentAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = $request->getParams();
        $id = $params['id'];
        if ($this->getModel('Model_Read')->getCommentData($resultComments,$id)!= FALSE) {
            $regex = '#<img([^>]*) src="([^"/]*/?[^".]*\.[^"]*)"([^>]*)>((?!</a>))#';
            $replace = '<a rel="group" class="fancybox fancy" title="" href="$2">$2</a>';
            $ret = preg_replace($regex, $replace, $resultComments['result'][0]['comment']);
            echo ($ret);
        }
        $this->_helper->layout()->disableLayout();
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

        if ($this->getModel('Model_Read')->updateVote($result, $table, $parameter, $where, $ip = $this->getRequest()->getServer('REMOTE_ADDR'))!=FALSE){
            echo ($result['result'][$parameter]);
        }

    }

    public function addcommentAction(){
        try{
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();

            $request = $this->getRequest();
            $params = $request->getParams();

            $data = array('userName' => $params['name'],
            'comment' => $params['message'],
            'id_recipe' => $params['id'],
            'user_id' => $this->getSession()->u_id);

            if ($this->getModel('Model_Read')->insertComment($return, $data)==FALSE){
                $this->_helper->redirector('index','index');
                $this->aso_sendCommand('Dodanie nowego komentarza nie powiodło się, błąd...','danger');
            }
        } catch(exception $e) {
        //            $this->logError("indexAction() exception: ".$e->getMessage());
            $this->_helper->FlashMessenger($this->messageBox($e,'danger'));
            $this->redirect('/');
        }
    }

}
