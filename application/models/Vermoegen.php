<?php

/**
 * Description of Application_Model_Vermoegen
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Vermoegen {
    
    protected $id;
    protected $kategorie;
    protected $beschreibung;
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
