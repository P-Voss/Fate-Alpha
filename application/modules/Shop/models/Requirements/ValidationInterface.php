<?php

namespace Shop\Models\Requirements;

/**
 *
 * @author Voß
 */
interface ValidationInterface {
    
    /**
     * @param \Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function check(\Application_Model_Charakter $charakter, $value);
    
}
