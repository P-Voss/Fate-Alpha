<?php


/**
 * Description of Application_Model_Charakter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Charakter
{

    /**
     * @var array
     */
    protected $categories = [
        1 => 'A',
        2 => 'B',
        3 => 'C',
        4 => 'D',
        5 => 'E',
        6 => 'F',
    ];


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
     * @var Application_Model_Klassengruppe
     */
    protected $klassengruppe;
    /**
     * @var int
     */
    protected $undead;
    /**
     * @var Application_Model_Luck
     */
    protected $luck;
    /**
     * @var Application_Model_Circuit
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
     * @var Application_Model_Trait[]
     */
    protected $traits = [];
    /**
     * @var array
     */
    protected $elemente = [];
    /**
     * @var array
     */
    protected $magieschulen = [];
    /**
     * @var array
     */
    protected $skills = [];
    /**
     * @var array
     */
    protected $magien = [];
    /**
     * @var DateTime
     */
    protected $createDate;
    /**
     * @var DateTime
     */
    protected $undeadDate;

    /**
     * @var
     */
    protected $naturElement;
    /**
     * @var Application_Model_Modifier
     */
    protected $modifiers = [];
    /**
     * @var int
     */
    protected $killCount;

    /**
     * @return int
     */
    public function getCharakterid ()
    {
        return $this->charakterid;
    }

    /**
     * @return int
     */
    public function getUserid ()
    {
        return $this->userid;
    }

    /**
     * @return string
     */
    public function getVorname ()
    {
        return $this->vorname;
    }

    /**
     * @return string
     */
    public function getNachname ()
    {
        return $this->nachname;
    }

    /**
     * @return string
     */
    public function getNickname ()
    {
        return $this->nickname;
    }

    /**
     * @param string $modifier
     *
     * @return mixed
     */
    public function getAlter ($modifier = 'y')
    {
        if ($this->alter === null) {
            $this->calcAlter();
        }
        return $this->alter->$modifier;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getGeburtsdatum ($format = 'Y-m-d')
    {
        return $this->geburtsdatum->format($format);
    }

    /**
     * @return string
     */
    public function getAugenfarbe ()
    {
        return $this->augenfarbe;
    }

    /**
     * @return string
     */
    public function getGeschlecht ()
    {
        return $this->geschlecht;
    }

    /**
     * @return string
     */
    public function getWohnort ()
    {
        return $this->wohnort;
    }

    /**
     * @return int
     */
    public function getSize ()
    {
        return $this->size;
    }

    /**
     * @return Application_Model_Klasse
     */
    public function getKlasse ()
    {
        return $this->klasse;
    }

    /**
     * @return Application_Model_Klassengruppe
     */
    public function getKlassengruppe ()
    {
        return $this->klassengruppe;
    }

    /**
     * @return Application_Model_Element[]
     */
    public function getElemente ()
    {
        return $this->elemente;
    }

    /**
     * @return Application_Model_Luck
     */
    public function getLuck ()
    {
        return $this->luck;
    }

    /**
     * @return Application_Model_Circuit
     */
    public function getMagiccircuit ()
    {
        return $this->magiccircuit;
    }

    /**
     * @return Application_Model_Odo
     */
    public function getOdo ()
    {
        return $this->odo;
    }

    /**
     * @param $charakterid
     *
     * @return $this
     */
    public function setCharakterid ($charakterid)
    {
        $this->charakterid = $charakterid;
        return $this;
    }

    /**
     * @param $userId
     *
     * @return $this
     */
    public function setUserid ($userId)
    {
        $this->userid = $userId;
        return $this;
    }

    /**
     * @param $vorname
     *
     * @return $this
     */
    public function setVorname ($vorname)
    {
        $this->vorname = $vorname;
        return $this;
    }

    /**
     * @param $nachname
     *
     * @return $this
     */
    public function setNachname ($nachname)
    {
        $this->nachname = $nachname;
        return $this;
    }

    /**
     * @param $nickname
     *
     * @return $this
     */
    public function setNickname ($nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * @return $this
     */
    public function calcAlter ()
    {
        $currentDate = new DateTime();
        $birthDate = new DateTime($this->getGeburtsdatum());
        $this->alter = $currentDate->diff($birthDate);
        return $this;
    }

    /**
     * @param $geburtsdatum
     *
     * @return $this
     */
    public function setGeburtsdatum ($geburtsdatum)
    {
        $datum = new DateTime($geburtsdatum);
        $this->geburtsdatum = $datum;
        return $this;
    }

    /**
     * @param $augenfarbe
     *
     * @return $this
     */
    public function setAugenfarbe ($augenfarbe)
    {
        $this->augenfarbe = $augenfarbe;
        return $this;
    }

    /**
     * @param $geschlecht
     *
     * @return $this
     */
    public function setGeschlecht ($geschlecht)
    {
        $this->geschlecht = $geschlecht;
        return $this;
    }

    /**
     * @param $wohnort
     *
     * @return $this
     */
    public function setWohnort ($wohnort)
    {
        $this->wohnort = $wohnort;
        return $this;
    }

    /**
     * @param $size
     *
     * @return $this
     */
    public function setSize ($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @param Application_Model_Klasse $klasse
     *
     * @return $this
     */
    public function setKlasse (Application_Model_Klasse $klasse)
    {
        $this->klasse = $klasse;
        return $this;
    }

    /**
     * @param Application_Model_Klassengruppe $klassengruppe
     *
     * @return $this
     */
    public function setKlassengruppe (Application_Model_Klassengruppe $klassengruppe)
    {
        $this->klassengruppe = $klassengruppe;
        return $this;
    }

    /**
     * @param array $elemente
     *
     * @return $this
     */
    public function setElemente ($elemente = [])
    {
        foreach ($elemente as $element) {
            if ($element instanceof Application_Model_Element) {
                $this->addElement($element);
            }
        }
        return $this;
    }

    /**
     * @param Application_Model_Element $element
     *
     * @return $this
     */
    public function addElement (Application_Model_Element $element)
    {
        $this->elemente[] = $element;
        return $this;
    }

    /**
     * @param $luck
     *
     * @return $this
     */
    public function setLuck ($luck)
    {
        $this->luck = $luck;
        return $this;
    }

    /**
     * @param $magiccircuit
     *
     * @return $this
     */
    public function setMagiccircuit ($magiccircuit)
    {
        $this->magiccircuit = $magiccircuit;
        return $this;
    }

    /**
     * @param $odo
     *
     * @return $this
     */
    public function setOdo ($odo)
    {
        $this->odo = $odo;
        return $this;
    }

    /**
     * @return Application_Model_Charakterwerte
     */
    public function getCharakterwerte ()
    {
        return $this->charakterwerte;
    }

    /**
     * @param Application_Model_Charakterwerte $charakterwerte
     */
    public function setCharakterwerte (Application_Model_Charakterwerte $charakterwerte)
    {
        $this->charakterwerte = $charakterwerte;
    }

    /**
     * @return Application_Model_Charakterprofil
     */
    public function getCharakterprofil ()
    {
        return $this->charakterprofil;
    }

    /**
     * @param Application_Model_Charakterprofil $charakterprofil
     */
    public function setCharakterprofil (Application_Model_Charakterprofil $charakterprofil)
    {
        $this->charakterprofil = $charakterprofil;
    }

    /**
     * @return string
     */
    public function getMagieStufe ()
    {
        return $this->magieStufe;
    }

    /**
     * @param $magieStufe
     */
    public function setMagieStufe ($magieStufe)
    {
        $this->magieStufe = $magieStufe;
    }

    /**
     * @return Application_Model_Schule[]
     */
    public function getMagieschulen ()
    {
        return $this->magieschulen;
    }

    /**
     * @param array $magieschulen
     */
    public function setMagieschulen ($magieschulen = [])
    {
        foreach ($magieschulen as $magieschule) {
            if ($magieschule instanceof Application_Model_Schule) {
                $this->addMagieschule($magieschule);
            }
        }
    }

    /**
     * @param Application_Model_Schule $magieschule
     */
    public function addMagieschule (Application_Model_Schule $magieschule)
    {
        $this->magieschulen[] = $magieschule;
    }

    /**
     * @return Application_Model_Skill[]
     */
    public function getSkills ()
    {
        return $this->skills;
    }

    /**
     * @param array $skills
     */
    public function setSkills ($skills = [])
    {
        foreach ($skills as $skill) {
            if ($skill instanceof Application_Model_Skill) {
                $this->addSkill($skill);
            }
        }
    }

    /**
     * @param Application_Model_Skill $skill
     */
    public function addSkill (Application_Model_Skill $skill)
    {
        $this->skills[] = $skill;
    }

    /**
     * @return Application_Model_Magie[]
     */
    public function getMagien ()
    {
        return $this->magien;
    }

    /**
     * @param array $magien
     */
    public function setMagien ($magien = [])
    {
        foreach ($magien as $magie) {
            if ($magie instanceof Application_Model_Magie) {
                $this->addMagie($magie);
            }
        }
    }

    /**
     * @param Application_Model_Magie $magie
     */
    public function addMagie (Application_Model_Magie $magie)
    {
        $this->magien[] = $magie;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getCreatedate ($format = 'Y-m-d')
    {
        return $this->createDate->format($format);
    }

    /**
     * @param DateTime $createDate
     *
     * @return \Application_Model_Charakter
     */
    public function setCreatedate (DateTime $createDate)
    {
        $this->createDate = $createDate;
        return $this;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getUndeadDate ($format = 'Y-m-d')
    {
        return $this->undeadDate->format($format);
    }

    /**
     * @param DateTime $undeadDate
     *
     * @return \Application_Model_Charakter
     */
    public function setUndeadDate (DateTime $undeadDate)
    {
        $this->undeadDate = $undeadDate;
        return $this;
    }


    /**
     * @return string
     */
    public function getCreateInterval ()
    {
        $currentDate = new DateTime();
        return $currentDate->diff($this->createDate)->format('%d');
    }

    /**
     * @return string
     */
    public function getSexualitaet ()
    {
        return $this->sexualitaet;
    }

    /**
     * @param $sexualitaet
     */
    public function setSexualitaet ($sexualitaet)
    {
        $this->sexualitaet = $sexualitaet;
    }

    /**
     * @return Application_Model_Element
     */
    public function getNaturElement ()
    {
        return $this->naturElement;
    }

    /**
     * @param Application_Model_Element $naturElement
     */
    public function setNaturElement (Application_Model_Element $naturElement)
    {
        $this->naturElement = $naturElement;
    }

    /**
     * @return Application_Model_Vermoegen
     */
    public function getVermoegen ()
    {
        return $this->vermoegen;
    }

    /**
     * @param Application_Model_Vermoegen $vermoegen
     */
    public function setVermoegen (Application_Model_Vermoegen $vermoegen)
    {
        $this->vermoegen = $vermoegen;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getCategory ($key)
    {
        return $this->categories[$key];
    }


    /**
     * @return int
     */
    public function getKillCount ()
    {
        return (int)$this->killCount;
    }

    /**
     * @param $killCount
     */
    public function setKillCount ($killCount)
    {
        $this->killCount = $killCount;
    }

    /**
     * @return int
     */
    public function getUndead ()
    {
        return $this->undead;
    }

    /**
     * @param $undead
     */
    public function setUndead ($undead)
    {
        $this->undead = $undead;
    }

    /**
     * @return Application_Model_Trait[]
     */
    public function getTraits (): array
    {
        return $this->traits;
    }

    /**
     * @param Application_Model_Trait[] $traits
     *
     * @return Application_Model_Charakter
     */
    public function setTraits (array $traits): Application_Model_Charakter
    {
        foreach ($traits as $trait) {
            $this->addTrait($trait);
        }
        return $this;
    }

    /**
     * @param Application_Model_Trait $trait
     *
     * @return Application_Model_Charakter
     */
    public function addTrait (Application_Model_Trait $trait): Application_Model_Charakter
    {
        $this->traits[] = $trait;
        return $this;
    }

    /**
     * @param array $modifiers
     */
    public function setModifiers ($modifiers = [])
    {
        foreach ($modifiers as $modifier) {
            if ($modifier instanceof Application_Model_Modifier) {
                $this->modifiers[] = $modifier;
            }
        }
    }

    /**
     * @param Application_Model_Modifier $modifier
     */
    public function addModifier (Application_Model_Modifier $modifier)
    {
        $this->modifiers[] = $modifier;
    }

    /**
     * @return Application_Model_Modifier
     */
    public function getModifiers ()
    {
        return $this->modifiers;
    }

    /**
     *
     */
    public function applyModifiers ()
    {
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
