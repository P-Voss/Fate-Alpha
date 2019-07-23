<?php

namespace Shop\Models;

/**
 * Description of Skill
 *
 * @author Vosser
 */
class Skill extends \Application_Model_Skill
{

    /**
     * @var boolean
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

    /**
     * @return array
     */
    public function jsonSerialize ()
    {
        $return = [];
        foreach (get_object_vars($this) as $key => $property) {
            $return[$key] = $property;
        }
        return $return;
    }

}
