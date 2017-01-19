<?php

/**
 * Description of Application_Model_Achievement
 *
 * @author Voß
 */
class Application_Model_Achievement {
    
    protected $id;
    protected $charakterId;
    protected $titel;
    protected $beschreibung;
    protected $creationDate;
    
    public function getId() {
        return $this->id;
    }

    public function getCharakterId() {
        return $this->charakterId;
    }

    public function getTitel() {
        return $this->titel;
    }

    public function getBeschreibung() {
        return $this->beschreibung;
    }

    /**
     * @param string $format
     * @return string
     */
    public function getCreationDate($format = 'd.m.Y H:i') {
        if ($this->creationDate === null) {
            $date = new DateTime();
        } else {
            $date = new DateTime($this->creationDate);
        }
        return $date->format($format);
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCharakterId($charakterId) {
        $this->charakterId = $charakterId;
    }

    public function setTitel($titel) {
        $this->titel = $titel;
    }

    public function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }
    
}
