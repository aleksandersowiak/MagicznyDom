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
        $select = $this->_db    ->select()
            ->from("recipe");
        $result_recipe = $this->getAdapter()->fetchAll($select);

        foreach ($result_recipe as $recipe){
            if ($params == $this->_helper->replaceOnLink($recipe['category'])){
                $category = $recipe['category'];
            }
        }


        if (isset($category) != NULL){
            $select_recipe_from_category = $this->_db     ->select()
                ->from(array("r" => "recipe"))
                ->where("category LIKE '$category'");
            $select_recipe_from_category;
            $result = $this->getAdapter()->fetchAll($select_recipe_from_category);
        }
        if ($this->aso_hasResult($result) == false) {
            return $this->aso_return($return,CMD_DB_ERROR_NO_DATA);
        }
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }

    public function getRecipesFromTags(&$result, $params = null){
        require_once( APPLICATION_PATH . '/views/helpers/ReplaceOnLink.php');
        $this->_helper = new Zend_View_Helper_ReplaceOnLink();

        $select = $this->_db->select()
                            ->from('tags')
                            ->where("tags LIKE '%\"$params\"%'")
                            ->joinInner(array("r" => "recipe"),'`tags`.`id_recipe` = `r`.`id`');

        $result = $this->getAdapter()->fetchAll($select);
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }

    public function getTags(&$result){
        $array = array();
        $i = 0;
        $select = $this->_db->select()
            ->from('tags');
        $result = $this->getAdapter()->fetchAll($select);

        foreach ($result as $tag){

            foreach (json_decode($tag['tags']) as $key => $value){
                $array[]= $value->tag;
            }
        }

        $result['tagList'] = array_unique($array);

        return $result;
    }
} 