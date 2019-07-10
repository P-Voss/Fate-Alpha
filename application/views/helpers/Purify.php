<?php

/**
 * Description of Zend_View_Helper_Purify
 *
 * @author Voß
 */
class Zend_View_Helper_Purify extends Zend_View_Helper_Abstract {

    /**
     * @var HTMLPurifier
     */
    private static $instance;
    
    /**
     * @param string $str
     * @return string
     */
    public function purify($str) {

        if (!self::$instance instanceof HTMLPurifier) {
            $config = HTMLPurifier_Config::createDefault();
            self::$instance = new HTMLPurifier($config);
        }
        return self::$instance->purify($str);
    }
    
}
