<?php

class Application_Model_Mapper_CharakterMapper{
    
    protected $dbTableCharakter;
    protected $dbTableTraining;
    protected $dbTableVorteil;
    protected $dbTableNachteil;

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

    public function getDbTableVorteil() {
        if (null === $this->dbTableVorteil) {
            $this->setDbTableVorteil('Application_Model_DbTable_Vorteil');
        }
        return $this->dbTableVorteil;
    }

    public function setDbTableVorteil($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableVorteil = $dbTable;
        return $this;
    }

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
        $select->from(array('C' => 'Charakter'), array('C.*'));
        $select->where('C.userid = ?', $userId);
        $select->joinLeft(array('K' => 'Klassen'), 'C.Klasse = K.KlassenID', array('K.Gruppe'));
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
                $model->setKlasse($row->Klasse);
                $model->setKlassengruppe($row->Gruppe);
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
        $select->where('charakterID = ?', $charakterId);
        $result = $this->getDbTableTraining()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $return = array();
                $return['training'] = $row->wert;
                $return['dauer'] = $row->dauer;
            }
            return $return;
        }else{
            return false;
        }
    }
    
    public function getVorteileByCharakterId($charakterId){
        $select = $this->getDbTableVorteil()->select();
        $select->setIntegrityCheck(false);
        $select->from(array('CV' => 'CharakterVorteil'), array('V.VorteilID', 'V.Vorteil', 'V.Beschreibung'));
        $select->where('CV.CharakterID = ?', $charakterId);
        $select->join(array('V' => 'Vorteile'), 'CV.VorteilID = V.VorteilID');
        $result = $this->getDbTableVorteil()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $vorteilModel = new Application_Model_Vorteil();
                $vorteilModel->setId($row->VorteilID);
                $vorteilModel->setBezeichnung($row->Vorteil);
                $vorteilModel->setBeschreibung($row->Beschreibung);
                
                $returnArray[] = $vorteilModel;
            }
            return $returnArray;
        }else{
            return null;
        }
    }
    
    public function getNachteileByCharakterId($charakterId){
        $select = $this->getDbTableNachteil()->select();
        $select->setIntegrityCheck(false);
        $select->from(array('CN' => 'CharakterNachteil'), array('N.NachteilID', 'N.Nachteil', 'N.Beschreibung'));
        $select->where('CN.CharakterID = ?', $charakterId);
        $select->join(array('N' => 'Nachteile'), 'CN.NachteilID = N.NachteilID');
        $result = $this->getDbTableNachteil()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                $nachteilModel = new Application_Model_Nachteil();
                $nachteilModel->setId($row->NachteilID);
                $nachteilModel->setBezeichnung($row->Nachteil);
                $nachteilModel->setBeschreibung($row->Beschreibung);
                
                $returnArray[] = $nachteilModel;
            }
            return $returnArray;
        }else{
            return null;
        }
    }
    
}
