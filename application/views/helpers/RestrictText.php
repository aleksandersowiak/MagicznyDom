<?php
class Zend_View_Helper_RestrictText extends Zend_View_Helper_Abstract
{
    public function restrictText($string, $length, $simple = false)
    {
        if ($simple == true){
            $countText = strlen($string);
            $table = array('<br>' => ' ', '<br/>' => ' ', '</br>' => ' ', '</li>' => ' ', '</p>' => ' ');
            if ($countText > $length) {
                $cut = mb_substr(strip_tags(strtr($string, $table)), 0, $length, 'utf-8');
                $restrict = ($cut) . "...";
            } else {
                $restrict = $string;
            }
            return $restrict;
        }
        if( !empty( $string ) && $length>0 ) {
            $isText = true;
            $ret = "";
            $i = 0;

            $currentChar = "";
            $lastSpacePosition = -1;
            $lastChar = "";

            $tagsArray = array();
            $currentTag = "";
            $tagLevel = 0;

            $noTagLength = strlen( strip_tags( $string ) );

// Parser loop
            for( $j=0; $j<strlen( $string ); $j++ ) {

                $currentChar = substr( $string, $j, 1 );
                $ret .= $currentChar;

// Lesser than event
                if( $currentChar == "<") $isText = false;

// Character handler
                if( $isText ) {

// Memorize last space position
                    if( $currentChar == " " ) { $lastSpacePosition = $j; }
                    else { $lastChar = $currentChar; }

                    $i++;
                } else {
                    $currentTag .= $currentChar;
                }

// Greater than event
                if( $currentChar == ">" ) {
                    $isText = true;

// Opening tag handler
                    if( ( strpos( $currentTag, "<" ) !== FALSE ) &&
                        ( strpos( $currentTag, "/>" ) === FALSE ) &&
                        ( strpos( $currentTag, "</") === FALSE ) ) {

// Tag has attribute(s)
                        if( strpos( $currentTag, " " ) !== FALSE ) {
                            $currentTag = substr( $currentTag, 1, strpos( $currentTag, " " ) - 1 );
                        } else {
// Tag doesn't have attribute(s)
                            $currentTag = substr( $currentTag, 1, -1 );
                        }

                        array_push( $tagsArray, $currentTag );

                    } else if( strpos( $currentTag, "</" ) !== FALSE ) {

                        array_pop( $tagsArray );
                    }

                    $currentTag = "";
                }

                if( $i >= $length) {
                    break;
                }
            }

// Cut HTML string at last space position
            if( $length < $noTagLength ) {
                if( $lastSpacePosition != -1 ) {
                    $ret = substr( $string, 0, $lastSpacePosition );
                } else {
                    $ret = substr( $string, $j );
                }
            }

// Close broken XHTML elements
            while( sizeof( $tagsArray ) != 0 ) {
                $aTag = array_pop( $tagsArray );
                $ret .= "</" . $aTag . ">\n";
            }

        } else {
            $ret = "";
        }
        $regex = '#<img([^>]*) src="([^"/]*/?[^".]*\.[^"]*)"([^>]*)>((?!</a>))#';
        $replace = '<a rel="group" class="fancybox fancy" title="" href="$2">$2</a>';
        $ret = preg_replace($regex, $replace, $ret);

        return( $ret );
    }

    public function simpleRestrictText($text, $count){

    }
}