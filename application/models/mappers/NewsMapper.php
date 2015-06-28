<?php

class Application_Model_Mapper_NewsMapper{
    
    public function getDbTable($tablename) {
        $className = 'Application_Model_DbTable_' . $tablename;
        if(!class_exists($className)){
            throw new Exception('Falsche Tabellenadapter angegeben');
        }
        $dbTable = new $className();
        if(!$dbTable instanceof Zend_Db_Table_Abstract){
            throw new Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }
    
    public function getNews() {
        $return = array();
        $select = $this->getDbTable('News')->select();
        $select->setIntegrityCheck(false);
        $select->from('news');
        $select->order('newsId DESC');
        $result = $this->getDbTable('News')->fetchAll($select);
        
        $usermapper = new Application_Model_Mapper_UserMapper();
        if($result->count() > 0){
            foreach ($result as $row){
                $model = new Application_Model_News();
                $model->setId($row->newsId);
                $model->setDatum($row->creationDate);
                $model->setEditdatum($row->editDate);
                $model->setEditor($row->editUserId);
                $model->setNachricht($row->nachricht);
                $model->setTitel($row->titel);
                $model->setVerfasser($row->verfasserUserId);
                $model->setVerfasserName($usermapper->getAdminnameById($row->verfasserUserId));
                if($row->editUserId !== null){
                    $model->setEditorName($usermapper->getAdminnameById($row->editUserId));
                }
                $return[] = $model;
            }
        }
        return $return;
    }
    
}

?>