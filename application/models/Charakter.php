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
    protected $charakterid;
    /**
     * @var int
     */
    protected $userid;
    /**
     * @var string
     */
    protected $vorname;
    /**
     * @var string
     */
    protected $nachname;
    /**
     * @var string
     */
    protected $nickname;
    /**
     * @var DateInterval
     */
    protected $alter;
    /**
     * @var string
     */
    protected $augenfarbe;
    /**
     * @var string
     */
    protected $geschlecht;
    /**
     * @var string
     */
    protected $wohnort;
    /**
     * @var int
     */
    protected $size;
    /**
     * @var Application_Model_Klasse
     */
    protected $klasse;
    /**
     * @var int
     */
    protected $klassengruppe;
    /**
     * @var Application_Model_Luck
     */
    protected $luck;
    /**
     * @var type Application_Model_Circuit
     */
    protected $magiccircuit;
    /**
     * @var Application_Model_Odo
     */
    protected $odo;
    /**
     * @var DateTime
     */
    protected $geburtsdatum;
    /**
     * @var Application_Model_Charakterwerte 
     */
    protected $charakterwerte;
    /**
     * @var Application_Model_Charakterprofil
     */
    protected $charakterprofil;
    /**
     * @var string
     */
    protected $magieStufe;
    /**
     * @var array
     */
    protected $vorteile = array();
    /**
     * @var array
     */
    protected $nachteile = array();
    /**
     * @var array
     */
    protected $elemente = array();
    /**
     * @var array 
     */
    protected $magieschulen = array();
    /**
     * @var array
     */
    protected $skills = array();


    public function getCharakterid() {
        return $this->charakterid;
    }
    
    public function getUserid() {
        return $this->userid;
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

    public function getAlter($modifier = null) {
        if($this->alter === null){
            $this->calcAlter();
        }
        return $this->alter->$modifier;
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

    /**
     * @return Application_Model_Vorteil
     */
    public function getVorteile() {
        return $this->vorteile;
    }

    public function getNachteile() {
        return $this->nachteile;
    }

    public function getElemente() {
        return $this->elemente;
    }

    public function getLuck() {
        return $this->luck;
    }

    public function getMagiccircuit() {
        return $this->magiccircuit;
    }

    public function getOdo() {
        return $this->odo;
    }

    public function setCharakterid($charakterid) {
        $this->charakterid = $charakterid;
        return $this;
    }

    public function setUserid($userId) {
        $this->userid = $userId;
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

    public function calcAlter() {
        $currentDate = new DateTime();
        $birthDate = new DateTime($this->getGeburtsdatum());
        $this->alter = $currentDate->diff($birthDate);
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

    public function setKlasse(Application_Model_Klasse $klasse) {
        $this->klasse = $klasse;
        return $this;
    }

    public function setKlassengruppe(Application_Model_Klassengruppe $klassengruppe) {
        $this->klassengruppe = $klassengruppe;
        return $this;
    }

    public function setVorteile($vorteile = array()) {
        foreach ($vorteile as $vorteil){
            if($vorteil instanceof Application_Model_Vorteil){
                $this->addVorteil($vorteil);
            }
        }
        return $this;
    }
    
    public function addVorteil(Application_Model_Vorteil $vorteil){
        $this->vorteile[] = $vorteil;
    }

    public function setNachteile($nachteile) {
        foreach ($nachteile as $nachteil){
            if($nachteil instanceof Application_Model_Nachteil){
                $this->addNachteil($nachteil);
            }
        }
        return $this;
    }
    
    public function addNachteil(Application_Model_Nachteil $nachteil){
        $this->nachteile[] = $nachteil;
    }

    public function setElemente($elemente = array()) {
        foreach ($elemente as $element){
            if($element instanceof Application_Model_Element){
                $this->addElement($element);
            }
        }
        return $this;
    }

    public function addElement(Application_Model_Element $element) {
        $this->elemente[] = $element;
        return $this;
    }

    public function setLuck($luck) {
        $this->luck = $luck;
        return $this;
    }

    public function setMagiccircuit($magiccircuit) {
        $this->magiccircuit = $magiccircuit;
        return $this;
    }

    public function setOdo($odo) {
        $this->odo = $odo;
        return $this;
    }
    
    public function getCharakterwerte() {
        return $this->charakterwerte;
    }

    public function setCharakterwerte(Application_Model_Charakterwerte $charakterwerte) {
        $this->charakterwerte = $charakterwerte;
    }
    
    public function getCharakterprofil() {
        return $this->charakterprofil;
    }

    public function setCharakterprofil(Application_Model_Charakterprofil $charakterprofil) {
        $this->charakterprofil = $charakterprofil;
    }
    
    public function getMagieStufe() {
        return $this->magieStufe;
    }

    public function setMagieStufe($magieStufe) {
        $this->magieStufe = $magieStufe;
    }
    
    /**
     * @return Application_Model_Schule
     */
    public function getMagieschulen() {
        return $this->magieschulen;
    }

    public function setMagieschulen($magieschulen = array()) {
        foreach ($magieschulen as $magieschule) {
            if($magieschule instanceof Application_Model_Schule){
                $this->addMagieschule($magieschule);
            }
        }
    }
    
    public function addMagieschule(Application_Model_Schule $magieschule) {
        $this->magieschulen[] = $magieschule;
    }
    
    /**
     * @return Application_Model_Schule
     */
    public function getSkills() {
        return $this->skills;
    }

    public function setSkills($skills = array()) {
        foreach ($skills as $skill) {
            if($skill instanceof Application_Model_Skill){
                $this->addSkill($skill);
            }
        }
    }
    
    public function addSkill(Application_Model_Skill $skill) {
        $this->skills[] = $skill;
    }
    
}
