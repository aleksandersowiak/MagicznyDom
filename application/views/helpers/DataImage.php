<?php
/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 2014-11-14
 * Time: 09:06
 */

class Zend_View_Helper_DataImage extends Zend_View_Helper_Abstract {
    public function dataImage($link = null, $text = null, $wight = null, $height = null)
    {
        if ($link != null) {
            return ("<img class=\"featurette-image img-responsive\" data-src=\"holder.js/$wight x $height/auto\" src=\"$link\")/>");
        } else {
        $data = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="' . $wight . '" height="' . $height . '" viewBox="0 0 230 230" preserveAspectRatio="none">
                    <defs/>
                    <rect width="' . $wight . '" height="' . $height . '" fill="#EEEEEE"/>
                        <g>
                            <text x="10%" y="90%" style="fill:#AAAAAA;font-weight:bold;font-family:Arial, Helvetica, Open Sans, sans-serif, monospace;font-size:12pt;dominant-baseline:central">' . $text . '</text>
                        </g>
                    </svg>';
        $dataXml = base64_encode($data);
        return ("<img class=\"featurette-image img-responsive\" data-src=\"holder.js/$wight x $height/auto\" src=\"data:image/svg+xml;base64,$dataXml\"/>");
        }
    }
} 