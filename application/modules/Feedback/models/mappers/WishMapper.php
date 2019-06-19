<?php


namespace Feedback\Models\Mappers;


use Feedback\Models\Wish;

class WishMapper
{

    /**
     * @param string $adaptername
     *
     * @return \Zend_Db_Table_Abstract
     * @throws \Exception
     */
    private function getDbTable($adaptername): \Zend_Db_Table_Abstract
    {
        $className = 'Application_Model_DbTable_' . $adaptername;
        if (!class_exists($className)) {
            throw new \Exception('Falsche Tabellenadapter angegeben');
        }
        $dbTable = new $className();
        if (!$dbTable instanceof \Zend_Db_Table_Abstract) {
            throw new \Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }

    /**
     * @param Wish $wish
     *
     * @return int
     * @throws \Exception
     */
    public function create (Wish $wish)
    {
        return $this->getDbTable('Wishes')->insert($wish->toArray());
    }

}