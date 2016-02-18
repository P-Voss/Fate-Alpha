<?php

/**
 * Description of Skillart
 *
 * @author Voß
 */
class Shop_Model_Skillart extends Application_Model_Skillart {
    
    private $requirementList;
    private $learned;
    
    /**
     * @return Shop_Model_Requirementlist
     */
    public function getRequirementList() {
        return $this->requirementList;
    }

    public function getLearned() {
        return $this->learned;
    }

    /**
     * @param Shop_Model_Requirementlist $requirementList
     */
    public function setRequirementList(Shop_Model_Requirementlist $requirementList) {
        $this->requirementList = $requirementList;
    }

    public function setLearned($learned) {
        $this->learned = $learned;
    }


    
}
