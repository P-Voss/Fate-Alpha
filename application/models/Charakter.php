<?php


/**
 * Description of Application_Model_Charakter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Charakter {
    
    protected $categories = array(
        1 => 'A',
        2 => 'B',
        3 => 'C',
        4 => 'D',
        5 => 'E',
        6 => 'F',
    );


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
    protected $sexualitaet;
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
     * @var Application_Model_Vermoegen
     */
    protected $vermoegen;
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
    /**
     * @var array
     */
    protected $magien = array();
    /**
     * @var DateTime
     */
    protected $createDate;
    
    protected $naturElement;
    /**
     * @var Application_Model_Modifier
     */
    protected $modifiers = array();

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

    public function getAlter($modifier = 'y') {
        if($this->alter === null){
            $this->calcAlter();
        }
        return $this->alter->$modifier;
    }

    public function getGeburtsdatum($format = 'Y-m-d') {
        return $this->geburtsdatum->format($format);
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

    /**
     * @return Application_Model_Klassengruppe
     */
    public function getKlassengruppe() {
        return $this->klassengruppe;
    }

    /**
     * @return Application_Model_Vorteil[]
     */
    public function getVorteile() {
        return $this->vorteile;
    }

    /**
     * @return Application_Model_Nachteil[]
     */
    public function getNachteile() {
        return $this->nachteile;
    }

    /**
     * @return Application_Model_Element
     */
    public function getElemente() {
        return $this->elemente;
    }

    public function getLuck() {
        return $this->luck;
    }

    /**
     * @return Application_Model_Circuit
     */
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
        $datum = new DateTime($geburtsdatum);
        $this->geburtsdatum = $datum;
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
     * @return Application_Model_Schule[]
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
     * @return Application_Model_Skill[]
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
    
    /**
     * @return Application_Model_Magie[]
     */
    public function getMagien() {
        return $this->magien;
    }
    
    public function setMagien($magien = array()) {
        foreach ($magien as $magie){
            if($magie instanceof Application_Model_Magie){
                $this->addMagie($magie);
            }
        }
    }
    
    /**
     * @param Application_Model_Magie $magie
     */
    public function addMagie(Application_Model_Magie $magie) {
        $this->magien[] = $magie;
    }

    /**
     * @return DateTime
     */
    public function getCreatedate($format = 'Y-m-d') {
        return $this->createDate->format($format);
    }

    /**
     * @param DateTime $createDate
     * @return \Application_Model_Charakter
     */
    public function setCreatedate(DateTime $createDate) {
        $this->createDate = $createDate;
        return $this;
    }
    
    
    public function getCreateInterval() {
        $currentDate = new DateTime();
        return $currentDate->diff($this->createDate)->format('%d');
    }
    
    public function getSexualitaet() {
        return $this->sexualitaet;
    }

    public function setSexualitaet($sexualitaet) {
        $this->sexualitaet = $sexualitaet;
    }
    
    /**
     * @return Application_Model_Element
     */
    public function getNaturElement() {
        return $this->naturElement;
    }

    public function setNaturElement(Application_Model_Element $naturElement) {
        $this->naturElement = $naturElement;
    }
    
    /**
     * @return Application_Model_Vermoegen
     */
    public function getVermoegen() {
        return $this->vermoegen;
    }

    /**
     * @param Application_Model_Vermoegen $vermoegen
     */
    public function setVermoegen(Application_Model_Vermoegen $vermoegen) {
        $this->vermoegen = $vermoegen;
    }
    
    public function getCategory($key) {
        return $this->categories[$key];
    }
    
    public function setModifiers($modifiers = array()) {
        foreach ($modifiers as $modifier) {
            if($modifier instanceof Application_Model_Modifier){
                $this->modifiers[] = $modifier;
            }
        }
    }
    
    public function addModifier(Application_Model_Modifier $modifier) {
        $this->modifiers[] = $modifier;
    }
    
    public function getModifiers() {
        return $this->modifiers;
    }
    
    public function applyModifiers() {
        foreach ($this->modifiers as $modifier) {
            switch ($modifier->getAttribute()) {
                case 'luck':
                    $this->luck->setModified(true);
                    $this->luck->setModification($modifier->getValue());
                    break;
                case 'odo':
                    $this->odo->setModified(true);
                    $this->odo->setModification($modifier->getValue());
                    break;
                case 'vermoegen':
                    $this->vermoegen->setModified(true);
                    $this->vermoegen->setModification($modifier->getValue());
                    break;
            }
        }
    }
    
}
