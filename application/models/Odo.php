<?php

/**
 * Description of Odo
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Odo
{

    protected $id;
    protected $kategorie;
    protected $beschreibung;
    protected $kosten;
    protected $amount;
    protected $actualAmount;
    protected $modified;
    protected $modification = 0;


    public function getId ()
    {
        return $this->id;
    }

    public function getKategorie ()
    {
        return $this->kategorie;
    }

    public function getBeschreibung ()
    {
        return $this->beschreibung;
    }

    public function getKosten ()
    {
        return $this->kosten;
    }

    public function getAmount ()
    {
        return $this->amount;
    }

    public function setId ($id)
    {
        $this->id = $id;
    }

    public function setKategorie ($kategorie)
    {
        $this->kategorie = $kategorie;
    }

    public function setBeschreibung ($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

    public function setKosten ($kosten)
    {
        $this->kosten = $kosten;
    }

    public function setAmount ($amount)
    {
        $this->amount = $amount;
    }

    public function getModified ()
    {
        return $this->modified === true;
    }

    public function setModified ($modified)
    {
        $this->modified = $modified;
    }

    public function getModification ()
    {
        return $this->modification;
    }

    public function setModification ($modification)
    {
        $this->modification += $modification;
    }

    public function getActualAmount ()
    {
        return $this->actualAmount;
    }

    /**
     * @param Application_Model_Circuit $circuit
     * @param Application_Model_Charakterwertecategory $controlCategory
     * @param Application_Model_Klassengruppe $klassengruppe
     */
    public function calculateActualOdo (
        Application_Model_Circuit $circuit,
        Application_Model_Charakterwertecategory $controlCategory,
        Application_Model_Klassengruppe $klassengruppe
    )
    {
        $actualAmount = $this->amount;
        $actualAmount += $this->calculateCircuitOdo($circuit);
        $actualAmount += $this->calculateControlOdo($controlCategory);
        if ($klassengruppe->getId() === 5) {
            $actualAmount = $actualAmount * 1.5;
        }
        $this->actualAmount = $actualAmount;
    }

    /**
     * @param Application_Model_Circuit $circuit
     *
     * @return int
     */
    private function calculateCircuitOdo (Application_Model_Circuit $circuit)
    {
        $bonusByCategory = [
            'A' => 250, 'B' => 200, 'C' => 150, 'D' => 100, 'E' => 50, 'F' => 0,
        ];
        return isset($bonusByCategory[$circuit->getKategorie()]) ? $bonusByCategory[$circuit->getKategorie()] : 0;
    }

    /**
     * @param Application_Model_Charakterwertecategory $controlCategory
     *
     * @return int
     */
    private function calculateControlOdo (Application_Model_Charakterwertecategory $controlCategory)
    {
        $actualCategory = substr($controlCategory->getCategory(), 0, 1);
        if ($controlCategory->getUebermensch()) {
            return $this->getOdoUeber($actualCategory);
        } else {
            return $this->getOdoNormal($actualCategory);
        }
    }

    /**
     * @param string $kategorie
     *
     * @return int
     */
    private function getOdoUeber ($kategorie)
    {
        $bonusOdo = [
            'F' => 200,
            'E' => 240,
            'D' => 290,
            'C' => 350,
            'B' => 420,
            'A' => 500,
        ];
        return isset($bonusOdo[$kategorie]) ? $bonusOdo[$kategorie] : 200;
    }

    /**
     * @param string $kategorie
     *
     * @return int
     */
    private function getOdoNormal ($kategorie)
    {
        $bonusOdo = [
            'F' => 0,
            'E' => 30,
            'D' => 60,
            'C' => 95,
            'B' => 130,
            'A' => 170,
        ];
        return isset($bonusOdo[$kategorie]) ? $bonusOdo[$kategorie] : 0;
    }

}
