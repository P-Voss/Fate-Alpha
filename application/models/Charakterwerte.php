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

    protected $circuitBonus = 0;

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
                break;
            case 'kontrolle':
                $this->setKontrolle($this->getKontrolle() + $attribute->getValue());
                break;
            case 'uebung':
                $this->setUebung($this->getUebung() + $attribute->getValue());
                if ($attribute->getValue() > 0) {
                    $this->setFp($this->getFp() + ceil($attribute->getValue()));
                }
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
        $attributes = [
            'str' => $this->staerke,
            'agi' => $this->agilitaet,
            'aus' => $this->ausdauer,
            'kon' => $this->kontrolle,
            'dis' => $this->disziplin,
            'pra' => $this->uebung,
        ];
        $value = isset($attributes[$attr]) ? $attributes[$attr] : 0;

        $categories = [
            ['category' => 'F-', 'lowerbound' => -10000000],
            ['category' => 'F', 'lowerbound' => -1],
            ['category' => 'F+', 'lowerbound' => 0],
            ['category' => 'E-', 'lowerbound' => 40],
            ['category' => 'E', 'lowerbound' => 80],
            ['category' => 'E+', 'lowerbound' => 120],
            ['category' => 'D-', 'lowerbound' => 160],
            ['category' => 'D', 'lowerbound' => 200],
            ['category' => 'D+', 'lowerbound' => 250],
            ['category' => 'C-', 'lowerbound' => 300],
            ['category' => 'C', 'lowerbound' => 350],
            ['category' => 'C+', 'lowerbound' => 400],
            ['category' => 'B-', 'lowerbound' => 460],
            ['category' => 'B', 'lowerbound' => 520],
            ['category' => 'B+', 'lowerbound' => 580],
            ['category' => 'A-', 'lowerbound' => 650],
            ['category' => 'A', 'lowerbound' => 720],
            ['category' => 'A+', 'lowerbound' => 800],
            ['category' => 'EF-', 'lowerbound' => 800],
            ['category' => 'EF', 'lowerbound' => 880],
            ['category' => 'EF+', 'lowerbound' => 960],
            ['category' => 'EE-', 'lowerbound' => 1050],
            ['category' => 'EE', 'lowerbound' => 1150],
            ['category' => 'EE+', 'lowerbound' => 1250],
            ['category' => 'ED-', 'lowerbound' => 1400],
            ['category' => 'ED', 'lowerbound' => 1500],
            ['category' => 'ED+', 'lowerbound' => 1600],
            ['category' => 'EC-', 'lowerbound' => 1800],
            ['category' => 'EC', 'lowerbound' => 1900],
            ['category' => 'EC+', 'lowerbound' => 2000],
            ['category' => 'EB-', 'lowerbound' => 2200],
            ['category' => 'EB', 'lowerbound' => 2300],
            ['category' => 'EB+', 'lowerbound' => 2400],
            ['category' => 'EA-', 'lowerbound' => 2600],
            ['category' => 'EA', 'lowerbound' => 2800],
            ['category' => 'EA+', 'lowerbound' => 3000],
        ];
        $activeKey = 0;
        $activeCategory = $categories[0];
        foreach ($categories as $key => $category) {
            if ($category['lowerbound'] <= $value) {
                $activeCategory = $category;
                $activeKey = $key;
            }
        }

        $werteCategory = new Application_Model_Charakterwertecategory();
        $werteCategory->setCategory($activeCategory['category']);
        $werteCategory->setNumericValue($activeKey);

        return $werteCategory;
    }


    /**
     * @return int
     */
    public function getEnergie ()
    {
        $category = $this->getCategory('aus');
        return (17 + $category->getNumericValue()) * 2;
    }

    /**
     * @return array
     */
    public function toArray ()
    {
        $returnArray = [];
        $nonArrayMethods = ['getCategory', 'getEnergie'];
        foreach (get_class_methods(get_class($this)) as $method) {
            if (substr($method, 0, 3) === 'get' AND !in_array($method, $nonArrayMethods)) {
                $returnArray[lcfirst(substr($method, 3))] = $this->{$method}();
            }
        }
        return $returnArray;
    }

    /**
     * @param array $stats
     */
    public function fromArray ($stats = [])
    {
        foreach ($stats as $key => $value) {
            switch ($key) {
                case 'staerke':
                    $this->staerke = $value;
                    break;
                case 'agilitaet':
                    $this->agilitaet = $value;
                    break;
                case 'ausdauer':
                    $this->ausdauer = $value;
                    break;
                case 'kontrolle':
                    $this->kontrolle = $value;
                    break;
                case 'disziplin':
                    $this->disziplin = $value;
                    break;
                case 'uebung':
                    $this->uebung = $value;
                    break;
            }
        }
    }

}
