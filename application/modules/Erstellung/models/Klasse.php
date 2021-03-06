<?php

/**
 * Description of Erstellung_Model_Klasse
 *
 * @author Vosser
 */
class Erstellung_Model_Klasse extends Application_Model_Klassengruppe implements JsonSerializable {

    /**
     * @return array
     */
    public function jsonSerialize ()
    {
        return [
            'id' => $this->id,
            'bezeichnung' => $this->bezeichnung,
            'beschreibung' => $this->beschreibung,
        ];
    }


}
