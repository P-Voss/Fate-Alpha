<?php

/**
 * Description of Application_Model_DamageComponent
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_DamageComponent {
    
    protected $type;
    protected $value;
    protected $multiplier;
    protected $attribute;
    
    public function getType() {
        return $this->type;
    }

    public function getValue() {
        return $this->value;
    }

    public function getMultiplier() {
        return $this->multiplier;
    }

    public function getAttribute() {
        return $this->attribute;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function setMultiplier($multiplier) {
        $this->multiplier = $multiplier;
    }

    public function setAttribute($attribute) {
        $this->attribute = $attribute;
    }
    
}
