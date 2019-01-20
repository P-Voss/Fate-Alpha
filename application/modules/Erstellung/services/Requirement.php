<?php

/**
 * Description of Requirement
 *
 * @author Voß
 */
class Erstellung_Service_Requirement
{

    /**
     * @var Erstellung_Model_Character
     */
    private $charakter;
    /**
     * @var Erstellung_Model_Requirements_Factory
     */
    private $factory;
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @param Erstellung_Model_Character $charakter
     */
    public function __construct (Erstellung_Model_Character $charakter = null)
    {
        if ($charakter !== null) {
            $this->charakter = $charakter;
        }
        $this->factory = new Erstellung_Model_Requirements_Factory();
    }

    /**
     * @param Erstellung_Model_Character $charakter
     */
    public function setCharakter (Erstellung_Model_Character $charakter)
    {
        $this->charakter = $charakter;
    }

    /**
     * @param Erstellung_Model_Requirementlist $requirementList
     *
     * @return boolean
     * @throws Exception
     */
    public function validate (Erstellung_Model_Requirementlist $requirementList)
    {
        $this->errors = [];
        $requirements = $requirementList->getRequirements();
        foreach ($requirements as $requirement) {
            $validator = $this->factory->getValidator($requirement->getArt());
            if ($validator->check($this->charakter, $requirement->getRequiredValue()) === false) {
                $this->errors[] = [
                    'art' => $requirement->getArt(),
                    'wert' => $requirement->getRequiredValue(),
                ];
            }
        }
        return count($this->errors) === 0;
    }

}
