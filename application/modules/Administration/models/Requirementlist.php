<?php

/**
 * Description of Requirementlist
 *
 * @author Voß
 */
class Administration_Model_Requirementlist
{

    CONST DELIMITER = '|';
    /**
     * @var Administration_Model_Requirement[]
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
     * @return Administration_Model_Requirement
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
     * @return Administration_Model_Requirement
     */
    public function get($key)
    {
        return $this->getRequirementByKey($key);
    }

    /**
     * @param $key
     *
     * @return array
     */
    public function getRequirementValuesByKey ($key)
    {
        foreach ($this->requirements as $requirement) {
            if ($requirement->getArt() === $key) {
                return explode(self::DELIMITER, $requirement->getRequiredValue());
            }
        }
        return [];
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

}
