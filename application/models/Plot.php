<?php

/**
 * Description of Plot
 *
 * @author Voß
 */
class Application_Model_Plot {
    
    protected $id;
    protected $name;
    protected $beschreibung;
    protected $genres = array();
    /**
     * @var DateTime
     */
    protected $createDate;
    
    public function getId() {
        return $this->id;
    }

    public function getCreateDate($format = 'd.m.Y H:i:s') {
        $date = new DateTime($this->createDate);
        return $date->format($format);
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCreateDate($createDate) {
        $this->createDate = $createDate;
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
    
}
