<?php

namespace Shop\Models;

/**
 * Description of Requirementlist
 *
 * @author Voß
 */
class Requirementlist implements \Iterator
{

    /**
     * @var Requirement[]
     */
    private $requirements = [];

    /**
     * @return Requirement[]
     */
    public function getRequirements ()
    {
        return $this->requirements;
    }

    /**
     * @param Requirement[] $requirements
     */
    public function setRequirements (array $requirements)
    {
        foreach ($requirements as $requirement) {
            $this->addRequirement($requirement);
        }
    }

    /**
     * @param Requirement $requirement
     */
    public function addRequirement (Requirement $requirement)
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
