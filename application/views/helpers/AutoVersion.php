<?php

/**
 * Description of Zend_View_Helper_AutoVersion
 *
 * @author Voß
 */
class Zend_View_Helper_AutoVersion extends Zend_View_Helper_Abstract {
    
    /**
     * @param string $file
     * @return string
     */
    public function autoVersion($file) {
        if (strpos($file, '/') !== 0 
            || 
            !file_exists($_SERVER['DOCUMENT_ROOT'] . $file)) 
        {
            return $file;
        }
        $mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
        return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);
    }
    
}
