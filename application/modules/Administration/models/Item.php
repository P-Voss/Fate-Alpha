<?php

/**
 * Description of Administration_Model_Item
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Model_Item extends Application_Model_Item {

    /**
     * @var Administration_Model_Requirementlist
     */
    private $requirementList;

    /**
     * @return Administration_Model_Requirementlist
     */
    public function getRequirementList() {
        return $this->requirementList;
    }

    /**
     * @param Administration_Model_Requirementlist $requirementList
     */
    public function setRequirementList(Administration_Model_Requirementlist $requirementList) {
        $this->requirementList = $requirementList;
    }
    
}
