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
        $actualAmount += $controlCategory->getNumericValue() * 5;
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

}
