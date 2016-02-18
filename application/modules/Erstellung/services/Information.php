<?php

/**
 * Description of Information
 *
 * @author Voß
 */
class Erstellung_Service_Information {
    
    
    public function getKlassengruppen() {
        return array('klassengruppen');
    }
    
    public function getKlassengruppe($id) {
        return json_encode(array(
                'id' => 1,
                'name' => 'Klassengruppe',
                'beschreibung' => 'Super gut',
            ));
    }
    
    public function getKlassen() {
        
    }
    
    public function getVorteile() {
        
    }
    
    public function getNachteile() {
        
    }
    
}
