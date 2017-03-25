<?php

/**
 * Description of Application_Model_Item
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Item {
    
    protected $itemName;
    protected $itemArt;
    protected $description;
    
    protected $damageComponents;
    protected $range;
    
    protected $statBoosts;
    
    public function getItemName() {
        return $this->itemName;
    }

    public function getItemArt() {
        return $this->itemArt;
    }

    public function getDescription() {
        return $this->description;
    }
    
    /**
     * @return Application_Model_DamageComponent
     */
    public function getDamageComponents() {
        return $this->damageComponents;
    }

    public function getRange() {
        return $this->range;
    }

    public function setItemName($itemName) {
        $this->itemName = $itemName;
    }

    public function setItemArt($itemArt) {
        $this->itemArt = $itemArt;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
    /**
     * @param array $damageComponents
     */
    public function setDamageComponents(Array $damageComponents) {
        foreach ($damageComponents as $damageComponent) {
            if ($damageComponent instanceof Application_Model_DamageComponent) {
                $this->damageComponents[] = $damageComponent;
            }
        }
    }
    
    /**
     * @param Application_Model_DamageComponent $damageComponent
     */
    public function addDamageComponent(Application_Model_DamageComponent $damageComponent) {
        $this->damageComponents[] = $damageComponent;
    }

    public function setRange($range) {
        $this->range = $range;
    }
    
}
