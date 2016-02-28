<?php

class Erstellung_Model_Mapper_KlassenMapper extends Application_Model_Mapper_KlasseMapper {
    
    
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
    
}
