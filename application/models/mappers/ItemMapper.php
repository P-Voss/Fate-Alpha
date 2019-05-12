<?php

/**
 * Description of Application_Model_Mapper_ItemMapper
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Mapper_ItemMapper {

    /**
     * @param $tablename
     *
     * @return Zend_Db_Table_Abstract
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
     * @param $itemId
     *
     * @return array
     */
    public function getDiscountDays ($itemId)
    {
        try {
            return array_map(
                function($entry) {return $entry['day'];},
                $this->getDbTable('ItemDiscountDays')->fetchAll(['itemId = ?' => $itemId])->toArray()
            );
        } catch (Exception $exception) {
            return [];
        }
    }
    
}
