<?php

/**
 * Description of Training
 *
 * @author Vosser
 */
class Application_Service_Training {
    
    public function init(){
        
    }

    public function getTrainingswerte($charakterid){
        $model = new Application_Model_Trainingswerte();
        $mapper = new Application_Model_Mapper_CharakterMapper();
        $charakter = $mapper->getCharakterById(Zend_Auth::getInstance()->getIdentity()->ID);
        $model = $this->getTrainingswerteAfterVorteil($model, $charakter->getVorteile());
        $model = $this->getTrainingswerteAfterNachteil($model, $charakter->getNachteile());
        $model = $this->getTrainingswerteAfterKlasse($model, $charakter->getKlasse(), $charakter->getKlassengruppe());
    }
    
    public function getTrainingswerteAfterVorteil($model, $vorteile = array()){
        
    }
    
    public function getTrainingswerteAfterNachteil($model, $nachteile = array()) {
        
    }
    
    public function getTrainingswerteAfterKlasse($model, $klasse, $klassengruppe){
        
    }
    
}
