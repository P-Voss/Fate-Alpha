<?php
/**
 * Description of Requirement
 *
 * @author Voß
 */
class Gruppen_Service_Requirement {
    
    /**
     * @var Application_Model_Charakter
     */
    private $charakter;
    /**
     * @var \Shop\Models\Requirements\Factory
     */
    private $factory;

    /**
     * @param Application_Model_Charakter $charakter
     */
    public function __construct(Application_Model_Charakter $charakter = null) {
        if($charakter !== null){
            $this->charakter = $charakter;
        }
        $this->factory = new \Shop\Models\Requirements\Factory();
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     */
    public function setCharakter(Application_Model_Charakter $charakter) {
        $this->charakter = $charakter;
    }

    /**
     * @param \Shop\Models\Requirementlist $requirementList
     *
     * @return boolean
     * @throws Exception
     */
    public function validate(\Shop\Models\Requirementlist $requirementList) {
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
