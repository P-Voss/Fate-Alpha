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
                    $this->setFp($this->getFp() + (2 * ceil($attribute->getValue())));
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
            ['category' => 'F-', 'lowerbound' => -10000000, 'numeric' => 0],
            ['category' => 'F', 'lowerbound' => -1, 'numeric' => 0],
            ['category' => 'F+', 'lowerbound' => 0, 'numeric' => 0],
            ['category' => 'E-', 'lowerbound' => 40, 'numeric' => 1],
            ['category' => 'E', 'lowerbound' => 80, 'numeric' => 1],
            ['category' => 'E+', 'lowerbound' => 120, 'numeric' => 1],
            ['category' => 'D-', 'lowerbound' => 160, 'numeric' => 2],
            ['category' => 'D', 'lowerbound' => 200, 'numeric' => 2],
            ['category' => 'D+', 'lowerbound' => 250, 'numeric' => 2],
            ['category' => 'C-', 'lowerbound' => 300, 'numeric' => 3],
            ['category' => 'C', 'lowerbound' => 350, 'numeric' => 3],
            ['category' => 'C+', 'lowerbound' => 400, 'numeric' => 3],
            ['category' => 'B-', 'lowerbound' => 460, 'numeric' => 4],
            ['category' => 'B', 'lowerbound' => 520, 'numeric' => 4],
            ['category' => 'B+', 'lowerbound' => 580, 'numeric' => 4],
            ['category' => 'A-', 'lowerbound' => 650, 'numeric' => 5],
            ['category' => 'A', 'lowerbound' => 720, 'numeric' => 5],
            ['category' => 'A+', 'lowerbound' => 800, 'numeric' => 5],
            ['category' => 'EF-', 'lowerbound' => 800, 'numeric' => 6],
            ['category' => 'EF', 'lowerbound' => 880, 'numeric' => 6],
            ['category' => 'EF+', 'lowerbound' => 960, 'numeric' => 6],
            ['category' => 'EE-', 'lowerbound' => 1050, 'numeric' => 7],
            ['category' => 'EE', 'lowerbound' => 1150, 'numeric' => 7],
            ['category' => 'EE+', 'lowerbound' => 1250, 'numeric' => 7],
            ['category' => 'ED-', 'lowerbound' => 1400, 'numeric' => 8],
            ['category' => 'ED', 'lowerbound' => 1500, 'numeric' => 8],
            ['category' => 'ED+', 'lowerbound' => 1600, 'numeric' => 8],
            ['category' => 'EC-', 'lowerbound' => 1800, 'numeric' => 9],
            ['category' => 'EC', 'lowerbound' => 1900, 'numeric' => 9],
            ['category' => 'EC+', 'lowerbound' => 2000, 'numeric' => 9],
            ['category' => 'EB-', 'lowerbound' => 2200, 'numeric' => 10],
            ['category' => 'EB', 'lowerbound' => 2300, 'numeric' => 10],
            ['category' => 'EB+', 'lowerbound' => 2400, 'numeric' => 10],
            ['category' => 'EA-', 'lowerbound' => 2600, 'numeric' => 11],
            ['category' => 'EA', 'lowerbound' => 2800, 'numeric' => 11],
            ['category' => 'EA+', 'lowerbound' => 3000, 'numeric' => 11],
            ['category' => 'DF-', 'lowerbound' => 3250, 'numeric' => 12],
            ['category' => 'DF', 'lowerbound' => 3500, 'numeric' => 12],
            ['category' => 'DF+', 'lowerbound' => 3750, 'numeric' => 12],
            ['category' => 'DE-', 'lowerbound' => 4000, 'numeric' => 13],
            ['category' => 'DE', 'lowerbound' => 4250, 'numeric' => 13],
            ['category' => 'DE+', 'lowerbound' => 4500, 'numeric' => 13],
            ['category' => 'DD-', 'lowerbound' => 4750, 'numeric' => 14],
            ['category' => 'DD', 'lowerbound' => 5000, 'numeric' => 14],
            ['category' => 'DD+', 'lowerbound' => 5500, 'numeric' => 14],
            ['category' => 'DC-', 'lowerbound' => 6000, 'numeric' => 15],
            ['category' => 'DC', 'lowerbound' => 6500, 'numeric' => 15],
            ['category' => 'DC+', 'lowerbound' => 70000, 'numeric' => 15],
            ['category' => 'DB-', 'lowerbound' => 7500, 'numeric' => 16],
            ['category' => 'DB', 'lowerbound' => 8250, 'numeric' => 16],
            ['category' => 'DB+', 'lowerbound' => 9000, 'numeric' => 16],
            ['category' => 'DA-', 'lowerbound' => 9750, 'numeric' => 17],
            ['category' => 'DA', 'lowerbound' => 10500, 'numeric' => 17],
            ['category' => 'DA+', 'lowerbound' => 11000, 'numeric' => 17],
        ];
        $activeCategory = $categories[0];
        foreach ($categories as $key => $category) {
            if ($category['lowerbound'] <= $value) {
                $activeCategory = $category;
            }
        }

        $werteCategory = new Application_Model_Charakterwertecategory();
        $werteCategory->setCategory($activeCategory['category']);
        $werteCategory->setNumericValue($activeCategory['numeric']);

        return $werteCategory;
    }


    /**
     * @return int
     */
    public function getEnergie ()
    {
        $category = $this->getCategory('aus');
        return (17 + ($category->getNumericValue() * 3)) * 2;
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
