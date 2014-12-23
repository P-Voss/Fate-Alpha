<?php

/**
 * Description of Charakterprofil
 *
 * @author Vosser
 */
class Application_Model_Charakterprofil {
    
    protected $charakterid;
    protected $charaktergeschichte;
    protected $privatdaten;
    protected $profilpic;
    protected $charpic;
    protected $kennenlerncode;
    protected $privatcode;
    
    public function getCharaktergeschichte() {
        return $this->charaktergeschichte;
    }

    public function getPrivatdaten() {
        return $this->privatdaten;
    }

    public function getProfilpic() {
        return $this->profilpic;
    }

    public function getCharpic() {
        return $this->charpic;
    }

    public function getKennenlerncode() {
        return $this->kennenlerncode;
    }

    public function getPrivatcode() {
        return $this->privatcode;
    }

    public function setCharaktergeschichte($charaktergeschichte) {
        $this->charaktergeschichte = $charaktergeschichte;
    }

    public function setPrivatdaten($privatdaten) {
        $this->privatdaten = $privatdaten;
    }

    public function setProfilpic($profilpic) {
        $this->profilpic = $profilpic;
    }

    public function setCharpic($charpic) {
        $this->charpic = $charpic;
    }

    public function setKennenlerncode($kennenlerncode) {
        $this->kennenlerncode = $kennenlerncode;
    }

    public function setPrivatcode($privatcode) {
        $this->privatcode = $privatcode;
    }


    
}
