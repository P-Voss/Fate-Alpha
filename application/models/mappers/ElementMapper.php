<?php

class Application_Model_Mapper_ElementMapper implements Application_Model_Erstellung_Information_InformationInterface{

    protected $dbTableElement;

    public function getDbTableElement() {
        if (null === $this->dbTableElement) {
            $this->setDbTableElement('Application_Model_DbTable_Element');
        }
        return $this->dbTableElement;
    }

    public function setDbTableElement($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableElement = $dbTable;
        return $this;
    }
    
    public function getPunkte($ids){
        $select = $this->getDbTableElement()->select();
        $select->setIntegrityCheck(false);
        $select->from('Elemente', array('Punkte' => new Zend_Db_Expr('SUM(Kosten)')));
        $select->where('ID IN(?)', $ids);
        $result = $this->getDbTableElement()->fetchAll($select);
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
        $select = $this->getDbTableElement()->select();
        $select->setIntegrityCheck('false');
        $select->from('Elemente', array('Beschreibung' => 'Charakterisierung'));
        $select->where('ID IN (?)', $ids);
        $result = $this->getDbTableElement()->fetchAll($select);
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
