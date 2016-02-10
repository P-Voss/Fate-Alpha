<?php

class Application_Model_Mapper_WetterMapper {
    
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
    
    public function getWetterByDate(DateTime $date) {
        $wetter = new Administration_Model_Tageswetter();
        $select = parent::getDbTable('Wetter')->select();
        $select->where('date = ?', $date->format('Y-m-D'));
        $row = parent::getDbTable('Wetter')->fetchRow($select);
        if($row !== null){
            
        }
        return $wetter;
    }
    
}
