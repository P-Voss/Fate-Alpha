<?php

class Application_Model_Mapper_SchuleMapper {

    /**
     * @param string $tablename
     * @return \Zend_Db_Table_Abstract
     * @throws Exception
     */
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
    
    /**
     * @return \Application_Model_Schule
     */
    public function getAllSchools() {
        $returnArray = array();
        $select = $this->getDbTable('Schule')->select();
        $result = $this->getDbTable('Schule')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row) {
                $model = new Application_Model_Schule();
                $model->setId($row->magieschuleId);
                $model->setBezeichnung($row->name);
                $model->setBeschreibung($row->beschreibung);
                $returnArray[] = $model;
            }
        }
        return $returnArray;
    }
    
}
