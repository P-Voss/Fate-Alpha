<?php

/**
 * Description of Requirementlist
 *
 * @author Voß
 */
class Erstellung_Model_Requirementlist implements Iterator
{

    /**
     * @var Erstellung_Model_Requirement[]
     */
    private $requirements = [];

    /**
     * @return Erstellung_Model_Requirement[]
     */
    public function getRequirements ()
    {
        return $this->requirements;
    }

    /**
     * @param Erstellung_Model_Requirement[] $requirements
     */
    public function setRequirements (array $requirements)
    {
        foreach ($requirements as $requirement) {
            if ($requirement instanceof Erstellung_Model_Requirement) {
                $this->requirements[] = $requirement;
            }
        }
    }

    /**
     * @param Erstellung_Model_Requirement $requirement
     */
    public function addRequirement (Erstellung_Model_Requirement $requirement)
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
