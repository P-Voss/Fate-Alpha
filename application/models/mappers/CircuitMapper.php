<?php

class Application_Model_Mapper_CircuitMapper implements Application_Model_Erstellung_Information_InformationInterface{

    protected $dbTableCircuit;

    public function getDbTableCircuit() {
        if (null === $this->dbTableCircuit) {
            $this->setDbTableCircuit('Application_Model_DbTable_Circuit');
        }
        return $this->dbTableCircuit;
    }

    public function setDbTableCircuit($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableCircuit = $dbTable;
        return $this;
    }
    
    public function getPunkte($ids){
        $select = $this->getDbTableCircuit()->select();
        $select->setIntegrityCheck(false);
        $select->from('Circuit', array('Punkte' => new Zend_Db_Expr('SUM(Kosten)')));
        $select->where('ID IN(?)', $ids);
        $result = $this->getDbTableCircuit()->fetchAll($select);
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
        $select = $this->getDbTableCircuit()->select();
        $select->setIntegrityCheck('false');
        $select->from('Circuit', array('Besonderheit' => 'Besonderheit'));
        $select->where('ID IN (?)', $ids);
        $result = $this->getDbTableCircuit()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = $row->Besonderheit;
            }
            return $return;
        }else{
            return null;
        }
    }
    
}
