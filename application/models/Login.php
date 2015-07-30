<?php

class Application_Model_Login extends Aso_Model
{

    private $_sql_fields = array('id',
        'name',
        'privileges',
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

    public function getUserData($id = null, $where = null)
    {
        $select_count = $this->_db->select()
            ->from(array('u' => 'user'), $this->_sql_fields);
        if ($id != null) $select_count->where('`u`.`id` LIKE ?', $id);
        if ($where != null) {
            foreach ($where as $key => $value) {
                if (in_array($key, $this->_sql_fields)) {
                    $select_count->where("`u`.`$key` LIKE '$value'");
                }
            }
        }
        $result = $this->getAdapter()->fetchAll($select_count);
        if ($id != null) {
            $getPrivilegesGroup = $this->_db->select()->from(array('up' => 'user'), array('privileges'));
            $getPrivilegesGroup->where('`up`.`id` LIKE ?', $id);
            $result_group = $this->getAdapter()->fetchAll($getPrivilegesGroup);
            if ($result_group != NULL) {
                $table_group = json_decode($result_group[0]['privileges']);
                foreach ($table_group as $privilege) {
                    $privileges = $this->_db->select()->from(array('pr' => 'privileges'), array('action', 'value'))->where('`pr`.`privilege` LIKE ?', $privilege)->where('`pr`.`value` = 1');
                    $result_p = $this->getAdapter()->fetchAll($privileges);
                    if ($result_p != NULL) {
                        $data = array('action' => $result_p[0]['action'],
                            'value' => $result_p[0]['value']);
                        array_push($result[0], $data);
                    }
                }
            }
        }
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function addNewSocialNetworkUser($array = array())
    {
        if (!empty($array)) {
            $date = Zend_Date::now();

            foreach ($array as $key => $value) {
                if (!in_array($key, $this->_sql_fields)) unset($array[$key]);
            }
            $array['created'] = $timeStamp = gmdate('Y-m-d H:i:s', $date->getTimestamp());
            $array['updated'] = $timeStamp = gmdate('Y-m-d H:i:s', $date->getTimestamp());
            $array['privileges'] = json_encode(array("1" => $array['provider']), true);

            $this->_db->insert('user', $array);
        }
    }

    public function upateAccessToken($id = null, $data = null)
    {

        $update = $this->_db->update('user', $data, 'id = ' . $id);
        if ($update) return true;
    }

    public function updateProvider($data = array())
    {
        $date = Zend_Date::now();
        $data['date'] = $timeStamp = gmdate('Y-m-d H:i:s', $date->getTimestamp());

        $select = $this->_db->select()->from(array('ps' => 'provider_settings'));
        foreach ($data as $key => $value) {

            if ($key == 'code' || $key == 'user_id') $select->where("`ps`.`" . $key . "` LIKE " . $value);
        }

        $provider_settings = $this->getAdapter()->fetchall($select);
        if ($provider_settings == FALSE) {
            $this->_db->insert('provider_settings', $data);
        } else {
            if ($provider_settings[0]['visibility'] != null) {
                $data['visibility'] = $provider_settings['visibility'];
            }
            $where['user_id = ?'] = $data['user_id'];
            $this->_db->update('provider_settings', $data, $where);
        }
    }

    public function getProviderSettings(&$return, $user_id = null)
    {
        $result = null;
        if ($user_id != null) {
            $select = $this->_db->select()->from(array('ps' => 'provider_settings'))->where('`ps`.`user_id` LIKE ?', $user_id);
            $result = $this->getAdapter()->fetchAll($select);
        }

        if ($result) {
            return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
        } else {
            return false;
        }
    }
}