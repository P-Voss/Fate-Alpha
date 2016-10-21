<?php

/**
 * Description of Episode
 *
 * @author Voß
 */
class Story_Model_Episode {
    
    protected $id;
    protected $name;
    protected $beschreibung;
    protected $zusammenfassung;
    protected $createDate;
    protected $editDate;
    
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

    public function getZusammenfassung() {
        return $this->zusammenfassung;
    }

    public function getCreateDate() {
        return $this->createDate;
    }

    public function getEditDate() {
        return $this->editDate;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    public function setZusammenfassung($zusammenfassung) {
        $this->zusammenfassung = $zusammenfassung;
    }

    public function setCreateDate($createDate) {
        $this->createDate = $createDate;
    }

    public function setEditDate($editDate) {
        $this->editDate = $editDate;
    }
    
}
