<?php

/**
 * Description of Application_Model_Charakterprofil
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Charakterprofil {
    
    /**
     * @var string
     */
    protected $_charaktergeschichte;
    /**
     * @var string
     */
    protected $_privatdaten;
    /**
     * @var string
     */
    protected $_sldaten;
    /**
     * @var string
     */
    protected $_profilpic;
    /**
     * @var string
     */
    protected $_charpic;
    /**
     * @var string
     */
    protected $_kennenlerncode;
    /**
     * @var string
     */
    protected $_privatcode;
    
    public function getCharaktergeschichte() {
        return $this->_charaktergeschichte;
    }
    
    public function outputCharaktergeschichte() {
        return $this->_charaktergeschichte;
    }

    public function getPrivatdaten() {
        return $this->_privatdaten;
    }
    
    public function outputPrivatdaten() {
        return $this->_privatdaten;
    }

    public function getProfilpic() {
        return $this->_profilpic;
    }

    public function getCharpic() {
        return $this->_charpic;
    }

    public function getKennenlerncode() {
        return $this->_kennenlerncode;
    }

    public function getPrivatcode() {
        return $this->_privatcode;
    }

    public function setCharaktergeschichte($charaktergeschichte) {
        $this->_charaktergeschichte = $charaktergeschichte;
    }

    public function setPrivatdaten($privatdaten) {
        $this->_privatdaten = $privatdaten;
    }

    public function setProfilpic($profilpic) {
        $this->_profilpic = $profilpic;
    }

    public function setCharpic($charpic) {
        $this->_charpic = $charpic;
    }

    public function setKennenlerncode($kennenlerncode) {
        $this->_kennenlerncode = $kennenlerncode;
    }

    public function setPrivatcode($privatcode) {
        $this->_privatcode = $privatcode;
    }

    public function getSldaten() {
        return $this->_sldaten;
    }
    
    public function outputSldaten() {
        return $this->_sldaten;
    }

    public function setSldaten($sldaten) {
        $this->_sldaten = $sldaten;
    }
    
}
