<?php

/**
 * Description of Trainingswerte
 *
 * @author Vosser
 */
class Application_Model_Trainingswerte {
    
    protected $strTraining;
    protected $agiTraining;
    protected $ausTraining;
    protected $disTraining;
    protected $konTraining;
    protected $praTraining;
    
    public function getStrTraining() {
        return $this->strTraining;
    }

    public function getAgiTraining() {
        return $this->agiTraining;
    }

    public function getAusTraining() {
        return $this->ausTraining;
    }

    public function getDisTraining() {
        return $this->disTraining;
    }

    public function getKonTraining() {
        return $this->konTraining;
    }

    public function getPraTraining() {
        return $this->praTraining;
    }

    public function setStrTraining($strTraining) {
        $this->strTraining = $strTraining;
    }

    public function setAgiTraining($agiTraining) {
        $this->agiTraining = $agiTraining;
    }

    public function setAusTraining($ausTraining) {
        $this->ausTraining = $ausTraining;
    }

    public function setDisTraining($disTraining) {
        $this->disTraining = $disTraining;
    }

    public function setKonTraining($konTraining) {
        $this->konTraining = $konTraining;
    }

    public function setPraTraining($praTraining) {
        $this->praTraining = $praTraining;
    }


    
}
