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
                $select_recipe  ->joinInner(array("t" => "tags"),'`r`.`id` = `t`.`id_recipe`')
                                ->joinInner(array("c" => "comments"), '`c`.`id_recipe` = `r`.`id`' );
            }
            $result = $this->getAdapter()->fetchAll($select_recipe);
        }

        if ($this->aso_hasResult($result) == false) {
            return $this->aso_return($return,CMD_DB_ERROR_NO_DATA);
        }
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }

    public function getComments(&$return, $params, $offset = 0){
        $data = $this->getDataRecipe($params);
        $id_recipe = $data['id_recipe'];

        $select_comment = $this->_db->select()
                                    ->from("comments")
                                    ->where("id_recipe LIKE  $id_recipe")
        ->limit(10, $offset)
                                    ->order("created DESC");

       $select_count =  $this->_db  ->select()
            ->from( array(  "c" => "comments"),
                array("comments_count" => "COUNT(`id`)"))
            ->where("id_recipe LIKE  $id_recipe");
        $result = array("comments" => $this->getAdapter()->fetchAll($select_comment),
                        'count' => $this->getAdapter()->fetchAll($select_count));

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
}