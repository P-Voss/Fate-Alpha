<?php

/**
 * Class Shop_Model_Item
 */
class Shop_Model_Item extends Application_Model_Item
{

    /**
     * @var boolean
     */
    private $learned = false;
    /**
     * @var Shop_Model_Requirementlist
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
     * @return Shop_Model_Requirementlist
     */
    public function getRequirementList ()
    {
        return $this->requirementList;
    }

    /**
     * @param Shop_Model_Requirementlist $requirementList
     */
    public function setRequirementList (Shop_Model_Requirementlist $requirementList)
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