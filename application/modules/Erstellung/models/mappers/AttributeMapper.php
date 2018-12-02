<?php

/**
 * Class Erstellung_Model_Mapper_AttributeMapper
 */
class Erstellung_Model_Mapper_AttributeMapper extends Application_Model_Mapper_ErstellungMapper {

    /**
     * @return array
     * @throws Exception
     */
    public function getKlassengruppen() {
        $returnArray = array();
        $select = parent::getDbTable('Klassengruppe')->select();
        $result = parent::getDbTable('Klassengruppe')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $klasse = new Erstellung_Model_Klasse();
                $klasse->setId($row->klassengruppenId);
                $klasse->setBezeichnung($row->name);
                $klasse->setBeschreibung($row->beschreibung);
                $returnArray[] = $klasse;
            }
        }
        return $returnArray;
    }
    
    
    public function getKlassengruppeById($klassengruppenId) {
        $select = parent::getDbTable('Klassengruppe')->select();
        $select->where('klassengruppenId = ?', $klassengruppenId);
        $row = parent::getDbTable('Klassengruppe')->fetchRow($select);
        if($row !== null){
            $klassengruppe = new Erstellung_Model_Klasse();
            $klassengruppe->setId($row->klassengruppenId);
            $klassengruppe->setBezeichnung($row->name);
            $klassengruppe->setBeschreibung($row->beschreibung);
            return $klassengruppe;
        }else{
            return false;
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getFamiliennamen() {
        $returnArray = array();
        $select = parent::getDbTable('Klasse')->select();
        $select->where('familienname != "" AND familienname IS NOT NULL');
        $result = parent::getDbTable('Klasse')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row) {
                $returnArray[] = $row->familienname;
            }
        }
        return $returnArray;
    }
    
}
