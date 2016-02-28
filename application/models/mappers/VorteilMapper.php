<?php

class Application_Model_Mapper_VorteilMapper implements Application_Model_Erstellung_Information_InformationInterface{

    
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
    
    public function getPunkte($ids){
        $select = $this->getDbTable('Vorteil')->select();
        $select->setIntegrityCheck(false);
        $select->from('vorteile', array('Punkte' => new Zend_Db_Expr('SUM(kosten)')));
        $select->where('vorteilId IN(?)', $ids);
        $result = $this->getDbTable('Vorteil')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = $row->Punkte;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getBeschreibung($ids) {
        $select = $this->getDbTable('Vorteil')->select();
        $select->setIntegrityCheck('false');
        $select->from('vorteile', array('beschreibung'));
        $select->where('vorteilId IN (?)', $ids);
        $result = $this->getDbTable('Vorteil')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = $row->beschreibung;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getIncompatibleVorteile($vorteilId) {
        $disabledVorteile = array();
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
        return $disabledVorteile;
    }
    
    public function getIncompatibleNachteile($vorteilId) {
        $disabledNachteile = array();
        $select = $this->getDbTable('VorteilToNachteil')->select();
        $select->where('vorteilId = ?', $vorteilId);
        $result = $this->getDbTable('VorteilToNachteil')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $disabledNachteile[] = $row->nachteilId;
            }
        }
        return $disabledNachteile;
    }
    
}
