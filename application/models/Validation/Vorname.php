<?php

/**
 * Description of Vorname
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Validation_Vorname implements Application_Model_Validation_ValidationInterface {
    
    public function validate($vorname) {
        $test = preg_match('/^[a-zA-ZäüöÄÜÖß]*$/iu', $vorname, $matches);

        if(mb_strlen($vorname, 'UTF-8') < 3){
            $return = 'Der Name ist zu kurz.';
        }elseif(mb_strlen($vorname, 'UTF-8') > 20){
            $return = 'Der Name ist zu lang.';
        }elseif($test !== 1){
            $return = 'Nicht erlaubte Zeichen im Namen.';
        }else{
            $return = ucfirst(mb_strtolower($vorname, 'UTF-8'));
        }
        return $return;
    }
    
}
