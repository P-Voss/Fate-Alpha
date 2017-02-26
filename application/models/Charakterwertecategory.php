<?php

/**
 * Description of Application_Model_Charakterwertecategory
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Charakterwertecategory {
    
    private $category;
    private $uebermensch;
    
    public function getCategory() {
        return $this->category;
    }

    public function getUebermensch() {
        return $this->uebermensch === true;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setUebermensch($uebermensch) {
        $this->uebermensch = $uebermensch;
    }
    
}
