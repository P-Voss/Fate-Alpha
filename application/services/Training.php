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

    public function getTrainingswerte(Application_Model_Charakter $charakter){
        $this->_trainingsMapper = new Application_Model_Mapper_TrainingMapper();
        if(($trainingswerte = $this->_trainingsMapper->getDefaultTraining()) === false){
            throw new Exception('Es wurden keine Standardwerte angegeben');
        }
        $trainingswerte = $this->_trainingsMapper->getRealTraining($trainingswerte, $charakter);
        return $this->_trainingsMapper->setOtherValuesNull($trainingswerte, $charakter);
    }
    
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
    
}
