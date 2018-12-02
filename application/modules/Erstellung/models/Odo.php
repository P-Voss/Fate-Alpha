<?php

/**
 * Description of Odo
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Erstellung_Model_Odo extends Application_Model_Odo implements JsonSerializable {

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
            'amount' => $this->amount,
        ];
    }

}
