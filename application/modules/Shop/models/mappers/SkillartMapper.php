<?php

class Shop_Model_Mapper_SkillartMapper extends Application_Model_Mapper_SchuleMapper
{

    /**
     * @param string $tablename
     *
     * @return Zend_Db_Table_Abstract
     * @throws Exception
     */
    public function getDbTable ($tablename)
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

    /**
     * @return Shop_Model_Skillart[]
     * @throws Exception
     */
    public function getSkillArten ()
    {
        $returnArray = [];
        $result = $this->getDbTable('Skillart')->fetchAll();
        foreach ($result as $row) {
            $skillArt = new Shop_Model_Skillart();
            $skillArt->setId($row->skillartId);
            $skillArt->setBezeichnung($row->name);
            $skillArt->setBeschreibung($row->beschreibung);
            $skillArt->setLearned(true);
            $returnArray[] = $skillArt;
        }
        return $returnArray;
    }

}
