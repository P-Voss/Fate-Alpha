<?php

namespace Shop\Services;

use Application_Model_Charakter;
use Shop\Models\Requirementlist;
use Shop\Models\Requirements\Factory;


/**
 * Class Requirement
 * @package Shop\Services
 */
class Requirement
{

    /**
     * @var \Application_Model_Charakter
     */
    private $charakter;
    /**
     * @var Factory
     */
    private $factory;
    /**
     * @var array
     */
    private $lastErrors = [];

    /**
     * @param Application_Model_Charakter $charakter
     */
    public function __construct (Application_Model_Charakter $charakter = null)
    {
        if ($charakter !== null) {
            $this->charakter = $charakter;
        }
        $this->factory = new Factory();
    }

    /**
     * @param Application_Model_Charakter $charakter
     */
    public function setCharakter (Application_Model_Charakter $charakter)
    {
        $this->charakter = $charakter;
    }

    /**
     * @param Requirementlist $requirementList
     *
     * @return boolean
     * @throws \Exception
     */
    public function validate (Requirementlist $requirementList)
    {
        $this->lastErrors = [];
        $requirements = $requirementList->getRequirements();
        $validWildcard = false;
        $hasWildcard = false;
        foreach ($requirements as $requirement) {
            $validator = $this->factory->getValidator($requirement->getArt());
            if ($validator->isIncompatible($this->charakter, $requirement->getRequiredValue())) {
                $this->lastErrors[] = [
                    'art' => $requirement->getArt(),
                    'wert' => $requirement->getRequiredValue(),
                ];
                return false;
            }
            if ($validator->isWildcard()) {
                $hasWildcard = true;
                if ($validWildcard) {
                    continue;
                }
                if ($validator->successfulWildcard($this->charakter, $requirement->getRequiredValue())) {
                    $validWildcard = true;
                    continue;
                }
            }
            if ($validator->check($this->charakter, $requirement->getRequiredValue()) === false) {
                $this->lastErrors[] = [
                    'art' => $requirement->getArt(),
                    'wert' => $requirement->getRequiredValue(),
                ];
            }
        }

        if ($hasWildcard && $validWildcard === false) {
            return false;
        }
        return count($this->lastErrors) === 0;
    }

    /**
     * @return array
     */
    public function getErrors ()
    {
        return $this->lastErrors;
    }

}
