<?php

namespace Shop\Models;

use Exception;

/**
 * Class Item
 */
class Item extends \Application_Model_Item
{

    /**
     * @var boolean
     */
    private $learned = false;
    /**
     * @var Requirementlist
     */
    private $requirementList;

    /**
     * @return bool
     */
    public function getLearned ()
    {
        return $this->learned;
    }

    /**
     * @param $learned
     */
    public function setLearned ($learned)
    {
        $this->learned = $learned;
    }

    /**
     * @return Requirementlist
     */
    public function getRequirementList ()
    {
        return $this->requirementList;
    }

    /**
     * @param Requirementlist $requirementList
     */
    public function setRequirementList (Requirementlist $requirementList)
    {
        $this->requirementList = $requirementList;
    }

    /**
     * @return array
     */
    public function jsonSerialize ()
    {
        $return = [];
        foreach (get_object_vars($this) as $key => $property) {
            $return[$key] = $property;
        }
        return $return;
    }

    /**
     * @return bool
     */
    public function activeDiscountDay ()
    {
        try {
            $date = new \DateTime();
            $currentDay = $date->format('N');
            return in_array($currentDay, $this->discountDays);
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param \Application_Model_Charakter $character
     *
     * @return int
     * @throws Exception
     */
    public function getActualCost (\Application_Model_Charakter $character)
    {
        $date = new \DateTime();
        $currentDay = $date->format('N');

        $discountByWealth = 0;
        switch ($character->getVermoegen()->getKategorie()) {
            case 'C':
                $discountByWealth = 10;
                break;
            case 'B':
                $discountByWealth = 20;
                break;
            case 'A':
                $discountByWealth = 30;
                break;
            case 'A+':
                $discountByWealth = 40;
                break;
            case 'EX':
                $discountByWealth = 80;
                break;
        }
        $costAfterDiscount = $this->cost - ceil($this->cost * ($discountByWealth / 100));

        if (in_array($currentDay, $this->discountDays)) {
            return $costAfterDiscount - ceil($costAfterDiscount * 0.2);
        } else {
            return $costAfterDiscount;
        }
    }

}