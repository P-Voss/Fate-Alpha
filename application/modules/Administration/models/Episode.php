<?php

/**
 * Description of Administration_Model_Episode
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Model_Episode extends Application_Model_Episode {
    
    /**
     * @var Application_Model_Interfaces_Auswertung 
     */
    protected $auswertungen = array();
    
    public function getAuswertungen() {
        return $this->auswertungen;
    }

    public function setAuswertungen(Array $auswertungen) {
        foreach ($auswertungen as $auswertung) {
            if($auswertung instanceof Application_Model_Interfaces_Auswertung){
                $this->auswertungen[] = $auswertung;
            }
        }
    }
    
    public function addAuswertung(Application_Model_Interfaces_Auswertung $auswertung) {
        $this->auswertungen[] = $auswertung;
    }
    
}
