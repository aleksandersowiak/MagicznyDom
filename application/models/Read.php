<?php
class Application_Model_Read extends Aso_Model
{
    private $_helper;
    public function init()
    {
        parent::init();
    }

    private function getDataRecipe($params = null){
        require_once( APPLICATION_PATH . '/views/helpers/ReplaceOnLink.php');

        $this->_helper = new Zend_View_Helper_ReplaceOnLink();
        $select = $this->_db    ->select()
            ->from("recipe");
        $result_recipe = $this->getAdapter()->fetchAll($select);
        foreach ($result_recipe as $recipe){
            if ($params == $this->_helper->replaceOnLink($recipe['title'])){
                $id_recipe = $recipe['id'];
                $updated = $recipe['updated'];
            }
        }
        return array("id_recipe" => $id_recipe, 'updated' => $updated);
    }


    public function getRecipeDetail(&$result, $params = null, $parameters = null) {
        $result = FALSE;
        $data = $this->getDataRecipe($params);
        $id_recipe = $data['id_recipe'];
        $updated = $data['updated'];
        if (isset($id_recipe) != NULL){
            if (isset($parameters) != NULL){
                $where = "updated $parameters '$updated'";
                $limit = 1;
                if ($parameters == '<') {
                    $order = "r.updated DESC";
                }else{
                    $order = "r.updated ASC";
                }
            }else{
                $where = "r.id = $id_recipe";
            }
            $select_recipe = $this->_db     ->select()
                                            ->from(array("r" => "recipe"))
                                            ->where($where);


            if (isset($parameters) != null) {
                 $select_recipe ->order($order)
                                ->limit($limit);
            }else{
                $select_recipe  ->joinInner(array("t" => "tags"),'`r`.`id` = `t`.`id_recipe`');
            }

            $result = $this->getAdapter()->fetchAll($select_recipe);
        }

        if ($this->aso_hasResult($result) == false) {
            return $this->aso_return($return,CMD_DB_ERROR_NO_DATA);
        }
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }

    public function getComments(&$return, $params, $page = 1){
        $data = $this->getDataRecipe($params);
        $id_recipe = $data['id_recipe'];
        $start_from = ($page-1) * 10;
        $select_comment = $this->_db->select()
                                    ->from("comments")
                                    ->where("id_recipe LIKE  $id_recipe")
                                    ->limit(10,$start_from)
                                    ->order("created DESC");

        $select_count =  $this->_db  ->select()
                                    ->from( array(  "c" => "comments"),
                                        array("comments_count" => "COUNT(`id`)"))
                                    ->where("id_recipe LIKE  $id_recipe");

        $result = array("comments"  => $this->getAdapter()->fetchAll($select_comment),
                        'count'     => $this->getAdapter()->fetchAll($select_count));

        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }
    public function getCountComments(&$return, $params){

        $data = $this->getDataRecipe($params);
        $id_recipe = $data['id_recipe'];
        $select_comment = $this->_db->select()
                                    ->from( array(  "c" => "comments"),
                                            array("comments_count" => "COUNT(`id`)"))
                                    ->where("id_recipe LIKE  $id_recipe");

        $result = $this->getAdapter()->fetchAll($select_comment);

        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }

    public function updateVote(&$return, $table = null, $data = null, $where = null, $ip = null){

        $vote = $this->getAdapter()->fetchAll($this->_db->select()->from('comments')->where($where));
        $array_encode =  json_decode($vote[0]['ips']);
        if(count($array_encode) > 10) $this->_db->update($table, array('ips' => null), $where);
        if ($array_encode == NULL) $array_encode = array();
        if (in_array($ip, $array_encode)){
            $ipTable = $array_encode;
            array_push($ipTable, $ip);
            $data = array($data => $vote[0][$data]);
        }else{
            $ipTable = $array_encode;
            array_push($ipTable, $ip);
            $data = array($data => $vote[0][$data]+1, 'ips' => json_encode($ipTable));
            $this->_db->update($table, $data, $where);
        }
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $data);
    }
}