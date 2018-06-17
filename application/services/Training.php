<?php

/**
 * Description of Training
 *
 * @author Vosser
 */
class Application_Service_Training {
    
    private $trainingsMapper;
    
    public function __construct(){
        $this->trainingsMapper = new Application_Model_Mapper_TrainingMapper();
    }

    /**
     * @param int $charakterId
     *
     * @throws Exception
     */
    public function getTrainingPrograms ($charakterId)
    {
        $programs = $this->trainingsMapper->getTrainingPrograms();
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @return Application_Model_Trainingswerte
     * @throws Exception
     */
    public function getTrainingswerte(Application_Model_Charakter $charakter){
        if(($trainingswerte = $this->trainingsMapper->getDefaultTraining()) === false){
            throw new Exception('Es wurden keine Standardwerte angegeben');
        }
        $trainingswerte = $this->trainingsMapper->getRealTraining($trainingswerte, $charakter);
        return $this->trainingsMapper->setOtherValuesNull($trainingswerte, $charakter);
    }

    /**
     * @param Application_Model_Charakter $charakter
     * @param Application_Model_Trainingswerte $trainingswerte
     * @param Zend_Controller_Request_Http $request
     *
     * @return bool|int|mixed
     * @throws Exception
     */
    public function startTraining(Application_Model_Charakter $charakter, Application_Model_Trainingswerte $trainingswerte, Zend_Controller_Request_Http $request) {
        $training = $request->getPost('Wert');
        $wert = $request->getParam($training);
        $return = false;
        if(property_exists($trainingswerte, $training)){
            if($this->trainingsMapper->checkTraining($charakter->getCharakterid())){
                $return = $this->trainingsMapper->updateTraining($charakter->getCharakterid(), $training, $wert);
            }else{
                $return = $this->trainingsMapper->setTraining($charakter->getCharakterid(), $training, $wert);
            }
        }
        return $return;
    }

    /**
     * @throws Exception
     */
    public function executeTraining() {
        $charakterIds = $this->trainingsMapper->getCharakterIdsToTrain();
        $defaultTraining = $this->trainingsMapper->getDefaultTraining();
        foreach ($charakterIds as $id) {
            $charakter = $this->initCharakter($id);
            $trainingswerte = $this->trainingsMapper->getRealTraining($defaultTraining, $charakter);
            $this->trainingsMapper->updateStats($charakter, $trainingswerte);
        }
    }

    /**
     * @throws Exception
     */
    public function addFp() {
        $this->trainingsMapper->addFp();
    }

    /**
     * @throws Exception
     */
    public function addBirthdayFp() {
        $this->trainingsMapper->addBirthdayFp();
    }

    /**
     * @param int $charakterId
     *
     * @return Application_Model_Charakter
     * @throws Exception
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

    /**
     * @param Application_Model_Charakter $charakter
     * @param int $days
     * @param string $attribute
     * @throws Exception
     */
    public function addBonusTraining(Application_Model_Charakter $charakter, $days, $attribute) {
        $trainingswerte = $this->getTrainingswerte($charakter);
        $werte = $charakter->getCharakterwerte();
        
        for($i = 0; $i < $days && $i < $werte->getStartpunkte(); $i++){
            $werte->addTraining(['training' => $attribute], $trainingswerte);
        }
        $werte->setStartpunkte($werte->getStartpunkte() - $i);
        $this->trainingsMapper->addBonusTraining($charakter->getCharakterid(), $werte);
    }
    
}
