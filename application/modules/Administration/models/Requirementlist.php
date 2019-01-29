<?php

/**
 * Description of Requirementlist
 *
 * @author Voß
 */
class Administration_Model_Requirementlist implements Iterator
{

    /**
     * @var array
     */
    private $requirements = [];

    /**
     * @return Administration_Model_Requirement[]
     */
    public function getRequirements ()
    {
        return $this->requirements;
    }

    /**
     * @param array $requirements
     */
    public function setRequirements (array $requirements)
    {
        foreach ($requirements as $requirement) {
            if ($requirement instanceof Administration_Model_Requirement) {
                $this->requirements[] = $requirement;
            }
        }
    }


    /**
     * @param $key
     *
     * @return Administration_Model_Requirement|mixed
     */
    public function getRequirementByKey ($key)
    {
        foreach ($this->requirements as $requirement) {
            if ($requirement->getArt() === $key) {
                return $requirement;
            }
        }
        return new Administration_Model_Requirement();
    }


    /**
     * @param $key
     *
     * @return array
     */
    public function getRequirementArrayByKey ($key)
    {
        $returnArray = [];
        foreach ($this->requirements as $requirement) {
            if ($requirement->getArt() === $key) {
                $returnArray[] = $requirement;
            }
        }
        return $returnArray;
    }


    /**
     * @param Administration_Model_Requirement $requirement
     */
    public function addRequirement (Administration_Model_Requirement $requirement)
    {
        $this->requirements[] = $requirement;
    }

    /**
     * @return mixed|void
     */
    public function current ()
    {

    }

    /**
     *
     */
    public function next ()
    {

    }

    /**
     * @return mixed|void
     */
    public function key ()
    {

    }

    /**
     *
     */
    public function rewind ()
    {

    }

    /**
     * @return bool|void
     */
    public function valid ()
    {

    }

}
