<?php

/**
 * Description of Odo
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Odo {
    
    protected $id;
    protected $kategorie;
    protected $beschreibung;
    protected $kosten;
    protected $menge;
    protected $modified;
    protected $modification = 0;
    

    public function getId() {
        return $this->id;
    }

    public function getKategorie() {
        return $this->kategorie;
    }

    public function getBeschreibung() {
        return $this->beschreibung;
    }

    public function getKosten() {
        return $this->kosten;
    }

    public function getMenge() {
        return $this->menge;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setKategorie($kategorie) {
        $this->kategorie = $kategorie;
    }

    public function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    public function setKosten($kosten) {
        $this->kosten = $kosten;
    }

    public function setMenge($menge) {
        $this->menge = $menge;
    }
    
    public function getModified() {
        return $this->modified === true;
    }

    public function setModified($modified) {
        $this->modified = $modified;
    }
    
    public function getModification() {
        return $this->modification;
    }

    public function setModification($modification) {
        $this->modification += $modification;
    }
    
}
