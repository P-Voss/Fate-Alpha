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
    
    function getId() {
        return $this->id;
    }

    function getKategorie() {
        return $this->kategorie;
    }

    function getMenge() {
        return $this->menge;
    }

    function getBeschreibung() {
        return $this->beschreibung;
    }

    function getKosten() {
        return $this->kosten;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setKategorie($kategorie) {
        $this->kategorie = $kategorie;
    }

    function setMenge($menge) {
        $this->menge = $menge;
    }

    function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    function setKosten($kosten) {
        $this->kosten = $kosten;
    }
    
}
