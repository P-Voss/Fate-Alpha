<?php

class Application_Model_Mapper_KlasseMapper implements Application_Model_Erstellung_Information_InformationInterface{

    protected $dbTableKlasse;
    protected $dbTableKlassenGruppe;

    public function getDbTableKlasse() {
        if (null === $this->dbTableKlasse) {
            $this->setDbTableKlasse('Application_Model_DbTable_Klasse');
        }
        return $this->dbTableKlasse;
    }

    public function setDbTableKlasse($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableKlasse = $dbTable;
        return $this;
    }

    public function getDbTableKlassengruppe() {
        if (null === $this->dbTableKlassengruppe) {
            $this->setDbTableKlassengruppe('Application_Model_DbTable_Klassengruppe');
        }
        return $this->dbTableKlassengruppe;
    }

    public function setDbTableKlassengruppe($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableKlassengruppe = $dbTable;
        return $this;
    }
    
    public function getPunkte($ids){
        $select = $this->getDbTableKlasse()->select();
        $select->setIntegrityCheck(false);
        $select->from('Klassen', array('Punkte' => new Zend_Db_Expr('SUM(Kosten)')));
        $select->where('KlassenID IN(?)', $ids);
        $result = $this->getDbTableKlasse()->fetchAll($select);
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
        $select = $this->getDbTableKlasse()->select();
        $select->setIntegrityCheck(false);
        $select->from('Klassen', array('Beschreibung' => 'Beschreibung'));
        $select->where('KlassenID IN (?)', $ids);
        $result = $this->getDbTableKlasse()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = $row->Beschreibung;
            }
            return $return;
        }else{
            return null;
        }
    }
    
    public function getKlassengruppe($klassenId) {
        $return = false;
        $select = $this->getDbTableKlasse()->select();
        $select->setIntegrityCheck(false);
        $select->from('Klassen', array('Gruppe'));
        $select->where('KlassenID = ?', $klassenId);
        $result = $this->getDbTableKlasse()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = $row->Gruppe;
            }
        }
        return $return;
    }
    
    public function getFamilienname($klassenId) {
        $return = '';
        $select = $this->getDbTableKlasse()->select();
        $select->setIntegrityCheck(false);
        $select->from('Klassen', array('KlassenID', 'Klasse'));
        $select->where('KlassenID = ?', $klassenId);
        $result = $this->getDbTableKlasse()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                if($row->KlassenID !== 1){
                    if($row->KlassenID == 10){
                        $return = (rand(0, 1)) ? 'Makiri' : 'Matou';
                    }else{
                        $return = $row->Klasse;
                    }
                }
            }
        }
        return $return;
    }
    
    
}
