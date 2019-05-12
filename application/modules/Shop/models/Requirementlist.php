<?php

/**
 * Description of Requirementlist
 *
 * @author Voß
 */
class Shop_Model_Requirementlist implements Iterator
{

    /**
     * @var Shop_Model_Requirement[]
     */
    private $requirements = [];

    /**
     * @return Shop_Model_Requirement[]
     */
    public function getRequirements ()
    {
        return $this->requirements;
    }

    /**
     * @param Shop_Model_Requirement[] $requirements
     */
    public function setRequirements (array $requirements)
    {
        foreach ($requirements as $requirement) {
            $this->addRequirement($requirement);
        }
    }

    /**
     * @param Shop_Model_Requirement $requirement
     */
    public function addRequirement (Shop_Model_Requirement $requirement)
    {
        $this->requirements[] = $requirement;
    }

    public function current ()
    {

    }

    public function next ()
    {

    }

    public function key ()
    {

    }

    public function rewind ()
    {

    }

    public function valid ()
    {

    }

}
