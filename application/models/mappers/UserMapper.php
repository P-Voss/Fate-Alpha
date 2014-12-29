<?php

class Application_Model_Mapper_UserMapper{
    
    protected $dbTableUser;
    protected $dbTablePm;

    
    public function getDbTableUser() {
        if (null === $this->dbTableUser) {
            $this->setDbTableUser('Application_Model_DbTable_User');
        }
        return $this->dbTableUser;
    }

    public function setDbTableUser($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableUser = $dbTable;
        return $this;
    }

    public function getDbTablePm() {
        if (null === $this->dbTablePm) {
            $this->setDbTablePm('Application_Model_DbTable_Pm');
        }
        return $this->dbTablePm;
    }

    public function setDbTablePm($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTablePm = $dbTable;
        return $this;
    }

    
    public function hasChara($userid){
        $select = $this->getDbTableUser()->select();
        $select->setIntegrityCheck(false);
        $select->from('Charakter');
        $select->where('userID = ?', $userid);
        $result = $this->getDbTableUser()->fetchAll($select);
        if($result->count() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function countNewPm($userid) {
        $select = $this->getDbTablePm()->select();
        $select->setIntegrityCheck(false);
        $select->from('NachrichtenEingang');
        $select->where('Empfaenger = ? AND Status = "Ungelesen"', $userid);
        $result = $this->getDbTablePm()->fetchAll($select);
        return $result->count();
    }
    
    public function getAdminnameById($userid) {
        $select = $this->getDbTableUser()->select();
        $select->setIntegrityCheck(false);
        $select->from('Benutzerdaten');
        $select->where('id = ?', $userid);
        $result = $this->getDbTableUser()->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row){
                return $row->Profilname;
            }
        }else{
            return false;
        }
    }
    
    public function getCharakterById($userid){
        
    }
    
}

?>