<?php

/**
 *
 * @author Voß
 */
interface Erstellung_Model_Requirements_ValidationInterface {
    
    /**
     * @param Erstellung_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(Erstellung_Model_Charakter $charakter, $value);
    
}
