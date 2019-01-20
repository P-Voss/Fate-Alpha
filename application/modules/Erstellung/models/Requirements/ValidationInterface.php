<?php

/**
 *
 * @author Voß
 */
interface Erstellung_Model_Requirements_ValidationInterface {
    
    /**
     * @param Erstellung_Model_Character $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Erstellung_Model_Character $charakter, $value);
    
}
