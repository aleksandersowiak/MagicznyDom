<?php
class Application_Model_Login extends Aso_Model {

    public function getUserData($id = null, $where = null ){

        $select_count = $this->_db  ->select()
            ->from(array('u' => 'user'), array('id', 'name', 'given_name', 'family_name', 'link', 'picture', 'gender', 'locale', 'active', 'role', 'email'));
        if ($id != null ) $select_count->where('`u`.`id` LIKE ?', $id);
        if ($where != null){
            foreach ($where as $key => $value)
            {
                $select_count->where("`u`.`$key` LIKE '$value'");
            }
        }

        $result = $this->getAdapter()->fetchAll($select_count);

        if ($result) { return $result; }else{ return false; }
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