<?php

namespace Shop\Models;

/**
 * Description of Magie
 *
 * @author Vosser
 */
class Magie extends \Application_Model_Magie
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
