<?php

class Application_Model_Mapper_NewsMapper{
    
    protected $dbTableNews;

    public function getDbTableNews() {
        if (null === $this->dbTableNews) {
            $this->setDbTableNews('Application_Model_DbTable_News');
        }
        return $this->dbTableNews;
    }

    public function setDbTableNews($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->dbTableNews = $dbTable;
        return $this;
    }
    
    public function getNews() {
        $select = $this->getDbTableNews()->select();
        $select->setIntegrityCheck(false);
        $select->from('News');
        $select->order('ID DESC');
        $result = $this->getDbTableNews()->fetchAll($select);
        
        $usermapper = new Application_Model_Mapper_UserMapper();
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Application_Model_News();
                $model->setId($row->ID);
                $model->setDatum($row->Datum);
                $model->setEditdatum($row->Editdatum);
                $model->setEditor($row->Edit);
                $model->setNachricht($row->Nachricht);
                $model->setTitel($row->Titel);
                $model->setVerfasser($row->Verfasser);
                $model->setVerfasserName($usermapper->getAdminnameById($row->Verfasser));
                $model->setEditorName($usermapper->getAdminnameById($row->Edit));
                
                $return[] = $model;
            }
            return $return;
        }else{
            return false;
        }
    }
    
}

?>