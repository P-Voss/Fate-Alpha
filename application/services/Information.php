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
     * @var Application_Model_Mapper_InformationMapper
     */
    private $informationMapper;
    
    public function __construct() {
        $this->informationMapper = new Application_Model_Mapper_InformationMapper();
    }
    
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
     * @return Application_Model_Information
     */
    public function getInformation(Zend_Controller_Request_Http $request, $userId) {
        return $this->informationMapper->getInformation($userId, $request->getParam('id'));
    }
    
    /**
     * @return \Application_Model_Information
     */
    public function getInformations() {
        return $this->informationMapper->getInformationsByUserId(Zend_Auth::getInstance()->getIdentity()->userId);
    }
    
    
    public function refreshInformation() {
        $charakterService = new Application_Service_Charakter();
        $informations = $this->initInformations();
        $users = $this->initUsers();
        $informationZuo = [];
        foreach ($users as $user) {
            $charakter = $charakterService->getCharakterByUserid($user->getId());
            $this->charakter = $charakter === false ? null : $charakter;
            $informationZuo[] = [
                'userId' => $user->getId(),
                'informationIds' => $this->buildInformationZuo($informations),
            ];
        }
        $this->informationMapper->truncateBenutzerinformationen();
        $this->informationMapper->saveBenutzerinformationen($informationZuo);
    }
    
    private function buildInformationZuo($informations) {
        $returnArray = [];
        foreach ($informations as $information) {
            if(count($information->getRequirementList()->getRequirements()) === 0){
                $returnArray[] = $information->getInformationId();
                continue;
            }
            if($this->charakter === null){
                continue;
            }
            if($this->checkValidation($information) === true){
                $returnArray[] = $information->getInformationId();
            }
        }
        return $returnArray;
    }
    
    /**
     * @param Application_Model_Information $information
     * @return boolean
     */
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
    
    
    private function initUsers() {
        $userService = new Application_Service_User();
        return $userService->getActiveUsers();
    }
    
    /**
     * @return Application_Model_Information
     */
    private function initInformations() {
        $informations = $this->informationMapper->getInformations();
        foreach ($informations as $information) {
            $information->setRequirementList($this->informationMapper->getRequirements($information->getInformationId()));
        }
        return $informations;
    }
    
}
