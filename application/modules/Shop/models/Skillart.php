<?php

/**
 * Description of Skillart
 *
 * @author Voß
 */
class Shop_Model_Skillart extends Application_Model_Skillart {

    /**
     * @var Shop_Model_Requirementlist
     */
    private $requirementList;
    /**
     * @var bool
     */
    private $learned = false;
    
    /**
     * @return Shop_Model_Requirementlist
     */
    public function getRequirementList() {
        return $this->requirementList;
    }

    /**
     * @return bool
     */
    public function getLearned() {
        return $this->learned;
    }

    /**
     * @param Shop_Model_Requirementlist $requirementList
     */
    public function setRequirementList(Shop_Model_Requirementlist $requirementList) {
        $this->requirementList = $requirementList;
    }

    /**
     * @param $learned
     */
    public function setLearned($learned) {
        $this->learned = $learned;
    }

}
