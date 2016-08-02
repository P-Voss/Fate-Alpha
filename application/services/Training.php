<?php

/**
 * Description of Training
 *
 * @author Vosser
 */
class Application_Service_Training {
    
    private $_trainingsMapper;
    
    public function init(){
        
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @return Application_Model_Trainingswerte
     * @throws Exception
     */
    public function getTrainingswerte(Application_Model_Charakter $charakter){
        $this->_trainingsMapper = new Application_Model_Mapper_TrainingMapper();
        if(($trainingswerte = $this->_trainingsMapper->getDefaultTraining()) === false){
            throw new Exception('Es wurden keine Standardwerte angegeben');
        }
        $trainingswerte = $this->_trainingsMapper->getRealTraining($trainingswerte, $charakter);
        return $this->_trainingsMapper->setOtherValuesNull($trainingswerte, $charakter);
    }
    
    /**
     * @param Application_Model_Charakter $charakter
     * @param Application_Model_Trainingswerte $trainingswerte
     * @param Zend_Controller_Request_Http $request
     * @return integer
     */
    public function startTraining(Application_Model_Charakter $charakter, Application_Model_Trainingswerte $trainingswerte, Zend_Controller_Request_Http $request) {
        $this->_trainingsMapper = new Application_Model_Mapper_TrainingMapper();
        $training = $request->getPost('Wert');
        $wert = $request->getParam($training);
        $return = false;
        if(property_exists($trainingswerte, $training)){
            if($this->_trainingsMapper->checkTraining($charakter->getCharakterid())){
                $return = $this->_trainingsMapper->updateTraining($charakter->getCharakterid(), $training, $wert);
            }else{
                $return = $this->_trainingsMapper->setTraining($charakter->getCharakterid(), $training, $wert);
            }
        }
        return $return;
    }
    
    /**
     * 
     */
    public function executeTraining() {
        $this->_trainingsMapper = new Application_Model_Mapper_TrainingMapper();
        $charakterIds = $this->_trainingsMapper->getCharakterIdsToTrain();
        $defaultTraining = $this->_trainingsMapper->getDefaultTraining();
        foreach ($charakterIds as $id) {
            $charakter = $this->initCharakter($id);
            $trainingswerte = $this->_trainingsMapper->getRealTraining($defaultTraining, $charakter);
            $this->_trainingsMapper->updateStats($charakter, $trainingswerte);
        }
    }
    
    
    public function addFp() {
        $this->_trainingsMapper = new Application_Model_Mapper_TrainingMapper();
        $this->_trainingsMapper->addFp();
    }
    
    /**
     * @param int $charakterId
     * @return Application_Model_Charakter
     */
    private function initCharakter($charakterId){
        $charakterMapper = new Application_Model_Mapper_CharakterMapper();
        $klassenMapper = new Application_Model_Mapper_KlasseMapper();
        $charakter = $charakterMapper->getCharakter($charakterId);
        $charakter->setKlasse($charakterMapper->getCharakterKlasse($charakter->getCharakterid()));
        $charakter->setKlassengruppe($klassenMapper->getKlassengruppe($charakter->getKlasse()->getId()));
        $charakter->setElemente($charakterMapper->getCharakterElemente($charakter->getCharakterid()));
        $charakter->setCharakterwerte($charakterMapper->getCharakterwerte($charakter->getCharakterid()));
        $charakter->setVorteile($charakterMapper->getVorteileByCharakterId($charakter->getCharakterid()));
        $charakter->setNachteile($charakterMapper->getNachteileByCharakterId($charakter->getCharakterid()));
        return $charakter;
    }
    
}
