<?php

/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 2014-11-14
 * Time: 09:06
 */
class Zend_View_Helper_CountReplyComments extends Zend_View_Helper_Abstract
{
    public function countReplyComments($idReplyComment = null)
    {
        try {
            $model = new Application_Model_Read();
            if ($model->getCountReplyComments($return, $idReplyComment) !== FALSE) {
                return ($return['result'][0]['reply_comments_count']) - LIMIT_REPLY_COMMENT;
            }
        } catch (exception $e) {
            //            $this->logError("indexAction() exception: ".$e->getMessage());
            $this->_helper->FlashMessenger($this->messageBox($e, 'danger'));
            $this->redirect('/');
        }
    }
}