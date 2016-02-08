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
    
    /**
     * @return \Application_Model_Vorteil
     */
    public function getAllVorteile() {
            $return = array();
        $select = $this->getDbTable('Vorteil')->select();
        $result = $this->getDbTable('Vorteil')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Application_Model_Vorteil();
                $model->setId($row->vorteilId);
                $model->setBezeichnung($row->name);
                $model->setBeschreibung($row->beschreibung);
                $model->setKosten($row->kosten);
                $model->setGruppe($row->kombo);
                $return[] = $model;
            }
        }
        return $return;
    }
    
    public function getVorteilIncompatibilities($vorteilIds = null, $nachteilIds = null) {
        $disabledVorteile = array();
        foreach ($vorteilIds as $vorteilId){
            $select1 = $this->getDbTable('VorteilToVorteil')->select();
            $select1->from('inkVorteilToVorteil', array('id' => 'vorteilId2'));
            $select1->where('vorteilId1 = ?', $vorteilId);

            $select2 = $this->getDbTable('VorteilToVorteil')->select();
            $select2->from('inkVorteilToVorteil', array('id' => 'vorteilId1'));
            $select2->Where('vorteilId2 = ?', $vorteilId);

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
            $select->from('inkNachteilToVorteil', array('id' => 'vorteilId'));
            $select->where('nachteilId = ?', $nachteilId);

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
            $select1->from('inkNachteilToNachteil', array('id' => 'nachteilId2'));
            $select1->where('nachteilId1 = ?', $nachteilId);

            $select2 = $this->getDbTable('NachteilToNachteil')->select();
            $select2->from('inkNachteilToNachteil', array('id' => 'nachteilId1'));
            $select2->Where('nachteilId2 = ?', $nachteilId);

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
            $select->from('inkVorteilToNachteil', array('id' => 'nachteilId'));
            $select->where('vorteilId = ?', $vorteilId);

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
        $return = array();
        $select = $this->getDbTable('Nachteil')->select();
        $result = $this->getDbTable('Nachteil')->fetchAll($select);
        foreach ($result as $row){
            $model = new Application_Model_Nachteil();
            $model->setId($row->nachteilId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            $model->setKosten($row->kosten);
            $return[] = $model;
        }
        return $return;
    }
    
    public function getAllClasses() {
        $select = $this->getDbTable('Klasse')->select();
        $result = $this->getDbTable('Klasse')->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Klasse();
                $model->setId($row->klassenId);
                $model->setBezeichnung($row->klasse);
                $model->setBeschreibung($row->beschreibung);
                $model->setKosten($row->kosten);
                $model->setGruppe($row->klassengruppenId);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getAllClassgroups() {
        $select = $this->getDbTable('Klassengruppe')->select();
        $result = $this->getDbTable('Klassengruppe')->fetchAll($select);
        if($result->count() > 0){
            $return = array();
            foreach ($result as $row){
                $model = new Application_Model_Klassengruppe();
                $model->setId($row->klassengruppenId);
                $model->setBezeichnung($row->name);
                $model->setBeschreibung($row->beschreibung);
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
                $model->setId($row->circuitId);
                $model->setKategorie($row->kategorie);
                $model->setBeschreibung($row->besonderheit);
                $model->setMenge($row->menge);
                $model->setKosten($row->kosten);
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
                $model->setId($row->luckId);
                $model->setKategorie($row->kategorie);
                $model->setBeschreibung($row->beschreibung);
                $model->setKosten($row->kosten);
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
                $model->setId($row->elementId);
                $model->setBezeichnung($row->name);
                $model->setBeschreibung($row->beschreibung);
                $model->setCharakterisierung($row->charakterisierung);
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
                $model->setId($row->odoId);
                $model->setKategorie($row->kategorie);
                $model->setMenge($row->menge);
                $model->setKosten($row->kosten);
                $return[] = $model;
            }
            return $return;
        }else{
            return null;
        }
    }
    
}
