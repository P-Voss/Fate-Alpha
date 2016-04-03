<?php

/**
 * Description of modifier
 *
 * @author Voß
 */
class Application_Model_Modifier {
    
    protected $attribute;
    protected $value;
    
    public function getAttribute() {
        return $this->attribute;
    }

    public function getValue() {
        return $this->value;
    }

    public function setAttribute($attribute) {
        $this->attribute = $attribute;
    }

    public function setValue($value) {
        $this->value = $value;
    }
    
}
