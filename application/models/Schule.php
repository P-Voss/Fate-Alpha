<?php

/**
 * Description of Schule
 *
 * @author Vosser
 */
class Application_Model_Schule {
    
    protected $id;
    protected $bezeichnung;
    protected $beschreibung;
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

    public function setKosten($kosten) {
        $this->kosten = $kosten;
    }

}
