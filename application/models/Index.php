<?php
class Application_Model_Index extends Aso_Model {
    public function init() {
        parent::init();
    }

    public function getSetings(&$result, $where = null) {
        if ($where != null) {
            $where_query = $this->getAdapter()->quoteInto("`type` LIKE ?", $where);
            $where_query .= (" AND `additional_settings` IS NOT NULL");
        }else{
            $where_query = 1;
        }
        $select = $this->_db    ->select()
                                ->from("setings")
                                ->where($where_query)
                                ->where('`active` = 1');
        $result = $this->getAdapter()->fetchAll($select);

        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }

    public function getRecipe(&$result, $offset, $limit, $order = null, $sort= null) {
        $select = $this->_db    ->select()
                                ->from("recipe")
                                ->limit($limit, $offset)
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

    public function getCount(&$result){
        $count = $this->_db->select()->from(array("r"=>"recipe"), array ("count" => "COUNT(`recipe`)"))->group('autor_id');
        $recipe_per_gage = $this->_db->select()->from('setings')->where("`type` LIKE 'max_limit'");
        $result = $this->getAdapter()->fetchAll($count);
        $result['max_limit'] = $this->getAdapter()->fetchAll($recipe_per_gage);
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }
    public function turnedOffApp(&$result, $what){
        $data = array(
            'active'      => 0,
        );
        $result = $this->_db->update("setings", $data, "`type` = '$what'");
        return $result;
    }
}
?>