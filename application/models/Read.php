<?php
class Application_Model_Read extends Aso_Model
{

    public function init()
    {
        parent::init();

    }

    public function getRecipeDetail(&$result, $params) {

        $select = $this->_db    ->select()
            ->from("recipe");
        $result = $this->getAdapter()->fetchAll($select);

        foreach ($result as $recipe){
            if ($params ==$this->replaceOnLink($recipe['title'])){
                $id_recipe = $recipe['id'];
            }
        }
        if (isset($id_recipe) != NULL){
            $select_recipe = $this->_db     ->select()
                                            ->from(array("r" => "recipe"))
                                            ->where("id = $id_recipe");
            $result_recipe = $this->getAdapter()->fetchAll($select_recipe);

        }else{
            $result_recipe = FALSE;
        }

        return $this->aso_return($return, CMD_DB_ERROR_NO_ERROR, $result_recipe);
    }

    public function replaceOnLink($text)
    {
        return $this->normalize($text);
    }
    private function normalize ($string) {
        $table = array(
            'Ę'=>'E', 'Ó'=>'O', 'Ą'=>'A', 'Ś'=>'S', 'Ł'=>'L', 'Ż'=>'Z', 'Ź'=>'Z', 'Ć'=>'C', 'Ń'=>'N', 'ę'=>'e', 'ó'=>'o',
            'ą'=>'a', 'ś'=>'s', 'ł'=>'l', 'ż'=>'z', 'ź'=>'z', 'ć'=>'c', 'ń'=>'n',
            'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
            'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', ' '=>'-', '.'=>'',  ','=>'',
        );
        return strtr(strtolower($string), $table);
    }
}