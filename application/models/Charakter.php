<?php


/**
 * Description of Application_Model_Charakter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Charakter {
    
    /**
     * @var int
     */
    protected $_charakterid;
    protected $_userid;
    /**
     * @var string
     */
    protected $_vorname;
    protected $_nachname;
    protected $_nickname;
    protected $_alter;
    protected $_augenfarbe;
    protected $_geschlecht;
    protected $_wohnort;
    protected $_size;
    /**
     *
     * @var Application_Model_Klasse
     */
    protected $_klasse;
    protected $_klassengruppe;
    /**
     *
     * @var Application_Model_Luck
     */
    protected $_luck;
    /**
     *
     * @var type Application_Model_Circuit
     */
    protected $_magiccircuit;
    /**
     *
     * @var Application_Model_Odo
     */
    protected $_odo;
    /**
     *
     * @var DateTime
     */
    protected $_geburtsdatum;
    /**
     * @var Application_Model_Charakterwerte 
     */
    protected $_charakterwerte;
    /**
     * @var Application_Model_Charakterprofil
     */
    protected $_charakterprofil;
    protected $_vorteile = array();
    protected $_nachteile = array();
    protected $_elemente = array();


    public function getCharakterid() {
        return $this->_charakterid;
    }
    
    public function getUserid() {
        return $this->_userid;
    }

    public function getVorname() {
        return $this->_vorname;
    }

    public function getNachname() {
        return $this->_nachname;
    }

    public function getNickname() {
        return $this->_nickname;
    }

    public function getAlter() {
        return $this->_alter;
    }

    public function getGeburtsdatum() {
        return $this->_geburtsdatum;
    }

    public function getAugenfarbe() {
        return $this->_augenfarbe;
    }

    public function getGeschlecht() {
        return $this->_geschlecht;
    }

    public function getWohnort() {
        return $this->_wohnort;
    }

    public function getSize() {
        return $this->_size;
    }

    public function getKlasse() {
        return $this->_klasse;
    }

    public function getKlassengruppe() {
        return $this->_klassengruppe;
    }

    public function getVorteile() {
        return $this->_vorteile;
    }

    public function getNachteile() {
        return $this->_nachteile;
    }

    public function getElemente() {
        return $this->_elemente;
    }

    public function getLuck() {
        return $this->_luck;
    }

    public function getMagiccircuit() {
        return $this->_magiccircuit;
    }

    public function getOdo() {
        return $this->_odo;
    }

    public function setCharakterid($charakterid) {
        $this->_charakterid = $charakterid;
        return $this;
    }

    public function setUserid($userid) {
        $this->_userid = $userid;
        return $this;
    }

    public function setVorname($vorname) {
        $this->_vorname = $vorname;
        return $this;
    }

    public function setNachname($nachname) {
        $this->_nachname = $nachname;
        return $this;
    }

    public function setNickname($nickname) {
        $this->_nickname = $nickname;
        return $this;
    }

    public function setAlter($alter) {
        $this->_alter = $alter;
        return $this;
    }

    public function setGeburtsdatum($geburtsdatum) {
        $this->_geburtsdatum = $geburtsdatum;
        return $this;
    }

    public function setAugenfarbe($augenfarbe) {
        $this->_augenfarbe = $augenfarbe;
        return $this;
    }

    public function setGeschlecht($geschlecht) {
        $this->_geschlecht = $geschlecht;
        return $this;
    }

    public function setWohnort($wohnort) {
        $this->_wohnort = $wohnort;
        return $this;
    }

    public function setSize($size) {
        $this->_size = $size;
        return $this;
    }

    public function setKlasse($klasse) {
        $this->_klasse = $klasse;
        return $this;
    }

    public function setKlassengruppe($klassengruppe) {
        $this->_klassengruppe = $klassengruppe;
        return $this;
    }

    public function setVorteile($vorteile) {
        $this->_vorteile = $vorteile;
        return $this;
    }
    
    public function addVorteil($vorteil){
        $this->_vorteile[] = $vorteil;
    }

    public function setNachteile($nachteile) {
        $this->_nachteile = $nachteile;
        return $this;
    }
    
    public function addNachteil($nachteil){
        $this->_nachteile[] = $nachteil;
    }

    public function setElemente($elemente) {
        $this->_elemente = $elemente;
        return $this;
    }

    public function addElement($element) {
        $this->_elemente[] = $element;
        return $this;
    }

    public function setLuck($luck) {
        $this->_luck = $luck;
        return $this;
    }

    public function setMagiccircuit($magiccircuit) {
        $this->_magiccircuit = $magiccircuit;
        return $this;
    }

    public function setOdo($odo) {
        $this->_odo = $odo;
        return $this;
    }
    
    public function getCharakterwerte() {
        return $this->_charakterwerte;
    }

    public function setCharakterwerte(Application_Model_Charakterwerte $charakterwerte) {
        $this->_charakterwerte = $charakterwerte;
    }
    
    public function getCharakterprofil() {
        return $this->_charakterprofil;
    }

    public function setCharakterprofil(Application_Model_Charakterprofil $charakterprofil) {
        $this->_charakterprofil = $charakterprofil;
    }



}
