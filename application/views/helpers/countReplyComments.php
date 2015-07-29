<?php
/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 2014-11-14
 * Time: 09:06
 */
class Zend_View_Helper_countReplyComments extends Zend_View_Helper_Abstract
{
    public function countReplyComments($idReplyComment = null)
    {
        $model = new Application_Model_Read();
        if ($model->getCountReplyComments($return, $idReplyComment) !== FALSE){
            return ($return['result'][0]['reply_comments_count'])-LIMIT_REPLY_COMMENT;
        }
    }
}