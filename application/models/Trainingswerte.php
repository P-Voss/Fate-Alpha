<?php

/**
 * Description of Trainingswerte
 *
 * @author Vosser
 */
class Application_Model_Trainingswerte {
    
    protected $staerke;
    protected $agilitaet;
    protected $ausdauer;
    protected $disziplin;
    protected $kontrolle;
    protected $uebung;
    
    public function getStrTraining() {
        return $this->staerke;
    }

    public function getAgiTraining() {
        return $this->agilitaet;
    }

    public function getAusTraining() {
        return $this->ausdauer;
    }

    public function getDisTraining() {
        return $this->disziplin;
    }

    public function getKonTraining() {
        return $this->kontrolle;
    }

    public function getPraTraining() {
        return $this->uebung;
    }

    public function setStrTraining($strTraining) {
        $this->staerke = $strTraining;
    }

    public function setAgiTraining($agiTraining) {
        $this->agilitaet = $agiTraining;
    }

    public function setAusTraining($ausTraining) {
        $this->ausdauer = $ausTraining;
    }

    public function setDisTraining($disTraining) {
        $this->disziplin = $disTraining;
    }

    public function setKonTraining($konTraining) {
        $this->kontrolle = $konTraining;
    }

    public function setPraTraining($praTraining) {
        $this->uebung = $praTraining;
    }

}
