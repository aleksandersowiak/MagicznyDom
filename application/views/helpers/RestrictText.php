<?php
class Zend_View_Helper_RestrictText extends Zend_View_Helper_Abstract
{
    public function restrictText($text, $count)
    {
        $countText = strlen($text);
        $table = array('<br>' => ' ', '<br/>' => ' ', '</br>' => ' ', '</li>' => ' ', '</p>' => ' ');
        if ($countText > $count) {
            $cut = mb_substr(strip_tags(strtr($text, $table)), 0, $count, 'utf-8');
            $restrict = ($cut) . "...";
        } else {
            $restrict = $text;
        }
        return $restrict;
    }
}