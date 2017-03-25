<?php

/**
 * Description of Application_Model_Weapons_CalculationInterface
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
interface Application_Model_Weapons_CalculationInterface {
    
    
    public function calculate(Application_Model_Charakterwerte $charakterWerte, $multiplier);
    
}
