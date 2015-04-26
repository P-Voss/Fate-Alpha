<?php

/**
 * Description of Utility
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Service_Utility {
    
    public static function BBCodes($string){
        $str = nl2br(htmlentities($string));
          # Formatierungen
        $str = preg_replace('#\[b\](.*)\[/b\]#isU', "<b>$1</b>", $str);
        $str = preg_replace('#\[i\](.*)\[/i\]#isU', "<i>$1</i>", $str);
        $str = preg_replace('#\[u\](.*)\[/u\]#isU', "<u>$1</u>", $str);
        $str = preg_replace('#\[color=(.*)\](.*)\[/color\]#isU', "<span style=\"color: $1\">$2</span>", $str);
        $str = preg_replace('#\[size=(8|10|12)\](.*)\[/size\]#isU', "<span style=\"font-size: $1 pt\">$2</span>", $str);

        return $str;
    }
    
    public static function generateShortHash() {
        return substr(md5(rand()), 0, 7);
    }
    
}
