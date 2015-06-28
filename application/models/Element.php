<?php

/**
 * Description of Element
 *
 * @author Vosser
 */
class Application_Model_Element {
    
    protected $id;
    protected $bezeichnung;
    protected $beschreibung;
    protected $charakterisierung;
    protected $kosten;
    
    public function getId() {
        return $this->id;
    }

    public function getBezeichnung() {
        return $this->bezeichnung;
    }

    public function getBeschreibung() {
        return $this->beschreibung;
    }

    public function getCharakterisierung() {
        return $this->charakterisierung;
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

    public function setCharakterisierung($charakterisierung) {
        $this->charakterisierung = $charakterisierung;
    }

    public function setKosten($kosten) {
        $this->kosten = $kosten;
    }
    
}
