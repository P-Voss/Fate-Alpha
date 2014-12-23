<?php

/**
 * Description of Vorteil
 *
 * @author Vosser
 */
class Application_Model_Vorteil {
    
    protected $id;
    protected $name;
    protected $bezeichnung;
    protected $kosten;
    protected $gruppe;
    
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getBezeichnung() {
        return $this->bezeichnung;
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

    public function setName($name) {
        $this->name = $name;
    }

    public function setBezeichnung($bezeichnung) {
        $this->bezeichnung = $bezeichnung;
    }

    public function setKosten($kosten) {
        $this->kosten = $kosten;
    }

    public function setGruppe($gruppe) {
        $this->gruppe = $gruppe;
    }
    
}
