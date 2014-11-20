<?php
class Application_Model_Index extends Aso_Model {
    public function init() {
        parent::init();
    }

    public function getSetings(&$result, $where = null) {
        if ($where != null) {
            $where = $this->getAdapter()->quoteInto("type LIKE ?", $where);
        }else{
            $where = 1;
        }
        $select = $this->_db    ->select()
                                ->from("setings")
                                ->where($where);
        $result = $this->getAdapter()->fetchAll($select);
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }

    public function getRecipe(&$result, $limit = null, $order = null, $sort= null) {
        $select = $this->_db    ->select()
                                ->from("recipe")
                                ->limit($limit)
                                ->order($order." ".$sort);
        $result = $this->getAdapter()->fetchAll($select);
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }

    public function getCategory(&$result){
        $select_count = $this->_db  ->select()
                                    ->from( array(  "r" => "recipe"),
                                            array(  "category",
                                                    "category_count" => "COUNT(`category`)"))
                                    ->group("category");

        $result = $this->getAdapter()->fetchAll($select_count);
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }
}
?>