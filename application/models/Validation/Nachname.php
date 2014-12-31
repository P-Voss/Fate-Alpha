<?php

/**
 * Description of Nachname
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Validation_Nachname implements Application_Model_Validation_ValidationInterface {
    
    public function validate($nachname) {
        $test = preg_match('/^[a-zA-ZäüöÄÜÖß]*$/iu', $nachname, $matches);

        if(mb_strlen($nachname, 'UTF-8') < 3){
            $return = 'Der Name ist zu kurz.';
        }elseif(mb_strlen($nachname, 'UTF-8') > 20){
            $return = 'Der Name ist zu lang.';
        }elseif($test !== 1){
            $return = 'Nicht erlaubte Zeichen im Namen.';
        }else{
            $return = ucfirst(mb_strtolower($nachname, 'UTF-8'));
        }
        return $return;
    }
    
}
