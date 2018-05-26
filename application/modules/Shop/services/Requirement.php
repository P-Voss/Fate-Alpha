<?php
/**
 * Description of Requirement
 *
 * @author Voß
 */
class Shop_Service_Requirement {
    
    /**
     * @var Application_Model_Charakter
     */
    private $charakter;
    /**
     * @var Shop_Model_Requirements_Factory
     */
    private $factory;

    /**
     * @param Application_Model_Charakter $charakter
     */
    public function __construct(Application_Model_Charakter $charakter = null) {
        if($charakter !== null){
            $this->charakter = $charakter;
        }
        $this->factory = new Shop_Model_Requirements_Factory();
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     */
    public function setCharakter(Application_Model_Charakter $charakter) {
        $this->charakter = $charakter;
    }

    /**
     * @param Shop_Model_Requirementlist $requirementList
     *
     * @return boolean
     * @throws Exception
     */
    public function validate(Shop_Model_Requirementlist $requirementList) {
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
