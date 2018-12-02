<?php

/**
 * Description of Erstellung_Model_Circuit
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Erstellung_Model_Circuit extends Application_Model_Circuit implements JsonSerializable {

    /**
     * @return array
     */
    public function jsonSerialize ()
    {
        return [
            'id' => $this->id,
            'beschreibung' => $this->beschreibung,
            'kategorie' => $this->kategorie,
            'menge' => $this->menge,
            'kosten' => $this->kosten
        ];
    }

}
