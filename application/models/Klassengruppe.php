<?php

/**
 * Description of Klassengruppe
 *
 * @author Vosser
 */
class Application_Model_Klassengruppe{
    
    protected $id;
    protected $bezeichnung;
    protected $beschreibung;
    
    
    public function getId() {
        return $this->id;
    }

    public function getBezeichnung() {
        return $this->bezeichnung;
    }

    public function getBeschreibung() {
        return $this->beschreibung;
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
    
}
