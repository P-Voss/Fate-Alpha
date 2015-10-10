<?php

/**
 * Description of Schule
 *
 * @author Vosser
 */
class Application_Model_Schule {
    
    protected $id;
    protected $bezeichnung;
    protected $beschreibung;
    protected $kosten;
    protected $magien = array();
    
    public function getId() {
        return $this->id;
    }

    public function getBezeichnung() {
        return $this->bezeichnung;
    }

    public function getBeschreibung() {
        return $this->beschreibung;
    }

    public function getKosten() {
        return $this->kosten;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setBezeichnung($bezeichnung) {
        $this->bezeichnung = $bezeichnung;
    }

    public function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    public function setKosten($kosten) {
        $this->kosten = $kosten;
    }
    
    /**
     * @return Application_Model_Magie
     */
    public function getMagien() {
        return $this->magien;
    }

    public function setMagien($magien) {
        foreach ($magien as $magie) {
            if($magie instanceof Application_Model_Magie){
                $this->addMagie($magie);
            }
        }
    }
    
    public function addMagie(Application_Model_Magie $magie) {
        $this->magien[] = $magie;
    }
    
}
