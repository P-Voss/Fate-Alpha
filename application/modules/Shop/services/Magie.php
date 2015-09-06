<?php
/**
 * Description of Shop_Service_Magie
 *
 * @author Voß
 */
class Shop_Service_Magie {
    
    /**
     * @var Shop_Model_Mapper_SchuleMapper
     */
    private $mapper;
    /**
     * @var Shop_Model_Mapper_MagieMapper
     */
    private $magieMapper;
    /**
     * @var Shop_Service_Requirement
     */
    private $requirementValidator;
    
    public function __construct() {
        $this->requirementValidator = new Shop_Service_Requirement();
        $this->mapper = new Shop_Model_Mapper_SchuleMapper();
        $this->magieMapper = new Shop_Model_Mapper_MagieMapper();
    }
    
    public function getMagieschulenForCharakter(Application_Model_Charakter $charakter) {
        $schulen = array();
        $this->requirementValidator->setCharakter($charakter);
        $magieschulen = $this->mapper->getAllSchools();
        foreach ($magieschulen as $magieschule){
            if($this->mapper->checkIfLearned($charakter->getCharakterid(), $magieschule->getId())){
                $magieschule->setLearned(true);
                $magieschule->setRequirementList(new Shop_Model_Requirementlist());
            }else{
                $magieschule->setRequirementList($this->mapper->getRequirements($magieschule->getId()));
                $magieschule->setLearned(false);
            }
            if($this->requirementValidator->validate($magieschule->getRequirementList())){
                $schulen[] = $magieschule;
            }
        }
        return $schulen;
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param int $schuleId
     */
    public function unlockSchool(Application_Model_Charakter $charakter, $schuleId) {
        $this->requirementValidator->setCharakter($charakter);
        $magieschule = $this->mapper->getMagieschuleById($schuleId);
        if($this->requirementValidator->validate($this->mapper->getRequirements($magieschule->getId()))){
            $this->mapper->unlockMagieschuleForCharakter($charakter, $magieschule);
        }
    }
    
    
    public function unlockMagie(Application_Model_Charakter $charakter, $magieId) {
        $this->requirementValidator->setCharakter($charakter);
        $magie = $this->magieMapper->getMagieById($magieId);
        if($this->magieMapper->checkIfLearned($charakter->getCharakterid(), $magie->getId()) === true){
            return array(
                'failure' => 'Magie wurde schon erlernt!',
            );
        }
        if($magie->getFp() > $charakter->getCharakterwerte()->getFp()){
            return array(
                'failure' => 'Du hast nicht genug FP!'
            );
        }
        if($this->requirementValidator->validate($this->magieMapper->getRequirements($magie->getId())) === false){
            return array(
                'failure' => 'Der Charakter erfüllt nicht alle Voraussetzungen zum Erlernen der Magie!',
            );
        }
        if($this->magieMapper->unlockMagie($charakter, $magie)){
            return array(
                'success' => 'Magie erlernt!',
            );
        }else{
            return array(
                'failure' => 'Da trat ein Fehler auf, frag mal einen Admin!',
            );
        }
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param int $magieschuleId
     * @return array
     */
    public function getUnlearnedMagienBySchulId(Application_Model_Charakter $charakter, $magieschuleId) {
        $this->requirementValidator->setCharakter($charakter);
        $magien = $this->magieMapper->getMagienByMagieschuleId($magieschuleId);
        $returnMagien = array();
        foreach ($magien as $magie){
            $magie->setLearned($this->magieMapper->checkIfLearned($charakter->getCharakterid(), $magie->getId()));
            if($this->requirementValidator->validate($this->magieMapper->getRequirements($magie->getId()))){
                $returnMagien[] = $magie;
            }
        }
        return $returnMagien;
    }
    
}
