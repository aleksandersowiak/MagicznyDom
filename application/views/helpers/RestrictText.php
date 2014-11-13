<?php
class Zend_View_Helper_RestrictText extends Zend_View_Helper_Abstract
{
    public function restrictText($text, $count)
    {
        $countText = strlen($text);
        if ($countText >= $count) {
            $cut = substr(strip_tags($text), 0, $count);
            $restrict = ($cut) . "...";
        } else {
            $restrict = $text;
        }
        return $restrict;
    }
    public function replaceOnLink($text){
        
    }
}