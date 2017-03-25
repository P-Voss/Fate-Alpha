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
    protected $circuitBonus = 0;


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
        $attributes = [
            'str' => $this->staerke,
            'agi' => $this->agilitaet,
            'aus' => $this->ausdauer,
            'kon' => $this->kontrolle,
            'dis' => $this->disziplin,
        ];
        $value = isset($attributes[$attr]) ? $attributes[$attr] : 0;
        
        $categories = [
            ['category' => 'F-', 'lowerbound' => -10, 'ueber' => false],
            ['category' => 'F', 'lowerbound' => -1, 'ueber' => false],
            ['category' => 'F+', 'lowerbound' => 0, 'ueber' => false],
            ['category' => 'E-', 'lowerbound' => 40, 'ueber' => false],
            ['category' => 'E', 'lowerbound' => 80, 'ueber' => false],
            ['category' => 'E+', 'lowerbound' => 120, 'ueber' => false],
            ['category' => 'D-', 'lowerbound' => 160, 'ueber' => false],
            ['category' => 'D', 'lowerbound' => 200, 'ueber' => false],
            ['category' => 'D+', 'lowerbound' => 250, 'ueber' => false],
            ['category' => 'C-', 'lowerbound' => 300, 'ueber' => false],
            ['category' => 'C', 'lowerbound' => 350, 'ueber' => false],
            ['category' => 'C+', 'lowerbound' => 400, 'ueber' => false],
            ['category' => 'B-', 'lowerbound' => 460, 'ueber' => false],
            ['category' => 'B', 'lowerbound' => 520, 'ueber' => false],
            ['category' => 'B+', 'lowerbound' => 580, 'ueber' => false],
            ['category' => 'A-', 'lowerbound' => 650, 'ueber' => false],
            ['category' => 'A', 'lowerbound' => 720, 'ueber' => false],
            ['category' => 'A+', 'lowerbound' => 800, 'ueber' => false],
            ['category' => 'F-', 'lowerbound' => 800, 'ueber' => true],
            ['category' => 'F', 'lowerbound' => 880, 'ueber' => true],
            ['category' => 'F+', 'lowerbound' => 960, 'ueber' => true],
            ['category' => 'E-', 'lowerbound' => 1050, 'ueber' => true],
            ['category' => 'E', 'lowerbound' => 1150, 'ueber' => true],
            ['category' => 'E+', 'lowerbound' => 1250, 'ueber' => true],
            ['category' => 'D-', 'lowerbound' => 1400, 'ueber' => true],
            ['category' => 'D', 'lowerbound' => 1500, 'ueber' => true],
            ['category' => 'D+', 'lowerbound' => 1600, 'ueber' => true],
            ['category' => 'C-', 'lowerbound' => 1800, 'ueber' => true],
            ['category' => 'C', 'lowerbound' => 1900, 'ueber' => true],
            ['category' => 'C+', 'lowerbound' => 2000, 'ueber' => true],
            ['category' => 'B-', 'lowerbound' => 2200, 'ueber' => true],
            ['category' => 'B', 'lowerbound' => 2300, 'ueber' => true],
            ['category' => 'B+', 'lowerbound' => 2400, 'ueber' => true],
            ['category' => 'A-', 'lowerbound' => 2600, 'ueber' => true],
            ['category' => 'A', 'lowerbound' => 2800, 'ueber' => true],
            ['category' => 'A+', 'lowerbound' => 3000, 'ueber' => true],
        ];
        foreach ($categories as $key => $category) {
            if ($category['lowerbound'] <= $value
                    && ($category['ueber'] === false || $ubermenschMod === true)) {
                $activeCategory = $category;
                $activeKey = $key;
            }
        }
        if (in_array($attr, ['dis', 'kon']) && $this->circuitBonus > 0) {
            $category = $categories[$activeKey + $this->circuitBonus];
            if ($category['ueber'] === false || $ubermenschMod === true) {
                $activeCategory = $category;
            }
        }
        $werteCategory = new Application_Model_Charakterwertecategory();
        $werteCategory->setCategory($activeCategory['category']);
        $werteCategory->setUebermensch($activeCategory['ueber']);
        return $werteCategory;
    }
    
    
    public function getEnergie() {
        $category = $this->getCategory('aus');
        if ($category->getUebermensch()) {
            return 1000 * $this->energieFaktor[substr($category->getCategory(), 0, 1)] + 4500;
        } else {
            return 750 * $this->energieFaktor[substr($category->getCategory(), 0, 1)];
        }
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
                        $this->uebermenschMods['aus'] = 1;
                        break;
                    case 3:
                        $this->uebermenschMods['agi'] = 1;
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
    
    
    public function setCircuitMod($circuitKategorie) {
        switch ($circuitKategorie) {
            case 'A':
                $this->circuitBonus = 1;
                break;
            case 'B':
                $this->circuitBonus = 1;
                break;
            case 'C':
                $this->circuitBonus = 1;
                break;
            default:
                $this->circuitBonus = 0;
                break;
        }
    }
    
}
