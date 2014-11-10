<?php
class Application_Model_Index extends Aso_Model {
    public function init() {
        parent::init();
    }

    public function getSetings(&$result, $where){
        $where = $this->getAdapter()->quoteInto("type LIKE ?", $where);
        $select = $this->_db    ->select()
                                ->from("setings")
                                ->where($where);
        $result = $this->getAdapter()->fetchAll($select);
        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result);
    }
}
?>