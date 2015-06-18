<?php
class Application_Model_Login extends Aso_Model {

    private  $_sql_fields = array(  'id',
                                    'name',
                                    'given_name',
                                    'family_name',
                                    'link',
                                    'picture',
                                    'gender',
                                    'locale',
                                    'active',
                                    'role',
                                    'email',
                                    'provider',
                                    'access_token');

    public function getUserData($id = null, $where = null ){

        $select_count = $this->_db  ->select()
            ->from(array('u' => 'user'), $this->_sql_fields);
        if ($id != null ) $select_count->where('`u`.`id` LIKE ?', $id);
        if ($where != null){
            foreach ($where as $key => $value)
            {
                if (in_array($key, $this->_sql_fields)){
                    $select_count->where("`u`.`$key` LIKE '$value'");
                }
            }
        }

        $result = $this->getAdapter()->fetchAll($select_count);

        if ($result) { return $result; }else{ return false; }
    }

    public function addNewSocialNetworkUser($array = array()){
      if (!empty($array)){
          $date = Zend_Date::now();

          foreach ($array as $key => $value)
          {
              if (!in_array($key, $this->_sql_fields)) unset($array[$key]);
          }
          $array['created'] =  $timeStamp = gmdate('Y-m-d H:i:s', $date->getTimestamp());
          $array['updated'] =  $timeStamp = gmdate('Y-m-d H:i:s', $date->getTimestamp());
          $this->_db->insert('user', $array);
      }
    }

    public function upateAccessToken($id = null, $data = null) {

        $update = $this->_db->update('user', $data ,'id = '. $id);
        if ($update) return true;
    }
}