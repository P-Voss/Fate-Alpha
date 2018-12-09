<?php

/**
 * Description of Erstellung_Model_Klasse
 *
 * @author Vosser
 */
class Erstellung_Model_Trait extends Application_Model_Trait implements JsonSerializable
{

    /**
     * @return array
     */
    public function jsonSerialize ()
    {
        $incTraitIds = array_map(
            function (Application_Model_Trait $trait) {
                return $trait->getTraitId();
            }, $this->incompatibleTraits
        );
        return [
            'id' => $this->traitId,
            'bezeichnung' => $this->name,
            'beschreibung' => $this->beschreibung,
            'kosten' => $this->kosten,
            'incompatibleTraits' => $incTraitIds,
        ];
    }


}
