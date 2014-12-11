<?php
class Application_Model_Read extends Aso_Model
{
    private $_helper;
    public function init()
    {
        parent::init();
    }

    public function getRecipeDetail(&$result, $params = null, $parameters = null) {
        require_once( APPLICATION_PATH . '/views/helpers/ReplaceOnLink.php');

        $this->_helper = new Zend_View_Helper_ReplaceOnLink();
        $result = FALSE;
        $select = $this->_db    ->select()
            ->from("recipe");
        $result_recipe = $this->getAdapter()->fetchAll($select);
        foreach ($result_recipe as $recipe){
            if ($params == $this->_helper->replaceOnLink($recipe['title'])){
                $id_recipe = $recipe['id'];
                $updated = $recipe['updated'];
            }
        }
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


//            echo $select_recipe;
            $result = $this->getAdapter()->fetchAll($select_recipe);
        }

        if ($this->aso_hasResult($result) == false) {
            return $this->aso_return($return,CMD_DB_ERROR_NO_DATA);
        }
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }
}