<?php

/**
 * Description of Odo
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Odo {
    
    protected $id;
    protected $kategorie;
    protected $beschreibung;
    protected $kosten;
    protected $amount;
    protected $actualAmount;
    protected $modified;
    protected $modification = 0;
    

    public function getId() {
        return $this->id;
    }

    public function getKategorie() {
        return $this->kategorie;
    }

    public function getBeschreibung() {
        return $this->beschreibung;
    }

    public function getKosten() {
        return $this->kosten;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setKategorie($kategorie) {
        $this->kategorie = $kategorie;
    }

    public function setBeschreibung($beschreibung) {
        $this->beschreibung = $beschreibung;
    }

    public function setKosten($kosten) {
        $this->kosten = $kosten;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }
    
    public function getModified() {
        return $this->modified === true;
    }

    public function setModified($modified) {
        $this->modified = $modified;
    }
    
    public function getModification() {
        return $this->modification;
    }

    public function setModification($modification) {
        $this->modification += $modification;
    }
    
    public function getActualAmount() {
        return $this->actualAmount;
    }
    
    public function calculateActualOdo($circuit, $controlCategory, Application_Model_Klassengruppe $klassengruppe) {
        $actualAmount = $this->amount;
        $actualAmount += $this->calculateCircuitOdo($circuit);
        $actualAmount += $this->calculateControlOdo($controlCategory);
        if ($klassengruppe->getId() === 5) {
            $actualAmount = $actualAmount * 1.5;
        }
        $this->actualAmount = $actualAmount;
    }
    
    
    private function calculateCircuitOdo($circuit) {
        $bonus = 0;
        if ($circuit !== null) {
            $bonusByCategory = [
                'A' => 250, 'B' => 200, 'C' => 150, 'D' => 100, 'E' => 50, 'F' => 0,
            ];
            $bonus = $bonusByCategory[$circuit->getKategorie()];
        }
        return $bonus;
    }
    
    
    private function calculateControlOdo(Application_Model_Charakterwertecategory $controlCategory) {
        $categories = ['A' => 6, 'B' => 5, 'C' => 4, 'D' => 3, 'E' => 2, 'F' => 1];
        $actualCategory = substr($controlCategory->getCategory(), 0, 1);
        if ($controlCategory->getUebermensch()) {
            $bonus = 180 + $categories[$actualCategory] * 60;
        } else {
            $bonus = $categories[$actualCategory] * 30;
        }
        return $bonus;
    }
    
}
