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
    
    
    function getId() {
        return $this->id;
    }

    function getKategorie() {
        return $this->kategorie;
    }

    function getBeschreibung() {
        return $this->beschreibung;
    }

    function getKosten() {
        return $this->kosten;
    }

    function getMenge() {
        return $this->menge;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setKategorie($kategorie) {
        $this->kategorie = $kategorie;
    }

    function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    function setKosten($kosten) {
        $this->kosten = $kosten;
    }

    function setMenge($menge) {
        $this->menge = $menge;
    }
    
}
