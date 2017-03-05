<?php

/**
 * Description of Application_Model_Charakterwerte
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Charakterwerte {
    
    protected $staerke;
    protected $agilitaet;
    protected $ausdauer;
    protected $disziplin;
    protected $kontrolle;
    protected $uebung;
    protected $fp;
    protected $startpunkte;
    protected $uebermenschMods = [
        'str' => 0,
        'agi' => 0,
        'aus' => 0,
        'dis' => 0,
        'kon' => 0,
    ];
    
    private $energieFaktor = [
        'F' => 1,
        'E' => 2,
        'D' => 3,
        'C' => 4,
        'B' => 5,
        'A' => 6,
    ];
    
    
    public function getStaerke() {
        return $this->staerke;
    }

    public function getAgilitaet() {
        return $this->agilitaet;
    }

    public function getAusdauer() {
        return $this->ausdauer;
    }

    public function getDisziplin() {
        return $this->disziplin;
    }

    public function getKontrolle() {
        return $this->kontrolle;
    }

    public function getUebung() {
        return $this->uebung;
    }

    public function getFp() {
        return $this->fp;
    }

    public function getStartpunkte() {
        return $this->startpunkte;
    }

    public function setStaerke($staerke) {
        $this->staerke = $staerke;
    }

    public function setAgilitaet($agilitaet) {
        $this->agilitaet = $agilitaet;
    }

    public function setAusdauer($ausdauer) {
        $this->ausdauer = $ausdauer;
    }

    public function setDisziplin($disziplin) {
        $this->disziplin = $disziplin;
    }

    public function setKontrolle($kontrolle) {
        $this->kontrolle = $kontrolle;
    }

    public function setUebung($uebung) {
        $this->uebung = $uebung;
    }

    public function setFp($fp) {
        $this->fp = $fp;
    }

    public function setStartpunkte($startpunkte) {
        $this->startpunkte = $startpunkte;
    }
    
    /**
     * @param type $training
     */
    public function addTraining($training, Application_Model_Trainingswerte $trainingswerte, $klassengruppe = 0) {
        switch ($training['training']){
            case 'staerke':
                $this->setStaerke($this->getStaerke() + $trainingswerte->getStrTraining());
                break;
            case 'agilitaet':
                $this->setAgilitaet($this->getAgilitaet() + $trainingswerte->getAgiTraining());
                break;
            case 'ausdauer':
                $this->setAusdauer($this->getAusdauer() + $trainingswerte->getAusTraining());
                break;
            case 'disziplin':
                $this->setDisziplin($this->getDisziplin() + $trainingswerte->getDisTraining());
                if($klassengruppe === 2){
                    $this->setUebung($this->getUebung() + $trainingswerte->getDisTraining());
                }
                break;
            case 'kontrolle':
                if($this->kontrolle < 40 && $this->kontrolle + $trainingswerte->getKonTraining() >= 40){
                    $this->fp = $this->fp + 100;
                }
                if($this->kontrolle < 300 && $this->kontrolle + $trainingswerte->getKonTraining() >= 300){
                    $this->fp = $this->fp + 100;
                }
                if($this->kontrolle < 650 && $this->kontrolle + $trainingswerte->getKonTraining() >= 650){
                    $this->fp = $this->fp + 100;
                }
                if($this->kontrolle < 800 && $this->kontrolle + $trainingswerte->getKonTraining() >= 800){
                    $this->fp = $this->fp + 100;
                }
                if($this->kontrolle < 1050 && $this->kontrolle + $trainingswerte->getKonTraining() >= 1050){
                    $this->fp = $this->fp + 100;
                }
                if($this->kontrolle < 1400 && $this->kontrolle + $trainingswerte->getKonTraining() >= 1400){
                    $this->fp = $this->fp + 100;
                }
                if($this->kontrolle < 1800 && $this->kontrolle + $trainingswerte->getKonTraining() >= 1800){
                    $this->fp = $this->fp + 100;
                }
                if($this->kontrolle < 2200 && $this->kontrolle + $trainingswerte->getKonTraining() >= 2200){
                    $this->fp = $this->fp + 100;
                }
                if($this->kontrolle < 2600 && $this->kontrolle + $trainingswerte->getKonTraining() >= 2600){
                    $this->fp = $this->fp + 100;
                }
                $this->setKontrolle($this->getKontrolle() + $trainingswerte->getKonTraining());
                break;
            case 'uebung':
                $this->setUebung($this->getUebung() + $trainingswerte->getPraTraining());
                $this->setFp($this->getFp() + ceil($trainingswerte->getPraTraining()));
                break;
        }
    }
    
    public function getCategory($attr) {
        $ubermenschMod = $this->uebermenschMods[$attr] === 1;
        $uebermensch = false;
        switch ($attr) {
            case 'str':
                $value = $this->staerke;
                break;
            case 'agi':
                $value = $this->agilitaet;
                break;
            case 'aus':
                $value = $this->ausdauer;
                break;
            case 'kon':
                $value = $this->kontrolle;
                break;
            case 'dis':
                $value = $this->disziplin;
                break;
            default:
                $value = 0;
                break;
        }
        switch (true) {
            case $value >= 3000 && $ubermenschMod:
                $category = "A+";
                $uebermensch = true;
                break;
            case $value >= 2800 && $ubermenschMod:
                $category = "A";
                $uebermensch = true;
                break;
            case $value >= 2600 && $ubermenschMod:
                $category = "A-";
                $uebermensch = true;
                break;
            case $value >= 2400 && $ubermenschMod:
                $category = "B+";
                $uebermensch = true;
                break;
            case $value >= 2300 && $ubermenschMod:
                $category = "B";
                $uebermensch = true;
                break;
            case $value >= 2200 && $ubermenschMod:
                $category = "B-";
                $uebermensch = true;
                break;
            case $value >= 2000 && $ubermenschMod:
                $category = "C+";
                $uebermensch = true;
                break;
            case $value >= 1900 && $ubermenschMod:
                $category = "C";
                $uebermensch = true;
                break;
            case $value >= 1800 && $ubermenschMod:
                $category = "C-";
                $uebermensch = true;
                break;
            case $value >= 1600 && $ubermenschMod:
                $category = "D+";
                $uebermensch = true;
                break;
            case $value >= 1500 && $ubermenschMod:
                $category = "D";
                $uebermensch = true;
                break;
            case $value >= 1400 && $ubermenschMod:
                $category = "D-";
                $uebermensch = true;
                break;
            case $value >= 1250 && $ubermenschMod:
                $category = "E+";
                $uebermensch = true;
                break;
            case $value >= 1150 && $ubermenschMod:
                $category = "E";
                $uebermensch = true;
                break;
            case $value >= 1050 && $ubermenschMod:
                $category = "E-";
                $uebermensch = true;
                break;
            case $value >= 960 && $ubermenschMod:
                $category = "F+";
                $uebermensch = true;
                break;
            case $value >= 880 && $ubermenschMod:
                $category = "F";
                $uebermensch = true;
                break;
            case $value >= 800 && $ubermenschMod:
                $category = "F-";
                $uebermensch = true;
                break;
            case $value >= 800:
                $category = "A+";
                break;
            case $value >= 720:
                $category = "A";
                break;
            case $value >= 650:
                $category = "A-";
                break;
            case $value >= 580:
                $category = "B+";
                break;
            case $value >= 520:
                $category = "B";
                break;
            case $value >= 460:
                $category = "B-";
                break;
            case $value >= 400:
                $category = "C+";
                break;
            case $value >= 350:
                $category = "C";
                break;
            case $value >= 300:
                $category = "C-";
                break;
            case $value >= 250:
                $category = "D+";
                break;
            case $value >= 200:
                $category = "D";
                break;
            case $value >= 160:
                $category = "D-";
                break;
            case $value >= 120:
                $category = "E+";
                break;
            case $value >= 80:
                $category = "E";
                break;
            case $value >= 40:
                $category = "E-";
                break;
            case $value >= 0:
                $category = "F+";
                break;
            case $value == 0:
                $category = "F";
                break;
            default:
                $category = "F-";
                break;
        }
        $werteCategory = new Application_Model_Charakterwertecategory();
        $werteCategory->setCategory($category);
        $werteCategory->setUebermensch($uebermensch);
        return $werteCategory;
    }
    
    
    public function getEnergie() {
        $category = $this->getCategory('aus');
        return 750 * $this->energieFaktor[substr($category->getCategory(), 0, 1)];
    }
    
    public function toArray() {
        $returnArray = array();
        $nonArrayMethods = ['getCategory', 'getEnergie', 'getUebermenschMods'];
        foreach (get_class_methods(get_class($this)) as $method){
            if(substr($method, 0, 3) === 'get' AND !in_array($method, $nonArrayMethods)){ 
                $returnArray[substr($method, 3)] = $this->{$method}();
            }
        }
        return $returnArray;
    }
    
    public function getUebermenschMods() {
        return $this->uebermenschMods;
    }
    
    public function addUebermenschMods($mod) {
        return $this->uebermenschMods[] = $mod;
    }

    public function setUebermenschMods($uebermenschMods) {
        $this->uebermenschMods = $uebermenschMods;
    }
    
    public function vorteilToUebermenschMod($vorteile = array()) {
        foreach ($vorteile as $vorteil) {
            if ($vorteil instanceof Application_Model_Vorteil) {
                switch ((int) $vorteil->getId()) {
                    case 1:
                        $this->uebermenschMods['str'] = 1;
                        break;
                    case 2:
                        $this->uebermenschMods['agi'] = 1;
                        break;
                    case 3:
                        $this->uebermenschMods['aus'] = 1;
                        break;
                    case 5:
                        $this->uebermenschMods['kon'] = 1;
                        break;
                    case 6:
                        $this->uebermenschMods['dis'] = 1;
                        break;
                }
            }
        }
    }
    
}
