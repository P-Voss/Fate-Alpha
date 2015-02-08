<?php

/**
 * Description of Application_Model_Charakterprofil
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Charakterprofil {
    
    protected $_charakterid;
    protected $_charaktergeschichte;
    protected $_privatdaten;
    protected $_sldaten;
    protected $_profilpic;
    protected $_charpic;
    protected $_kennenlerncode;
    protected $_privatcode;
    
    public function getCharaktergeschichte() {
        return $this->_charaktergeschichte;
    }

    public function getPrivatdaten() {
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
    
    public function getCharakterid() {
        return $this->_charakterid;
    }

    public function getSldaten() {
        return $this->_sldaten;
    }

    public function setCharakterid($charakterid) {
        $this->_charakterid = $charakterid;
    }

    public function setSldaten($sldaten) {
        $this->_sldaten = $sldaten;
    }
    
}
