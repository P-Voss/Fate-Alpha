<?php

/**
 * Description of Information
 *
 * @author Vosser
 */
class Application_Service_Information {
    
    /**
     * @var Application_Model_Charakter
     */
    private $charakter;
    /**
     * @var Application_Service_Requirement
     */
    private $requirementValidator;
    
    /**
     * @param Application_Model_Charakter $charakter
     */
    public function setCharakter(Application_Model_Charakter $charakter) {
        $this->charakter = $charakter;
        $this->requirementValidator = new Application_Service_Requirement($charakter);
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @param int $userId
     * @return boolean | Application_Model_Information
     */
    public function getInformation(Zend_Controller_Request_Http $request, $userId) {
        $charakterService = new Application_Service_Charakter();
        $mapper = new Application_Model_Mapper_InformationMapper();
        $charakter = $charakterService->getCharakterByUserid($userId);
        if($charakter !== false){
            $this->setCharakter($charakter);
        }
        $information = $mapper->getInformation($request->getParam('id'));
        if($information->getInformationId() === null){
            return false;
        }
        $information->setRequirementList($mapper->getRequirements($information->getInformationId()));
        if($this->checkValidation($information) === true){
            return $information;
        }else{
            return false;
        }
    }
    
    /**
     * @return array
     */
    public function getInformations() {
        $returnArray = array();
        $mapper = new Application_Model_Mapper_InformationMapper();
        $informations = $mapper->getInformations();
        foreach ($informations as $information) {
            $information->setRequirementList($mapper->getRequirements($information->getInformationId()));
            if(count($information->getRequirementList()->getRequirements()) === 0){
                $returnArray[] = $information;
                continue;
            }
            if($this->charakter === null){
                continue;
            }
            if($this->checkValidation($information) === true){
                $returnArray[] = $information;
            }
        }
        return $returnArray;
    }
    
    
    private function checkValidation(Application_Model_Information $information){
        $validatorFactory = new Application_Model_Requirements_Factory();
        foreach ($information->getRequirementList()->getRequirements() as $requirement) {
            $validator = $validatorFactory->getValidator($requirement->getArt());
            if($validator->check($this->charakter, $requirement->getRequiredValue()) !== true){
                return false;
            }
        }
        return true;
    }
    
}
