<?php

/**
 * Description of Element
 *
 * @author Vosser
 */
class Application_Model_Magie {
    
    protected $id;
    protected $bezeichnung;
    protected $beschreibung;
    protected $fp;
    protected $prana;
    /**
     * @var Application_Model_Element
     */
    protected $element;
    protected $rang;
    /**
     * @var Application_Model_Klasse
     */
    protected $klasse;
    protected $gruppe;
    protected $stufe;
    /**
     * @var Application_Model_Magieschule
     */
    protected $schule;
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

    public function getPrana() {
        return $this->prana;
    }

    public function getElement() {
        return $this->element;
    }

    public function getRang() {
        return $this->rang;
    }

    public function getKlasse() {
        return $this->klasse;
    }

    public function getGruppe() {
        return $this->gruppe;
    }

    public function getStufe() {
        return $this->stufe;
    }

    public function getSchule() {
        return $this->schule;
    }

    public function getLernbedingung() {
        return $this->lernbedingung;
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

    public function setPrana($prana) {
        $this->prana = $prana;
    }

    public function setElement(Application_Model_Element $element) {
        $this->element = $element;
    }

    public function setRang($rang) {
        $this->rang = $rang;
    }

    public function setKlasse(Application_Model_Klasse $klasse) {
        $this->klasse = $klasse;
    }

    public function setGruppe($gruppe) {
        $this->gruppe = $gruppe;
    }

    public function setStufe($stufe) {
        $this->stufe = $stufe;
    }

    public function setSchule(Application_Model_Magieschule $schule) {
        $this->schule = $schule;
    }

    public function setLernbedingung($lernbedingung) {
        $this->lernbedingung = $lernbedingung;
    }
    
}
