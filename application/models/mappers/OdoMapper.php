<?php

class Application_Model_Mapper_OdoMapper implements Application_Model_Erstellung_Information_InformationInterface{

    protected $dbTableOdo;

    public function getDbTableOdo() {
        if (null === $this->dbTableOdo) {
            $this->setDbTableOdo('Application_Model_DbTable_Odo');
        }
        return $this->dbTableOdo;
    }

    public function setDbTableOdo($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableOdo = $dbTable;
        return $this;
    }
    
    public function getPunkte($ids){
        $select = $this->getDbTableOdo()->select();
        $select->setIntegrityCheck(false);
        $select->from('Odo', array('Punkte' => new Zend_Db_Expr('SUM(Kosten)')));
        $select->where('ID IN(?)', $ids);
        $result = $this->getDbTableOdo()->fetchAll($select);
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
        $select = $this->getDbTableOdo()->select();
        $select->setIntegrityCheck('false');
        $select->from('Odo', array('Beschreibung' => 'Menge'));
        $select->where('ID IN (?)', $ids);
        $result = $this->getDbTableOdo()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = $row->Beschreibung;
            }
            return $return;
        }else{
            return null;
        }
    }
    
}
