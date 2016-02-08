<?php

/**
 * Description of Vorteil
 *
 * @author Vosser
 */
class Application_Model_Klasse{
    
    protected $id;
    protected $bezeichnung;
    protected $beschreibung;
    protected $familienname;
    protected $kosten;
    protected $gruppe;
    
    
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

    public function getGruppe() {
        return $this->gruppe;
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

    public function setGruppe($gruppe) {
        $this->gruppe = $gruppe;
    }
    
    public function getFamilienname() {
        return $this->familienname;
    }

    public function setFamilienname($familienname) {
        $this->familienname = $familienname;
    }
    
}
