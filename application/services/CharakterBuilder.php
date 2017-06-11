<?php

/**
 * Description of Application_Service_Charakter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Service_CharakterBuilder {
    
    
    /**
     * @var Application_Model_Mapper_CharakterMapper 
     */
    private $charakterMapper;
    /**
     * @var Application_Model_Charakter
     */
    private $charakter;
    private $charakterId;
    
    public function __construct() {
        $this->charakterMapper = new Application_Model_Mapper_CharakterMapper();
    }
    
    
    public function getCharakter() {
        return $this->charakter;
    }
    
    /**
     * @param int $charakterId
     * @return $this
     */
    public function initCharakterByCharakterId($charakterId) {
        $this->charakter = $this->charakterMapper->getCharakter($charakterId);
        if ($this->charakter === false) {
            return false;
        }
        $this->charakterId = $charakterId;
        $this->charakter->setModifiers($this->charakterMapper->getModifierByCharakter($charakterId));
        return true;
    }
    
    /**
     * @param int $userId
     * @return $this
     */
    public function initCharakterByUserId($userId) {
        $this->charakter = $this->charakterMapper->getCharakterByUserId($userId);
        if ($this->charakter === false) {
            return false;
        }
        $this->charakterId = $this->charakter->getCharakterid();
        $this->charakter->setModifiers($this->charakterMapper->getModifierByCharakter($this->charakterId));
        return true;
    }
    
    
    public function setClassData() {
        $klassenMapper = new Application_Model_Mapper_KlasseMapper();
        $this->charakter->setKlasse($this->charakterMapper->getCharakterKlasse($this->charakterId));
        $this->charakter->setKlassengruppe($klassenMapper->getKlassengruppe($this->charakter->getKlasse()->getId()));
        return $this;
    }
    
    
    public function setNaturelement() {
        $this->charakter->setNaturElement($this->charakterMapper->getNaturelement($this->charakterId));
        return $this;
    }
    
    
    public function setWerte() {
        $this->charakter->setCharakterwerte($this->charakterMapper->getCharakterwerte($this->charakterId));
        if ($this->charakter->getVorteile() === null) {
            $this->setVorteile();
        }
        $this->charakter->getCharakterwerte()->vorteilToUebermenschMod($this->charakter->getVorteile());
        if ($this->charakter->getMagiccircuit() === null) {
            $this->setCircuit();
        }
        if ($this->charakter->getMagiccircuit() !== null 
                && in_array($this->charakter->getMagiccircuit()->getKategorie(), ['A', 'B', 'C']))
        {
            $this->charakter->getCharakterwerte()->setCircuitMod($this->charakter->getMagiccircuit()->getKategorie());
        }
        return $this;
    }
    
    
    public function setVorteile() {
        $this->charakter->setVorteile($this->charakterMapper->getVorteileByCharakterId($this->charakterId));
        return $this;
    }
    
    
    public function setNachteile() {
        $this->charakter->setNachteile($this->charakterMapper->getNachteileByCharakterId($this->charakterId));
        return $this;
    }
    
    
    public function setLuck() {
        $this->charakter->setLuck($this->charakterMapper->getLuck($this->charakterId, $this->charakter->getModifiers()));
        return $this;
    }
    
    
    public function setVermoegen() {
        $this->charakter->setVermoegen($this->charakterMapper->getVermoegen($this->charakterId, $this->charakter->getModifiers()));
        return $this;
    }
    
    
    public function setCircuit() {
        $this->charakter->setMagiccircuit($this->charakterMapper->getMagiccircuit($this->charakterId));
        return $this;
    }
    
    
    public function setOdo() {
        if ($this->charakter->getMagiccircuit() === null) {
            $this->setCircuit();
        }
        if ($this->charakter->getCharakterwerte() === null) {
            $this->setWerte();
        }
        $odo = $this->charakterMapper->getOdo($this->charakterId, $this->charakter->getModifiers());
        $odo->calculateActualOdo(
            $this->charakter->getMagiccircuit(), 
            $this->charakter->getCharakterwerte()->getCategory('kon'), 
            $this->charakter->getKlassengruppe()
        );
        $this->charakter->setOdo($odo);
        return $this;
    }
    
    
    public function setProfile() {
        $this->charakter->setCharakterprofil($this->charakterMapper->getCharakterProfil($this->charakterId));
        return $this;
    }
    
    
    public function setSkills() {
        $this->charakter->setSkills($this->charakterMapper->getCharakterSkills($this->charakterId));
        return $this;
    }
    
    
    public function setMagieschulen() {
        $this->charakter->setMagieschulen($this->charakterMapper->getCharakterMagieschulen($this->charakterId));
        return $this;
    }
    
    
    public function setMagien() {
        $this->charakter->setMagien($this->charakterMapper->getCharakterMagien($this->charakterId));
        return $this;
    }
    
    
}
