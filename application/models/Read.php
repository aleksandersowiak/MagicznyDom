<?php
class Application_Model_Read extends Aso_Model
{
    private $_helper;
    public function init()
    {
        parent::init();
    }

    public function getRecipeDetail(&$result, $params) {
        require_once( APPLICATION_PATH . '/views/helpers/ReplaceOnLink.php');
        $this->_helper = new Zend_View_Helper_ReplaceOnLink();
        $result = FALSE;
        $select = $this->_db    ->select()
            ->from("recipe");
        $result_recipe = $this->getAdapter()->fetchAll($select);
        foreach ($result_recipe as $recipe){
            if ($params == $this->_helper->replaceOnLink($recipe['title'])){
                $id_recipe = $recipe['id'];
            }
        }
        if (isset($id_recipe) != NULL){
            $select_recipe = $this->_db     ->select()
                                            ->from(array("r" => "recipe"))
                                            ->where("id = $id_recipe");
            $result = $this->getAdapter()->fetchAll($select_recipe);
        }
        if ($this->aso_hasResult($result) == false) {
            return $this->aso_return($return,CMD_DB_ERROR_NO_DATA);
        }
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }
}