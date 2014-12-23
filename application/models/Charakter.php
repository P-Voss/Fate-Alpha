<?php


/**
 * Description of Charakter
 *
 * @author Vosser
 */
class Application_Model_Charakter {
    
    protected $charakterid;
    protected $vorname;
    protected $nachname;
    protected $nickname;
    protected $alter;
    protected $geburtsdatum;
    protected $augenfarbe;
    protected $geschlecht;
    protected $wohnort;
    protected $size;
    protected $klasse;
    protected $klassengruppe;
    protected $vorteile = array();
    protected $nachteile = array();
    protected $naturelement;
    protected $magiccircuit;
    
    public function getCharakterid() {
        return $this->charakterid;
    }

    public function getVorname() {
        return $this->vorname;
    }

    public function getNachname() {
        return $this->nachname;
    }

    public function getNickname() {
        return $this->nickname;
    }

    public function getAlter() {
        return $this->alter;
    }

    public function getGeburtsdatum() {
        return $this->geburtsdatum;
    }

    public function getAugenfarbe() {
        return $this->augenfarbe;
    }

    public function getGeschlecht() {
        return $this->geschlecht;
    }

    public function getWohnort() {
        return $this->wohnort;
    }

    public function getSize() {
        return $this->size;
    }

    public function getKlasse() {
        return $this->klasse;
    }

    public function getKlassengruppe() {
        return $this->klassengruppe;
    }

    public function getVorteile() {
        return $this->vorteile;
    }

    public function getNachteile() {
        return $this->nachteile;
    }

    public function getNaturelement() {
        return $this->naturelement;
    }

    public function getMagiccircuit() {
        return $this->magiccircuit;
    }

    public function setCharakterid($charakterid) {
        $this->charakterid = $charakterid;
        return $this;
    }

    public function setVorname($vorname) {
        $this->vorname = $vorname;
        return $this;
    }

    public function setNachname($nachname) {
        $this->nachname = $nachname;
        return $this;
    }

    public function setNickname($nickname) {
        $this->nickname = $nickname;
        return $this;
    }

    public function setAlter($alter) {
        $this->alter = $alter;
        return $this;
    }

    public function setGeburtsdatum($geburtsdatum) {
        $this->geburtsdatum = $geburtsdatum;
        return $this;
    }

    public function setAugenfarbe($augenfarbe) {
        $this->augenfarbe = $augenfarbe;
        return $this;
    }

    public function setGeschlecht($geschlecht) {
        $this->geschlecht = $geschlecht;
        return $this;
    }

    public function setWohnort($wohnort) {
        $this->wohnort = $wohnort;
        return $this;
    }

    public function setSize($size) {
        $this->size = $size;
        return $this;
    }

    public function setKlasse($klasse) {
        $this->klasse = $klasse;
        return $this;
    }

    public function setKlassengruppe($klassengruppe) {
        $this->klassengruppe = $klassengruppe;
        return $this;
    }

    public function setVorteile($vorteile) {
        $this->vorteile = $vorteile;
        return $this;
    }
    
    public function addVorteile($vorteil){
        $this->vorteile[] = $vorteil;
    }

    public function setNachteile($nachteile) {
        $this->nachteile = $nachteile;
        return $this;
    }
    
    public function addNachteile($nachteil){
        $this->nachteile[] = $nachteil;
    }

    public function setNaturelement($naturelement) {
        $this->naturelement = $naturelement;
        return $this;
    }

    public function setMagiccircuit($magiccircuit) {
        $this->magiccircuit = $magiccircuit;
        return $this;
    }


}
