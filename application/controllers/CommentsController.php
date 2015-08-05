<?php

class CommentsController extends Aso_Controller_Action
{
    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        return $this->_helper->viewRenderer->setNoRender(true);
//        return $this->render('index');
    }

    public function getcommentsAction()
    {
        try {
            $request = $this->getRequest();
            $params = $request->getParams();
            $id = $params['id'];
            $page = $params['page'];
            $resultComments = NULL;
            if ($this->getModel('Model_Read')->getComments($resultComments, $id, $page) != FALSE) {
                if ($resultComments['result']) {
                    $this->view->comments = $resultComments['result']['comments'];
                    //                    $this->view->commentsCount = $resultComments['result']['count'][0]['comments_count'];
                }
            }
            $this->view->issCommentToAdd = true;
            $this->_helper->layout()->disableLayout();

        } catch (exception $e) {
            //            $this->logError("indexAction() exception: ".$e->getMessage());
            $this->_helper->FlashMessenger($this->messageBox($e, 'danger'));
            $this->redirect('/');
        }
    }

    public function getReplyCommentsAction()
    {
        $request = $this->getRequest();
        $params = $request->getParams();
        $id = $params['id'];
        $limit = (isset($params['limit'])) ? $params['limit'] : null;
        $this->getModel('Model_Read')->getReplyComment($replyComment, $id, $limit);

        if (count($replyComment["result"]) > 0) {
            foreach ($replyComment["result"] as $data) {
                $view = '<div class="media small">
                            <div class="pull-left media-top">
                                <span>';
                if (isset($data['picture']) && $data['picture'] != '') {
                    $view .= '<img class="" src="' . $data['picture'] . '" width="30px" height="30px">';
                } else {
                    $view .= '<span class="glyphicon glyphicon-user" style="font-size: 30px"></span>';
                }
                $view .= '<span>
                        </div>
                        <div class="media-body">
                        <h4 class="media-heading user">
                        <div class="btn-group small">
                            <span aria-haspopup="true" aria-expanded="false" data-toggle="dropdown">
                                ' . $data['userName'] . '</span>
                            </span>
                        </h4>
                        <p class="small">' . $data['created'] . '</p>
                        <p style="width: 100%"
                           class="list-group-item-text">';
                $regex = '#<img([^>]*) src="([^"/]*/?[^".]*\.[^"]*)"([^>]*)>((?!</a>))#';
                $replace = '<a rel="group" class="fancybox fancy" title="" href="$2">$2</a>';
                $view .= preg_replace($regex, $replace, $data['comment']);
                $view .= '</p>
                        </div>
                </div>';

                echo $view;
            }
        }
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
    }

    public function getCommentAction()
    {
        try {
            $resultComments =null;
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();
            $request = $this->getRequest();
            $params = $request->getParams();
            $id = $params['id'];
            if ($this->getModel('Model_Read')->getCommentData($resultComments, $id) != FALSE) {
                $regex = '#<img([^>]*) src="([^"/]*/?[^".]*\.[^"]*)"([^>]*)>((?!</a>))#';
                $replace = '<a rel="group" class="fancybox fancy" title="" href="$2">$2</a>';
                $ret = preg_replace($regex, $replace, $resultComments['result'][0]['comment']);
                echo($ret);
            }
            $this->_helper->layout()->disableLayout();
        } catch (exception $e) {
            //            $this->logError("indexAction() exception: ".$e->getMessage());
            $this->_helper->FlashMessenger($this->messageBox($e, 'danger'));
            $this->redirect('/');
        }
    }

    public function voteAction()
    {
        $request = $this->getRequest();
        $params = $request->getParams();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();

        if (isset($params['plus']) != null) {
            $id = $params['plus'];
            $parameter = 'plus';
        } elseif (isset($params['minus']) != null) {
            $id = $params['minus'];
            $parameter = 'minus';
        }
        $where = '`id` = ' . $id;
        $table = 'comments';

        if ($this->getModel('Model_Read')->updateVote($result, $table, $parameter, $where, $ip = $this->getRequest()->getServer('REMOTE_ADDR')) != FALSE) {
            echo($result['result'][$parameter]);
        }

    }

    public function addcommentAction()
    {
        try {
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();

            $request = $this->getRequest();
            $params = $request->getParams();
            if (isset($params['reply_id'])) {
                $data = array('userName' => $params['name'],
                    'comment' => $params['message'],
                    'user_id' => $this->getSession()->u_id,
                    'reply_id' => $params['reply_id'],
                );
            } else {
                $data = array('userName' => $params['name'],
                    'comment' => $params['message'],
                    'id_recipe' => $params['id'],
                    'user_id' => $this->getSession()->u_id,
                    'reply' => ($params['reply'] === 'true'));
            }

            if (isset($params['moderate'])) {
                $data['moderate'] = $params['moderate'];
            }
            if ($this->getModel('Model_Read')->insertComment($return, $data) == FALSE) {
                $this->_helper->redirector('index', 'index');
                $this->aso_sendCommand('Dodanie nowego komentarza nie powiodło się, błąd...', 'danger');
            }
        } catch (exception $e) {
            //            $this->logError("indexAction() exception: ".$e->getMessage());
            $this->_helper->FlashMessenger($this->messageBox($e, 'danger'));
            $this->redirect('/');
        }
    }

}
