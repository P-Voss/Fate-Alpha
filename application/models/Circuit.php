<?php

/**
 * Description of Circuit
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Circuit {
    
    protected $id;
    protected $kategorie;
    protected $menge;
    protected $beschreibung;
    protected $kosten;
    
    public function getId() {
        return $this->id;
    }

    public function getKategorie() {
        return $this->kategorie;
    }

    public function getMenge() {
        return $this->menge;
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

    public function setKategorie($kategorie) {
        $this->kategorie = $kategorie;
    }

    public function setMenge($menge) {
        $this->menge = $menge;
    }

    public function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    public function setKosten($kosten) {
        $this->kosten = $kosten;
    }
    
}
