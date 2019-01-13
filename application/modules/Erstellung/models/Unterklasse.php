<?php

/**
 * Description of Erstellung_Model_Unterklasse
 *
 * @author Vosser
 */
class Erstellung_Model_Unterklasse extends Application_Model_Klasse implements JsonSerializable {
    
    /**
     * @var Erstellung_Model_Requirementlist
     */
    private $requirementList;
    
    public function getRequirementList() {
        return $this->requirementList;
    }

    public function setRequirementList(Erstellung_Model_Requirementlist $requirementList) {
        $this->requirementList = $requirementList;
    }

    /**
     * @return array
     */
    public function jsonSerialize ()
    {
        return [
            'id' => $this->id,
            'bezeichnung' => $this->bezeichnung,
            'beschreibung' => $this->beschreibung,
            'familienname' => $this->familienname,
            'kosten' => $this->kosten,
        ];
    }
    
}
