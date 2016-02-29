<?php

/**
 * Description of Erstellung_Model_Unterklasse
 *
 * @author Vosser
 */
class Erstellung_Model_Unterklasse extends Application_Model_Klasse {
    
    /**
     * @var Erstellung_Model_Requirementlist
     */
    private $requirementList;
    
    public function getRequirementList() {
        return $this->requirementList;
    }

    public function setRequirementList(Erstellung_Model_Requirementlist $requirementList) {
        $this->requirementList = $requirementList;
    }
    
}
