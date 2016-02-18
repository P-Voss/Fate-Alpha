<?php

/**
 * Description of Gruppe
 *
 * @author Voß
 */
class Gruppen_Model_Gruppe {
    
    protected $id;
    protected $name;
    protected $beschreibung;
    protected $passwort;
    protected $mitglieder = array();
    protected $gruender;
    protected $createDate;
    
    
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

    public function getPasswort() {
        return $this->passwort;
    }

    public function getMitglieder() {
        return $this->mitglieder;
    }

    public function getGruender() {
        return $this->gruender;
    }

    public function getCreateDate() {
        return $this->createDate;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    public function setPasswort($passwort) {
        $this->passwort = $passwort;
    }

    public function setMitglieder($mitglieder = array()) {
        foreach ($mitglieder as $mitglied){
            if($mitglied instanceof Application_Model_Charakter){
                $this->addMitglied($mitglied);
            }
        }
    }
    
    public function addMitglied(Application_Model_Charakter $charakter) {
        $this->mitglieder[] = $charakter;
    }

    public function setGruender($gruender) {
        $this->gruender = $gruender;
    }

    public function setCreateDate($createDate) {
        $this->createDate = $createDate;
    }
    
}
