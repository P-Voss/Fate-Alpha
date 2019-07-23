<?php

namespace Shop\Models;

/**
 * Description of Schule
 *
 * @author Vosser
 */
class Schule extends \Application_Model_Schule
{

    /**
     * @var bool
     */
    private $learned;
    /**
     * @var Requirementlist
     */
    private $requirementList;

    /**
     * @return bool
     */
    public function getLearned ()
    {
        return $this->learned;
    }

    /**
     * @param $learned
     */
    public function setLearned ($learned)
    {
        $this->learned = $learned;
    }

    /**
     * @return Requirementlist
     */
    public function getRequirementList ()
    {
        return $this->requirementList;
    }

    /**
     * @param Requirementlist $requirementList
     */
    public function setRequirementList (Requirementlist $requirementList)
    {
        $this->requirementList = $requirementList;
    }

}
