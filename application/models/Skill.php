<?php

/**
 * Description of Skill
 *
 * @author Vosser
 */
class Application_Model_Skill implements JsonSerializable {
    
    protected $id;
    /**
     * @var string
     */
    protected $bezeichnung;
    /**
     * @var string
     */
    protected $beschreibung;
    protected $skillArt;
    protected $fp;
    protected $rang;
    protected $uebung;
    protected $disziplin;
    /**
     * @var string 
     */
    protected $lernbedingung;
    
    public function getId() {
        return $this->id;
    }

    public function getBezeichnung() {
        return $this->bezeichnung;
    }

    public function getBeschreibung() {
        return $this->beschreibung;
    }

    public function getFp() {
        return $this->fp;
    }

    public function getRang() {
        return $this->rang;
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

    public function setFp($fp) {
        $this->fp = $fp;
    }

    public function setRang($rang) {
        $this->rang = $rang;
    }
    
    public function getSkillArt() {
        return $this->skillArt;
    }

    public function setSkillArt($skillArt) {
        $this->skillArt = $skillArt;
    }
    
    public function getUebung() {
        return $this->uebung;
    }

    public function getDisziplin() {
        return $this->disziplin;
    }

    public function setUebung($uebung) {
        $this->uebung = $uebung;
    }

    public function setDisziplin($disziplin) {
        $this->disziplin = $disziplin;
    }
    
    public function getLernbedingung() {
        return $this->lernbedingung;
    }

    public function setLernbedingung($lernbedingung) {
        $this->lernbedingung = $lernbedingung;
    }
    
    public function jsonSerialize() {
        $return = array();
        foreach (get_object_vars($this) as $key => $property){
            $return[$key] = $property;
        }
        return $return;
    }

}
