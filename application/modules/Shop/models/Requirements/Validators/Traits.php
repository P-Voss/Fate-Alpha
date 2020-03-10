<?php

namespace Shop\Models\Requirements\Validators;

use Shop\Models\Requirements\ValidationInterface;

/**
 * Description of Trait
 *
 * @author Voß
 */
class Traits implements ValidationInterface
{

    /**
     * @param \Application_Model_Charakter $charakter
     * @param mixed $value
     *
     * @return boolean
     */
    public function check (\Application_Model_Charakter $charakter, $value)
    {
        $values = explode('|', $value);
        foreach ($values as $value) {
            foreach ($charakter->getTraits() as $trait) {
                if ($trait->getTraitId() == $value) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param \Application_Model_Charakter $charakter
     * @param mixed $value
     * @return boolean
     */
    public function successfulWildcard (\Application_Model_Charakter $charakter, $value)
    {
        return false;
    }

    /**
     * @param \Application_Model_Charakter $charakter
     * @param $value
     *
     * @return bool
     */
    public function isIncompatible (\Application_Model_Charakter $charakter, $value)
    {
        return false;
    }

}
