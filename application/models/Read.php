<?php

class Application_Model_Read extends Aso_Model
{
    private $_helper;

    public function init()
    {
        parent::init();
    }

    private function getDataRecipe($params = null)
    {
        require_once(APPLICATION_PATH . '/views/helpers/ReplaceOnLink.php');

        $this->_helper = new Zend_View_Helper_ReplaceOnLink();
        $select = $this->_db->select()
            ->from('recipe')->where('`active` = 1');
        $result_recipe = $this->getAdapter()->fetchAll($select);
        foreach ($result_recipe as $recipe) {
            if ($params == $this->_helper->replaceOnLink($recipe['title'])) {
                $id_recipe = $recipe['id'];
                $updated = $recipe['updated'];
            }
        }
        return array("id_recipe" => $id_recipe, 'updated' => $updated);
    }


    public function getRecipeDetail(&$result, $params = null, $parameters = null)
    {
        $result = FALSE;
        $data = $this->getDataRecipe($params);
        $id_recipe = $data['id_recipe'];
        $updated = $data['updated'];
        if (isset($id_recipe) != NULL) {
            if (isset($parameters) != NULL) {
                $where = "updated $parameters '$updated'";
                $limit = 1;
                if ($parameters == '<') {
                    $order = 'r.updated DESC';
                } else {
                    $order = 'r.updated ASC';
                }
            } else {
                $where = 'r.id = ' . $id_recipe;
            }
            $select_recipe = $this->_db->select()
                ->from(array('r' => 'recipe'))
                ->where($where);
            if (isset($parameters) != null) {
                $select_recipe->order($order)
                    ->limit($limit);
            }

            $select_reciped_tags = $this->_db->select()
                ->from(array('r' => 'recipe'))
                ->where($where)
                ->joinInner(array('t' => 'tags'), '`r`.`id` = `t`.`id_recipe`')->where('`r`.`active` = 1');
            $result = $this->getAdapter()->fetchAll($select_recipe);
            $result_tags = $this->getAdapter()->fetchAll($select_reciped_tags);

            if (!empty($result_tags)) {
                foreach ($result_tags as $tags) {
                    $result_tag[] = $tags['tags'];
                }
                $result['tagList'] = $result_tag;
            }
        }

        if ($this->aso_hasResult($result) == false) {
            return $this->aso_return($return, CMD_DB_ERROR_NO_DATA);
        }
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }

    public function perPage()
    {
        $per_page = $this->getAdapter()->fetchOne($this->_db->select()
            ->from(array('s' => 'setings'), 'data')
            ->where('`type` LIKE "com_per_page"'));
        return ($per_page != false) ? $per_page : COM_PER_PAGE;
    }

    public function getComments(&$return, $params, $page = 1)
    {
        $data = $this->getDataRecipe($params);
        $id_recipe = $data['id_recipe'];
        $per_page = $this->perPage();
        $start_from = ($page - 1) * $per_page;
        $select_comment = $this->_db->select()
            ->from(array('c' => 'comments'))
            ->joinInner(array('u' => 'user'),
                '`c`.user_id = `u`.id',
                array('name',
                    'given_name',
                    'family_name',
                    'link',
                    'picture',
                    'gender',
                    'locale',
                    'email',
                    'provider'))
            ->where('`c`.id_recipe LIKE ?', $id_recipe)
            ->where('`c`.moderate != FALSE')
            ->limit($per_page, $start_from)
            ->order('c.created DESC');

        $select_count = $this->_db->select()
            ->from(array('c' => 'comments'),
                array('comments_count' => 'COUNT(`id`)'))
            ->where('id_recipe LIKE ?', $id_recipe)
            ->where('moderate != FALSE');

        $result = array('comments' => $this->getAdapter()->fetchAll($select_comment),
            'count' => $this->getAdapter()->fetchAll($select_count),
            'per_page' => $per_page);

        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }

    public function getReplyComment(&$return, $params = null, $limit = null)
    {

        $select_reply = $this->_db->select()
            ->from(array('c' => 'comments'))
            ->joinInner(array('u' => 'user'),
                '`c`.user_id = `u`.id',
                array('name',
                    'given_name',
                    'family_name',
                    'link',
                    'picture',
                    'gender',
                    'locale',
                    'email',
                    'provider'))
            ->where('`c`.`reply_id` LIKE ?', $params)
            ->where('`c`.`reply_id` IS NOT NULL')
            ->where('`c`.`moderate` != FALSE')
            ->order('c.created DESC');
        if ($limit != NULL) {
            $select_reply->limit($limit);
        }
        $result = $this->getAdapter()->fetchAll($select_reply);
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }

    public function getCountComments(&$return, $params)
    {

        $data = $this->getDataRecipe($params);
        $id_recipe = $data['id_recipe'];
        $select_comment = $this->_db->select()
            ->from(array('c' => 'comments'),
                array('comments_count' => 'COUNT(`id`)'))
            ->where('id_recipe LIKE ?', $id_recipe)
            ->where('moderate !=  FALSE');

        $result = $this->getAdapter()->fetchAll($select_comment);
        $result['per_page'] = $this->perPage();
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }

    public function updateVote(&$return, $table = null, $data = null, $where = null, $ip = null)
    {

        $vote = $this->getAdapter()->fetchAll($this->_db->select()->from('comments')->where($where));
        $array_encode = json_decode($vote[0]['ips']);
        if (count($array_encode) > 10) $this->_db->update($table, array('ips' => null), $where);
        if ($array_encode == NULL) $array_encode = array();
        if (in_array($ip, $array_encode)) {
            $ipTable = $array_encode;
            array_push($ipTable, $ip);
            $data = array($data => $vote[0][$data]);
        } else {
            $ipTable = $array_encode;
            array_push($ipTable, $ip);
            $data = array($data => $vote[0][$data] + 1, 'ips' => json_encode($ipTable));
            $this->_db->update($table, $data, $where);
        }
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $data);
    }

    public function insertComment(&$return, $data)
    {
        $date = Zend_Date::now();
        $timeStamp = gmdate('Y-m-d H:i:s', $date->getTimestamp());
        if (isset($data["reply_id"])){
            $_data = array(
                'created' => $timeStamp
            );
            $data = array_replace($data, $_data);
        }else{
            $data_id_recipe = $this->getDataRecipe($data['id_recipe']);
            $id_recipe = $data_id_recipe['id_recipe'];

            $_data = array(
                'id_recipe' => $id_recipe,
                'created' => $timeStamp
            );
            $data = array_replace($data, $_data);
        }

        $this->_db->insert('comments', $data);
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $data);
    }

    public function getCommentData(&$return, $id = null)
    {
        $select_comment = $this->_db->select()
            ->from(array('c' => 'comments'))
            ->where('id LIKE ?', $id)
            ->where('moderate !=  FALSE');

        $result = $this->getAdapter()->fetchAll($select_comment);

        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }
}