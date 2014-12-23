<?php

class Application_Model_Mapper_CharakterMapper{
    
    protected $dbTableCharakter;
    protected $dbTableTraining;

    public function getDbTableCharakter() {
        if (null === $this->dbTableCharakter) {
            $this->setDbTableCharakter('Application_Model_DbTable_Charakter');
        }
        return $this->dbTableCharakter;
    }

    public function setDbTableCharakter($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableCharakter = $dbTable;
        return $this;
    }
    
    public function getDbTableTraining() {
        if (null === $this->dbTableTraining) {
            $this->setDbTableTraining('Application_Model_DbTable_Training');
        }
        return $this->dbTableTraining;
    }

    public function setDbTableTraining($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableTraining = $dbTable;
        return $this;
    }
    
    public function getCharakterById($userId){
        $select = $this->getDbTableCharakter()->select();
        $select->setIntegrityCheck(false);
        $select->from('Charakter');
        $select->where('userid = ?', $userId);
        $result = $this->getDbTableCharakter()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Application_Model_Charakter();
                $model->setVorname($row->Vorname);
                $model->setNachname($row->Nachname);
                $model->setCharakterid($row->ID);
                $model->setAlter($row->Jahre);
                $model->setAugenfarbe($row->Augenfarbe);
                $model->setGeburtsdatum($row->Geburtsdatum);
                $model->setGeschlecht($row->Sex);
                $model->setMagiccircuit($row->MagicCircuit);
                $model->setNaturelement($row->Naturelement);
                $model->setNickname($row->Nickname);
                $model->setSize($row->Size);
                $model->setWohnort($row->Wohnort);
                $model->setVorteile($this->getVorteileByCharakterId($row->ID));
                $model->setNachteile($this->getNachteileByCharakterId($row->ID));
            }
            return $model;
        }else{
            return false;
        }
    }
    
    public function getCurrentTraining($charakterId){
        $select = $this->getDbTableTraining()->select();
        $select->setIntegrityCheck(FALSE);
        $select->from('Training');
        $select->where('CharakterID = ?', $charakterId);
        $result = $this->getDbTableCharakter()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = array();
                $return['Training'] = $row->Wert;
                $return['Dauer'] = $row->Dauer;
            }
            return $return;
        }else{
            return false;
        }
    }
    
    public function getVorteileByCharakterId($charakterId){
        
    }
    
    public function getNachteileByCharakterId($charakterId){
        
    }
    
}

?>