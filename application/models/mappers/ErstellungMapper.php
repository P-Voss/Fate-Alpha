<?php

/**
 * Description of ErstellungMapper
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Mapper_ErstellungMapper {
    
    public function getDbTable($tablename) {
        $className = 'Application_Model_DbTable_' . $tablename;
        if(!class_exists($className)){
            throw new Exception('Falsche Tabellenadapter angegeben');
        }
        $dbTable = new $className();
        if(!$dbTable instanceof Zend_Db_Table_Abstract){
            throw new Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }
    
    public function getAllVorteile() {
        $select = $this->getDbTable('Vorteil')->select();
        $result = $this->getDbTable('Vorteil')->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Vorteil();
                $model->setId($row->VorteilID);
                $model->setBezeichnung($row->Vorteil);
                $model->setBeschreibung($row->Beschreibung);
                $model->setKosten($row->Kosten);
                $model->setGruppe($row->Kombo);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getVorteilIncompatibilities($vorteilIds = null, $nachteilIds = null) {
        $disabledVorteile = array();
        foreach ($vorteilIds as $vorteilId){
            $select1 = $this->getDbTable('VorteilToVorteil')->select();
            $select1->from('InkVorteilToVorteil', array('id' => 'id2'));
            $select1->where('id1 = ?', $vorteilId);

            $select2 = $this->getDbTable('VorteilToVorteil')->select();
            $select2->from('InkVorteilToVorteil', array('id' => 'id1'));
            $select2->Where('id2 = ?', $vorteilId);

            $select = $this->getDbTable('VorteilToVorteil')->select();
            $select->union(array($select1, $select2));
            $result = $this->getDbTable('VorteilToVorteil')->fetchAll($select);
            if($result->count() > 0){
                foreach ($result as $row){
                    $disabledVorteile[] = $row->id;
                }
            }
        }
        foreach ($nachteilIds as $nachteilId){
            $select = $this->getDbTable('NachteilToVorteil')->select();
            $select->from('InkNachteilToVorteil', array('id' => 'vorteil_id'));
            $select->where('nachteil_id = ?', $nachteilId);

            $result = $this->getDbTable('NachteilToVorteil')->fetchAll($select);
            if($result->count() > 0){
                foreach ($result as $row){
                    $disabledVorteile[] = $row->id;
                }
            }
        }
        return $disabledVorteile;
    }
    
    public function getNachteilIncompatibilities($nachteilIds = null, $vorteilIds = null) {
        $disabledNachteile = array();
        foreach ($nachteilIds as $nachteilId){
            $select1 = $this->getDbTable('NachteilToNachteil')->select();
            $select1->from('InkNachteilToNachteil', array('id' => 'id2'));
            $select1->where('id1 = ?', $nachteilId);

            $select2 = $this->getDbTable('NachteilToNachteil')->select();
            $select2->from('InkNachteilToNachteil', array('id' => 'id1'));
            $select2->Where('id2 = ?', $nachteilId);

            $select = $this->getDbTable('NachteilToNachteil')->select();
            $select->union(array($select1, $select2));
            $result = $this->getDbTable('NachteilToNachteil')->fetchAll($select);
            if($result->count() > 0){
                foreach ($result as $row){
                    $disabledNachteile[] = $row->id;
                }
            }
        }
        foreach ($vorteilIds as $vorteilId){
            $select = $this->getDbTable('VorteilToNachteil')->select();
            $select->from('InkVorteilToNachteil', array('id' => 'nachteil_id'));
            $select->where('vorteil_id = ?', $vorteilId);

            $result = $this->getDbTable('VorteilToNachteil')->fetchAll($select);
            if($result->count() > 0){
                foreach ($result as $row){
                    $disabledNachteile[] = $row->id;
                }
            }
        }
        return $disabledNachteile;
    }
    
    public function getAllNachteile() {
        $select = $this->getDbTable('Nachteil')->select();
        $result = $this->getDbTable('Nachteil')->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Nachteil();
                $model->setId($row->NachteilID);
                $model->setBezeichnung($row->Nachteil);
                $model->setBeschreibung($row->Beschreibung);
                $model->setKosten($row->Kosten);
                $model->setGruppe($row->Kombo);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getAllClasses() {
        $select = $this->getDbTable('Klasse')->select();
        $result = $this->getDbTable('Klasse')->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Klasse();
                $model->setId($row->KlassenID);
                $model->setBezeichnung($row->Klasse);
                $model->setBeschreibung($row->Beschreibung);
                $model->setKosten($row->Kosten);
                $model->setGruppe($row->Gruppe);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getAllCircuits() {
        $select = $this->getDbTable('Circuit')->select();
        $result = $this->getDbTable('Circuit')->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Circuit();
                $model->setId($row->ID);
                $model->setKategorie($row->Kategorie);
                $model->setBeschreibung($row->Besonderheit);
                $model->setMenge($row->Menge);
                $model->setKosten($row->Kosten);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getAllLuckvalues() {
        $select = $this->getDbTable('Luck')->select();
        $result = $this->getDbTable('Luck')->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Luck();
                $model->setId($row->ID);
                $model->setKategorie($row->Kategorie);
                $model->setBeschreibung($row->Beschreibung);
                $model->setKosten($row->Kosten);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getAllElements() {
        $select = $this->getDbTable('Element')->select();
        $result = $this->getDbTable('Element')->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Element();
                $model->setId($row->ID);
                $model->setBezeichnung($row->Element);
                $model->setBeschreibung($row->Beschreibung);
                $model->setCharakterisierung($row->Charakterisierung);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getAllOdo() {
        $select = $this->getDbTable('Odo')->select();
        $result = $this->getDbTable('Odo')->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Odo();
                $model->setId($row->ID);
                $model->setKategorie($row->Kategorie);
                $model->setMenge($row->Menge);
                $model->setKosten($row->Kosten);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
}
