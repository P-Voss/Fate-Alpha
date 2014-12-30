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
    
    function getId() {
        return $this->id;
    }

    function getBezeichnung() {
        return $this->bezeichnung;
    }

    function getBeschreibung() {
        return $this->beschreibung;
    }

    function getCharakterisierung() {
        return $this->charakterisierung;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setBezeichnung($bezeichnung) {
        $this->bezeichnung = $bezeichnung;
    }

    function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    function setCharakterisierung($charakterisierung) {
        $this->charakterisierung = $charakterisierung;
    }
    
}
