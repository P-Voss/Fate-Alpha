<?php

/**
 * Description of Application_Model_Charakterwerte
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Charakterwerte {
    
    protected $_staerke;
    protected $_agilitaet;
    protected $_ausdauer;
    protected $_disziplin;
    protected $_kontrolle;
    protected $_uebung;
    protected $_fp;
    protected $_startpunkte;
    
    public function getStaerke() {
        return $this->_staerke;
    }

    public function getAgilitaet() {
        return $this->_agilitaet;
    }

    public function getAusdauer() {
        return $this->_ausdauer;
    }

    public function getDisziplin() {
        return $this->_disziplin;
    }

    public function getKontrolle() {
        return $this->_kontrolle;
    }

    public function getUebung() {
        return $this->_uebung;
    }

    public function getFp() {
        return $this->_fp;
    }

    public function getStartpunkte() {
        return $this->_startpunkte;
    }

    public function setStaerke($staerke) {
        $this->_staerke = $staerke;
    }

    public function setAgilitaet($agilitaet) {
        $this->_agilitaet = $agilitaet;
    }

    public function setAusdauer($ausdauer) {
        $this->_ausdauer = $ausdauer;
    }

    public function setDisziplin($disziplin) {
        $this->_disziplin = $disziplin;
    }

    public function setKontrolle($kontrolle) {
        $this->_kontrolle = $kontrolle;
    }

    public function setUebung($uebung) {
        $this->_uebung = $uebung;
    }

    public function setFp($fp) {
        $this->_fp = $fp;
    }

    public function setStartpunkte($startpunkte) {
        $this->_startpunkte = $startpunkte;
    }
    
}
