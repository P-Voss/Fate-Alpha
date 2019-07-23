<?php

namespace Shop\Models;

/**
 * Description of Skillart
 *
 * @author Voß
 */
class Skillart extends \Application_Model_Skillart {

    /**
     * @var Requirementlist
     */
    private $requirementList;
    /**
     * @var bool
     */
    private $learned = false;
    
    /**
     * @return Requirementlist
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
     * @param Requirementlist $requirementList
     */
    public function setRequirementList(Requirementlist $requirementList) {
        $this->requirementList = $requirementList;
    }

    /**
     * @param $learned
     */
    public function setLearned($learned) {
        $this->learned = $learned;
    }

}
