<?php

/**
 * Description of Plot
 *
 * @author Voß
 */
class Application_Model_Plot {
    
    protected $id;
    protected $slId;
    protected $name;
    protected $beschreibung;
    protected $zusammenfassung;
    protected $genres = array();
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function getBeschreibung() {
        return $this->beschreibung;
    }

    public function getGenres() {
        return $this->genres;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    public function setGenres($genres) {
        $this->genres = $genres;
    }
    
    public function getSlId() {
        return $this->slId;
    }

    public function setSlId($slId) {
        $this->slId = $slId;
    }
    
    public function getZusammenfassung() {
        return $this->zusammenfassung;
    }

    public function setZusammenfassung($zusammenfassung) {
        $this->zusammenfassung = $zusammenfassung;
    }
    
}
