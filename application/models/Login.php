<?php
class Application_Model_Login extends Aso_Model {

    public function checkLogin($id = null){
        echo $select_count = $this->_db  ->select()
            ->from(array('u' => 'user'))
            ->where('`u`.`id` LIKE ?', $id);
        $result = $this->getAdapter()->fetchAll($select_count);
        if ($result) { return true; }else{ return false; }
    }

    public function addNewGoogleUser($array = array()){
      if (!empty($array)){
          $date = Zend_Date::now();
          $array['created'] =  $timeStamp = gmdate('Y-m-d H:i:s', $date->getTimestamp());
          $array['updated'] =  $timeStamp = gmdate('Y-m-d H:i:s', $date->getTimestamp());
          $this->_db->insert('user', $array);
      }
    }
}