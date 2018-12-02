<?php

/**
 * Description of Element
 *
 * @author Vosser
 */
class Erstellung_Model_Element extends Application_Model_Element implements JsonSerializable {

    /**
     * @return array
     */
    public function jsonSerialize ()
    {
        return [
            'id' => $this->id,
            'bezeichnung' => $this->bezeichnung,
            'beschreibung' => $this->beschreibung,
            'charakterisierung' => $this->charakterisierung,
            'kosten' => $this->kosten,
        ];
    }

}
