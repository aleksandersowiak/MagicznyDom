<?php

class Zend_View_Helper_DateFormat extends Zend_View_Helper_Abstract
{
    public function dateFormat($date)
    {
        $locale = new Zend_Locale('pl_PL');
        Zend_Date::setOptions(array('format_type' => 'php'));
        $date_result = new Zend_Date($date, false, $locale);
        return $date_result->toString(DATE_INDEX_FORMAT);
    }
}