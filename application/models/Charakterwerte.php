<?php

/**
 * Description of Application_Model_Charakterwerte
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Charakterwerte
{

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


    /**
     * @return mixed
     */
    public function getStaerke ()
    {
        return $this->staerke;
    }

    /**
     * @return mixed
     */
    public function getAgilitaet ()
    {
        return $this->agilitaet;
    }

    /**
     * @return mixed
     */
    public function getAusdauer ()
    {
        return $this->ausdauer;
    }

    /**
     * @return mixed
     */
    public function getDisziplin ()
    {
        return $this->disziplin;
    }

    /**
     * @return mixed
     */
    public function getKontrolle ()
    {
        return $this->kontrolle;
    }

    /**
     * @return mixed
     */
    public function getUebung ()
    {
        return $this->uebung;
    }

    /**
     * @return mixed
     */
    public function getFp ()
    {
        return $this->fp;
    }

    /**
     * @return mixed
     */
    public function getStartpunkte ()
    {
        return $this->startpunkte;
    }

    /**
     * @param $staerke
     */
    public function setStaerke ($staerke)
    {
        $this->staerke = $staerke;
    }

    /**
     * @param $agilitaet
     */
    public function setAgilitaet ($agilitaet)
    {
        $this->agilitaet = $agilitaet;
    }

    /**
     * @param $ausdauer
     */
    public function setAusdauer ($ausdauer)
    {
        $this->ausdauer = $ausdauer;
    }

    /**
     * @param $disziplin
     */
    public function setDisziplin ($disziplin)
    {
        $this->disziplin = $disziplin;
    }

    /**
     * @param $kontrolle
     */
    public function setKontrolle ($kontrolle)
    {
        $this->kontrolle = $kontrolle;
    }

    /**
     * @param $uebung
     */
    public function setUebung ($uebung)
    {
        $this->uebung = $uebung;
    }

    /**
     * @param $fp
     */
    public function setFp ($fp)
    {
        $this->fp = $fp;
    }

    /**
     * @param $startpunkte
     */
    public function setStartpunkte ($startpunkte)
    {
        $this->startpunkte = $startpunkte;
    }

    /**
     * @todo Bonus auf Übung wenn Menschen Disziplin trainieren?
     *
     * @param Application_Model_Training_Attribute $attribute
     * @param int $klassengruppe
     */
    public function addTraining (Application_Model_Training_Attribute $attribute, $klassengruppe = 0)
    {
        switch ($attribute->getAttributeKey()) {
            case 'staerke':
                $this->setStaerke($this->getStaerke() + $attribute->getValue());
                break;
            case 'agilitaet':
                $this->setAgilitaet($this->getAgilitaet() + $attribute->getValue());
                break;
            case 'ausdauer':
                $this->setAusdauer($this->getAusdauer() + $attribute->getValue());
                break;
            case 'disziplin':
                $this->setDisziplin($this->getDisziplin() + $attribute->getValue());
                if ($klassengruppe === 2) {
                    $this->setUebung($this->getUebung() + $attribute->getValue());
                }
                break;
            case 'kontrolle':
                $this->setKontrolle($this->getKontrolle() + $attribute->getValue());
                break;
            case 'uebung':
                $this->setUebung($this->getUebung() + $attribute->getValue());
                $this->setFp($this->getFp() + ceil($attribute->getValue()));
                break;
        }
    }

    /**
     * @param $attr
     *
     * @return Application_Model_Charakterwertecategory
     */
    public function getCategory ($attr)
    {
        $ubermenschMod = $this->uebermenschMods[$attr] === 1;
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


    /**
     * @return int
     */
    public function getEnergie ()
    {
        $category = $this->getCategory('aus');
        $energie = new Application_Model_Lebensenergie();
        return $energie->getEnergiewert($category->getCategory(), $category->getUebermensch());
    }

    /**
     * @return array
     */
    public function toArray ()
    {
        $returnArray = [];
        $nonArrayMethods = ['getCategory', 'getEnergie', 'getUebermenschMods'];
        foreach (get_class_methods(get_class($this)) as $method) {
            if (substr($method, 0, 3) === 'get' AND !in_array($method, $nonArrayMethods)) {
                $returnArray[lcfirst(substr($method, 3))] = $this->{$method}();
            }
        }
        return $returnArray;
    }

    /**
     * @return array
     */
    public function getUebermenschMods ()
    {
        return $this->uebermenschMods;
    }

    /**
     * @param $mod
     *
     * @return mixed
     */
    public function addUebermenschMods ($mod)
    {
        return $this->uebermenschMods[] = $mod;
    }

    /**
     * @param $uebermenschMods
     */
    public function setUebermenschMods ($uebermenschMods)
    {
        $this->uebermenschMods = $uebermenschMods;
    }

    /**
     * @param Application_Model_Trait[] $traits
     */
    public function traitsToUebermenschMod ($traits = [])
    {
        foreach ($traits as $trait) {
            if ($trait instanceof Application_Model_Trait) {
                switch ((int) $trait->getTraitId()) {
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


    /**
     * @param $circuitKategorie
     */
    public function setCircuitMod ($circuitKategorie)
    {
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
