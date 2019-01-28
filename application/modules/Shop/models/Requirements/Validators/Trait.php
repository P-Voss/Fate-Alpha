<?php

/**
 * Description of Shop_Model_Requirements_Validators_Trait
 *
 * @author Voß
 */
class Shop_Model_Requirements_Validators_Trait implements Shop_Model_Requirements_ValidationInterface
{

    /**
     * @param Application_Model_Charakter $charakter
     * @param mixed $value
     *
     * @return boolean
     */
    public function check (Application_Model_Charakter $charakter, $value)
    {
        $values = explode(':', $value);
        foreach ($values as $value) {
            foreach ($charakter->getTraits() as $trait) {
                if ($trait->getTraitId() == $value) {
                    return true;
                }
            }
        }
        return false;
    }

}
