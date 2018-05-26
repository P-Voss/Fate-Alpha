<?php
/**
 * Description of Requirement
 *
 * @author Voß
 */
class Erstellung_Service_Requirement {
    
    /**
     * @var Erstellung_Model_Charakter
     */
    private $charakter;
    /**
     * @var Erstellung_Model_Requirements_Factory
     */
    private $factory;

    /**
     * @param Erstellung_Model_Charakter $charakter
     */
    public function __construct(Erstellung_Model_Charakter $charakter = null) {
        if($charakter !== null){
            $this->charakter = $charakter;
        }
        $this->factory = new Erstellung_Model_Requirements_Factory();
    }
    
    /**
     * @param Erstellung_Model_Charakter $charakter
     */
    public function setCharakter(Erstellung_Model_Charakter $charakter) {
        $this->charakter = $charakter;
    }

    /**
     * @param Erstellung_Model_Requirementlist $requirementList
     *
     * @return boolean
     * @throws Exception
     */
    public function validate(Erstellung_Model_Requirementlist $requirementList) {
        $errors = array();
        $requirements = $requirementList->getRequirements();
        foreach ($requirements as $requirement){
            $validator = $this->factory->getValidator($requirement->getArt());
            if($validator->check($this->charakter, $requirement->getRequiredValue()) === false){
                $errors[] = [
                    'art' => $requirement->getArt(),
                    'wert' => $requirement->getRequiredValue(),
                ];
            }
        }
        if(count($errors) > 0){
            return $errors;
        }
        return true;
    }
    
}
