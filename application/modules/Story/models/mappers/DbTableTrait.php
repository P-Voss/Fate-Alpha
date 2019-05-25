<?php


Trait Story_Model_Mapper_DbTableTrait
{

    /**
     * @param string $tablename
     *
     * @return Zend_Db_Table_Abstract
     * @throws Exception
     */
    protected function getDbTable ($tablename)
    {
        $className = 'Application_Model_DbTable_' . $tablename;
        if (!class_exists($className)) {
            throw new Exception('Falsche Tabellenadapter angegeben');
        }
        $dbTable = new $className();
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }
}