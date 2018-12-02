<?php

/**
 * Description of Luck
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Erstellung_Model_Luck extends Application_Model_Luck implements JsonSerializable {

    /**
     * @return array
     */
    public function jsonSerialize ()
    {
        return [
            'id' => $this->id,
            'kategorie' => $this->kategorie,
            'beschreibung' => $this->beschreibung,
            'kosten' => $this->kosten,
        ];
    }

}
