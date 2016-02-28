<?php

class Application_Model_Mapper_NachteilMapper implements Application_Model_Erstellung_Information_InformationInterface{


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
    
    public function getPunkte($id){
        $select = $this->getDbTable('Nachteil')->select();
        $select->setIntegrityCheck(false);
        $select->from('nachteile', array('Punkte' => new Zend_Db_Expr('SUM(kosten)')));
        $select->where('nachteilId = ?', $id);
        $result = $this->getDbTable('Nachteil')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = $row->Punkte;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getBeschreibung($id) {
        $select = $this->getDbTable('Nachteil')->select();
        $select->setIntegrityCheck('false');
        $select->from('nachteile', array('beschreibung'));
        $select->where('nachteilId = ?', $id);
        $result = $this->getDbTable('Nachteil')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = $row->beschreibung;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    
    public function getIncompatibleNachteile($nachteilId) {
        $disabledNachteile = array();
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
        return $disabledNachteile;
    }
    
    
    public function getIncompatibleVorteile($nachteilId) {
        $disabledVorteile = array();
        $select = $this->getDbTable('VorteilToNachteil')->select();
        $select->where('nachteilId = ?', $nachteilId);
        $result = $this->getDbTable('VorteilToNachteil')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $disabledVorteile[] = $row->vorteilId;
            }
        }
        return $disabledVorteile;
    }
    
    
}
