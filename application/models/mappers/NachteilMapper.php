<?php

class Application_Model_Mapper_NachteilMapper implements Application_Model_Erstellung_Information_InformationInterface{

    protected $dbTableNachteil;

    public function getDbTableNachteil() {
        if (null === $this->dbTableNachteil) {
            $this->setDbTableNachteil('Application_Model_DbTable_Nachteil');
        }
        return $this->dbTableNachteil;
    }

    public function setDbTableNachteil($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableNachteil = $dbTable;
        return $this;
    }
    
    public function getPunkte($ids){
        $select = $this->getDbTableNachteil()->select();
        $select->setIntegrityCheck(false);
        $select->from('Nachteile', array('Punkte' => new Zend_Db_Expr('SUM(Kosten)')));
        $select->where('NachteilID IN(?)', $ids);
        $result = $this->getDbTableNachteil()->fetchAll($select);
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
        $select = $this->getDbTableNachteil()->select();
        $select->setIntegrityCheck('false');
        $select->from('Nachteile', array('Beschreibung' => 'Beschreibung'));
        $select->where('NachteilID IN (?)', $ids);
        $result = $this->getDbTableNachteil()->fetchAll($select);
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
