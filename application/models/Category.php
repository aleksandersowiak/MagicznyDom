<?php
/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 2014-12-01
 * Time: 07:42
 */

class Application_Model_Category extends Aso_Model {
    private $_helper;
    public function getRecipesFromCategory(&$result, $params = null){
        require_once( APPLICATION_PATH . '/views/helpers/ReplaceOnLink.php');
        $this->_helper = new Zend_View_Helper_ReplaceOnLink();

        $result = FALSE;
        $select = $this->_db->select()
                            ->from("recipe");
        $result_recipe = $this->getAdapter()->fetchAll($select);

        foreach ($result_recipe as $recipe){
            if ($params == $this->_helper->replaceOnLink($recipe['category'])){
                $category = $recipe['category'];
            }
        }

        if (isset($category) != NULL){
            $select_recipe_from_category = $this->_db   ->select()
                                                        ->from(array("r" => "recipe"))
                                                        ->where("category LIKE '$category'");
            $result = $this->getAdapter()->fetchAll($select_recipe_from_category);
        }
        if ($this->aso_hasResult($result) == false) {
            return $this->aso_return($return,CMD_DB_ERROR_NO_DATA);
        }

        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }

    public function getRecipesFromTags(&$result_tags, $params = null){
        require_once( APPLICATION_PATH . '/views/helpers/ReplaceOnLink.php');
        $this->_helper = new Zend_View_Helper_ReplaceOnLink();

        $select = $this->_db->select()
                            ->from('tags');
        $result_tags_db = $this->getAdapter()->fetchAll($select);

        foreach ($result_tags_db as $tag) {
            if($this->_helper->replaceOnLink($tag['tags']) == $params) {
               $_tag = $tag['tags'];
            }
        }
        $select_one_tag = $this->_db->select()
                                    ->from(array('t'=>'tags'))
                                    ->where("tags LIKE '" . $_tag . "'")
                                    ->joinInner(array("r" => "recipe"),'`t`.`id_recipe` = `r`.`id`');
        $result_one_tag = $this->getAdapter()->fetchAll($select_one_tag);
        foreach ($result_one_tag as $recipe_by_tag) {

                $result_tags[] = $recipe_by_tag;
        }
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result_tags);
    }

    public function getTags(&$result){
        $select = $this->_db->select()
                            ->distinct()
                            ->from(array('t' => 'tags'))
                            ->order( 't.tags');
        $result = $this->getAdapter()->fetchAll($select);

        foreach ($result as $tag) {
                $array[] =  $tag['tags'];
        }

        $result['tagList'] = array_unique($array);
        return $result;
    }
} 