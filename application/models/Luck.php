<?php

/**
 * Description of Luck
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Luck {
    
    protected $id;
    protected $kategorie;
    protected $beschreibung;
    protected $kosten;
    
    
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
    
}
