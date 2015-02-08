<?php

class Application_Model_Mapper_LuckMapper implements Application_Model_Erstellung_Information_InformationInterface{

    protected $dbTableLuck;

    public function getDbTableLuck() {
        if (null === $this->dbTableLuck) {
            $this->setDbTableLuck('Application_Model_DbTable_Luck');
        }
        return $this->dbTableLuck;
    }

    public function setDbTableLuck($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableLuck = $dbTable;
        return $this;
    }
    
    public function getPunkte($ids){
        $select = $this->getDbTableLuck()->select();
        $select->setIntegrityCheck(false);
        $select->from('Luck', array('Punkte' => new Zend_Db_Expr('SUM(Kosten)')));
        $select->where('ID IN(?)', $ids);
        $result = $this->getDbTableLuck()->fetchAll($select);
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
        $select = $this->getDbTableLuck()->select();
        $select->setIntegrityCheck('false');
        $select->from('Luck', array('Beschreibung' => 'Beschreibung'));
        $select->where('ID IN (?)', $ids);
        $result = $this->getDbTableLuck()->fetchAll($select);
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
