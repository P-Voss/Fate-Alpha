<?php

/**
 * Description of Wetter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Wetter {
    
    public $name;
    public $beschreibung;
    public $image;
    
    public  function getName() {
        return $this->name;
    }

    public function getBeschreibung() {
        return $this->beschreibung;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }
    
    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

}
