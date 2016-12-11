<?php

class Application_Model_Mapper_LogMapper{
    
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
    
    public function checkIfExists(Application_Model_Log $log) {
        $select = $this->getDbTable('Logs')->select();
        $select->where('md5 = ?', $log->getMd5());
        $result = $this->getDbTable('Logs')->fetchAll();
        return $result->count() > 0;
    }
    
}
